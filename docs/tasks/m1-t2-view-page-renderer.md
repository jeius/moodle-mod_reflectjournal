# Task M1-T2: View page, renderer and course list

**Task:** Implement `view.php` (the activity's landing page) with a plugin renderer and
Mustache template, plus `index.php` for the course-wide list.

**Context:** Milestone M1 in `docs/plan.md` (after M1-T1); Output row of the ledger in
`docs/architecture.md` (renderer classes + Mustache, no inline HTML); activity-module
guide for the `view.php`/`index.php` patterns (incl. the `activityoverviewbase` redirect
pattern for index): https://moodledev.io/docs/5.3/apis/plugintypes/mod

**Requirements / acceptance criteria:**
- `view.php`: `id` = course-module id via `required_param(PARAM_INT)`; resolve with
  `get_course_and_cm_from_cmid()`; `require_login($course, false, $cm)`; `$PAGE->set_url`
  + context + title/breadcrumbs; render via plugin renderer.
- Renderer (`classes/output/renderer.php` extends `plugin_renderer_base`) +
  `templates/view.mustache` showing the activity name and the formatted prompt
  (`format_text()` with intro+format; `{{#text}}...` passed as pre-rendered HTML).
- Users without `mod/reflectjournal:view` get Moodle's standard permission error
  (nothing bespoke).
- `index.php`: course instances list using the modern overview-redirect pattern
  (fall back to a simple table only if the pattern doesn't fit; note why).
- Deadline/entries UI is out of scope here (M2) — view shows prompt only, plus a
  "Reflection Journal" page heading from lang strings.

**Target files:** `view.php`, `index.php`, `classes/output/renderer.php`,
`templates/view.mustache`, `lang/en/reflectjournal.php`, `tests/` + `tests/behat/`.
Off-limits: `moodle/` core, `docker/`.

**Verification (all must pass):**
- PHPUnit additions (e.g. renderer returns formatted prompt; capability denial via
  `\core\context` in a test with a user lacking the cap).
- Behat: learner opens the activity and sees the prompt text; teacher view same page.
- `ci/bin/moodle-plugin-ci phpcs` and `mustache` steps clean; CI green (pgsql+mariadb).
- `docs/security-checklist.md` walked for the diff.

**When done:** update `docs/progress.md`; summarize; small focused commit → PR
(milestone M1).
