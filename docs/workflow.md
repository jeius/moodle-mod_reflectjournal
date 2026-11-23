# Workflow: decide → spec → tickets → plan → execute → PR → merge

The repo's development process, built on the installed skills. Skill facts below were
verified against the installed SKILL.md files on 2026-11-23. Overrides on skill
defaults are declared in `AGENTS.md` ("Workflow preferences") and `docs/agents/*.md`,
and the rationale is in `docs/adr/0006-spec-and-plan-workflow.md`.

## Phases

| # | Phase | Skill | Run by | Artifact |
|---|-------|-------|--------|----------|
| 1 | Decide | `/wayfinder` (large or foggy effort) or `/grill-with-docs` (one feature; wraps grilling + domain-modeling and writes docs as it goes) | **user** (slash command) | wayfinder map issue (`wayfinder:map` + child decision tickets, native blocking), or updated `GLOSSARY.md` + `docs/adr/` |
| 2 | Spec | `/to-spec` | **user** | `specs/NNN-slug.md` — canonical, committed via a small docs PR before tickets exist — plus a parent GitHub issue that links to it |
| 3 | Tickets | `/to-tickets` | **user** | GitHub issues in the milestone, native blocked-by edges, label `ready-for-agent`, each body linking its spec |
| 4 | Plan | `superpowers:writing-plans` | agent | `plans/<issue#>-slug.md` (front matter + the skill's required header and task structure; `plans/README.md`) |
| 5 | Execute | `superpowers:subagent-driven-development` (fallback: `superpowers:executing-plans`), with `superpowers:test-driven-development`, `superpowers:verification-before-completion`, `superpowers:systematic-debugging` on failures | agent | commits on the ticket branch |
| 6 | PR | `superpowers:requesting-code-review`, then `superpowers:finishing-a-development-branch` | agent, then user | PR via `gh`: body says `Closes #N`, links the spec and the plan, CI green |
| 7 | Merge | user reviews the diff against `docs/security-checklist.md` | **user** | merged PR; the agent then updates `docs/progress.md` and artifact statuses |

**Who triggers what.** Phases 1–3 are user-invoked skills — all four carry
`disable-model-invocation: true` in their front matter, so the agent never runs them.
If work arrives without a spec or tickets, the agent stops and asks for phase 2–3 to
happen first. Phases 4–6 are run by the agent when starting a ticket. Phase 7 is the
user's; `finishing-a-development-branch` presents its options and the expected choice
is "push and create a PR" — merging happens on GitHub, after the user's
security-checklist review of the diff. After the merge, the agent updates
`docs/progress.md`, flips the plan's `status` to `done`, fills `pr:`, and — when the
last ticket of a spec merges — flips the spec's `status` to `implemented`.

## One skill per phase (decisions)

Where installed skills overlap, one is canonical per phase; the rest stay available
but out of the workflow:

- **Phase 1 — `/grill-with-docs` over `grilling` / `grill-me`.** It is `grilling` plus
  `domain-modeling` plus doc creation (glossary, ADRs) — exactly the artifact this
  repo indexes. `/wayfinder` is the same family for multi-session, foggy efforts.
  `research` is not a phase: it is phase 1's legwork arm (wayfinder research tickets,
  Moodle API fact checks against moodledev.io).
- **Phases 2–3 — `/to-spec`, `/to-tickets`.** No competitors. `/to-spec`'s body
  template is the spec body, repo notes marked (`specs/README.md`); its "publish to the tracker" default
  is overridden (spec file is canonical, parent issue is a link stub, and it gets no
  `ready-for-agent` label — tickets do).
- **Phase 4 — `superpowers:writing-plans` over `writing-implementation-plans`.** The
  local skill *extends* writing-plans with recon and content rules, but its examples
  are TypeScript/drizzle/vitest-specific and its gates don't transfer; Moodle's plan
  gates live in `plans/README.md` instead. Its general discipline (blast-radius sweep,
  pinned literals from verified sources, runnable checks over prose claims) is worth
  consulting, not binding.
- **Phase 5 — `superpowers:subagent-driven-development` over `implement` /
  `implement-spec` / `sdd-execution`.** SDD gives one fresh implementer per task plus
  a spec-compliance + quality review loop, and chains into requesting-code-review and
  finishing-a-development-branch. `implement-spec` fans parallel background
  implementers across a whole task graph on one integration branch — that breaks both
  one-PR-per-ticket and this repo's no-parallel-writers rule (worktrees are disabled,
  `ADR-0006`). `executing-plans` is the fallback when subagents are unavailable or a
  ticket is one tightly-coupled change. `superpowers:test-driven-development` over
  local `tdd`: same red-green core, but the superpowers Iron-Law loop integrates with
  SDD's review loop and systematic-debugging; the seam discipline `tdd` adds is
  already handled upstream — `/to-spec` step 2 agrees seams with the user, and
  `plans/README.md` binds them per plan.
- **Phase 6 — `superpowers:requesting-code-review` over local `code-review`.** It is
  the reviewer SDD's final whole-branch pass already uses, and it pairs with
  finishing-a-development-branch. The two-axis `code-review` remains available as a
  deeper, user-invoked audit (it already searches `specs/` for the spec) but is not
  the phase skill.

## Artifact lifecycle

- **Spec** (`specs/NNN-slug.md`): `draft` → `approved` (user confirms; parent issue
  filed) → merged to `main` via a small docs PR → tickets cut (`tickets:` fills in) →
  `implemented` when the last ticket merges. **Never deleted** — portfolio evidence.
- **Plan** (`plans/<issue#>-slug.md`): `ready` → `in-progress` → `done`. Committed as
  the **first commit** of the ticket's PR, so the PR reads spec → plan → code.
  **Never deleted.**
- **Parent issue**: one paragraph + link to the spec path; no duplication, no
  `ready-for-agent` label.
- **Ticket issues**: `ready-for-agent`, native blocked-by edges, `Spec:` link line,
  in the milestone; PR bodies say `Closes #N`.
- **Map issues** (wayfinder): `wayfinder:map` + child decision tickets per
  `docs/agents/issue-tracker.md` ("Wayfinding operations"); a map is done when the
  route is clear, and its destination is usually a spec (phase 2).

## Worked example (all numbers made up; no GitHub writes)

Feature: *"learners can't edit after the deadline"* in milestone M2.

1. **Decide.** One feature, mild fog — `/grill-with-docs`. Locks the semantics
   (teachers exempt; what happens at the exact second), adds `deadline` semantics to
   `GLOSSARY.md`; no ADR needed.
2. **Spec.** `/to-spec` writes `specs/004-entry-edit-lock.md`
   (`status: draft`, `milestone: M2`). User approves → `status: approved`; parent
   issue **#17** filed at that same step — one paragraph + "Canonical spec:
   `specs/004-entry-edit-lock.md`", front matter `issue: 17`. Then the small docs
   PR `docs: add spec 004 entry-edit-lock` merges to main.
3. **Tickets.** `/to-tickets` (pointed at the spec): **#18** "Deadline lock: service
   + PHPUnit" (no blockers) and **#19** "Deadline lock: UI + Behat" (blocked by #18).
   Both in milestone M2, `ready-for-agent`, bodies carry `Spec:
   specs/004-entry-edit-lock.md`. Spec: `tickets: [18, 19]`.
4. **Plan.** Agent branches `ticket/18-deadline-lock-service`, runs
   writing-plans → `plans/18-deadline-lock-service.md` (`status: ready`, `issue: 18`,
   `spec: specs/004-entry-edit-lock.md`, `pr: 0`), committed as the branch's first
   commit. Global Constraints carry the Moodle gates from `plans/README.md` and name
   the core API (e.g. activity dates API + calendar events).
5. **Execute.** SDD: failing PHPUnit test at the `classes/` service seam → minimal
   implementation → task review → next. Test failures route through
   systematic-debugging; no completion claims without fresh verification output.
6. **PR.** requesting-code-review's final whole-branch pass, then
   finishing-a-development-branch → push + PR, body: `Closes #18`, links to the spec
   and the plan. CI green. `pr: <n>`.
7. **Merge.** User walks `docs/security-checklist.md` over the diff, merges on
   GitHub. Agent updates `docs/progress.md`; plan `#18` → `done`; spec stays
   `approved` until **#19** merges, then → `implemented`.

## Worktree policy

Worktrees are **disabled** for this repo: the moodle-docker stack bind-mounts this
exact path (ADR-0004), so a worktree anywhere else is invisible to the containers and
tests would run against the wrong tree. Work in place, one feature branch at a time,
never on `main`; subagent execution is sequential. This is the declared preference
that `superpowers:using-git-worktrees` Step 0 and the execution skills honor. Full
rationale and the rejected docker-override alternative: `docs/adr/0006`.
