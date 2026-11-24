# 0006. Spec/plan workflow replaces per-task prompts

Date: 2026-11-23
Status: Accepted (amended 2026-11-23 and 2026-11-24 — see Amendments below)

## Context

The M0 workflow wrote a per-task prompt from `docs/task-template.md` into
`docs/tasks/` for every unit of work. That gives no canonical artifact between
"idea" and "code": there is no spec layer for tickets to link, no stable path a PR
can reference, and the process itself is invisible in the repo — weak as portfolio
evidence, which is one of this project's goals. Meanwhile the machine has two
complementary skill sets installed: Matt Pocock's decision/spec/ticket skills
(`wayfinder`, `grill-with-docs`, `to-spec`, `to-tickets`; all user-invoked via
`disable-model-invocation`) and superpowers' execution skills (`writing-plans`,
`subagent-driven-development`, `test-driven-development`, `requesting-code-review`,
`finishing-a-development-branch`).

## Decision

Restructure the workflow around seven phases — decide → spec → tickets → plan →
execute → PR → merge — documented in `docs/workflow.md`:

- **`docs/specs/NNN-slug.md`** is the canonical feature spec (front matter + `/to-spec`'s
  body template, repo notes marked; conventions in `docs/specs/README.md`). It lands on `main`
  through a small docs PR **before** tickets are cut, so tickets link a stable path.
  The GitHub parent issue links to it and does not duplicate it. `docs/task-template.md`
  and the two prompts under `docs/tasks/` are removed (user call, 2026-11-23);
  their M1 scope lives on in `docs/plan.md`.
- **`docs/plans/<issue#>-slug.md`** is the agent-written implementation plan per ticket
  (`superpowers:writing-plans` template + front matter; `docs/plans/README.md`), committed
  as the first commit of the ticket's PR so the PR reads spec → plan → code.
- Phases 1–3 run by the user (the skills are user-invoked by design), phases 4–6 by
  the agent, merge by the user. One skill per phase where skills overlap; rationale
  in `docs/workflow.md`.

**Git worktrees: disabled** (single feature branch at a time, work in place). The
dev stack bind-mounts exactly this path (ADR-0004), so a worktree in another
directory is not seen by the containers — PHPUnit/Behat would execute against the
wrong tree. The alternative, a docker override mounting each worktree, was rejected:
it means editing `local.yml` in the pinned moodle-docker clone per branch, and
stacks more per-branch state on top of the shadow-volume trick ADR-0004 already
needs. `superpowers:using-git-worktrees` explicitly honors a worktree preference
declared in instructions (its Step 0), so the override lives in `AGENTS.md`
("Workflow preferences"); `subagent-driven-development`'s "never start on main"
rule still applies via the feature-branch requirement. Consequence: subagent
implementers run strictly sequentially in the one tree (the skill already forbids
parallel implementers).

## Skill defaults overridden (and why it is safe)

| Skill | Default | This repo | Mechanism |
|---|---|---|---|
| `/to-spec` | publish the spec as a tracker issue, `ready-for-agent` | canonical file `docs/specs/NNN-slug.md` + link-stub parent issue, no `ready-for-agent` (tickets only) | `AGENTS.md` prefs + `docs/agents/issue-tracker.md` (the tracker doc the skill consults) |
| `superpowers:writing-plans` | `docs/superpowers/plans/YYYY-MM-DD-<feature>.md` | `docs/plans/<issue#>-slug.md` | the skill itself says user preferences override the location |
| `superpowers:using-git-worktrees` (and SDD/executing-plans' worktree setup) | create an isolated worktree | work in place on one feature branch | the skill's Step 0 honors a declared preference in instructions (`AGENTS.md`) |
| `finishing-a-development-branch` | three integration options | expected choice is "push and create a PR"; merge on GitHub by the user | preference note in `docs/workflow.md` phase 7 |

## Amendment (2026-11-23, later the same day)

`specs/` and `plans/` moved under `docs/` — now `docs/specs/` and `docs/plans/` — by
user decision, before anything had executed against the root layout (no spec, plan,
or ticket flows through the old paths). Co-locating all documentation in one tree
drops the per-directory `export-ignore` lines from `.gitattributes`, and the
discoverability argument in the rejected alternative below was overstated: the
`code-review` skill searches repo-root `specs/` **and** `docs/` for a spec, so
`docs/specs/` is found just as well. Skill-default overrides are unaffected —
`writing-plans` and `using-git-worktrees` honor whatever `AGENTS.md` declares.

## Amendment (2026-11-24): location settled under `docs/`

During the 2026-11-24 architecture round, `specs/` and `plans/` were briefly moved to
the repo root and moved back under `docs/` the same day, on user review. **The
canonical locations are `docs/specs/` and `docs/plans/` — a deliberate choice.** The
reason: the repo root **is** the plugin root, and this repository ships as the plugin
(Marketplace zip, one activity module) — non-plugin workflow files stay out of it.
`docs/` is already export-ignored in `.gitattributes`, so release zips stay clean
without per-directory entries, and the 2026-11-23 nesting rationale (co-locating all
documentation in one tree) stands. Nothing ever executed against the brief root
layout, so no artifact paths changed.

## Alternatives considered

- **Keep `docs/tasks/` prompts**: no canonical spec layer, no stable link targets,
  process invisible; rejected.
- **Skill-default locations** (`docs/superpowers/plans/`, tracker-only specs):
  splits the portfolio across directories; rejected. (The "hides specs from tooling"
  clause was overstated — the `code-review` skill searches repo-root `specs/` and
  `docs/` alike; see Amendment.)
- **Worktree via docker override** (mount the worktree per branch): see above; rejected.

## Consequences

Specs and plans are committed and never deleted — the repo itself demonstrates the
process. They sit under `docs/`, whose `export-ignore` keeps them out of release
zips. Milestone entry points (grill-first; wayfinder only on real unknowns) are
recorded in `docs/plan.md`.
