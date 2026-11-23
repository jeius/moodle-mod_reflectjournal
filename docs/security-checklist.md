# Security checklist — walk this for EVERY diff

Reviewer: agent walks it before claiming done; human spot-checks. Any "no" = fix first.

## Access & authentication
- [ ] Every entry script calls `require_login($course, false, $cm)` (or `require_admin` / CLI `define('CLI_SCRIPT', true)` + `require_cli()`? — CLI scripts use `CLI_SCRIPT` + config include) before any output.
- [ ] Course module resolved via `get_course_and_cm_from_cm_info`? no — via `get_course_and_cm_from_cmid()` / `$PAGE->set_cm()`.
- [ ] `require_capability('mod/reflectjournal:…', $context)` immediately before each privileged action (not just page load).

## CSRF & sessions
- [ ] Every state-changing GET/POST checks `require_sesskey()` (or `confirm_sesskey()`); forms include sesskey via `moodleform`/`button` helpers.

## Input handling
- [ ] All request input via `required_param()` / `optional_param()` with explicit `PARAM_*`; never `$_GET/$_POST/$_REQUEST` (or `optional_param_array` with `PARAM_INT` etc. for arrays).
- [ ] IDs typed `PARAM_INT`; text `PARAM_TEXT`/`PARAM_RAW` only where justified; `PARAM_ALPHA`, `PARAM_ALPHANUMEXT` for filenames/areas.
- [ ] Editor/file content cleaned at save (`format_text`/`file_postprocess` usage) with the owner's format and trusted rules decided consciously.

## SQL & data access
- [ ] All SQL through `$DB->get_records('reflectjournal_…', [...])` or explicit placeholders (`:param` / `?`); no string interpolation of user input.
- [ ] Fetches scoped by capability (`WHERE userid` only where the caller may see it).

## Output & files
- [ ] Output via renderer + Mustache; `{{.}}` escaped, `{{{.}}}` only for pre-cleaned HTML; `format_text()`/`format_string()` for stored text.
- [ ] `pluginfile()` in `lib.php` checks capabilities + item ownership before `send_stored_file()`; stale draft areas not listable.
- [ ] No URLs/paths echoed raw; `new moodle_url()` + `action_link`/`button`.

## Privacy & data lifecycle
- [ ] New user data ⇒ `classes/privacy/provider.php` updated (metadata/export/delete) + tests, same commit.
- [ ] Events fired for state changes; no personal data in event `other` beyond ids.

## Supply chain / env
- [ ] No new dependencies without an ADR + user approval; no remote code executed at install/upgrade time.
- [ ] Base images current (PHP2Shell, Oct 2026): `docker compose pull` before long sessions.

## Conventions that are security-adjacent
- [ ] All strings via `get_string()` (no hardcoded text, no HTML in strings).
- [ ] Schema/capability change ⇒ `version.php` bump + `upgrade.php` savepoint (CI checks).
- [ ] GPL + PHPDoc headers on every PHP file; nothing deprecated in 5.3 (`\external_*`, `FEATURE_GROUPMEMBERSONLY`).
- [ ] No edits outside the plugin dir; core and `docker/` untouched.
