# 0008. `feedbackby`: the teacher who wrote feedback is a data subject

Date: 2026-11-24
Status: Accepted (2026-11-24)

## Context

`reflectjournal_entries.feedbackby` stores the id of the teacher who wrote the
feedback. It is needed so that the learner can see who responded, and so that tests can
check who saved what. The privacy provider declares it in `get_metadata()`. Three
questions follow: is the teacher a data subject for that row, what does a teacher's
export contain, and what happens to the feedback when a teacher asks for erasure.

What core does for the same shape of data, `assign_grades.grader` in `mod_assign`
(`mod/assign/classes/privacy/provider.php`):

- Contexts: `get_contexts_for_userid()` returns every assignment where the user is the
  graded user **or** the grader.
- User lists: `get_users_in_context()` adds both `userid` and `grader`.
- Export: `export_grade_data()` writes the grader as a transformed user reference
  (`transform::user()`), and `export_marks()` exports marks where the user is the
  student or the marker.
- Erasure: `delete_marks_for_users()` deletes marks where the user is the student **or
  the marker**. The things a teacher authored on other users' grades are removed.

## Decision

**Feedback written by a teacher is that teacher's personal data.** The plugin follows
the `mod_assign` pattern:

- **Contexts and user lists.** `get_contexts_for_userid()` and
  `get_users_in_context()` select on `userid` **and** `feedbackby`.
- **Export.** A learner gets their entry, their feedback, and who wrote it
  (`transform::user($entry->feedbackby)`). A teacher gets a "Feedback you wrote" list
  per activity: the learner (as a transformed user reference), the feedback text, and
  the time it was saved.
- **Erasure.** When a teacher's data is deleted for a context
  (`delete_data_for_user()` or `delete_data_for_users()`), every feedback they wrote in
  that context is deleted: `feedback`, `feedbackformat` and `feedbackmodified` are
  cleared, `feedbackby` is set to 0, and the files in that entry's `feedback` file area
  are deleted. The learner's entry text is not touched, and the grade stays — it is the
  gradebook's data, not the plugin's (ADR-0007).
- **Metadata string.** The `privacy:metadata:*` string for `feedbackby` says that the
  feedback a teacher authored is removed when they request erasure (accepted
  2026-11-24).

## Alternatives considered

- **Only anonymise**: keep the text and set `feedbackby` to 0. Rejected: the learner
  normally knows who wrote the feedback, so the text stays linkable to the teacher, and
  removing the id alone is not erasure. Core deletes authored content in the same
  situation (`delete_marks_for_users()`).
- **Treat `feedbackby` as a plain reference field**, the way `usermodified` is usually
  treated, and leave the feedback alone. Rejected: the feedback is the teacher's
  substantive work record, not a bookkeeping column, and `mod_assign` treats `grader`
  as a data subject.
- **Do not store `feedbackby`.** Rejected: the interface needs it, and it is what makes
  "who gave this feedback" testable.

## Consequences

- A learner can lose the text and the files of a feedback when a teacher is erased. The
  grade is not affected. This is the accepted cost of treating the feedback as the
  teacher's data.
- Erasing a learner deletes their entry row, feedback included; nothing else changes.
- `delete_data_for_all_users_in_context()` removes every row, so it needs no special
  case.
- Test (PHPUnit): teacher T writes feedback on learner A's entry.
  `get_contexts_for_userid(T)` lists that context. After a delete request for T, A's
  row still exists with `feedback`, `feedbackformat` and `feedbackmodified` cleared and
  `feedbackby` 0, and the `feedback` file area is empty; A's export no longer contains
  the feedback; a grade stored for A is unchanged.
