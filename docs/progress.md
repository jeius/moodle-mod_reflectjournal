# Reflection Journal: Progress

_Last updated: 2026-11-25 (M1–M9 paused until the larger demo site ships; M0 complete)_

## Current milestone

**M0 — Baseline: complete** (2026-11-24). The `fix baseline CI` PR ran green on
**all four matrix jobs** (php 8.3/8.4 × pgsql/mariadb, run 45338573304); the Validating
step carries `continue-on-error: true` until M1 lands the three entry files (#2). Docs
work (architecture round 3, ADR-0007/0008, plan re-slice approval) merged as PR #4.

## Done

- Versions verified from official sources (`docs/research.md`); brief confirmed with
  user changes (success criteria, deadline semantics, group mode out, attachments last).
- Docs set + ADRs 0001–0005; AGENTS.md (verified commands); GLOSSARY; docs/agents/ config.
- Repo restructured: plugin at root; `docker/` = override files + pinned-clone docs;
  fresh git history; GitHub repo `jeius/moodle-mod_reflectjournal` (issues + milestones
  M0–M9 mirror plan.md).
- Dev env verified: moodle-docker @ `f0583ec`, core `MOODLE_503_STABLE` (5.3.1+),
  plugin bind-mounted at `public/mod/reflectjournal` (nested `moodle/`+`ci/` shadowed —
  see ADR-0004).
- Plugin installs via `admin/cli/install_database.php` (table `m_reflectjournal`
  created; `mod_reflectjournal` version 2026112300 recorded).
- PHPUnit: **3/3 green** (`mod_reflectjournal_testsuite`). phpcs (moodle-cs):
  **0 findings**. Behat init + run verified (no scenarios yet). purge_caches +
  CLI upgrade verified.
- Workflow restructured around `docs/specs/` + `docs/plans/` (ADR-0006, amended
  same day to nest them under `docs/`): `docs/task-template.md` and the superseded
  `docs/tasks/` prompts removed, `docs/workflow.md` added, AGENTS.md rewritten.
- M0 closed out (2026-11-24): plan re-slice approved and merged (PR #4); baseline CI
  fixed and green on all four jobs (PR #5, run 45338573304) — `CoversNothing` on the
  base test, Validating `continue-on-error` until #2, `$plugin->release = '0.1.0'`.

## Next

M1–M9 are **paused (2026-11-25)** until the larger Moodle demo site (maintained in a
separate private repository) ships. Work then resumes at M1 via the workflow
(`docs/workflow.md`), as before: `/grill-with-docs` on the M1 slice → `/to-spec` →
small docs PR → `/to-tickets`. Scope: the M1 section of `docs/plan.md` (the removed
`docs/tasks/` prompts added no scope beyond it).

## Known issues / notes for next session

- After Behat init, PHPUnit asks for re-init (`php public/admin/tool/phpunit/cli/init.php`)
  before its next run — expected, just re-run it.
- PHPUnit/Behat CLI live under `public/admin/tool/...` in Moodle 5.x (AGENTS.md has it).
- phpdoc/validate/mustache/grunt need a booted core → verified in CI only, not locally.
- moodledev.io per-API doc pages are live (re-checked 2026-11-24; 378 URLs in the
  sitemap) — cite the versioned `/docs/5.3/` paths; index: `docs/research.md`.
- Host ports 80/8080/5432/3306 are taken by other projects → env web port is 8000.
- Never `docker down` (DB has no volume; its data lives in the container fs, which
  `stop` keeps and `down` destroys). Reset path if ever needed: `up`, then re-run
  `install_database.php`.
