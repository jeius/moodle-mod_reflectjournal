# Graph Report - moodle-demo  (2026-11-24)

## Corpus Check
- 1 files · ~15,648 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 381 nodes · 457 edges · 34 communities (13 shown, 21 thin omitted)
- Extraction: 91% EXTRACTED · 9% INFERRED · 0% AMBIGUOUS · INFERRED: 40 edges (avg confidence: 0.86)
- Token cost: 127,708 input · 0 output

## Community Hubs (Navigation)
- Core API Integrations
- Agent Operating Manual
- Spec and Plan Workflow
- Workflow Skills and Plugins
- Milestones and Plan Phases
- Capabilities and Baseline Decisions
- CI Workflow Config
- Architecture and Core-API Ledger
- Worktree and Docker Policy
- CI YAML Structure
- Domain Glossary Terms
- lib.php Instance Hooks
- Unit Test Baseline
- Issue Tracker Conventions
- Graphify Knowledge Graph
- Plugin Icon Design
- Known Environment Issues
- Node Toolchain Pin
- PHP Version Matrix
- Worktree Override Decision
- Security Primitives
- CLAUDE.md Import
- Portfolio Audience
- PHPUnit and Behat Coverage
- Nice-to-Have Features
- Public Web Root
- Renderer and Mustache
- Sesskey Protection
- Wwwroot Concept
- GPL-3.0 License

## God Nodes (most connected - your core abstractions)
1. `Seven-phase workflow lifecycle (Decide-Spec-Tickets-Plan-Execute-PR-Merge)` - 20 edges
2. `mod_reflectjournal (Reflection Journal)` - 16 edges
3. `Specs README (docs/specs/README.md)` - 14 edges
4. `User stories T1-T7, L1-L4, E1` - 13 edges
5. `Seven-phase workflow (decide, spec, tickets, plan, execute, PR, merge)` - 13 edges
6. `Security checklist walked for every diff` - 13 edges
7. `Plans README (docs/plans/README.md)` - 12 edges
8. `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` - 9 edges
9. `with` - 8 edges
10. `steps` - 8 edges

## Surprising Connections (you probably didn't know these)
- `Platform requirements (Moodle 5.3 LTS, PHP 8.3+, PostgreSQL 17+/MariaDB 11.4+, Selenium)` --conceptually_related_to--> `Moodle 5.3 LTS target (MOODLE_503_STABLE)`  [INFERRED]
  README.md → docs/adr/0002-target-moodle-5-3-lts.md
- `Plans convention (docs/plans/<issue#>-slug.md)` --references--> `Plans README (docs/plans/README.md)`  [EXTRACTED]
  AGENTS.md → docs/plans/README.md
- `Plugin bind mount /var/www/html/public/mod/reflectjournal` --references--> `Plugin bind mount via pinned clone's local.yml`  [EXTRACTED]
  docker/README.md → docs/adr/0004-plugin-mount-bind-mount.md
- `Moodle 5.x public/ web root` --conceptually_related_to--> `public/ (Moodle 5.x web root)`  [INFERRED]
  docs/adr/0004-plugin-mount-bind-mount.md → GLOSSARY.md
- `moodle-plugin-ci` --conceptually_related_to--> `GitHub Actions CI via moodle-plugin-ci (MOODLE_503_STABLE x PHP 8.3/8.4 x pgsql/mariadb)`  [INFERRED]
  GLOSSARY.md → docs/adr/0005-testing-approach.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Reflection Journal entry lifecycle domain model** — glossary_activity_module, glossary_instance, glossary_cm_course_module, glossary_prompt, glossary_entry, glossary_deadline, glossary_feedback, glossary_gradebook [EXTRACTED 1.00]
- **Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md)** — docs_plan_milestone_ladder, docs_plan_milestone_m0, docs_plan_milestone_m1, docs_plan_milestone_m2, docs_plan_milestone_m3, docs_plan_milestone_m4, docs_plan_milestone_m5, docs_plan_milestone_m6, docs_plan_milestone_m7, docs_plan_milestone_m8, docs_plan_milestone_m9 [EXTRACTED 1.00]
- **Global Constraints binding every implementation plan** — docs_adr_0006_spec_and_plan_workflow_per_ticket_plan_file, docs_plans_readme_test_first_always, docs_plans_readme_highest_existing_seam, docs_plans_readme_end_of_task_gate, docs_plans_readme_name_the_core_api [EXTRACTED 1.00]
- **Capability matrix: five mod/reflectjournal capabilities** — docs_architecture_capability_matrix, docs_architecture_capability_addinstance, docs_architecture_capability_view, docs_architecture_capability_submit, docs_architecture_capability_givefeedback, docs_architecture_capability_grade [EXTRACTED 1.00]
- **Seven-phase workflow and its per-phase skills** — docs_adr_0006_spec_and_plan_workflow_seven_phase_workflow, docs_adr_0006_spec_and_plan_workflow_wayfinder, docs_adr_0006_spec_and_plan_workflow_grill_with_docs, docs_adr_0006_spec_and_plan_workflow_to_spec, docs_adr_0006_spec_and_plan_workflow_to_tickets, docs_adr_0006_spec_and_plan_workflow_writing_plans, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_test_driven_development, docs_adr_0006_spec_and_plan_workflow_requesting_code_review, docs_adr_0006_spec_and_plan_workflow_finishing_a_development_branch [EXTRACTED 1.00]
- **Work-in-place decision: skill defaults, declared preferences, docker constraints** — docs_adr_0006_spec_and_plan_workflow_git_worktrees_disabled, docs_adr_0006_spec_and_plan_workflow_using_git_worktrees, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_executing_plans, docs_adr_0006_spec_and_plan_workflow_agents_md, docs_adr_0006_spec_and_plan_workflow_adr_0004 [EXTRACTED 1.00]
- **Development pipeline: phases 1-7 (decide to merge)** — docs_workflow_phase_1_decide, docs_workflow_phase_2_spec, docs_workflow_phase_3_tickets, docs_workflow_phase_4_plan, docs_workflow_phase_5_execute, docs_workflow_phase_6_pr, docs_workflow_phase_7_merge [EXTRACTED 1.00]
- **Containerized dev and test stack** — docker_readme_moodle_docker_pin, docker_readme_local_yml_example, docker_readme_env_sh, docs_adr_0003_repo_layout_pinned_dev_stack, docs_adr_0004_plugin_mount_bind_mount_bind_mount, docs_adr_0004_plugin_mount_bind_mount_shadow_volumes, docs_adr_0005_testing_approach_container_testing [INFERRED 0.85]
- **Seven-phase workflow lifecycle (Decide, Spec, Tickets, Plan, Execute, PR, Merge)** — agents_workflow_lifecycle, agents_wayfinder, agents_grill_with_docs, agents_to_spec, agents_to_tickets, agents_superpowers_writing_plans, agents_superpowers_subagent_driven_development, agents_superpowers_executing_plans, agents_superpowers_test_driven_development, agents_verification_before_completion, agents_systematic_debugging, agents_superpowers_requesting_code_review, agents_finishing_a_development_branch [EXTRACTED 1.00]
- **Single-context domain documentation (GLOSSARY.md + docs/adr/)** — agents_domain_docs, glossary, docs_adr [EXTRACTED 1.00]
- **Graphify knowledge graph system (skill, artifacts, querying)** — agents_graphify_knowledge_graph, agents_graphify_skill, graphify_out [EXTRACTED 1.00]

## Communities (34 total, 21 thin omitted)

### Community 0 - "Core API Integrations"
Cohesion: 0.06
Nodes (31): mod_reflectjournal\dates (activity dates class), Backup/restore scope, Calendar event integration for the deadline, mod/reflectjournal:givefeedback, mod/reflectjournal:submit, grade_update(), reflectjournal grade module callbacks (*_grade_item_update, *_update_grades, *_grade_item_delete, *_rescale_activity_grades), Privacy provider scope (+23 more)

### Community 1 - "Agent Operating Manual"
Cohesion: 0.06
Nodes (21): GitHub Actions CI, mod_reflectjournal (Reflection Journal), Moodle 5.3 LTS, documents/pdf/presentations plugins, Plugin bind mount /var/www/html/public/mod/reflectjournal, docker/env.sh (sourced exports), docker/local.yml.example (plugin bind mount), Core-API ledger (docs/architecture.md) (+13 more)

### Community 2 - "Spec and Plan Workflow"
Cohesion: 0.09
Nodes (28): ADR-0006: Spec/plan workflow replaces per-task prompts, ADR-0004 (docker bind-mount / shadow-volume stack), AGENTS.md, Canonical spec file (docs/specs/NNN-slug.md), code-review, docs/agents/issue-tracker.md, docs/plan.md, docs/workflow.md (+20 more)

### Community 3 - "Workflow Skills and Plugins"
Cohesion: 0.08
Nodes (33): browser-use plugin, code-review skill, superpowers:finishing-a-development-branch, github plugin, grill-me skill, grill-with-docs skill, grilling skill, GitHub Issues issue tracker (jeius/moodle-mod_reflectjournal) (+25 more)

### Community 4 - "Milestones and Plan Phases"
Cohesion: 0.07
Nodes (28): v1 success criteria (CI green both DBs, zero phpcs, capability+grading tests, 2-min demo), Milestone ladder M0-M9 (GitHub milestones mirror docs/plan.md), Milestone M1: Skeleton activity, Milestone M8: Attachments (last feature milestone), Milestone M9: Polish and release, Feature: file attachments on entries (last), Success criteria, Next: M1 via the workflow (+20 more)

### Community 5 - "Capabilities and Baseline Decisions"
Cohesion: 0.07
Nodes (18): mod/reflectjournal:addinstance, mod/reflectjournal:grade, mod/reflectjournal:view, Milestone M0: Baseline, Milestone M3: Capabilities and security review, Feature: tests + CI from M0, Non-functional requirements (WCAG 2.1 AA, security APIs, Boost, coding style), Dev environment verified (moodle-docker f0583ec, MOODLE_503_STABLE) (+10 more)

### Community 6 - "CI Workflow Config"
Cohesion: 0.07
Nodes (29): MARIADB_ALLOW_EMPTY_ROOT_PASSWORD, MYSQL_CHARACTER_SET_SERVER, MYSQL_COLLATION_SERVER, POSTGRES_HOST_AUTH_METHOD, POSTGRES_USER, jobs, test, env (+21 more)

### Community 7 - "Architecture and Core-API Ledger"
Cohesion: 0.09
Nodes (14): Future: external web service (core_external), Future: Hooks API (db/hooks.php), mod_reflectjournal (Reflection Journal plugin), Post-v1 scope: web service, hooks API, mobile app, v1 out of scope (group mode, multi-entry, peer review, rubrics, AI), Product: prompt -> one entry by deadline -> feedback + optional grade, Out of scope (group mode, overrides, custom release, advanced grading), Hooks API (PSR-14, db/hooks.php, dispatch via core hook manager) (+6 more)

### Community 8 - "Worktree and Docker Policy"
Cohesion: 0.11
Nodes (15): Single-context domain docs, Moodle Docker stack, superpowers:using-git-worktrees, COMPOSE_PROJECT_NAME, MOODLE_DOCKER_BIN, MOODLE_DOCKER_DB, MOODLE_DOCKER_PHP_VERSION, MOODLE_DOCKER_WEB_PORT (+7 more)

### Community 9 - "CI YAML Structure"
Cohesion: 0.12
Nodes (17): DB, MOODLE_BRANCH, continue-on-error, env, if, name, run, uses (+9 more)

### Community 10 - "Domain Glossary Terms"
Cohesion: 0.14
Nodes (16): activity module, backup/restore, cm / course module, completion, deadline, entry, feedback, filearea (+8 more)

### Community 13 - "Issue Tracker Conventions"
Cohesion: 0.33
Nodes (5): GitHub issue tracker (jeius/moodle-mod_reflectjournal via gh CLI), Native issue dependencies (blocked-by edges), GitHub sub-issues (parent/child links), Wayfinding operations (map + child tickets), Canonical triage roles mapped to tracker labels

### Community 14 - "Graphify Knowledge Graph"
Cohesion: 1.00
Nodes (3): Graphify knowledge graph, graphify skill (.agents/skills/graphify/), graphify-out/ (knowledge graph artifacts)

## Knowledge Gaps
- **106 isolated node(s):** `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB`, `MOODLE_DOCKER_PHP_VERSION`, `MOODLE_DOCKER_WEB_PORT` (+101 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 178 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **21 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Seven-phase workflow lifecycle (Decide-Spec-Tickets-Plan-Execute-PR-Merge)` connect `Workflow Skills and Plugins` to `Worktree and Docker Policy`, `Agent Operating Manual`?**
  _High betweenness centrality (0.099) - this node is a cross-community bridge._
- **Are the 3 inferred relationships involving `mod_reflectjournal (Reflection Journal)` (e.g. with `Moodle 5.3 LTS target (MOODLE_503_STABLE)` and `Repo root = plugin root`) actually correct?**
  _`mod_reflectjournal (Reflection Journal)` has 3 INFERRED edges - model-reasoned connections that need verification._
- **What connects `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB` to the rest of the system?**
  _106 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Core API Integrations` be split into smaller, more focused modules?**
  _Cohesion score 0.06039488966318235 - nodes in this community are weakly interconnected._
- **Why does `mod_reflectjournal (Reflection Journal)` connect `Agent Operating Manual` to `Worktree and Docker Policy`, `Domain Glossary Terms`, `Workflow Skills and Plugins`?**
  _High betweenness centrality (0.084) - this node is a cross-community bridge._
- **Should `Agent Operating Manual` be split into smaller, more focused modules?**
  _Cohesion score 0.06025641025641026 - nodes in this community are weakly interconnected._
- **Why does `Step 2: docs set (brief -> prd -> architecture -> tech-stack -> plan -> progress -> security-checklist)` connect `Architecture and Core-API Ledger` to `Core API Integrations`, `Milestones and Plan Phases`, `Capabilities and Baseline Decisions`?**
  _High betweenness centrality (0.065) - this node is a cross-community bridge._