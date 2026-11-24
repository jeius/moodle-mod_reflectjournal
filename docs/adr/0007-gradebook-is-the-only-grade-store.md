# 0007. Gradebook is the only grade store (no plugin-side grade column)

Date: 2026-11-24
Status: Accepted (2026-11-24)

## Context

PRD T3/T5: the teacher chooses none, points or a scale, enters a grade, and it shows in
the gradebook — also for a learner who has not written an entry. The PRD also decides
that grade visibility follows the gradebook's hidden-grade setting.

`docs/architecture.md` said both "grades live only in the gradebook" and that
`reflectjournal_update_grades()` "re-syncs grades … e.g. after restore". Both cannot
hold: a re-sync needs a plugin-side copy of the grade to push, and there is none.

What core requires (read in the 5.3 source):

- `grade_update()` (`lib/gradelib.php`) writes a grade into the gradebook and creates
  or updates the grade item. A grade is addressed by user id only, so a learner with no
  entry can be graded.
- A module declares `<mod>_grade_item_update` and `<mod>_update_grades` **together** or
  core reports a developer warning; core calls both, in that order, from
  `grade_update_mod_grades()` (`lib/gradelib.php`).
- Core can ask a module to re-push its grades at any time: `grade_item::refresh_grades()`
  in `lib/grade/grade_item.php` ends in `grade_update_mod_grades()`.
- Activity grades are backed up and restored by core itself
  (`backup_activity_task::build()` in `backup/moodle2/backup_activity_task.class.php`;
  `restore_gradebook_structure_step` and `restore_grade_history_structure_step` in
  `backup/moodle2/restore_stepslib.php`).

## Decision

**The gradebook is the single store.** The teacher's grade is written once, from the
grading page, with `grade_update()`. The plugin keeps no grade column and no grade
table. `reflectjournal_update_grades()` exists only as the partner of
`reflectjournal_grade_item_update()`: it makes sure the grade item exists and pushes
nothing, because there is nothing to push.

Rules that follow:

- **Return codes are checked on every write** (`lib/grade/constants.php`):
  - `GRADE_UPDATE_OK` — saved.
  - `GRADE_UPDATE_ITEM_LOCKED` — the grade item is locked in the gradebook
    (`lib/gradelib.php`). The teacher is told to unlock it there; nothing is retried.
  - `GRADE_UPDATE_FAILED` — the learner's grade is locked or past its lock time, or the
    item cannot take raw grades (`grade_item::update_raw_grade()` in
    `lib/grade/grade_item.php`). The teacher is told the grade was not saved.
  - `GRADE_UPDATE_MULTIPLE` — more than one grade item matches (`lib/gradelib.php`).
    That is a bug: raise a coding exception.
- **Reading the current grade** for the grading form: `grade_item::fetch()` for the
  activity's item, then `get_grade($userid, false)` — `false` so that looking does not
  insert an empty grade row (`lib/grade/grade_item.php`). Not `grade_get_grades()`
  (`lib/gradelib.php`): its docblock warns it can trigger a full course regrade.
- **Visibility stays with the gradebook.** `FEATURE_CONTROLS_GRADE_VISIBILITY` is not
  declared (`grade_item::can_control_visibility()` in `lib/grade/grade_item.php`), and
  `hidden` is never passed in `$itemdetails`, although `grade_update()` accepts it.
- **Feedback is not mirrored to the gradebook.** `grade_update()` could carry it
  (`lib/gradelib.php`), but feedback is visible the moment it is saved (PRD L3)
  while grades follow the gradebook's hidden setting. One store cannot serve both rules,
  and two copies would drift.
- **Rescaling and deletion** use the module callbacks. `reflectjournal_rescale_activity_grades()`
  has no plugin data to touch: it calls `grade_item::rescale_grades_keep_percentage()`
  on the activity's grade item, the helper the gradebook itself uses when a teacher edits
  an item's maximum (`grade/edit/tree/item.php`). It must return `true`, or core throws
  `cannotreprocessgrades` (`update_moduleinfo()` in `course/modlib.php`). Deleting the
  activity removes the grade item with `['deleted' => 1]`, as `mod_quiz` does
  (`quiz_grade_item_delete()` in `mod/quiz/lib.php`); core would remove it anyway right
  after `_delete_instance()` returns (`core_courseformat\local\cmactions::delete()` in
  `course/format/classes/local/cmactions.php`).

## Alternatives considered

- **Plugin-owned grade, synced to the gradebook**: a grade column on the entry row (or a
  grades table) that `update_grades()` re-pushes. `mod_assign` works this way:
  `assign_rescale_activity_grades()` rescales its own table and pushes again
  (`mod/assign/lib.php`). Rejected: two stores that can disagree
  — a grade edited in the Grader report becomes overridden, and later raw-grade writes no
  longer change the final grade (`grade_item::update_final_grade()` and
  `grade_item::update_raw_grade()` in `lib/grade/grade_item.php`); it needs its own
  backup, restore and reset code; and a grade on the entry row cannot hold
  a learner who has no entry.
- **Grade only in the gradebook, with no grading page in the activity.** Rejected: PRD
  T4/T5 put the grade next to the entry and the feedback. (`grade_update()` in
  `lib/gradelib.php` also refuses manual items.)
- **Mirror feedback into the gradebook as well.** Rejected: see above.

## Consequences

- `reflectjournal_update_grades()` looks empty on purpose. Its docblock must say so and
  link here, so that nobody "fixes" it into a second writer.
- A grade overridden in the Grader report is shown read-only in the grading form, with a
  note: while it is overridden, core keeps the final grade and the gradebook's own
  feedback (`grade_item::update_raw_grade()` in `lib/grade/grade_item.php`). To change
  it, the teacher removes the override in the gradebook.
- The gradebook's "Feedback" column stays empty for this activity; feedback lives only in
  the activity.
- Backup, restore and the grade side of course reset need no grade code beyond the
  module callbacks (`docs/architecture.md`, §Grading integration and §Course reset).
- What a learner sees was decided on 2026-11-24 and is specified in
  `docs/architecture.md` (§Grading integration, "What a learner sees"): their own grade,
  read the same way, shown only while `grade_grade::is_hidden()` is `false`.
