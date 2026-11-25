# Brief — mod_reflectjournal (Reflection Journal)

**Status: confirmed by the user 2026-11-23** (with the changes recorded below);
later docs inherit it.

## Problem

A job application needs a portfolio piece proving real Moodle plugin craftsmanship:
fluent use of core APIs, Moodle coding style, meaningful tests, CI, and a documented
agentic development workflow. The vehicle is a small but complete activity module.

## Product (one line)

Teachers post a reflection prompt; each learner writes and edits **one entry** up to a
deadline; teachers give feedback and an optional gradebook grade.

## Audience

- **Hiring reviewers / Moodle developers** (primary — they read the code, docs, CI).
- **Teachers and learners** (the demo's users; UX must be credible, not throwaway).

**Note 2026-11-25:** the plugin is now also a component of a larger Moodle demo site
maintained in a separate private repository, so a non-technical evaluator looking at
a working LMS joins hiring reviewers as an audience. Scope and success criteria for
this plugin are unchanged.

## Scope

**Must have (v1):**
- Activity module `mod_reflectjournal`, installable on Moodle 5.3 LTS.
- Teacher configures prompt (rich text), deadline, and grading (none/points/scale).
- Learner submits one entry (rich text + attachments), editable until the deadline.
- Teacher per-learner feedback; grade flows through the gradebook (`grade_update`).
- Completion rules, events/logging, privacy provider, backup/restore.
- PHPUnit + Behat tests; moodle-plugin-ci CI green; GPL headers; lang strings only.

**Nice to have (post-v1, architecture must leave room — "Future" sections):**
- External web service (current `core_external` API — `\external_*` is deprecated in 5.3).
- Hooks API usage (`db/hooks.php`).
- Moodle App (mobile) support.

**Scheduled last within v1:** file attachments on entries (kept in v1 scope, built as
the final feature milestone — see `docs/plan.md` M8).

**Out of scope (v1):**
- **Group mode / group submissions** (explicitly not declared; no groupings support).
- Multi-entry journals, peer review, rubrics/advanced grading beyond core hooks,
- teacher-to-teacher moderation workflows, AI features, branding/theming work,
- support for Moodle < 5.3, databases other than PostgreSQL/MariaDB.

## Success criteria (v1 done = all of these)

- CI green on **PostgreSQL and MariaDB** from M0 onwards.
- **Zero phpcs (moodle-cs) errors/warnings** in every milestone.
- Tests cover **every capability** and the **grading path** (PHPUnit + Behat).
- A **2-minute demo script** (deterministic, seedable) driving the README
  **screen recording**.

## Deadline semantics (settled)

Entries lock at the deadline; teachers can give feedback and grades at any time
(before or after the deadline).

## Constraints

- **Design principle: use Moodle core, never reinvent** — every mechanism maps to a core
  API, recorded in `docs/architecture.md` with doc links; custom code needs an ADR.
- Target: **Moodle 5.3 LTS** (`MOODLE_503_STABLE`), **PHP 8.3/8.4**, **PostgreSQL 17**,
  **Node 22 LTS** (`lts/jod` from core `.nvmrc`). Facts in `docs/research.md`.
- Dev environment: moodle-docker under WSL2; repo root = plugin root; never modify core;
  code stays on the Linux filesystem, not `/mnt/c`.
- Workflow: agent-ready-repo docs (this file set), small verified tasks, human review.

## Decisions (settled 2026-11-23)

1. **Fresh git history** — orphan history from the restructure commit; old moodle-docker
   clone history dropped (upstream keeps it). See ADR-0003.
2. **docker/ holds only small override files** — no vendored moodle-docker copy; the
   dev environment is a pinned clone of upstream moodle-docker (step documented in
   `docker/README.md`). See ADR-0003/0004.
3. **Issue tracker: GitHub Issues** on the new public repo `jeius/moodle-mod_reflectjournal`,
   with **milestones M0–M9 mirroring `docs/plan.md`** and **one PR per issue**.
4. PostgreSQL minimum corrected to **17** per the 5.3 release notes (`docs/research.md`).
