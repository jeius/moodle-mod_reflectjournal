# Reflection Journal: Product Requirements

Source of truth for scope. Inherited from `docs/brief.md`; every must-have is testable.

## Goals

- A complete, installable Moodle 5.3 activity module that demonstrates fluent core-API
  usage, tested code, green CI, and a documented agentic workflow (portfolio for a
  Moodle developer role).
- A credible product: a teacher prompts, a learner reflects once before a deadline,
  the teacher responds with feedback and an optional grade.

## User stories

**Teacher**
- T1. As a teacher, I add a Reflection Journal to my course and write the prompt with
  rich text, so learners know what to reflect on.
- T2. As a teacher, I set a deadline, so entries after it are not accepted.
- T3. As a teacher, I choose no grading, points, or a scale, so the activity fits my
  assessment plan.
- T4. As a teacher, I read each learner's entry and write private feedback.
- T5. As a teacher, I enter a grade and it appears in the gradebook.
- T6. As a teacher, I see who has/hasn't submitted at a glance.
- T7. As a teacher, my activity works with course completion (entry submitted ⇒ complete).

**Learner**
- L1. As a learner, I read the prompt and write my entry using the rich-text editor
  and attachments.
- L2. As a learner, I can edit my entry until the deadline; after it, my entry is locked.
- L3. As a learner, I see my teacher's feedback (and grade, if graders release it).
- L4. As a learner, the activity respects my privacy: I can export or delete my data
  through Moodle's privacy machinery.

## Features

### Must have (v1)

- **Activity instance** (T1): `mod_form` with name, prompt (rich text), deadline.
- **Deadline semantics**: entries lock at the deadline (no late edits or new entries);
  teachers can give feedback and grades at any time, before or after the deadline.
- **Single entry per learner** (L1, L2): rich-text editor; editable until the deadline;
  locked after.
- **Teacher feedback** (T4): per-entry private feedback by users with the capability.
- **Gradebook grading** (T3, T5): none/points/scale via `grade_update`.
- **Completion** (T7): custom completion rule "entry submitted".
- **Events + logging** (T4, T6): entry submitted/updated, feedback given.
- **Privacy API** (L4): metadata, export, delete for entry/feedback data.
- **Backup/restore**: activity config and user data round-trip.
- **File attachments on entries** (L1): last feature milestone (M8), after all other
  features — editor-only entries until then.
- **Tests + CI**: PHPUnit + Behat suites; moodle-plugin-ci green on GitHub Actions
  **on PostgreSQL and MariaDB from M0**.

## Success criteria (measurable "done")

Mirrors `docs/brief.md`: CI green on pgsql+mariadb; zero phpcs findings; tests covering
every capability and the grading path; a 2-minute scripted demo; README with a screen
recording of that script.

### Nice to have (v1.1+, each needs its own task)

- Submission overview table with filters (T6 core part: simple list is v1).
- Calendar event for the deadline.
- Word-count minimum rule.

## Out of scope

- **Group mode / group submissions / separate-group visibility** — v1 is strictly
  individual; the plugin does not declare group support.
- Multi-entry/iterative journals, peer review.
- Advanced grading (rubrics/checklists) — plain points/scale only.
- Mobile app support, external web service, hooks consumption (Future; see
  `docs/architecture.md` §Future — architecture leaves room, no v1 code).
- Moodle < 5.3, databases other than PostgreSQL/MariaDB, multi-tenant/scale concerns.

## Open questions

- None blocking M1. (Deadline semantics: editing allowed until deadline; no late
  submissions in v1 — recorded in `docs/architecture.md`.)
