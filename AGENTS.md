# AGENTS.md — mod_reflectjournal (Reflection Journal)

## Project
Moodle 5.3 LTS activity module (portfolio piece): teachers post a reflection prompt,
learners write one entry before a deadline, teachers give feedback + optional gradebook
grade. Core-API-first: every mechanism maps to a Moodle core API (ledger in
`docs/architecture.md`); deviations need an ADR.

Read first: `docs/progress.md` → `docs/plan.md` (milestones M0–M9 = GitHub milestones).
Design: `docs/architecture.md`; decisions: `docs/adr/`; terms: `GLOSSARY.md`;
workflow + one-skill-per-phase rationale: `docs/workflow.md`.
Knowledge graph of docs + code: `graphify-out/` — see *Knowledge graph* below.

## Workflow preferences (overrides on skill defaults — why: ADR-0006)
- Specs: `docs/specs/NNN-slug.md` is canonical (`docs/specs/README.md`). `/to-spec` writes the
  file + a parent issue linking it; the parent never duplicates the spec and gets no
  `ready-for-agent` label (tickets only). Spec reaches main via a small docs PR
  before tickets are cut.
- Plans: `docs/plans/<issue#>-slug.md` (`docs/plans/README.md`), committed as the first commit
  of the ticket's PR.
- **Git worktrees disabled** (ADR-0006): the docker stack bind-mounts this exact
  path, so work in place — one feature branch at a time, never on `main`
  (declared preference per `superpowers:using-git-worktrees` Step 0). Sequential
  subagent implementers only; never two writers in this tree at once.
- Phases 1–3 are the user's slash commands (`disable-model-invocation`): the agent
  never runs `/wayfinder`, `/grill-with-docs`, `/to-spec`, `/to-tickets`, and never
  creates issues or milestones unasked. A ticket without a spec/plan → stop and ask.

## Workflow (lifecycle + worked example: `docs/workflow.md`)
| Phase | Skill | Run by | Artifact |
|---|---|---|---|
| 1 Decide | `/wayfinder` (foggy/large) or `/grill-with-docs` (one feature) | user | map issue, or GLOSSARY.md + `docs/adr/` |
| 2 Spec | `/to-spec` | user | `docs/specs/NNN-slug.md` + parent issue linking it |
| 3 Tickets | `/to-tickets` | user | milestone issues; native blocking; `ready-for-agent`; each links its spec |
| 4 Plan | `superpowers:writing-plans` | agent | `docs/plans/<issue#>-slug.md` |
| 5 Execute | `superpowers:subagent-driven-development` (fallback `executing-plans`) + `test-driven-development`, `verification-before-completion`, `systematic-debugging` | agent | commits on the ticket branch |
| 6 PR | `superpowers:requesting-code-review` → `finishing-a-development-branch` | agent → user | PR `Closes #N`, links spec + plan, CI green |
| 7 Merge | diff vs `docs/security-checklist.md` | user | merge; agent updates `docs/progress.md` + statuses |

## Commands (all verified on this machine)
Every shell: `source docker/env.sh` (sets `$MOODLE_DOCKER_BIN`, wwwroot, port 8000).
One-time setup (pinned moodle-docker clone etc.): `docker/README.md`.

- Start / stop stack (keep data — **never** `down`): `$MOODLE_DOCKER_BIN up -d` / `$MOODLE_DOCKER_BIN stop`
- Site: http://localhost:8000 (admin / adminpass)
- Purge caches: `$MOODLE_DOCKER_BIN exec -T webserver php admin/cli/purge_caches.php`
- CLI upgrade (after version bumps): `$MOODLE_DOCKER_BIN exec -T webserver php admin/cli/upgrade.php`
- PHPUnit init: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/phpunit/cli/init.php`
- PHPUnit run: `$MOODLE_DOCKER_BIN exec -T webserver php vendor/bin/phpunit --testsuite mod_reflectjournal_testsuite`
- Behat init: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/behat/cli/init.php`
- Behat run: `$MOODLE_DOCKER_BIN exec -T webserver php public/admin/tool/behat/cli/run.php --tags="@mod_reflectjournal"`
- Lint (one-time: `composer create-project -n --no-dev --prefer-dist moodlehq/moodle-plugin-ci ci ^4`):
  - phpcs (must stay at **zero** findings — success criterion):
    `./ci/vendor/bin/phpcs --standard=moodle --parallel=1 -d memory_limit=512M lib.php version.php db lang tests classes`
  - savepoints: `./ci/bin/moodle-plugin-ci savepoints .`
  - phpdoc/validate/mustache/grunt need a booted core → they run in GitHub Actions (see below).
- All checks on push: GitHub Actions (moodle-plugin-ci; php 8.3/8.4 × pgsql/mariadb).

## Conventions
- Business logic in namespaced `classes/`; `lib.php` stays a thin bridge.
- Output only via renderer + Mustache; strings only via `get_string()`.
- GPL header + `@package`/`@copyright`/`@license` + PHPDoc on every PHP file.
- Schema/capability change ⇒ bump `version.php` + `db/upgrade.php` savepoint (CI checks).

## Guardrails
- **Never modify Moodle core** (`moodle/` is a checkout; also never commit it) — plugin dir only.
- `$DB` API with param placeholders only; no raw SQL with user input; input via
  `required_param`/`optional_param`; writes behind `require_sesskey()`;
  `require_login` + `require_capability` on every route — walk `docs/security-checklist.md` per diff.
- No APIs deprecated in 5.3 (`\external_*` classes, `FEATURE_GROUPMEMBERSONLY`).
- Keep code on the Linux filesystem in WSL, never `/mnt/c`.
- Docker: never `down`, `down -v`, or volume prunes without asking (DB has no volume; other projects share this host).
- Never commit `moodle/`, `moodledata`, `docker/local.yml`, `ci/`, or secrets.
- Ask before adding any dependency or changing the architecture.

## Skills & tools (one per phase; rationale: `docs/workflow.md`)
- Phases 1–3 (user): `wayfinder`, `grill-with-docs` (over `grilling`/`grill-me`),
  `to-spec`, `to-tickets`.
- Phases 4–6 (agent): `superpowers:writing-plans` (over `writing-implementation-plans`);
  `superpowers:subagent-driven-development` with `superpowers:test-driven-development`
  (over `tdd`), `verification-before-completion`, `systematic-debugging`;
  `superpowers:requesting-code-review` (over `code-review`) →
  `finishing-a-development-branch`.
- Support: `research` (Moodle API facts vs moodledev.io; wayfinder research tickets);
  `moodle-external-api-development` (future web-service phase only); `browser-use`
  plugin (UI verification + M9 recording); `github` plugin (PRs/issues);
  `documents`/`pdf`/`presentations` (portfolio artifacts).

## Knowledge graph (graphify snapshot of docs + code: `graphify-out/`)
- `graphify-out/` is committed and built by the `graphify` skill
  (`.agents/skills/graphify/`): `graph.html` (interactive map), `GRAPH_REPORT.md`
  (communities, hubs, cross-doc bridges), `graph.json` (raw data).
- For questions that span documents — what a concept touches, how two decisions
  connect — query it before grepping: `graphify query "<question>"`;
  `graphify affected "<node>"` (what references it); `graphify path "A" "B" --undirected`;
  `graphify explain "<node>"`. A single known symbol or file is still faster with `grep`.
- It is a snapshot and can lag the working tree: each node names its source file —
  confirm there before relying on an answer. The source wins.
- Refresh only when the user asks, with `/graphify . --update`: incremental (changed code
  re-parsed free, changed docs re-read through the LLM), and it always scans the root saved
  in `graphify-out/.graphify_root` — keep that the repo root. `graph.json` is rewritten
  whole each time: a full-file diff is normal, not churn.

## Agent skills
### Issue tracker
GitHub Issues on `jeius/moodle-mod_reflectjournal` via `gh`; milestones M0–M9 mirror `docs/plan.md`; one PR per issue. See `docs/agents/issue-tracker.md`.
### Triage labels
Defaults: `needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human`, `wontfix`. See `docs/agents/triage-labels.md`.
### Domain docs
Single-context: root `GLOSSARY.md` + `docs/adr/`. See `docs/agents/domain.md`.
