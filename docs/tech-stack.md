# Reflection Journal: Tech Stack

Versions pinned 2026-11-23 (sources in `docs/research.md`). Significant choices have
ADRs in `docs/adr/`.

| Area | Choice | Version | Why |
|------|--------|---------|-----|
| Platform | Moodle core | `MOODLE_503_STABLE` (5.3.1+, Build 20261117) | Current stable **and** LTS → Oct 2029; what a hiring reviewer expects (ADR-0002) |
| Language | PHP | 8.3 (min) / 8.4 in CI matrix | 5.3 floor is 8.3.0; 8.4 supported — cover both |
| Database | PostgreSQL | 17 | 5.3 minimum; matches moodle-docker default and plugin-ci 4.5.11 guidance |
| Node | `lts/jod` | Node 22 LTS | Pinned by core `.nvmrc`; only needed for Grunt/SCSS/AMD work |
| Dev runtime | moodle-docker (external pinned clone) | upstream commit `f0583ec` (2026-11) | HQ-blessed PHP/Apache/DB/Selenium stack; repo keeps only override files in `docker/` (ADR-0003/0004) |
| PHP image | `moodlehq/moodle-php-apache` | `8.3` tag, re-pull regularly | PHP2Shell CVEs (Oct 2026) make freshness a security requirement |
| Unit/integration tests | PHPUnit (core-bundled) | as shipped by 5.3 | `advanced_testcase`, generators, DB snapshots (ADR-0005) |
| Acceptance tests | Behat (core-bundled) + Selenium | Firefox standalone 4 | Ships with moodle-docker; Chrome profile in CI |
| Code quality | moodle-plugin-ci | `^4` (latest stable 4.5.11) | phplint/phpcs (moodle-cs)/phpdoc/validate/savepoints/mustache/grunt/phpunit/behat in one CLI (ADR-0005) |
| CI | GitHub Actions | ubuntu-24.04 runners | Free for public repo; official workflow template from moodle-plugin-ci; **pgsql + mariadb** matrix (success criterion) |
| Packaging | `.gitattributes` export-ignore | — | Marketplace zips exclude docs/, docker/, .github/ |

Everything else is Moodle core API surface — no additional dependencies by design.
