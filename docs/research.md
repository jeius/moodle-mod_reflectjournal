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
  Re-checked 2026-11-24: the versioned per-API pages (`moodledev.io/docs/5.3/apis/…`)
  are **live** — the sitemap (https://moodledev.io/sitemap.xml) lists 378 URLs; the
  Privacy page was fetched as a spot check. Cite the versioned pages. (The
  `docs.moodle.org/dev` mirror stays bot-blocked from this environment, 403.)
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

## Architecture evidence (rounds 2–3)

Verified 2026-11-24 against the local checkout: `MOODLE_503_STABLE`, commit
`1156a935ba4` ("weekly release 5.3.1+", 24 commits after tag `v5.3.1`). No tag points
at that commit. `docs/architecture.md` cites file and function names; the line numbers
are kept here so a later checkout can be compared.

### Where each kind of file goes in 5.3

| File | Evidence |
|---|---|
| Renderer | Core tries the autoloaded `\mod_<name>\output\renderer` before the legacy root `renderer.php` with class `mod_<name>_renderer`: `renderer_factory_base::standard_renderer_classnames()` in `lib/classes/output/renderer_factory/renderer_factory_base.php` (legacy file included L129-135; candidate order L158-171). The choice is made in `standard_renderer_factory::get_renderer()` (`lib/classes/output/renderer_factory/standard_renderer_factory.php` L44-84), reached through `moodle_page::get_renderer()` (`lib/pagelib.php` L1037) and `theme_config::get_renderer()` (`lib/classes/output/theme_config.php` L2203). Core knowledge graph count: 7 modules have `mod/<name>/classes/output/renderer.php` (assign, bigbluebuttonbn, feedback, lti, book, quiz, glossary); 9 have a root `mod/<name>/renderer.php` with class `mod_<name>_renderer` (data, forum, scorm, wiki, choice, workshop, lesson, folder, subsection). The Output API guide's example is `admin/tool/demo/classes/output/renderer.php`. |
| Forms | Form API guide example: `[path/to/plugin]/classes/form/myform.php`, namespace `[plugintype]_[pluginname]\form`. Core modules with a `classes/form/` directory (graph): bigbluebuttonbn, data, feedback, forum, quiz. |
| Tables | Classes under `*/classes/table/` (graph): `admin/classes/table/` (9 files, e.g. `plugin_management_table.php`), `reportbuilder/classes/table/`, `ai/classes/table/`. Activity modules have no fixed folder: `mod/feedback/classes/responses_table.php`, `mod/quiz/classes/local/reports/attempts_report_table.php`; legacy root file `mod/assign/gradingtable.php`. |
| Test generators | `mod/assign/tests/generator/lib.php` L30 (`mod_assign_generator`), `lib/testing/generator/module_generator.php` L38 (`testing_module_generator`); `mod/assign/tests/generator/behat_mod_assign_generator.php` L25 (`behat_mod_assign_generator`). `lib/behat/classes/behat_generator_base.php`: class docblock L119-122 ("behat_..._generator is defined in tests/generator/behat_..._generator.php inside the plugin"), class L129, `get_creatable_entities()` L166. |
| Icon | `pix/monologo.svg` exists in all 23 core activity modules that ship a `lib.php`; none ships `pix/icon.svg`. `theme_config::resolve_image_location()` (`lib/classes/output/theme_config.php` L1936-1946): for `mod_` components the candidates are `['monologo', 'icon']`, and asking for `icon` raises a developer debugging notice. `core_component::has_monologo_icon()` (`lib/classes/component.php` L2098-2119). |

### Features declared by `reflectjournal_supports()`

| Feature | Evidence |
|---|---|
| `FEATURE_MOD_INTRO` | `moodleform_mod::init_features()` (`course/moodleform_mod.php` L195), default `true`. |
| `FEATURE_GRADE_HAS_GRADE` | `moodleform_mod::init_features()` (`course/moodleform_mod.php` L193); the "Require grade" condition is switched on in `core_completion\form\form_trait::add_completion_elements()` (`completion/classes/form/form_trait.php` L110). |
| `FEATURE_COMPLETION_HAS_RULES` | `assign_supports()` (`mod/assign/lib.php` L377). The rule's value is published by `assign_get_coursemodule_info()` (L497-500) and turned into a state by `custom_completion::get_state()` (`mod/assign/classes/completion/custom_completion.php` L41). |
| `FEATURE_BACKUP_MOODLE2` | File-level code loads the activity task classes only for modules that declare it: `backup/moodle2/backup_plan_builder.class.php` L59 and `backup/moodle2/restore_plan_builder.class.php` L69. Recycle bin: `course_bin::store_item()` (`admin/tool/recyclebin/classes/course_bin.php` L116). `FEATURE_GROUPMEMBERSONLY` throws in `plugin_supports()` (`lib/moodlelib.php` L7574-7581). |
| `FEATURE_SHOW_DESCRIPTION` | `moodleform_mod::init_features()` (`course/moodleform_mod.php` L198, default `false`); the checkbox is added at L1064-1068 of the same file; the flag is stored on the course module by `add_moduleinfo()` (L117-121) and `update_moduleinfo()` (L715-719) in `course/modlib.php`. |
| `FEATURE_MOD_PURPOSE` | `assign_supports()` returns `MOD_PURPOSE_ASSESSMENT` (`mod/assign/lib.php` L386); core falls back to `MOD_PURPOSE_OTHER` in `activity_icon::__construct()` (`course/classes/output/activity_icon.php` L73). |
| Not declared | `FEATURE_COMPLETION_TRACKS_VIEWS` defaults to `false` (`completion/classes/form/form_trait.php` L109; `completion/classes/edit_base_form.php` `support_views()` L67-74). `FEATURE_CONTROLS_GRADE_VISIBILITY`: `grade_item::can_control_visibility()` (`lib/grade/grade_item.php` L2663-2665). |

### Facts behind the round-3 design decisions

| Fact | Source |
|---|---|
| Module deletion is cleaned up by core | `core_courseformat\local\cmactions::delete()` (`course/format/classes/local/cmactions.php` L260-399): calls `<mod>_delete_instance()` (L307-313), "Remove all module files in case modules forget to do that" (L320-323), deletes calendar events (L325-333), grade items (L335-345), completion data (L353-362), then the context (L371-372). `course_delete_module()` (`course/lib.php` L725-739) is deprecated since 5.2. |
| Deleting a context deletes its files | `core\context::delete()` calls `delete_content()`, which runs `$fs->delete_area_files($this->_id)` (`lib/classes/context.php` L579-610, files at L593-595). |
| What core does with a rescale callback | `MoodleQuickForm_modgrade` shows the "Rescale existing grades" choice only when `canrescale` is set (`lib/form/modgrade.php` L166-185) and refuses a changed maximum without an answer (L434-452). `moodleform_mod::init_features()` sets `canrescale` from `component_callback_exists()` (`course/moodleform_mod.php` L202) and passes it on (L958). `update_moduleinfo()` (`course/modlib.php` L743-782) calls `<mod>_update_instance()` first, then the callback, and throws `cannotreprocessgrades` unless it returns `true`; `component_callback()` (`lib/moodlelib.php` L7419-7448) passes a `null` return through. |
| Gradebook-side rescale helper | `grade_item::rescale_grades_keep_percentage()` (`lib/grade/grade_item.php` L995-1049); used by the gradebook at `grade/edit/tree/item.php` L195. `mod_assign` instead rescales its own table and pushes again: `assign_rescale_activity_grades()` (`mod/assign/lib.php` L1298-1333). |
| No transactions around the save path | `moodle_database::transactions_forbidden()` (`lib/dml/moodle_database.php` L2661-2671) throws `dml_transaction_exception` when a transaction is open. PostgreSQL manual, §3.4 Transactions: "ROLLBACK TO is the only way to regain control of a transaction block that was put in aborted state by the system due to an error, short of rolling it back completely and starting again." Moodle's own pgsql test notes the same (`test_recordset_cursors_transaction_rollback()`, `lib/dml/tests/pgsql_native_recordset_test.php` L297, comment at L322). |
| `pluginfile` contract | `file_pluginfile()` (`lib/filelib.php` L4443). For a module, core serves the `intro` area itself after `require_course_login()` (L5296-5323), then calls `<component>_pluginfile()`, which "must send the file and terminate. Whatever it returns leads to not found" (L5325-5335). Owner-or-capability example: `assignsubmission_file_pluginfile()` (`mod/assign/submission/file/lib.php` L38-89). Rewrite before format: `format_module_intro()` (`lib/weblib.php` L870-877). Editor: `maxfiles` defaults to 0 (`lib/form/editor.php` L58-60) and the file manager is only built when it is non-zero (L335). |
| Hidden grades | `grade_grade::is_hidden()` (`lib/grade/grade_grade.php` L621-633) checks the grade's own hidden flag or hidden-until time and the item's. |
| Suspended users | `moodle/course:viewsuspendedusers` (`lib/db/access.php` L1216). Core's participants table shows active users only unless the viewer holds both `moodle/course:enrolreview` and `moodle/course:viewsuspendedusers` (`user/classes/table/participants_search.php` L590-603). |
| `feedbackby` precedent | `mod/assign/classes/privacy/provider.php`: `get_metadata()` L74-77, `get_contexts_for_userid()` L152-170, `get_users_in_context()` L256-277, `export_grade_data()` L628, `delete_marks_for_users()` L792-811. `transform::user()` (`privacy/classes/local/request/transform.php` L44). |
| Conventions | `get_capability_string()` (`lib/accesslib.php` L2719-2737); `base::load_disk_version()` reads `release` (`lib/classes/plugininfo/base.php` L281, L303-304); `plugin_manager::available_updates()` compares `maturity` (`lib/classes/plugin_manager.php` L1613, L1628-1632). Guides: `version.php` (maturity and release "Recommended"), Templates ("Mustache file boilerplate"; "Raw unescaped variable": the value "has been processed by format_text() or another adequate way"). |
| External API deprecation | `moodle/UPGRADING.md` §5.3, core_external → Deprecated (L625-657, MDL-81225); legacy names still resolve through `$renamedclasses` (`lib/db/renamedclasses.php` L55-66); function stubs in `lib/externallib.php` carry `@deprecated since Moodle 4.4 - MDL-76583` (L26-87). |
| Keys are indexes, not constraints | `sql_generator::$unique_keys` and `$foreign_keys` are `false` (`lib/ddl/sql_generator.php` L85-89); `getCreateTableSQL()` creates a unique index for a `UNIQUE KEY` and a plain one for a foreign key (L364-394); the comment "we aren't going to enable referential integrity" is in `getDropKeySQL()` (L906-907). |

### Five citations spot-checked directly (2026-11-24)

All confirmed: `clock::time()` (`lib/classes/clock.php` L32); `core\event\course_module_viewed`
(L38) and `core\event\course_module_instance_list_viewed` (L44), both abstract;
`core_table\sql_table` (L36) and `sql_table::set_sql()` (L142) in
`lib/table/classes/sql_table.php`; `custom_completion::get_state()`
(`mod/assign/classes/completion/custom_completion.php` L41).

### Approval rulings (2026-11-24)

| Fact | Source |
|---|---|
| No core activity gates an in-activity grade on the course `showgrades` setting | The only `showgrades` references under `mod/` are the "View grades" link on lesson's end-of-lesson page (`display_eol_page()`, `mod/lesson/renderer.php` L641-646 — gated on `gradereport/user:view` **and** `$course->showgrades`, linking to `/grade/index.php`) and a `$showgrades` property of quiz's attempts report (teacher-facing, `mod/quiz/classes/local/reports/attempts_report.php` L65). Quiz and assign show grades inside the activity without consulting the setting. The setting gates the gradebook reports themselves (`grade/report/user/index.php` L66, L69; `grade/report/overview/lib.php` L191, L287) and the activity-report page (`course/user.php` L98). The accepted learner-grade rule (`view` + `is_hidden()`, no `showgrades` gate) therefore matches core behaviour. |
| PostgreSQL 17 confirmed in our docs and stack | `docs/tech-stack.md` (Database row: 17); `docker/README.md` ("PostgreSQL 17"); `~/moodle-docker/db.pgsql.yml` defaults `MOODLE_DOCKER_DB_VERSION` to 17. |

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
  `MOODLE_503_STABLE` × PHP 8.3/8.4 × pgsql/mariadb, **both databases from M0**
  (per the PRD and ADR-0005; corrected 2026-11-24).

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
