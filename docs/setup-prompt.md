[$agent-ready-repo](/home/jeius/.zcode/skills/agent-ready-repo/SKILL.md) [$setup-matt-pocock-skills](/home/jeius/.zcode/skills/setup-matt-pocock-skills/SKILL.md)  
You are setting up a Moodle activity-module plugin as a job-application demo
project, using the agent-ready-repo skill. Follow its stages in order. Do NOT
start feature work: this session ends after the docs, AGENTS.md, a verified
baseline, and the first task prompts exist.

## Project
- Plugin: mod_reflectjournal (display name: Reflection Journal)
- Idea: A Moodle activity where teachers post a reflection prompt, learners
  submit and edit one entry before a deadline, and teachers give feedback and
  an optional grade through the gradebook.
- Purpose: a portfolio piece for a Moodle developer role. It must show clean
  Moodle conventions, real tests, CI, and a documented agentic workflow.
- Later (NOT v1, but the architecture must leave room): external web service,
  hooks API usage, mobile app support. Put these in a "Future" section.

## Design principle: use Moodle core, don't reinvent it
The goal is to show fluent use of Moodle's own APIs. Prefer the core
mechanism over custom code in every case, and record each choice in
architecture.md with the API used and a link to its docs:
- Forms: moodleform and the standard mod_form (moodleform_mod)
- Grading: the gradebook via grade_update / the advanced grading API, not a
  custom grade table
- Completion: the custom completion rules API (core_completion)
- Access: roles and capabilities (db/access.php, require_capability)
- Dates and deadlines: the activity dates API and calendar events
- Rich text and attachments: editor and filemanager form elements with the
  File API (file_save_draft_area_files, pluginfile)
- Output: renderer classes, output components and Mustache templates
- Logging: the Events API and standard log store
- Personal data: the Privacy API (metadata, export, delete)
- Backup/restore: the backup and restore task/step classes
- Data access: $DB with XMLDB-defined tables
- Strings: lang files and get_string, never hardcoded text
- Search, activity icon, and "supports" features: declare via
  <modname>_supports()
Only write custom code where no core mechanism fits, and say why in an ADR.

## Step 0: Discover before writing anything
1. Inspect the current repo and the moodle-docker setup: directory layout,
   how Moodle core is checked out, how the plugin is (or should be) mounted
   into mod/, running containers, and which PHP/Node/Composer/Docker versions
   exist in this WSL environment. Report what you find. Do not guess.
2. Search for locally installed skills and tools you can use here: your
   available skills list, ~/.claude/skills, .claude/skills, installed plugins
   and MCP servers. List each one that is relevant (docs, testing, review,
   frontend, PDF, etc.) with when to use it, and record them in AGENTS.md
   under "Skills & tools". Do not install anything without asking me.
3. Never overwrite existing files. Show a diff and merge.

## Step 1: Research (use web search, cite URLs in the ADRs)
Verify these from current official sources (moodledev.io, docs.moodle.org,
github.com/moodlehq) instead of trusting your memory:
- Which Moodle release to target. My own lookup says 5.3 LTS was released on
  5 Oct 2026, with PHP 8.3 minimum (8.4 supported) and PostgreSQL 15+. Confirm
  this, then pin Moodle, PHP, DB and Node versions (Node from Moodle's .nvmrc).
- Current plugin development docs for the "mod" plugin type: required files,
  db/ files (install.xml, access.php, services.php, upgrade.php), privacy
  provider, backup/restore, events, completion and grading support.
- Moodle coding style, PHPDoc rules, security APIs (require_login,
  require_capability, require_sesskey, required_param/optional_param),
  the $DB API, moodleform, renderers/output classes and Mustache, the
  AMD/ES module build with Grunt, and deprecations in the target version.
- The Hooks API: when to use it instead of lib.php callbacks for the target
  version.
- Current moodle-plugin-ci setup and the recommended GitHub Actions matrix
  for supported Moodle/PHP/DB combinations.
- Moodle Marketplace (formerly the Plugins directory) listing requirements.
- Any recent Moodle/PHP security advisories affecting dev containers.
Summarise findings in docs/research.md (short, with links).

## Step 2: Docs (real content, no placeholders, keep each one short)
Create docs/brief.md first and get my confirmation before expanding. Then:
- prd.md: user stories for teacher and student roles, must-have vs
  nice-to-have, explicit out-of-scope list.
- architecture.md: Moodle-specific design: component and folder layout,
  DB tables and relationships (install.xml), capabilities per role, events,
  gradebook and completion integration, form and renderer/template
  structure, privacy provider, backup/restore scope, where web service and
  hooks will plug in later. Include one Mermaid diagram.
- tech-stack.md: every tool with a pinned version and a one-line reason.
- plan.md: phased milestones, each finishable in a handful of small tasks
  with a clear done-condition. Propose something like: M0 baseline (plugin
  installs, lint and tests run, CI green) > M1 skeleton activity with
  add/edit/view > M2 data model and core interaction > M3 capabilities and
  security review > M4 grading and completion > M5 events, logging, privacy
  API > M6 backup/restore > M7 PHPUnit and Behat coverage > M8 polish, seed
  script, README, screen recording. Adjust as you see fit and explain why.
- progress.md, task-template.md (since replaced by docs/specs/ + docs/plans/ — see
  docs/workflow.md), and ADRs for: Moodle version target, plugin
  mounting strategy, repo layout, testing approach.
- docs/security-checklist.md for reviewing every diff (capability checks,
  sesskey, input cleaning, output escaping, no raw SQL with user input).

## Step 3: AGENTS.md (lean, under ~100 lines, every command verified)
Include exact, tested commands for: starting/stopping the environment, purging
caches, running the CLI upgrade, PHPUnit init and run, Behat, phpcs/phpdoc/
mustache lint, Grunt. Include hard guardrails:
- Never modify Moodle core; work only inside the plugin directory.
- Use the $DB API and Moodle security functions; no raw SQL with user input.
- All user-visible text goes in lang/en strings.
- Bump version.php and add upgrade steps with savepoints on any schema or
  capability change.
- Every PHP file gets the GPL header, @package, and PHPDoc.
- Avoid APIs deprecated in the target version.
- Keep code on the Linux filesystem in WSL, not /mnt/c.
- Never run destructive docker commands (down -v, volume prune) without asking.
- Do not commit Moodle core, moodledata, or secrets.

## Step 4: Baseline, then stop
- Make the plugin directory the repo root (version.php, lib.php, db/, lang/
  at top level), with the dev environment under docker/ or documented
  separately, excluded from release zips via .gitattributes.
- Generate a minimal installable skeleton, confirm it installs through the
  CLI upgrade, add one passing PHPUnit test, add .github/workflows running
  moodle-plugin-ci, and make the first commit.
- Report exactly what you verified and what you could not.
- Then write the first two M1 work items per the then-current workflow (task
  prompts from the task template; superseded 2026-11-23 by docs/specs/ + docs/plans/ —
  docs/workflow.md), and suggest which to run first. Wait for my go-ahead.