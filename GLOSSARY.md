# Glossary — mod_reflectjournal / Moodle plugin terms

Vocabulary for issues, ADRs, and agent output. Use these terms; don't drift to synonyms.

| Term | Meaning |
|---|---|
| activity module | A `mod_*` plugin teachers add to a course (our plugin type). |
| instance | One configured occurrence of the activity in a course (row in `reflectjournal`). |
| cm / course module | The `course_modules` record wrapping an instance inside a course section. |
| context | Moodle's permission scope (COURSE, MODULE…); capabilities attach to contexts. |
| capability | `mod/reflectjournal:*` permission in `db/access.php`, checked with `require_capability()`. |
| sesskey | Moodle's CSRF token; `require_sesskey()` on every write. |
| Frankenstyle | `plugintype_pluginname` naming, e.g. `mod_reflectjournal`, `mod/reflectjournal`. |
| entry | A learner's single submission for an instance (`reflectjournal_entries` row). |
| prompt | The teacher's question/instructions; stored as the instance `intro`. |
| deadline | After it, entries are read-only (`deadline` column + calendar event). |
| feedback | Teacher's private response stored on the entry row; distinct from the grade. |
| XMLDB | Moodle's XML schema DSL (`db/install.xml`); tables are prefixed `reflectjournal_`. |
| moodleform | Core form framework; `mod_form.php` (settings) and entry forms subclass it. |
| renderer / Mustache | `classes/output/` + `templates/` — all plugin HTML goes through these. |
| pluginfile | lib.php callback serving stored files for a filearea with access checks. |
| filearea | Named bucket for the File API: `intro`, `entry`, `feedback`. |
| gradebook | Core grades subsystem; our grades flow via `grade_update()`, no custom table. |
| completion | Core activity-completion subsystem; custom rule `completionsubmit`. |
| privacy provider | `classes/privacy/provider.php`: metadata/export/delete of personal data. |
| backup/restore | `backup/moodle2/*` classes making instances + user data portable. |
| moodledata | Core's data dir (file pool); outside the repo, inside the containers. |
| public/ | Moodle 5.x web root inside core (`moodle/public`); plugins at `public/mod/`. |
| wwwroot | The core checkout path used by docker (`$MOODLE_DOCKER_WWWROOT` = `./moodle`). |
| moodle-plugin-ci | HQ tool running phpcs/phpdoc/mustache/grunt/phpunit/behat in CI. |
