# Reflection Journal: Progress

_Last updated: 2026-11-23 (M0 session)_

## Current milestone

**M0 — Baseline: complete** (pending CI-green confirmation on first push).

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

## Next

Run **task prompt M1-T1** (`docs/tasks/m1-t1-mod-form-and-instance-crud.md`):
mod_form + instance CRUD. Then M1-T2 (view + renderer).

## Known issues / notes for next session

- After Behat init, PHPUnit asks for re-init (`php public/admin/tool/phpunit/cli/init.php`)
  before its next run — expected, just re-run it.
- PHPUnit/Behat CLI live under `public/admin/tool/...` in Moodle 5.x (AGENTS.md has it).
- phpdoc/validate/mustache/grunt need a booted core → verified in CI only, not locally.
- moodledev.io per-API doc pages are mid-migration (404s); use the APIs index +
  `docs/research.md` links.
- Host ports 80/8080/5432/3306 are taken by other projects → env web port is 8000.
- Never `docker down` (DB has no volume; its data lives in the container fs, which
  `stop` keeps and `down` destroys). Reset path if ever needed: `up`, then re-run
  `install_database.php`.
