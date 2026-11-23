# Research — verified 2026-11-23

Facts verified against primary sources for the Moodle 5.3 target. Links checked live
unless marked otherwise. This file feeds the ADRs and `docs/tech-stack.md`.

## Moodle release target

- **Moodle 5.3 is the current stable and the new LTS**: released **5 Oct 2026**, general
  support to 4 Oct 2027, security support to 1 Oct 2029. Latest point release 5.3.1
  (12 Nov 2026); 5.3.2 scheduled 7 Dec 2026.
  https://moodledev.io/general/releases — https://moodledev.io/general/releases/5.3
- `MOODLE_503_STABLE` today: `$version 2026100501.01`, `$release '5.3.1+ (Build: 20261117)'`,
  `$branch '503'` (read from `public/version.php`,
  https://raw.githubusercontent.com/moodle/moodle/MOODLE_503_STABLE/public/version.php).
- **PHP: 8.3.0 minimum, 8.4.x supported** (64-bit only, `sodium` required,
  `max_input_vars >= 5000`). Confirms the brief.
- **Databases (minimums)**: PostgreSQL **17** (raised in 5.3 — the brief's "15+" is
  outdated), MySQL 8.4, MariaDB 11.4.0, SQL Server 2019. Oracle unsupported since 5.0.
- **Node**: Moodle 5.3 `.nvmrc` = `lts/jod` → **Node 22 LTS**
  (https://raw.githubusercontent.com/moodle/moodle/MOODLE_503_STABLE/.nvmrc).
- Moodle 5.x layout: web root is `public/`; plugins live at `public/mod/<name>`.

## mod plugin structure and APIs

- Current activity-module docs (file list, db/ files, backup dirs, `mod_[name]_supports`,
  the `mod_[name]_mod_form` exception, `index.php` redirect pattern):
  https://moodledev.io/docs/apis/plugintypes/mod (version selector includes 5.3).
- Core API guides index (Access, Completion, Gradebook, Privacy, Backup, Output, Form,
  Files, Events, Hooks, DDL, Web services):
  https://moodledev.io/docs/apis/
  ⚠️ The per-API pages under `moodledev.io/docs/apis/core/*` are **mid-migration**:
  several (access, grade, completion, privacy, backup, output, form) redirect to a 6.0
  path that currently 404s, and the `docs.moodle.org/dev` mirror is bot-blocked from
  this environment (403). Cite the index + the pages below; re-check per-API URLs when
  writing feature code.
- Hooks API (verified live): PSR-14 hooks since Moodle 4.3; register via `db/hooks.php`;
  array-notation callbacks need 4.4+; use hooks for new code instead of legacy
  `lib.php` callbacks via `get_plugins_with_function()`;
  dispatch via `\core\di::get(\core\hook\manager::class)->dispatch($hook)`.
  https://moodledev.io/docs/apis/core/hooks
- Custom completion: `\mod_<name>\completion\custom_completion` class +
  `get_completion_active_rule_descriptions()`; reference implementations in every core
  mod (e.g. https://phpdoc.moodledev.io/4.4/da/d87/classmod__feedback_1_1completion_1_1custom__completion.html).
- Coding style + PHPDoc rules (GPL header, `@package`/`@copyright`/`@license` required;
  namespaced classes; `else if`; short arrays; 4-space):
  https://moodledev.io/general/development/policies/codingstyle
  Enforced by **moodle-cs** (`local_codechecker` / phpcs) — see CI below.
- Security functions (`require_login`, `require_capability`, `require_sesskey`,
  `required_param`/`optional_param`, `$DB` param API) are stable core API; community
  checklists converge on the same rules our `docs/security-checklist.md` encodes, e.g.
  https://github.com/emeneo/Moodle-plugin-security-checklist

## 5.3 deprecations relevant to us (per-claim sources)

Both are listed on the 5.3 release notes page (verified live,
https://moodledev.io/general/releases/5.3); tracker links point at Moodle's issue
tracker (now hosted on Atlassian; pages are JS-rendered — titles come from the release
notes, which name the MDL numbers):
- `\external_*` classes deprecated — "Deprecate old \external_* classes" (MDL-81225):
  https://moodledev.io/general/releases/5.3 and
  https://moodle.atlassian.net/browse/MDL-81225
  → future web-service work uses the namespaced external API instead.
- `FEATURE_GROUPMEMBERSONLY` deprecated (MDL-83231):
  https://moodledev.io/general/releases/5.3 and
  https://moodle.atlassian.net/browse/MDL-83231
  → never declare it in `reflectjournal_supports()`.

## 5.3 web root / plugin path (verified)

The 5.3-versioned activity-modules guide shows plugin file paths as
`public/mod/[modname]/...` (e.g. `public/mod/[modname]/db/access.php`),
while prose still says modules live "in the /mod folder":
https://moodledev.io/docs/5.3/apis/plugintypes/mod — corroborated by the local
`MOODLE_503_STABLE` checkout (web root `public/`, no top-level `mod/`).

## CI: moodle-plugin-ci

- Latest stable **4.5.11** (2026-08-07); unreleased additions on main (colour-mode behat,
  phpunit junit/cobertura). Travis removed; GitHub Actions is the path.
  https://moodlehq.github.io/moodle-plugin-ci/ — changelog:
  https://moodlehq.github.io/moodle-plugin-ci/CHANGELOG.html
- 4.5.11 explicitly recommends **Postgres 17 / MariaDB 11** service containers for
  Moodle 5.3 — matches our DB pin.
- Recommended workflow = copy `gha.dist.yml`
  (https://raw.githubusercontent.com/moodlehq/moodle-plugin-ci/main/gha.dist.yml):
  init via `composer create-project -n --no-dev --prefer-dist moodlehq/moodle-plugin-ci ci ^4`,
  then steps phplint, phpmd (advisory), phpcs (code checker, `--max-warnings 0`),
  phpdoc, validate, savepoints, mustache, grunt, phpunit, behat (`--profile chrome`).
  Its default matrix (405/PHP 8.1–8.3) is stale for our target — we set our own:
  `MOODLE_503_STABLE` × PHP 8.3/8.4 × pgsql (+mariadb later if desired).

## Marketplace (formerly Plugins directory)

- Plugins Directory has become **Moodle Marketplace** (https://marketplace.moodle.com);
  docs: https://docs.moodle.org/en/Marketplace (search-verified, not fetched).
- Legacy contribution guide (repo-root layout, Frankenstyle naming, public tracker,
  screenshots, AMOS after approval) still describes the practical bar:
  https://moodledev.io/general/community/plugincontribution — itself marked legacy.
- Implications for us now: repo root = plugin root; naming `mod_reflectjournal`;
  English-only lang strings; GPL v3+; versioned tags.

## Security advisories affecting the dev environment

- **"PHP2Shell"**: CVE-2026-109618 / CVE-2026-109619, PHP releases 21 Oct 2026; Moodle HQ
  took hosted sites offline and patched. Our `moodlehq/moodle-php-apache-*` images must
  be recent (HQ rebuilds them with patched PHP); archive: https://moodle.org/security/
- MSA-26-0045 (15 Oct 2026): TinyMCE/PrismJS upgrades, not exploitable in Moodle core.
- Action: pin a current `MOODLE_DOCKER_PHP_VERSION` tag and re-pull regularly; nothing
  in the plugin itself is affected by these advisories at baseline.
