# Task prompt template

Copy per task (e.g. into `docs/tasks/<milestone>-<task>-<slug>.md`); don't edit this file.

**Task:** <one-sentence objective, e.g. "Implement the activity settings form">

**Context:** <milestone in docs/plan.md; docs/architecture.md section + ADRs to read>

**Requirements / acceptance criteria:**
- <concrete, testable behavior>
- <edge case, e.g. "deadline in the past shows a warning but is allowed">

**Target files:** <paths to create or modify; Moodle core (`moodle/`) and `docker/` are off-limits>

**Verification (must all pass):**
- PHPUnit: `bin/moodle-docker-compose exec webserver php vendor/bin/phpunit --testsuite mod_reflectjournal_testsuite` (run from `$MOODLE_DOCKER_WWWROOT`)
- New/changed behavior is covered by a test (PHPUnit, Behat where UI-visible)
- Code checker: `moodle-plugin-ci phpcs` clean (CI must stay green)
- `docs/security-checklist.md` walked for the diff
- `docs/progress.md` updated in the same commit

**When done:** summarize what changed, test evidence, and follow-ups; leave a small,
focused commit.
