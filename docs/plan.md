# Reflection Journal: Plan

Vertical, demoable slices — every milestone ends with something a user can do in the
browser and tests+lint green, with `docs/progress.md` updated. GitHub milestones
**M0–M9** mirror this file; **one PR per issue**; workflow: `docs/workflow.md`
(decide → spec → tickets → plan → execute → PR → merge).

## Milestone entry points (re-sliced 2026-11-24)

`/grill-with-docs` → `/to-spec` for every milestone; escalate to `/wayfinder` only if
the grill surfaces real unknowns. One spec per slice (`docs/specs/NNN-…`, globally
sequential).

| Milestone | Entry point | Expected specs |
|---|---|---|
| M0 Baseline | pending CI green (no spec) | 0 |
| M1 Teacher adds; enrolled users open | grill → spec | 1 |
| M2 Learner submits an entry | grill → spec | 1 |
| M3 Teacher reviews and gives feedback | grill → spec | 1 |
| M4 Grading | grill → spec | 1 |
| M5 Deadline display and completion | grill → spec | 1 |
| M6 Privacy and course reset | grill → spec | 1 |
| M7 Backup/restore | grill → spec | 1 |
| M8 Attachments | grill → spec | 1 |
| M9 Hardening and release | audit tickets, no spec | 0 |

## M0 — Baseline
- [x] Docs set + ADRs 0001–0005; brief confirmed with user changes (2026-11-23)
- [x] Repo restructured: plugin at root; `docker/` = override files only; dev stack = pinned
      moodle-docker clone (see `docker/README.md`); fresh git history; GitHub repo + milestones
- [x] Minimal installable skeleton (version.php, db/access.php, db/install.xml, lib.php callbacks, lang)
- [x] Installs via CLI (`admin/cli/install_database.php`) on Moodle 5.3
- [x] One passing PHPUnit test in the plugin's testsuite
- [ ] `version.php`: add `$plugin->release` (ruled 2026-11-24: lands with the fix-baseline-CI
      PR; `MATURITY_ALPHA` already set)
- [ ] `.github/workflows/moodle-ci.yml` exists (moodle-plugin-ci, 5.3 × PHP 8.3/8.4 ×
      **pgsql+mariadb**, full 2×2 matrix = 4 jobs) — **not ticked until the
      fix-baseline-CI PR is green on every job**, the Validating step excepted
      (`continue-on-error: true` until #2; Code Checker stays strict; ruled 2026-11-24)
**Done when:** local install + PHPUnit green; **fix-baseline-CI PR green on all four
matrix jobs**, the Validating step excepted (#2).

## M1 — Teacher adds the activity; enrolled users open it
- [ ] Generators: `tests/generator/lib.php` (PHPUnit) +
      `tests/generator/behat_mod_reflectjournal_generator.php` (Behat) — created here on
      first need, extended by later slices
- [ ] Capability lang strings for the skeleton's `addinstance` + `view` caps, if missing
- [ ] `mod_form.php` (name, intro editor, show-description checkbox) + working
      add/update/delete instance; declares `FEATURE_SHOW_DESCRIPTION` +
      `FEATURE_MOD_PURPOSE` (`FEATURE_MOD_INTRO` already declared by the skeleton)
- [ ] `view.php` + `index.php`: `require_login` + cm lookup, renderer + Mustache,
      modern redirect pattern; `course_module_viewed` and
      `course_module_instance_list_viewed` triggered before any output
- [ ] Behat: teacher adds the activity to a course, enrolled learner opens the view page;
      Behat accessibility checks written for the new pages
- [ ] PHPUnit, scheduled here: output cleaning on the prompt — `<script>` saved as the
      intro never reaches a rendered page (first output-cleaning surface)
**Done when:** a teacher adds the activity in the browser; an enrolled learner reads
the prompt; both viewed events land in the log; `continue-on-error` removed from the
Validating step (#2); PHPUnit + Behat green.

## M2 — Learner submits an entry
- [ ] Capability: `submit` in `db/access.php`
- [ ] `entries` table + `deadline` column via upgrade.php + savepoint (version bump)
- [ ] Entry form: rich-text editor with `maxfiles` 0 (no file manager until M8); optional
      deadline field on `mod_form`
- [ ] Entry save through `classes/entry.php`: one entry per learner — unique key plus
      duplicate-key race recovery; deadline enforced server-side on every write; calls
      `\completion_info::update_state()` after save (the completion rule itself arrives
      in M5)
- [ ] `entry_submitted` / `entry_updated` events + tests asserting triggers
- [ ] PHPUnit, scheduled here: race test via the `entry::find_existing()` `\core\di` seam
      (CI runs it on both databases); transaction guard (`dml_transaction_exception`
      inside a delegated transaction); frozen-clock deadline tests (one second before =
      saved, at the deadline = rejected, nothing written); a save is keyed to the current
      user (`$USER->id`) — no request parameter can target another learner's entry;
      output cleaning for entry text
**Done when:** a learner submits and edits their entry; a forced race ends with exactly
one row; edits lock at the deadline; events logged.

## M3 — Teacher reviews and gives feedback
- [ ] Capability: `givefeedback` in `db/access.php`
- [ ] Feedback columns on `entries` (`feedback`, `feedbackformat`, `feedbackby`,
      `feedbackmodified`) via upgrade.php + savepoint
- [ ] Submissions list (T6): `classes/table/submissions_table.php` over
      `get_enrolled_sql(..., onlyactive)` LEFT JOINed to entries; served by `grade.php`
- [ ] Teacher's single-entry view (the page the submissions list links to): one learner's
      entry above its feedback form — the grade form joins it in M4; renders another
      user's content through `format_text()` (first cross-user rendering surface);
      `givefeedback` guards the save
- [ ] Feedback form in `classes/form/` + save behind sesskey; the learner sees feedback
      as soon as it is saved; `feedback_added` event + test
- [ ] `reflectjournal_pluginfile()` + `classes/files::resolve()`: login → module context
      → `view` → owner-or-`givefeedback` per area — built now so M8 adds the single
      `entry` area without a new access path (editors run `maxfiles` 0 until then;
      feedback stays text — no area, PRD L1)
- [ ] PHPUnit, scheduled here: cross-learner file access denied (learner B on learner
      A's `entry` area; owner and `givefeedback` teacher allowed; foreign instance id not
      found); an entry and its feedback are readable only by the owner or a
      `givefeedback` user (learner B denied learner A's entry and feedback); output
      cleaning for feedback text; no `givefeedback` → no `grade.php`
**Done when:** a teacher works down the submissions list giving feedback; learners see
it immediately; file access rules hold across learners; events logged.

## M4 — Grading
- [ ] Capability: `grade` in `db/access.php` (guards only the grade field and its save)
- [ ] `grade` column via upgrade.php + savepoint; `FEATURE_GRADE_HAS_GRADE` declared;
      `standard_grading_coursemodule_elements()` on `mod_form` (none/points/scale)
- [ ] Gradebook callbacks (ADR-0007): `reflectjournal_grade_item_update()`,
      `reflectjournal_update_grades()` (exists, pushes nothing),
      `reflectjournal_grade_item_delete()`, `reflectjournal_rescale_activity_grades()`
- [ ] Grade field on `grade.php`: `mod/reflectjournal:grade` + sesskey; writes via
      `grade_update()` with every return code handled; overridden grades show read-only
- [ ] Learner sees their own grade (ruling 7): `grade_item::fetch()` +
      `get_grade($userid, false)` + `grade_grade::is_hidden()`; no other gate
- [ ] PHPUnit, scheduled here: rescale keeps percentages; `GRADE_UPDATE_ITEM_LOCKED` /
      `GRADE_UPDATE_FAILED` results; hidden grades stay hidden (both hide levels);
      capability split (no `grade` → feedback works, grade refused)
**Done when:** grades appear in the gradebook for learners with and without entries;
the learner's view follows the gradebook's hidden rules; grading tests green.

## M5 — Deadline display and completion
- [ ] Calendar: deadline action event created with the instance; callbacks
      `mod_reflectjournal_core_calendar_provide_event_action()`,
      `mod_reflectjournal_core_calendar_event_timestart_updated()`,
      `reflectjournal_refresh_events()`
- [ ] Course-page dates: `mod_reflectjournal\dates extends \core\activity_dates`
- [ ] `FEATURE_COMPLETION_HAS_RULES` declared; `completionsubmit` column via upgrade.php +
      savepoint; `classes/completion/custom_completion.php` +
      `reflectjournal_get_coursemodule_info()`
- [ ] PHPUnit, scheduled here: calendar event create/update/refresh (the path restore
      also uses); completion rule — entry row exists → complete via
      `\completion_info::update_state()`, no entry → incomplete, state never regresses;
      completion shows immediately after saving — the M2 save path calls
      `\completion_info::update_state()`, so the state flips in-request, not via cron
**Done when:** the deadline shows in the calendar and on the course page; completion
ticks on submit and stays.

## M6 — Privacy and course reset
- [ ] `classes/privacy/provider.php`: metadata (`userid` and `feedbackby` as data
      subjects), export, both delete methods, userlist provider (ADR-0008)
- [ ] PHPUnit on core's `\core_privacy\tests\provider_testcase`, scheduled here: learner
      and teacher export/erasure, teacher-erasure semantics (feedback text, format,
      timestamp gone; feedback stays text — no `feedback` file area, PRD L1; grade stays)
- [ ] Course reset: `reflectjournal_reset_course_form_definition()` / `…_defaults()` /
      `reflectjournal_reset_userdata()` (entries + files; returns a status array), grade
      item reset via `grade_item_update($instance, 'reset')`, deadline shift via
      `shift_course_mod_dates()`
- [ ] PHPUnit: reset clears entries + feedback; grades follow the gradebook's reset options
**Done when:** Moodle's privacy tools cover entry and feedback data end to end; course
reset demoes cleanly.

## M7 — Backup/restore
- [ ] `FEATURE_BACKUP_MOODLE2` declared here (not earlier)
- [ ] `backup/moodle2/` backup task + structure step: config always, entries + feedback
      behind the user-data setting, `annotate_files()` for `intro`/`entry` (feedback
      stays text — no area, PRD L1)
- [ ] Restore counterparts: `userid` and `feedbackby` mapped (unmapped → 0),
      `apply_date_offset()` on the deadline, `add_related_files()`; the deadline action
      event rebuilt via the queued `refresh_mod_calendar_events_task`
- [ ] PHPUnit, scheduled here: backup/restore round trip — entries, feedback (with
      `feedbackby` remapped), files and the shifted deadline come back; without user
      data, no entries arrive
**Done when:** a backup restores into a second course with data intact (test).

## M8 — Attachments (last feature milestone)
- [ ] File manager element on the entry form only — feedback stays text (PRD L1: files
      attach to entries; ruled 2026-11-24); `maxfiles` raised here; draft area prepare +
      save
- [ ] `file_rewrite_pluginfile_urls()` before `format_text()` on every output of stored
      entry text (feedback has no file area)
- [ ] Entry attachments counted in privacy export and backup annotation
- [ ] PHPUnit/Behat: learner attaches and downloads; serving rules re-tested on the now
      populated `entry` area (the access path itself was built and tested in M3)
**Done when:** a learner attaches and downloads files; tests cover serving permissions.

## M9 — Hardening and release (audit; no feature tests are first-written here)
- [ ] Security checklist over the whole diff (`docs/security-checklist.md`), review recorded
- [ ] Coverage audit: `docs/architecture.md` §Tests this design needs vs the suites —
      gaps become tickets, not silent M9 work
- [ ] Accessibility audit: all pages pass the Behat accessibility checks (written per
      slice in M1/M3; verified together here)
- [ ] Demo: seed script for the 2-minute demo; README (setup, screenshots, recording)
- [ ] Release: `MATURITY_STABLE`, tag `v1.0.0`, zip via `.gitattributes` export-ignore,
      Marketplace quick-guide check
**Done when:** audit recorded with no findings; tagged release; recording linked; all
success criteria met.

### Re-slice (2026-11-24, user proposal; approved 2026-11-24)
M1–M8 are now vertical, demoable slices (add → submit → feedback → grade →
deadline/completion → privacy/reset → backup → attachments); M9 is an audit, not where
tests are first written. Generators and the viewed events moved to M1; every test type
from `docs/architecture.md` is scheduled with the slice that builds its surface; entry
points are grill-first, escalating to wayfinder only on real unknowns; each slice gets
one spec.

**Approved 2026-11-24** with five edits applied: the draft-adjustments section removed
(its generator claim contradicted this re-slice); M5 tests completion immediately after
saving; M2 tests save ownership and M3 tests entry+feedback readability; M3 makes the
teacher's single-entry view explicit; attachments are entry-only — feedback stays text
(PRD L1), with the file-area notes in `docs/architecture.md` and ADR-0008 updated.
