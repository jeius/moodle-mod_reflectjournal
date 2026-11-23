# Reflection Journal: Plan

Small milestones; every task ends with tests+lint green and `docs/progress.md` updated.
GitHub milestones **M0–M9** mirror this file; **one PR per issue**; working loop and
per-task prompts: `AGENTS.md` + `docs/task-template.md`.

## M0 — Baseline (this session)
- [x] Docs set + ADRs 0001–0005; brief confirmed with user changes (2026-11-23)
- [x] Repo restructured: plugin at root; `docker/` = override files only; dev stack = pinned
      moodle-docker clone (see `docker/README.md`); fresh git history; GitHub repo + milestones
- [x] Minimal installable skeleton (version.php, db/access.php, db/install.xml, lib.php callbacks, lang)
- [x] Installs via CLI (`admin/cli/install_database.php`) on Moodle 5.3
- [x] One passing PHPUnit test in the plugin's testsuite
- [x] `.github/workflows/moodle-ci.yml`: moodle-plugin-ci, 5.3 × PHP 8.3/8.4 × **pgsql+mariadb**
**Done when:** local install + PHPUnit green; CI green on both databases.

## M1 — Skeleton activity (add/edit/view)
- [ ] `mod_form.php` (name, intro editor) + working add/update/delete instance
- [ ] `view.php`: require_login, cm lookup, renderer + Mustache template
- [ ] `index.php` instances list (modern redirect pattern)
- [ ] Behat: add activity to course, see view page
**Done when:** a teacher can add the activity in the browser; Behat scenario passes.

## M2 — Data model and core interaction
- [ ] `entries` table + `deadline`/`grade` columns via upgrade.php + savepoint
- [ ] Learner entry form (rich-text editor, File API draft areas wired, no attachments UI yet)
- [ ] Deadline semantics: editing locked after deadline (teachers exempt); calendar event
- [ ] Activity dates surfaced on course page
**Done when:** learner submits/edits/gets locked exactly at the deadline; PHPUnit + Behat cover it.

## M3 — Capabilities and security review
- [ ] Full capability matrix (view/submit/givefeedback), defaults per role
- [ ] Every route: require_login, require_capability, sesskey on writes, param cleaning
- [ ] `docs/security-checklist.md` pass over the whole diff; phpcs `--max-warnings 0`
**Done when:** checklist review recorded; no findings; CI code-checker green.

## M4 — Grading and completion
- [ ] Gradebook callbacks (`*_grade_item_update`, `*_update_grades`), none/points/scale
- [ ] Teacher feedback per entry + feedback event (any time, incl. after deadline)
- [ ] Custom completion rule `completionsubmit` + active-rule descriptions
**Done when:** grade appears in gradebook; completion ticks on submit; grading path has tests.

## M5 — Events, logging, privacy API
- [ ] Event classes (entry_submitted/updated, feedback_added) + tests asserting triggers
- [ ] Privacy provider: metadata, export, delete (entries + fileareas)
**Done when:** privacy tests pass (export/delete phpunit); events logged.

## M6 — Backup/restore
- [ ] backup activity task + structure step (config; entries behind userdata setting)
- [ ] restore counterparts + id mapping
**Done when:** backup then restore round-trips config and user data (test).

## M7 — PHPUnit and Behat coverage
- [ ] Fill gaps per feature area; generator (`tests/generator.php`) for instances+entries
- [ ] Behat: teacher flow + learner flow end-to-end; every capability covered by a test
**Done when:** suites run green locally and in CI (both DBs) without skips.

## M8 — Attachments (last feature milestone)
- [ ] filemanager element on the entry form; draft area save; `pluginfile()` serving
- [ ] Attachments counted in privacy export/backup paths
**Done when:** learner attaches/downloads files; tests cover serving permissions.

## M9 — Polish and release
- [ ] Seed script for the **2-minute demo script** (see success criteria in `docs/prd.md`)
- [ ] README (setup, screenshots, demo script), screen recording
- [ ] Tag `v1.0.0`, zip via `.gitattributes` export-ignore, Marketplace quick-guide check
**Done when:** tagged release; recording linked; all success criteria met.

### Adjustments from the user's draft (why)
Kept the order but: lint/tests are a *definition of done for every milestone* (not just
M7); CI is created in M0 (a baseline that isn't CI-green isn't a baseline); generator
work lives in M7 with coverage; **attachments were moved to M8 as the last feature
milestone** (user decision 2026-11-23), pushing polish to M9 — so GitHub milestones
run M0–M9.
