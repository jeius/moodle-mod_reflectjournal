# Dev environment (moodle-docker, pinned external clone)

This repo deliberately keeps **only override files** here (`env.sh`,
`local.yml.example`). The dev stack itself is upstream
[moodle-docker](https://github.com/moodlehq/moodle-docker), cloned outside the repo and
**pinned to a commit** so every machine reproduces the verified baseline
(decision: `docs/adr/0003`).

## One-time setup

```bash
# 1. Clone moodle-docker OUTSIDE this repo and pin it (currently verified commit):
git clone https://github.com/moodlehq/moodle-docker.git ~/moodle-docker
git -C ~/moodle-docker checkout f0583ec

# 2. Install our plugin bind mount into the clone (applied last by the wrapper):
cp docker/local.yml.example ~/moodle-docker/local.yml
#    (adjust the repo path inside if you cloned this repo elsewhere)

# 3. Moodle core 5.3 checkout inside this repo (gitignored; MOODLE_503_STABLE):
git clone --branch MOODLE_503_STABLE https://github.com/moodle/moodle.git moodle

# 4. Site config from the pinned clone's template:
cp ~/moodle-docker/config.docker-template.php moodle/config.php

# 5. Source the environment (do this in every shell):
source docker/env.sh
```

## Daily use

See `AGENTS.md` for the exact verified commands (`$MOODLE_DOCKER_BIN up -d`,
`exec webserver php admin/cli/upgrade.php`, PHPUnit, Behat, …).

## Updating the stack pin

```bash
git -C ~/moodle-docker fetch origin
git -C ~/moodle-docker checkout <new-commit>   # then re-verify the baseline
```
Record the new commit here and in `docs/tech-stack.md`.

**Currently pinned: `f0583ec`** (verified 2026-11-23 with Moodle 5.3.1+ / PHP 8.3 /
PostgreSQL 17).

## Notes

- Host ports 80/8080/5432/3306 are taken by other projects on this machine —
  `env.sh` pins the web port to **8000** and `COMPOSE_PROJECT_NAME=reflectjournal`.
- The plugin bind-mounts to `/var/www/html/public/mod/reflectjournal` because Moodle
  5.x serves from `public/` (docs + local checkout; see `docs/adr/0004`).
- Never run `down -v` or volume prunes without asking — other projects share this host.
