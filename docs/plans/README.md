# Plans

One implementation plan per ticket, written by the agent with
`superpowers:writing-plans` (phase 4 of `docs/workflow.md`). Plans are kept forever —
they are portfolio evidence of the workflow.

## Naming and front matter

`docs/plans/<issue#>-slug.md`, named after the ticket (e.g. `docs/plans/18-deadline-lock-service.md`).

```markdown
---
status: ready          # ready | in-progress | done
issue: 18              # ticket this plan implements
spec: docs/specs/004-entry-edit-lock.md   # canonical spec
pr: 0                  # PR number (0 until opened)
---
```

## Body template

The body follows `superpowers:writing-plans` exactly — do not invent a second shape:

- The **required plan header** (goal, architecture, tech stack, `Spec:` path,
  **Global Constraints** copied verbatim from the spec), including its line pointing
  executors at `superpowers:subagent-driven-development` / `executing-plans`.
- Bite-sized tasks, each with exact **Files**, **Interfaces**, and checkbox steps:
  write the failing test → run it, watch it fail → minimal implementation → run
  again → commit. No placeholders ("TBD", "add error handling", "similar to Task N").
- The skill's self-review pass (spec coverage, placeholder scan, type consistency)
  before the plan is committed.

The front matter is the only addition on top of the skill's template.

## Lifecycle

The plan is committed as the **first commit of the ticket's PR**, so the PR reads
spec → plan → code. Status flips `ready → in-progress → done` as execution proceeds;
`pr:` is filled when the PR opens. Never deleted; `done` plans stay as evidence.

## Moodle-specific requirements (binding for every plan)

Global Constraints must carry these, and every task must satisfy them:

1. **Test-first, always.** Every feature task starts with a failing test:
   PHPUnit for logic (use the plugin's PHPUnit data generator for instances and
   entries — `tests/generator/lib.php` is finalized in M7, so earlier plans create or
   extend it as their first need requires), Behat only for UI journeys. Run
   commands are in `AGENTS.md`; watch the test fail before writing
   implementation code (`superpowers:test-driven-development`).
2. **Highest existing seam.** Test through the service classes in `classes/`;
   Behat for UI flows. New seams are proposed in the spec (`/to-spec` step 2), never
   invented in a plan. The ideal number of new seams is zero.
3. **End-of-task gate.** Every task ends with all of:
   - `phpcs` at **zero findings** (command in `AGENTS.md`);
   - user-visible text only via lang strings (`get_string()` — never hardcoded);
   - `docs/security-checklist.md` walked for the task's diff: capability checks,
     `require_sesskey()` on writes, `required_param`/`optional_param` cleaning;
   - `version.php` bump + `db/upgrade.php` savepoint **if** schema or capabilities
     changed (CI checks this);
   - cache purge: `$MOODLE_DOCKER_BIN exec -T webserver php admin/cli/purge_caches.php`.
4. **Name the core API.** Every mechanism in the plan names the Moodle core API it
   uses, matching the ledger in `docs/architecture.md` (e.g. `grade_update`,
   `\core_privacy\local\metadata\provider`). A mechanism with no core API needs an
   ADR **before** the plan is written, not during execution.

## Location override

`superpowers:writing-plans` defaults to `docs/superpowers/plans/YYYY-MM-DD-<feature-name>.md`;
it explicitly honors user preferences, which this repo declares in `AGENTS.md`
("Workflow preferences") and records in `docs/adr/0006-spec-and-plan-workflow.md`:
plans live here, named after the ticket.
