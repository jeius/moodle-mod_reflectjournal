# 0004. Plugin mounting: bind mount via the pinned clone's local.yml

Date: 2026-11-23
Status: Accepted

## Context

moodle-docker mounts the whole core checkout (`$MOODLE_DOCKER_WWWROOT` →
`/var/www/html`). The plugin repo sits outside that checkout, so it must appear inside
the container at the correct plugin path without copying files or editing core.

**Plugin path, verified from official docs for 5.3:** the 5.3-versioned activity-module
guide shows module files at `public/mod/[modname]/…`
(e.g. `public/mod/[modname]/db/access.php`) —
https://moodledev.io/docs/5.3/apis/plugintypes/mod — i.e. since Moodle 5.0 the web
root is `public/`, so the container path is
`/var/www/html/public/mod/reflectjournal` (corroborated by the local
`MOODLE_503_STABLE` checkout, which has `public/` and no top-level `mod/`).

## Decision

The moodle-docker wrapper's documented local-customisation hook is a `local.yml` next
to its compose files (applied last). Our committed `docker/local.yml.example` is copied
into the pinned moodle-docker clone (e.g. `~/moodle-docker/local.yml`, gitignored
there) and adds to the webserver service:

```yaml
services:
  webserver:
    volumes:
      - "/home/jeius/moodle-demo:/var/www/html/public/mod/reflectjournal:delegated"
      # Anonymous volumes shadow repo-local, non-plugin dirs from the classmap:
      - "/var/www/html/public/mod/reflectjournal/moodle"
      - "/var/www/html/public/mod/reflectjournal/ci"
```

Without the shadow volumes, Behat init regenerates the classmap over the nested core
copy and dies with "Cannot declare interface behat_session_interface" (verified
2026-11-23). `docker/env.sh` sets `MOODLE_DOCKER_WWWROOT` to this repo's `moodle/`
checkout. The mount is read-write on the webserver; selenium's copy is read-only core
and doesn't need it.

## Alternatives considered

- **Symlink `moodle/public/mod/reflectjournal → ../../`**: dangles inside the container
  (bind mounts can't follow paths outside the mounted tree). Rejected — this is the
  technical crux.
- **Copy/sync files into `moodle/`**: drift, stale-code bugs; rejected.
- **Put the plugin repo inside `moodle/public/mod/`**: inverts repo layout, conflicts
  with the plugin-at-root requirement (ADR-0003).

## Consequences

The repo root is visible inside the container under `mod/reflectjournal/`, with
`moodle/` and `ci/` hidden by anonymous volumes. CI is unaffected (checks out the repo
without gitignored paths). `moodle/` nesting inside the repo remains the price of a
one-directory setup; the shadow volumes neutralise its only observed side effect.
