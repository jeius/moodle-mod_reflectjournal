# Reflection Journal (mod_reflectjournal) — Moodle activity module

A Moodle 5.3 (LTS) activity where teachers post a reflection prompt, each learner
writes and edits **one entry** until a deadline, and teachers respond with private
feedback and an optional gradebook grade. Built as a portfolio piece demonstrating
fluent use of Moodle core APIs, real tests, CI, and a documented agentic workflow.

**Status:** M0 baseline (installable skeleton + CI). Roadmap: `docs/plan.md`.

## Requirements

| | |
|---|---|
| Moodle | 5.3 LTS (`MOODLE_503_STABLE`) |
| PHP | 8.3+ (8.4 supported) |
| Database | PostgreSQL 17+, MariaDB 11.4+ |
| Browser tests | Selenium (via moodle-docker) |

## What's inside

- Plugin at repo root (clones straight into `mod/`, per Marketplace convention).
- Core-API-first design: every mechanism maps to a Moodle core API — see the ledger in
  `docs/architecture.md`; deviations require an ADR (`docs/adr/`).
- PHPUnit + Behat tests; moodle-plugin-ci on GitHub Actions (PostgreSQL + MariaDB).
- Agent-ready docs: `AGENTS.md` (operating manual), `docs/` (brief, PRD, architecture,
  plan, progress, ADRs), `GLOSSARY.md`.

## Developing

```bash
source docker/env.sh                       # env vars (see docker/README.md for one-time setup)
$MOODLE_DOCKER_BIN up -d                   # start Moodle 5.3 + PostgreSQL + Selenium
```

Full verified commands: `AGENTS.md`. Dev-environment setup (pinned moodle-docker
clone): `docker/README.md`.

## License

GPL-3.0-or-later, like Moodle itself — see [LICENSE](LICENSE).
