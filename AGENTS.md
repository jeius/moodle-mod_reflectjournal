# AGENTS.md — mod_reflectjournal (Reflection Journal)

## Project
Moodle 5.3 LTS activity module (portfolio piece): teachers post a reflection prompt,
learners write one entry before a deadline, teachers give feedback + optional gradebook
grade. Core-API-first: every mechanism maps to a Moodle core API (ledger in
`docs/architecture.md`); deviations need an ADR.

Read first: `docs/progress.md` → `docs/plan.md` (milestones M0–M9 = GitHub milestones).
Design: `docs/architecture.md`; decisions: `docs/adr/`; terms: `GLOSSARY.md`.

## Commands (all verified on this machine)
Every shell: `source docker/env.sh` (sets `$MOODLE_DOCKER_BIN`, wwwroot, port 8000).
One-time setup (pinned moodle-docker clone etc.): `docker/README.md`.

- Start / stop stack (keep data — **never** `down`): `$MOODLE_DOCKER_BIN up -d` / `$MOODLE_DOCKER_BIN stop`
- Site: http://localhost:8000 (admin / adminpass)
- Purge caches: `$MOODLE_DOCKER_BIN exec -T webserver php admin/cli/purge_caches.php`
- CLI upgrade (after version bumps): `$MOODLE_DOCKER_BIN exec -T webserver php admin/cli/upgrade.php`
- PHPUnit init: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/phpunit/cli/init.php`
- PHPUnit run: `$MOODLE_DOCKER_BIN exec -T webserver php vendor/bin/phpunit --testsuite mod_reflectjournal_testsuite`
- Behat init: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/behat/cli/init.php`
- Behat run: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/behat/cli/run.php --tags="@mod_reflectjournal"`
- Lint (one-time: `composer create-project -n --no-dev --prefer-dist moodlehq/moodle-plugin-ci ci ^4`):
  - phpcs (must stay at **zero** findings — success criterion):
    `./ci/vendor/bin/phpcs --standard=moodle --parallel=1 -d memory_limit=512M lib.php version.php db lang tests classes`
  - savepoints: `./ci/bin/moodle-plugin-ci savepoints .`
  - phpdoc/validate/mustache/grunt need a booted core → they run in GitHub Actions (see below).
- All checks on push: GitHub Actions (moodle-plugin-ci; php 8.3/8.4 × pgsql/mariadb).

## Conventions
- Business logic in namespaced `classes/`; `lib.php` stays a thin bridge.
- Output only via renderer + Mustache; strings only via `get_string()`.
- GPL header + `@package`/`@copyright`/`@license` + PHPDoc on every PHP file.
- Schema/capability change ⇒ bump `version.php` + `db/upgrade.php` savepoint (CI checks).

## Guardrails
- **Never modify Moodle core** (`moodle/` is a checkout; also never commit it) — plugin dir only.
- `$DB` API with param placeholders only; no raw SQL with user input; input via
  `required_param`/`optional_param`; writes behind `require_sesskey()`;
  `require_login` + `require_capability` on every route — walk `docs/security-checklist.md` per diff.
- No APIs deprecated in 5.3 (`\external_*` classes, `FEATURE_GROUPMEMBERSONLY`).
- Keep code on the Linux filesystem in WSL, never `/mnt/c`.
- Docker: never `down`, `down -v`, or volume prunes without asking (DB has no volume; other projects share this host).
- Never commit `moodle/`, `moodledata`, `docker/local.yml`, `ci/`, or secrets.
- Ask before adding any dependency or changing the architecture.

## Working loop
1. Pick the next task from `docs/plan.md` (GitHub issue in milestone M0–M9;
   **one PR per issue**); write the prompt from `docs/task-template.md`.
2. Implement; PHPUnit + Behat + phpcs clean (commands above).
3. Human reviews the diff (security + edge cases).
4. Update `docs/progress.md` (and architecture/ADR if design changed) in the same commit; small focused PR.

## Skills & tools (installed locally)
- `tdd` / `superpowers:test-driven-development` — test-first feature tasks.
- `code-review` + `superpowers:requesting-code-review` — before every PR.
- `research` / `grill-with-docs` — verify Moodle API facts against docs (moodledev.io).
- `moodle-external-api-development` — the future web-service phase only.
- `triage`, `to-tickets`, `to-spec` — issue workflow (config below).
- `browser-use` plugin — UI verification + M9 screen recording.
- `github` plugin — PRs/issues; `documents`/`pdf`/`presentations` — portfolio artifacts.

## Agent skills
### Issue tracker
GitHub Issues on `jeius/moodle-mod_reflectjournal` via `gh`; milestones M0–M9 mirror `docs/plan.md`; one PR per issue. See `docs/agents/issue-tracker.md`.
### Triage labels
Defaults: `needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human`, `wontfix`. See `docs/agents/triage-labels.md`.
### Domain docs
Single-context: root `GLOSSARY.md` + `docs/adr/`. See `docs/agents/domain.md`.
