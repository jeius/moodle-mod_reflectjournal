# Task M1-T1: Activity settings form and instance CRUD

**Task:** Implement the teacher-facing settings form (`mod_form.php`) and complete the
instance add/update/delete callbacks so a Reflection Journal can be created, edited and
deleted in the browser.

**Context:** Milestone M1 in `docs/plan.md`; Forms row of the core-API ledger in
`docs/architecture.md` (mechanism: `moodleform_mod`, no custom form code); reference a
small core module (e.g. `mod_book`) for the intro-editor wiring; existing stubs in
`lib.php`; ADR-0002 pins the target APIs.

**Requirements / acceptance criteria:**
- `mod_reflectjournal_mod_form extends moodleform_mod` with: name (`PARAM_TEXT`),
  standard intro editor (prompt) including draft-file handling in
  `data_preprocessing()`, standard buttons.
- `reflectjournal_add_instance()` / `_update_instance()` / `_delete_instance()` persist
  name, intro, introformat, timemodified (delete also removes intro filearea files).
- Editing an existing instance keeps its id (form carries `instance`).
- Creating, editing, deleting an instance from a course works in the browser; deleting
  the course module removes the instance row.
- No hardcoded user-visible text: new strings go to `lang/en/reflectjournal.php`.
- No schema change in this task (`db/install.xml` untouched).

**Target files:** `mod_form.php` (new), `lib.php` (extend stubs),
`lang/en/reflectjournal.php` (strings), `tests/` (PHPUnit), `tests/behat/` (new).
Off-limits: `moodle/` core, `docker/`, `docs/adr/` (raise a question instead).

**Verification (all must pass):**
- PHPUnit: `$MOODLE_DOCKER_BIN exec webserver php vendor/bin/phpunit --testsuite mod_reflectjournal_testsuite`
  (after `source docker/env.sh`), including a new test asserting add→update→delete on
  the callbacks.
- Behat: new feature file covers teacher adds activity with a prompt → sees it listed;
  edits name → change persists.
- `ci/bin/moodle-plugin-ci phpcs` clean (zero warnings — success criterion).
- Walk `docs/security-checklist.md` for the diff (moodleform covers sesskey; confirm).

**When done:** update `docs/progress.md`; summarize what changed and follow-ups; small
focused commit → PR (one PR per issue, GitHub milestone M1).
