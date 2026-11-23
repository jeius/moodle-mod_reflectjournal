# 0003. Repo layout: plugin at root, pinned dev-stack clone, fresh history

Date: 2026-11-23
Status: Accepted

## Context

The working directory began life as a clone of `moodlehq/moodle-docker` (origin
unpushable; 350+ irrelevant commits). The plugin must be clonable straight into
`mod/` (Marketplace requirement: repo root = plugin root), while the dev environment
and docs need a home that stays out of release zips.

## Decision

- **Repo root is the plugin** (`version.php`, `lib.php`, `db/`, `lang/`, …).
- **`docker/` contains only small override files**: `env.sh` (sourced exports),
  `local.yml.example` (plugin bind mount), and `README.md`. **No vendored copy of
  moodle-docker** — the dev stack is a clone of upstream moodle-docker, **pinned to
  commit `f0583ec`**, living outside the repo (default `~/moodle-docker`); the pinned
  clone step is documented in `docker/README.md`.
- `docs/`, `GLOSSARY.md`, `.github/` live at root; `.gitattributes` marks them
  `export-ignore` so release zips contain only the plugin.
- `moodle/` (core checkout, `MOODLE_503_STABLE`) is gitignored inside the repo and
  is the compose `wwwroot`.
- **Fresh git history**: orphan history starting at the restructure commit; repo
  `jeius/moodle-mod_reflectjournal` (Marketplace naming convention), public.

## Alternatives considered

- Vendoring moodle-docker's compose files under `docker/`: works offline but forks
  upstream config we'd have to re-diff on every upstream change — user rejected;
  updates via `git pull` in a pinned clone are cleaner.
- Keep moodle-docker history: noise, wrong authorship story for a portfolio.
- Separate plugin + env repos: two repos to juggle; rejected.
- Plugin in a subdirectory with symlink: breaks "clone into mod/" requirement.

## Consequences

One-time setup: clone + checkout the pinned commit (documented). Upgrading the dev
stack = pull + move the pin in `docker/README.md`. The repo alone cannot boot the
environment — acceptable for a dev-only, gitignored concern.
