# Specs

Canonical feature specifications. The spec file is the **single source of truth** for a
feature: GitHub issues link to it and never duplicate it. Specs are kept forever —
they are portfolio evidence of the workflow (see `docs/workflow.md`).

## Naming and numbering

`docs/specs/NNN-slug.md`, globally sequential across the whole repo (`001`, `002`, … — not
per milestone). Take the next free number.

## Front matter

Every spec starts with this front matter (wrapped around the body template below):

```markdown
---
status: draft          # draft | approved | implemented
milestone: M4          # milestone in docs/plan.md
issue: 0               # GitHub parent issue number (0 until filed)
tickets: []            # ticket issue numbers cut from this spec
adrs: []               # ADRs this spec relies on or introduced
---
```

## Body template

The body keeps `/to-spec`'s own template — same sections, same order; wording
preserved except /to-spec's inline example story (omitted) and the two spots
marked *repo note* below. Do not invent a second template. The file layout is:
front matter, then exactly these sections:

```markdown
## Problem Statement

The problem that the user is facing, from the user's perspective.

## Solution

The solution to the problem, from the user's perspective.

## User Stories

A LONG, numbered list of user stories. Each user story should be in the format of:

1. As an <actor>, I want a <feature>, so that <benefit>

This list of user stories should be extremely extensive and cover all aspects of the feature.

## Implementation Decisions

A list of implementation decisions that were made. This can include:

- The modules that will be built/modified
- The interfaces of those modules that will be modified
- Technical clarifications from the developer
- Architectural decisions
- Schema changes
- API contracts
- Specific interactions

*Repo note (condensed from /to-spec):* no specific file paths or code snippets
(they go stale), with one exception: a prototype snippet that encodes a decision
more precisely than prose can may be inlined, trimmed to the decision-rich parts.

## Testing Decisions

A list of testing decisions that were made, including:

- A description of what makes a good test (only test external behavior, not
  implementation details)
- Which modules will be tested (*repo note:* the highest existing seam —
  service classes in `classes/`; Behat for UI journeys)
- Prior art for the tests (similar types of tests in the codebase)

## Out of Scope

A description of the things that are out of scope for this spec.

## Further Notes

Any further notes about the feature.
```

## Lifecycle

1. **draft** — written by the user via `/to-spec` (which synthesizes the
   `/wayfinder` or `/grill-with-docs` conversation; it does not interview).
2. **approved** — user confirms; front matter flips; a parent GitHub issue is filed
   that links to the spec path (one-paragraph summary + link, no duplication).
3. **on main** — the spec lands through a small docs PR **before** tickets are cut,
   so tickets reference a stable path.
4. **implemented** — all tickets cut from it are merged; `tickets:` is filled as
   tickets are cut; status flips when the last one merges.

Statuses are updated by the agent after merges (phase 7 of `docs/workflow.md`).

## Repo-specific overrides on `/to-spec`

Recorded in `AGENTS.md` ("Workflow preferences") and `docs/workflow.md`:

- The canonical artifact is this file, not a tracker issue. `/to-spec`'s default
  ("publish the spec to the issue tracker") becomes: write `docs/specs/NNN-slug.md` and
  file a parent issue that links it.
- The parent issue gets **no** `ready-for-agent` label — that label is for tickets
  cut by `/to-tickets` (`docs/agents/triage-labels.md`). The parent is a link stub,
  not agent-grabbable work.
