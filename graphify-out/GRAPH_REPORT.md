# Graph Report - moodle-demo  (2026-11-23)

## Corpus Check
- Corpus is ~15,365 words - fits in a single context window. You may not need a graph.

## Summary
- 321 nodes · 380 edges · 29 communities (12 shown, 17 thin omitted)
- Extraction: 88% EXTRACTED · 12% INFERRED · 0% AMBIGUOUS · INFERRED: 44 edges (avg confidence: 0.87)
- Token cost: 864,968 input · 0 output

## Community Hubs (Navigation)
- Workflow Phases and Milestones
- Agent Operating Manual
- Core API Integrations
- Product Requirements and Scope
- CI Workflow Config
- Workflow Skills and Conventions
- Milestones and Success Criteria
- CI YAML Structure
- Domain Glossary Terms
- Capabilities and Security
- Docker Env Configuration
- lib.php Instance Hooks
- Unit Test Baseline
- Security Primitives
- Output and Coding Conventions
- Plugin Icon Design
- Known Environment Issues
- Node Toolchain Pin
- PHP Version Matrix
- Worktree Policy
- Portfolio Audience
- Nice-to-Have Features
- Public Web Root
- Wwwroot Concept
- Spec Naming Convention

## God Nodes (most connected - your core abstractions)
1. `Security checklist walked for every diff` - 14 edges
2. `User stories T1-T7, L1-L4, E1` - 13 edges
3. `Reflection Journal (mod_reflectjournal)` - 9 edges
4. `Seven-phase workflow (decide, spec, tickets, plan, execute, PR, merge)` - 9 edges
5. `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` - 9 edges
6. `steps` - 8 edges
7. `with` - 8 edges
8. `entry` - 8 edges
9. `reflectjournal_entries table` - 8 edges
10. `Plugin bind mount via pinned clone's local.yml` - 7 edges

## Surprising Connections (you probably didn't know these)
- `Platform requirements (Moodle 5.3 LTS, PHP 8.3+, PostgreSQL 17+/MariaDB 11.4+, Selenium)` --conceptually_related_to--> `Moodle 5.3 LTS target (MOODLE_503_STABLE)`  [INFERRED]
  README.md → docs/adr/0002-target-moodle-5-3-lts.md
- `Worked example: entry-edit-lock (spec 004, issues #17-#19, plan 18)` --references--> `Spec front matter (status, milestone, issue, tickets, adrs)`  [INFERRED]
  docs/workflow.md → specs/README.md
- `Moodle 5.3 LTS target (MOODLE_503_STABLE)` --conceptually_related_to--> `Reflection Journal (mod_reflectjournal)`  [INFERRED]
  docs/adr/0002-target-moodle-5-3-lts.md → AGENTS.md
- `Repo root = plugin root` --conceptually_related_to--> `Reflection Journal (mod_reflectjournal)`  [INFERRED]
  docs/adr/0003-repo-layout.md → AGENTS.md
- `AGENTS.md operating manual` --conceptually_related_to--> `In-container PHPUnit + Behat testing`  [INFERRED]
  AGENTS.md → docs/adr/0005-testing-approach.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Seven-phase lifecycle and its skills** — agents_seven_phase_workflow, agents_wayfinder_skill, agents_grill_with_docs_skill, agents_to_spec_skill, agents_to_tickets_skill, agents_superpowers_writing_plans, agents_superpowers_subagent_driven_development, agents_superpowers_test_driven_development, agents_superpowers_requesting_code_review, agents_superpowers_finishing_a_development_branch [EXTRACTED 1.00]
- **Reflection Journal entry lifecycle domain model** — glossary_activity_module, glossary_instance, glossary_cm_course_module, glossary_prompt, glossary_entry, glossary_deadline, glossary_feedback, glossary_gradebook [EXTRACTED 1.00]
- **Containerized dev and test stack** — docker_readme_moodle_docker_pin, docker_readme_local_yml_example, docker_readme_env_sh, docs_adr_0003_repo_layout_pinned_dev_stack, docs_adr_0004_plugin_mount_bind_mount_bind_mount, docs_adr_0004_plugin_mount_bind_mount_shadow_volumes, docs_adr_0005_testing_approach_container_testing [INFERRED 0.85]
- **Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md)** — docs_plan_milestone_ladder, docs_plan_milestone_m0, docs_plan_milestone_m1, docs_plan_milestone_m2, docs_plan_milestone_m3, docs_plan_milestone_m4, docs_plan_milestone_m5, docs_plan_milestone_m6, docs_plan_milestone_m7, docs_plan_milestone_m8, docs_plan_milestone_m9 [EXTRACTED 1.00]
- **Capability matrix: five mod/reflectjournal capabilities** — docs_architecture_capability_matrix, docs_architecture_capability_addinstance, docs_architecture_capability_view, docs_architecture_capability_submit, docs_architecture_capability_givefeedback, docs_architecture_capability_grade [EXTRACTED 1.00]
- **Development pipeline: phases 1-7 (decide to merge)** — docs_workflow_phase_1_decide, docs_workflow_phase_2_spec, docs_workflow_phase_3_tickets, docs_workflow_phase_4_plan, docs_workflow_phase_5_execute, docs_workflow_phase_6_pr, docs_workflow_phase_7_merge [EXTRACTED 1.00]

## Communities (29 total, 17 thin omitted)

### Community 0 - "Workflow Phases and Milestones"
Cohesion: 0.07
Nodes (33): Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md), Milestone M1: Skeleton activity, Milestone M2: Data model and core interaction, Milestone M7: PHPUnit and Behat coverage, Next: M1 via the workflow, Phase 1: Decide, Phase 2: Spec, Phase 3: Tickets (+25 more)

### Community 1 - "Agent Operating Manual"
Cohesion: 0.07
Nodes (23): Domain docs convention (GLOSSARY.md + docs/adr/), GitHub Actions CI (moodle-plugin-ci matrix), grill-with-docs skill (Phase 1: decide), Reflection Journal (mod_reflectjournal), AGENTS.md operating manual, CLAUDE.md @AGENTS.md import, Plugin bind mount /var/www/html/public/mod/reflectjournal, docker/env.sh (sourced exports) (+15 more)

### Community 2 - "Core API Integrations"
Cohesion: 0.07
Nodes (27): mod_reflectjournal\dates (activity dates class), Backup/restore scope, Calendar event integration for the deadline, mod/reflectjournal:givefeedback, mod/reflectjournal:submit, grade_update(), reflectjournal grade module callbacks (*_grade_item_update, *_update_grades, *_grade_item_delete, *_rescale_activity_grades), Privacy provider scope (+19 more)

### Community 3 - "Product Requirements and Scope"
Cohesion: 0.08
Nodes (17): Future: external web service (core_external), Future: Hooks API (db/hooks.php), mod_reflectjournal (Reflection Journal plugin), Post-v1 scope: web service, hooks API, mobile app, v1 out of scope (group mode, multi-entry, peer review, rubrics, AI), Product: prompt -> one entry by deadline -> feedback + optional grade, Out of scope (group mode, overrides, custom release, advanced grading), 5.3 DB minimums (PostgreSQL 17, MySQL 8.4, MariaDB 11.4) (+9 more)

### Community 4 - "CI Workflow Config"
Cohesion: 0.07
Nodes (29): MARIADB_ALLOW_EMPTY_ROOT_PASSWORD, MYSQL_CHARACTER_SET_SERVER, MYSQL_COLLATION_SERVER, POSTGRES_HOST_AUTH_METHOD, POSTGRES_USER, jobs, test, env (+21 more)

### Community 5 - "Workflow Skills and Conventions"
Cohesion: 0.12
Nodes (19): Issue tracker conventions (GitHub Issues via gh), Milestones M0-M9, superpowers:finishing-a-development-branch skill (Phase 6-7), superpowers:requesting-code-review skill (Phase 6: PR), superpowers:subagent-driven-development skill (Phase 5: execute), superpowers:test-driven-development skill, superpowers:writing-plans skill (Phase 4: plan), to-spec skill (Phase 2: spec) (+11 more)

### Community 6 - "Milestones and Success Criteria"
Cohesion: 0.10
Nodes (15): v1 success criteria (CI green both DBs, zero phpcs, capability+grading tests, 2-min demo), Milestone M0: Baseline, Milestone M8: Attachments (last feature milestone), Milestone M9: Polish and release, Feature: file attachments on entries (last), Feature: tests + CI from M0, Non-functional requirements (WCAG 2.1 AA, security APIs, Boost, coding style), Success criteria (+7 more)

### Community 7 - "CI YAML Structure"
Cohesion: 0.12
Nodes (17): DB, MOODLE_BRANCH, continue-on-error, env, if, name, run, uses (+9 more)

### Community 8 - "Domain Glossary Terms"
Cohesion: 0.15
Nodes (15): activity module, backup/restore, cm / course module, completion, deadline, entry, feedback, filearea (+7 more)

### Community 9 - "Capabilities and Security"
Cohesion: 0.17
Nodes (5): mod/reflectjournal:addinstance, mod/reflectjournal:grade, mod/reflectjournal:view, Milestone M3: Capabilities and security review, Security functions (require_login, require_capability, require_sesskey, params, $DB) stable core API

### Community 10 - "Docker Env Configuration"
Cohesion: 0.25
Nodes (7): COMPOSE_PROJECT_NAME, MOODLE_DOCKER_BIN, MOODLE_DOCKER_DB, MOODLE_DOCKER_PHP_VERSION, MOODLE_DOCKER_WEB_PORT, MOODLE_DOCKER_WWWROOT, env.sh script

### Community 13 - "Security Primitives"
Cohesion: 0.50
Nodes (3): capability, context, sesskey

## Knowledge Gaps
- **69 isolated node(s):** `MOODLE_DOCKER_WWWROOT`, `MOODLE_DOCKER_DB`, `MOODLE_DOCKER_PHP_VERSION`, `MOODLE_DOCKER_WEB_PORT`, `COMPOSE_PROJECT_NAME` (+64 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 140 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **17 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` connect `Product Requirements and Scope` to `Workflow Phases and Milestones`, `Capabilities and Security`, `Core API Integrations`, `Milestones and Success Criteria`?**
  _High betweenness centrality (0.089) - this node is a cross-community bridge._
- **Are the 3 inferred relationships involving `Reflection Journal (mod_reflectjournal)` (e.g. with `Moodle 5.3 LTS target (MOODLE_503_STABLE)` and `Repo root = plugin root`) actually correct?**
  _`Reflection Journal (mod_reflectjournal)` has 3 INFERRED edges - model-reasoned connections that need verification._
- **What connects `MOODLE_DOCKER_WWWROOT`, `MOODLE_DOCKER_DB`, `MOODLE_DOCKER_PHP_VERSION` to the rest of the system?**
  _69 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Workflow Phases and Milestones` be split into smaller, more focused modules?**
  _Cohesion score 0.06533776301218161 - nodes in this community are weakly interconnected._
- **Why does `Security checklist walked for every diff` connect `Capabilities and Security` to `Workflow Phases and Milestones`, `Product Requirements and Scope`, `Milestones and Success Criteria`?**
  _High betweenness centrality (0.069) - this node is a cross-community bridge._
- **Should `Agent Operating Manual` be split into smaller, more focused modules?**
  _Cohesion score 0.06882591093117409 - nodes in this community are weakly interconnected._
- **Why does `User stories T1-T7, L1-L4, E1` connect `Core API Integrations` to `Product Requirements and Scope`, `Milestones and Success Criteria`?**
  _High betweenness centrality (0.069) - this node is a cross-community bridge._