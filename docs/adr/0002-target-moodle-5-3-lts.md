# 0002. Target Moodle 5.3 LTS

Date: 2026-11-23
Status: Accepted

## Context

A portfolio plugin must target a version a reviewer would deploy, for a support window
that outlives the application process. Verified 2026-11-23
(<https://moodledev.io/general/releases>, <https://moodledev.io/general/releases/5.3>,
core `public/version.php` on `MOODLE_503_STABLE`).

## Decision

Target **Moodle 5.3 LTS** (`MOODLE_503_STABLE`, currently 5.3.1+ Build 20261117):
- PHP **8.3** floor, **8.4** in the CI matrix (5.3 supports both).
- **PostgreSQL 17** (5.3 raised the minimum from 15 — corrected from the brief).
- **Node 22 LTS** (`lts/jod`, from core `.nvmrc`) for Grunt work only.
- `version.php`: `$plugin->requires = 2026100500` (5.3.0); no `supported` range below that.

## Alternatives considered

- 5.2 (what the local checkout had): non-LTS, security support ends Oct 2027 — a weaker
  portfolio story; rejected.
- 4.5 LTS: longer tail but pre-`public/` layout and ageing APIs; rejected.
- `main`/6.0: moving target, no support guarantees; rejected.

## Consequences

Single-branch support keeps code simple (`$plugin->supported` optional). Plugins
directory/Marketplace listing will run its checks against 5.3. Deprecations to respect:
`\external_*` classes (MDL-81225), `FEATURE_GROUPMEMBERSONLY` (MDL-83231).
