# 0005. Testing approach: PHPUnit + Behat in containers, moodle-plugin-ci on GitHub

Date: 2026-11-23
Status: Accepted

## Context

Tests must prove real Moodle behaviour (DB, forms, completion, gradebook), run locally
in WSL2 without host PHP setup, and gate every push. Verified current practice:
moodle-plugin-ci 4.5.11 (https://moodlehq.github.io/moodle-plugin-ci/CHANGELOG.html).

## Decision

- **Locally**: everything runs inside the moodle-docker containers —
  `admin/tool/phpunit/cli/init.php` then `vendor/bin/phpunit --testsuite mod_reflectjournal_testsuite`
  in the webserver container; Behat analogously against the bundled Selenium.
- **CI**: GitHub Actions workflow modelled on moodle-plugin-ci `gha.dist.yml`
  (https://raw.githubusercontent.com/moodlehq/moodle-plugin-ci/main/gha.dist.yml), matrix
  **`MOODLE_503_STABLE` × PHP 8.3/8.4 × {pgsql, mariadb}** (Postgres 17 / MariaDB 11
  services per 4.5.11 guidance; **both DBs from M0** — success criterion),
  steps: phplint, phpmd (advisory), phpcs (moodle-cs, max-warnings 0), phpdoc, validate,
  savepoints, mustache, grunt, phpunit, behat (chrome profile).
- The plugin's own tests live in `tests/` (PHPUnit) and `tests/behat/` (Gherkin);
  a `tests/generator.php` feeds both (M7).

## Alternatives considered

- Host-installed PHP + core checkout: duplicates the container stack, WSL friction.
- CI-only testing: slow feedback loop; agents need local proof to self-correct.
- Third-party test runners: none have Moodle's fixtures/generators.

## Consequences

Two execution contexts must both stay green; container first-run cost (~minutes).
`phpunit.xml` overrides stay in core (`moodle/`), never in the repo. Behat in CI uses
Chrome while local uses Firefox — both are stock profiles of the same suite.
