# Graph Report - moodle-demo  (2026-11-23)

## Corpus Check
- 34 files · ~15,478 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 345 nodes · 412 edges · 30 communities (12 shown, 18 thin omitted)
- Extraction: 90% EXTRACTED · 10% INFERRED · 0% AMBIGUOUS · INFERRED: 40 edges (avg confidence: 0.86)
- Token cost: 177,288 input · 0 output

## Community Hubs (Navigation)
- Core API Integrations
- Agent Operating Manual
- Spec and Plan Workflow
- Milestones and Plan Phases
- Capabilities and Baseline Decisions
- CI Workflow Config
- Product Requirements and Scope
- Workflow Skills and Conventions
- CI YAML Structure
- Domain Glossary Terms
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
- PHPUnit and Behat Coverage
- Nice-to-Have Features
- Public Web Root
- Wwwroot Concept

## God Nodes (most connected - your core abstractions)
1. `User stories T1-T7, L1-L4, E1` - 13 edges
2. `Security checklist walked for every diff` - 13 edges
3. `Seven-phase workflow (decide, spec, tickets, plan, execute, PR, merge)` - 13 edges
4. `Specs README (docs/specs/README.md)` - 13 edges
5. `Plans README (docs/plans/README.md)` - 11 edges
6. `Reflection Journal (mod_reflectjournal)` - 9 edges
7. `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` - 9 edges
8. `with` - 8 edges
9. `steps` - 8 edges
10. `reflectjournal_entries table` - 8 edges

## Surprising Connections (you probably didn't know these)
- `Platform requirements (Moodle 5.3 LTS, PHP 8.3+, PostgreSQL 17+/MariaDB 11.4+, Selenium)` --conceptually_related_to--> `Moodle 5.3 LTS target (MOODLE_503_STABLE)`  [INFERRED]
  README.md → docs/adr/0002-target-moodle-5-3-lts.md
- `Moodle 5.3 LTS target (MOODLE_503_STABLE)` --conceptually_related_to--> `Reflection Journal (mod_reflectjournal)`  [INFERRED]
  docs/adr/0002-target-moodle-5-3-lts.md → AGENTS.md
- `Repo root = plugin root` --conceptually_related_to--> `Reflection Journal (mod_reflectjournal)`  [INFERRED]
  docs/adr/0003-repo-layout.md → AGENTS.md
- `Plugin bind mount /var/www/html/public/mod/reflectjournal` --references--> `Plugin bind mount via pinned clone's local.yml`  [EXTRACTED]
  docker/README.md → docs/adr/0004-plugin-mount-bind-mount.md
- `Moodle 5.x public/ web root` --conceptually_related_to--> `public/ (Moodle 5.x web root)`  [INFERRED]
  docs/adr/0004-plugin-mount-bind-mount.md → GLOSSARY.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Reflection Journal entry lifecycle domain model** — glossary_activity_module, glossary_instance, glossary_cm_course_module, glossary_prompt, glossary_entry, glossary_deadline, glossary_feedback, glossary_gradebook [EXTRACTED 1.00]
- **Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md)** — docs_plan_milestone_ladder, docs_plan_milestone_m0, docs_plan_milestone_m1, docs_plan_milestone_m2, docs_plan_milestone_m3, docs_plan_milestone_m4, docs_plan_milestone_m5, docs_plan_milestone_m6, docs_plan_milestone_m7, docs_plan_milestone_m8, docs_plan_milestone_m9 [EXTRACTED 1.00]
- **Capability matrix: five mod/reflectjournal capabilities** — docs_architecture_capability_matrix, docs_architecture_capability_addinstance, docs_architecture_capability_view, docs_architecture_capability_submit, docs_architecture_capability_givefeedback, docs_architecture_capability_grade [EXTRACTED 1.00]
- **Seven-phase lifecycle and its skills** — agents_seven_phase_workflow, agents_wayfinder_skill, agents_grill_with_docs_skill, agents_to_spec_skill, agents_to_tickets_skill, agents_superpowers_writing_plans, agents_superpowers_subagent_driven_development, agents_superpowers_test_driven_development, agents_superpowers_requesting_code_review, agents_superpowers_finishing_a_development_branch [EXTRACTED 1.00]
- **Development pipeline: phases 1-7 (decide to merge)** — docs_workflow_phase_1_decide, docs_workflow_phase_2_spec, docs_workflow_phase_3_tickets, docs_workflow_phase_4_plan, docs_workflow_phase_5_execute, docs_workflow_phase_6_pr, docs_workflow_phase_7_merge [EXTRACTED 1.00]
- **Containerized dev and test stack** — docker_readme_moodle_docker_pin, docker_readme_local_yml_example, docker_readme_env_sh, docs_adr_0003_repo_layout_pinned_dev_stack, docs_adr_0004_plugin_mount_bind_mount_bind_mount, docs_adr_0004_plugin_mount_bind_mount_shadow_volumes, docs_adr_0005_testing_approach_container_testing [INFERRED 0.85]
- **Seven-phase workflow and its per-phase skills** — docs_adr_0006_spec_and_plan_workflow_seven_phase_workflow, docs_adr_0006_spec_and_plan_workflow_wayfinder, docs_adr_0006_spec_and_plan_workflow_grill_with_docs, docs_adr_0006_spec_and_plan_workflow_to_spec, docs_adr_0006_spec_and_plan_workflow_to_tickets, docs_adr_0006_spec_and_plan_workflow_writing_plans, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_test_driven_development, docs_adr_0006_spec_and_plan_workflow_requesting_code_review, docs_adr_0006_spec_and_plan_workflow_finishing_a_development_branch [EXTRACTED 1.00]
- **Work-in-place decision: skill defaults, declared preferences, docker constraints** — docs_adr_0006_spec_and_plan_workflow_git_worktrees_disabled, docs_adr_0006_spec_and_plan_workflow_using_git_worktrees, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_executing_plans, docs_adr_0006_spec_and_plan_workflow_agents_md, docs_adr_0006_spec_and_plan_workflow_adr_0004 [EXTRACTED 1.00]
- **Global Constraints binding every implementation plan** — docs_adr_0006_spec_and_plan_workflow_per_ticket_plan_file, docs_plans_readme_test_first_always, docs_plans_readme_highest_existing_seam, docs_plans_readme_end_of_task_gate, docs_plans_readme_name_the_core_api [EXTRACTED 1.00]

## Communities (30 total, 18 thin omitted)

### Community 0 - "Core API Integrations"
Cohesion: 0.06
Nodes (31): mod_reflectjournal\dates (activity dates class), Backup/restore scope, Calendar event integration for the deadline, mod/reflectjournal:givefeedback, mod/reflectjournal:submit, grade_update(), reflectjournal grade module callbacks (*_grade_item_update, *_update_grades, *_grade_item_delete, *_rescale_activity_grades), Privacy provider scope (+23 more)

### Community 1 - "Agent Operating Manual"
Cohesion: 0.07
Nodes (23): Domain docs convention (GLOSSARY.md + docs/adr/), GitHub Actions CI (moodle-plugin-ci matrix), grill-with-docs skill (Phase 1: decide), Reflection Journal (mod_reflectjournal), AGENTS.md operating manual, CLAUDE.md @AGENTS.md import, Plugin bind mount /var/www/html/public/mod/reflectjournal, docker/env.sh (sourced exports) (+15 more)

### Community 2 - "Spec and Plan Workflow"
Cohesion: 0.09
Nodes (28): ADR-0006: Spec/plan workflow replaces per-task prompts, ADR-0004 (docker bind-mount / shadow-volume stack), AGENTS.md, Canonical spec file (docs/specs/NNN-slug.md), code-review, docs/agents/issue-tracker.md, docs/plan.md, docs/workflow.md (+20 more)

### Community 3 - "Milestones and Plan Phases"
Cohesion: 0.07
Nodes (28): v1 success criteria (CI green both DBs, zero phpcs, capability+grading tests, 2-min demo), Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md), Milestone M1: Skeleton activity, Milestone M8: Attachments (last feature milestone), Milestone M9: Polish and release, Feature: file attachments on entries (last), Success criteria, Next: M1 via the workflow (+20 more)

### Community 4 - "Capabilities and Baseline Decisions"
Cohesion: 0.07
Nodes (18): mod/reflectjournal:addinstance, mod/reflectjournal:grade, mod/reflectjournal:view, Milestone M0: Baseline, Milestone M3: Capabilities and security review, Feature: tests + CI from M0, Non-functional requirements (WCAG 2.1 AA, security APIs, Boost, coding style), Dev environment verified (moodle-docker f0583ec, MOODLE_503_STABLE) (+10 more)

### Community 5 - "CI Workflow Config"
Cohesion: 0.07
Nodes (29): MARIADB_ALLOW_EMPTY_ROOT_PASSWORD, MYSQL_CHARACTER_SET_SERVER, MYSQL_COLLATION_SERVER, POSTGRES_HOST_AUTH_METHOD, POSTGRES_USER, jobs, test, env (+21 more)

### Community 6 - "Product Requirements and Scope"
Cohesion: 0.09
Nodes (14): Future: external web service (core_external), Future: Hooks API (db/hooks.php), mod_reflectjournal (Reflection Journal plugin), Post-v1 scope: web service, hooks API, mobile app, v1 out of scope (group mode, multi-entry, peer review, rubrics, AI), Product: prompt -> one entry by deadline -> feedback + optional grade, Out of scope (group mode, overrides, custom release, advanced grading), Hooks API (PSR-14, db/hooks.php, dispatch via core hook manager) (+6 more)

### Community 7 - "Workflow Skills and Conventions"
Cohesion: 0.13
Nodes (17): Issue tracker conventions (GitHub Issues via gh), Milestones M0-M9, superpowers:finishing-a-development-branch skill (Phase 6-7), superpowers:requesting-code-review skill (Phase 6: PR), superpowers:subagent-driven-development skill (Phase 5: execute), superpowers:test-driven-development skill, superpowers:writing-plans skill (Phase 4: plan), to-spec skill (Phase 2: spec) (+9 more)

### Community 8 - "CI YAML Structure"
Cohesion: 0.12
Nodes (17): DB, MOODLE_BRANCH, continue-on-error, env, if, name, run, uses (+9 more)

### Community 9 - "Domain Glossary Terms"
Cohesion: 0.15
Nodes (15): activity module, backup/restore, cm / course module, completion, deadline, entry, feedback, filearea (+7 more)

### Community 10 - "Docker Env Configuration"
Cohesion: 0.25
Nodes (7): COMPOSE_PROJECT_NAME, MOODLE_DOCKER_BIN, MOODLE_DOCKER_DB, MOODLE_DOCKER_PHP_VERSION, MOODLE_DOCKER_WEB_PORT, MOODLE_DOCKER_WWWROOT, env.sh script

### Community 13 - "Security Primitives"
Cohesion: 0.50
Nodes (3): capability, context, sesskey

## Knowledge Gaps
- **80 isolated node(s):** `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB`, `MOODLE_DOCKER_PHP_VERSION`, `MOODLE_DOCKER_WEB_PORT` (+75 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 150 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **18 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` connect `Product Requirements and Scope` to `Core API Integrations`, `Milestones and Plan Phases`, `Capabilities and Baseline Decisions`?**
  _High betweenness centrality (0.079) - this node is a cross-community bridge._
- **What connects `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB` to the rest of the system?**
  _80 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Core API Integrations` be split into smaller, more focused modules?**
  _Cohesion score 0.06039488966318235 - nodes in this community are weakly interconnected._
- **Why does `User stories T1-T7, L1-L4, E1` connect `Core API Integrations` to `Milestones and Plan Phases`, `Capabilities and Baseline Decisions`, `Product Requirements and Scope`?**
  _High betweenness centrality (0.063) - this node is a cross-community bridge._
- **Should `Agent Operating Manual` be split into smaller, more focused modules?**
  _Cohesion score 0.06882591093117409 - nodes in this community are weakly interconnected._
- **Why does `Security checklist walked for every diff` connect `Capabilities and Baseline Decisions` to `Milestones and Plan Phases`, `Product Requirements and Scope`?**
  _High betweenness centrality (0.047) - this node is a cross-community bridge._
- **Should `Spec and Plan Workflow` be split into smaller, more focused modules?**
  _Cohesion score 0.08771929824561403 - nodes in this community are weakly interconnected._