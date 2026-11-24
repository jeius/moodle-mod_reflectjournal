# Reflection Journal: Product Requirements

Source of truth for scope. Inherited from `docs/brief.md`; every must-have is testable.

## Goals

- A complete, installable Moodle 5.3 activity module that demonstrates fluent core-API
  usage, tested code, green CI, and a documented agentic workflow (portfolio for a
  Moodle developer role).
- A credible product: a teacher prompts, a learner reflects once before an optional
  deadline, the teacher responds with private feedback and an optional grade.

## User stories

**Teacher**
- T1. As a teacher, I add a Reflection Journal to my course and write the prompt with
  rich text, so learners know what to reflect on.
- T2. As a teacher, I set an optional deadline, so entries lock after it.
- T3. As a teacher, I choose no grading, points, or a scale, so the activity fits my
  assessment plan.
- T4. As a teacher, I read each learner's entry and write private feedback.
- T5. As a teacher, I enter a grade and it appears in the gradebook, including for a
  learner who has not written an entry.
- T6. As a teacher, I open a submissions list that shows each learner's status and
  links to their entry, so I can see who has and has not submitted.
- T7. As a teacher, my activity works with course completion (entry submitted ⇒ complete).

**Learner**
- L1. As a learner, I read the prompt and write my entry using the rich-text editor
  and attachments.
- L2. As a learner, I can edit my entry until the deadline; after it, my entry is locked.
  If there is no deadline, it stays editable.
- L3. As a learner, I see my teacher's feedback as soon as it is saved.
- L4. As a learner, my personal data is covered by Moodle's data request export and
  deletion tools.

**Teacher and learner**
- E1. As a teacher or learner, I see the deadline in the calendar and on the course page.

## Features

### Must have (v1)

- **Activity instance** (T1): `mod_form` with name, prompt (rich text), optional deadline.
- **Single entry per learner** (L1, L2): rich-text editor; editable until the deadline;
  locked after.
- **No draft state**: saving an entry counts as submitting it.
- **Submissions list** (T6): status per learner and a link to each entry, built with a
  core table API.
- **Teacher feedback** (T4): per entry and private; visible only to the entry's learner
  and to teachers; learners see it as soon as it is saved.
- **Gradebook grading** (T3, T5): none/points/scale via `grade_update`; a learner can be
  graded with or without an entry.
- **Deadline display** (E1): calendar event and course-page dates (activity dates API);
  scheduled after the core flow.
- **Completion** (T7): custom completion rule "entry submitted"; once earned, it stays.
- **Events + logging** (T4, T6): entry submitted/updated, feedback given, activity viewed
  and instances list viewed (`course_module_viewed`, `course_module_instance_list_viewed`).
- **Privacy API** (L4): metadata, export and delete support, so Moodle's data request
  tools cover entry and feedback data.
- **Backup/restore**: activity config and user data round-trip.
- **Course reset** (ruled 2026-11-24): "Delete all entries and feedback" in the course
  reset form; grades follow the gradebook's own reset options.
- **File attachments on entries** (L1): last feature milestone, after all other features.
- **Tests + CI**: PHPUnit + Behat suites; moodle-plugin-ci green on GitHub Actions
  **on PostgreSQL and MariaDB from M0**.

### Nice to have (v1.1+, each needs its own task)

- Filters on the submissions list.
- Notify the learner when feedback is posted (Message API).
- Word-count minimum rule.
- Show suspended learners on the submissions list, gated on both
  `moodle/course:enrolreview` and `moodle/course:viewsuspendedusers`.

## Decisions

- The deadline is optional: no deadline means the journal is always open.
- Entries lock at the deadline (no late edits or new entries); teachers can give feedback
  and grades at any time, before or after the deadline.
- There is no draft state: saving an entry is submitting it, and completion, once earned,
  stays.
- Feedback is visible only to the entry's learner and to teachers; learners see it as
  soon as it is saved.
- Grade visibility follows the gradebook's own hidden-grade setting, and learners see
  their own grade inside the activity whenever the gradebook shows it (ruled
  2026-11-24). There is no custom release mechanism.
- Teachers can grade a learner who has no entry.
- Suspended learners are not in the submissions list; their stored entries stay and
  still count for completion. Showing them is a nice-to-have gated on
  `moodle/course:enrolreview` + `moodle/course:viewsuspendedusers`.

## Non-functional requirements

- **Accessibility**: WCAG 2.1 AA; the plugin's pages pass Moodle's Behat accessibility
  checks.
- **Security**: every route uses Moodle's login, capability, sesskey and parameter APIs;
  `docs/security-checklist.md` is walked for every diff.
- **Theme and layout**: works in the Boost theme with no custom theme; responsive layout
  built from core UI components.
- **Coding standards**: Moodle coding style, enforced by moodle-plugin-ci (code checker,
  PHPDoc checker, Mustache lint).

## Out of scope

- **Group mode / group submissions / separate-group visibility** — v1 is strictly
  individual; the plugin does not declare group support.
- **Individual deadlines, extensions and overrides.**
- **Custom grade release mechanism** — the gradebook's hidden-grade setting is the only
  one.
- **Deleting an entry** — no delete action for anyone in v1 (ruled 2026-11-24); this is
  what keeps "completion once earned, stays" true.
- Multi-entry/iterative journals, peer review.
- Advanced grading (rubrics/checklists) — plain points/scale only.
- Mobile app support, external web service, hooks consumption (Future; see
  `docs/architecture.md` §Future — architecture leaves room, no v1 code).
- Moodle < 5.3, databases other than PostgreSQL/MariaDB, multi-tenant/scale concerns.

## Success criteria

- CI green on PostgreSQL and MariaDB.
- Zero phpcs errors and warnings (CI runs with `--max-warnings 0`).
- Tests cover every capability and the grading path.
- A 2-minute demo script.
- README with a screen recording of that script.

## Rulings (2026-11-24; closes the former open questions)

- **Course reset**: yes — a must-have. Resetting clears entries, feedback and their
  files; grades follow the gradebook's own reset options.
- **Deleting an entry**: confirmed — no delete action for anyone in v1.
- **Grades inside the activity**: learners see their own grade there when the gradebook
  shows it; the course `showgrades` switch and the gradebook's hidden rules are the
  only gates (see `docs/architecture.md` §Grading integration).
