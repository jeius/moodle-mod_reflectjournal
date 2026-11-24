# Graph Report - moodle-demo  (2026-11-24)

## Corpus Check
- 10 files · ~22,256 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 407 nodes · 515 edges · 47 communities (16 shown, 31 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 27 edges (avg confidence: 0.85)
- Token cost: 705,986 input · 0 output

## Community Hubs (Navigation)
- Activity core design
- CI workflow config
- Project conventions
- Moodle 5.3 platform facts
- Grading and privacy decisions
- Spec and plan workflow
- Agent ops conventions
- Testing and CI pipeline
- Security and access rules
- Workflow phase skills
- Docker dev environment
- Moodle domain glossary
- MariaDB container config
- lib.php instance callbacks
- Plugin PHPUnit base test
- Issue tracker operations
- Graphify knowledge graph
- Deadline decisions
- Spec-plan lifecycle example
- Activity icon assets
- Git worktrees policy
- Capability context pair
- CLAUDE.md import
- addinstance capability
- Audience goals
- v1 out of scope
- v1 success criteria
- T1 prompt story
- Node 22 LTS
- PHP CI matrix
- PostgreSQL 17
- Renderer Mustache output
- Sesskey CSRF
- wwwroot
- GPL license

## God Nodes (most connected - your core abstractions)
1. `Seven-phase workflow lifecycle (Decide-Spec-Tickets-Plan-Execute-PR-Merge)` - 20 edges
2. `Core-API mapping ledger (the use-core table)` - 20 edges
3. `mod_reflectjournal (Reflection Journal)` - 16 edges
4. `Security checklist - walk for EVERY diff` - 16 edges
5. `Reflection Journal: Plan (milestones M0-M9)` - 16 edges
6. `Research - verified Moodle 5.3 facts` - 15 edges
7. `Specs README (docs/specs/README.md)` - 14 edges
8. `Seven-phase workflow (decide, spec, tickets, plan, execute, PR, merge)` - 13 edges
9. `Tests this design needs (XSS cleaning, server-side deadline, race, transaction guard, hidden grades, file access, capability split, teacher erasure, rescale, locked grades, backup round-trip, privacy, calendar, completion)` - 12 edges
10. `docs/plans/README.md (implementation plan conventions)` - 11 edges

## Surprising Connections (you probably didn't know these)
- `Plans convention (docs/plans/<issue#>-slug.md)` --references--> `docs/plans/README.md (implementation plan conventions)`  [EXTRACTED]
  AGENTS.md → docs/plans/README.md
- `mod_reflectjournal (Reflection Journal)` --references--> `Reflection Journal: Progress`  [EXTRACTED]
  AGENTS.md → docs/progress.md
- `Moodle 5.3 LTS target (MOODLE_503_STABLE)` --conceptually_related_to--> `mod_reflectjournal (Reflection Journal)`  [INFERRED]
  docs/adr/0002-target-moodle-5-3-lts.md → AGENTS.md
- `Repo root = plugin root` --conceptually_related_to--> `mod_reflectjournal (Reflection Journal)`  [INFERRED]
  docs/adr/0003-repo-layout.md → AGENTS.md
- `Plugin bind mount /var/www/html/public/mod/reflectjournal` --references--> `Plugin bind mount via pinned clone's local.yml`  [EXTRACTED]
  docker/README.md → docs/adr/0004-plugin-mount-bind-mount.md

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Reflection Journal entry lifecycle domain model** — glossary_activity_module, glossary_instance, glossary_cm_course_module, glossary_prompt, glossary_entry, glossary_deadline, glossary_feedback, glossary_gradebook [EXTRACTED 1.00]
- **Graphify knowledge graph system (skill, artifacts, querying)** — agents_graphify_knowledge_graph, agents_graphify_skill, graphify_out [EXTRACTED 1.00]
- **Seven-phase workflow lifecycle (Decide, Spec, Tickets, Plan, Execute, PR, Merge)** — agents_workflow_lifecycle, agents_wayfinder, agents_grill_with_docs, agents_to_spec, agents_to_tickets, agents_superpowers_writing_plans, agents_superpowers_subagent_driven_development, agents_superpowers_executing_plans, agents_superpowers_test_driven_development, agents_verification_before_completion, agents_systematic_debugging, agents_superpowers_requesting_code_review, agents_finishing_a_development_branch [EXTRACTED 1.00]
- **Seven-phase workflow and its per-phase skills** — docs_adr_0006_spec_and_plan_workflow_seven_phase_workflow, docs_adr_0006_spec_and_plan_workflow_wayfinder, docs_adr_0006_spec_and_plan_workflow_grill_with_docs, docs_adr_0006_spec_and_plan_workflow_to_spec, docs_adr_0006_spec_and_plan_workflow_to_tickets, docs_adr_0006_spec_and_plan_workflow_writing_plans, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_test_driven_development, docs_adr_0006_spec_and_plan_workflow_requesting_code_review, docs_adr_0006_spec_and_plan_workflow_finishing_a_development_branch [EXTRACTED 1.00]
- **Single-context domain documentation (GLOSSARY.md + docs/adr/)** — agents_domain_docs, glossary, docs_adr [EXTRACTED 1.00]
- **Work-in-place decision: skill defaults, declared preferences, docker constraints** — docs_adr_0006_spec_and_plan_workflow_git_worktrees_disabled, docs_adr_0006_spec_and_plan_workflow_using_git_worktrees, docs_adr_0006_spec_and_plan_workflow_subagent_driven_development, docs_adr_0006_spec_and_plan_workflow_executing_plans, docs_adr_0006_spec_and_plan_workflow_agents_md, docs_adr_0006_spec_and_plan_workflow_adr_0004 [EXTRACTED 1.00]
- **Development pipeline: phases 1-7 (decide to merge)** — docs_workflow_phase_1_decide, docs_workflow_phase_2_spec, docs_workflow_phase_3_tickets, docs_workflow_phase_4_plan, docs_workflow_phase_5_execute, docs_workflow_phase_6_pr, docs_workflow_phase_7_merge [EXTRACTED 1.00]
- **Containerized dev and test stack** — docker_readme_moodle_docker_pin, docker_readme_local_yml_example, docker_readme_env_sh, docs_adr_0003_repo_layout_pinned_dev_stack, docs_adr_0004_plugin_mount_bind_mount_bind_mount, docs_adr_0004_plugin_mount_bind_mount_shadow_volumes [INFERRED 0.85]
- **Grading pipeline: grading page -> grade_update -> gradebook -> learner visibility** — docs_architecture_grade_update, docs_adr_0007_gradebook_is_the_only_grade_store_single_store, docs_adr_0007_gradebook_is_the_only_grade_store_module_callbacks, docs_adr_0007_gradebook_is_the_only_grade_store_return_codes, docs_architecture_grade_item_read_path, docs_architecture_grade_grade_is_hidden, docs_architecture_learner_grade_display, docs_architecture_rescale_callback [INFERRED 0.90]
- **Privacy lifecycle for entries and teacher feedback** — docs_architecture_privacy_provider, docs_architecture_feedbackby_column, docs_adr_0008_feedbackby_privacy_semantics_teacher_data_subject, docs_adr_0008_feedbackby_privacy_semantics_teacher_erasure, docs_adr_0008_feedbackby_privacy_semantics_mod_assign_precedent, docs_prd_l4_privacy_coverage [INFERRED 0.90]
- **Docs workflow: decide -> spec -> tickets -> plan -> execute -> PR -> merge** — docs_workflow, docs_plans_readme, docs_adr_0006_spec_and_plan_workflow, docs_plans_readme_writing_plans_skill, docs_plans_readme_subagent_driven_development, agents_superpowers_test_driven_development, docs_plans_readme_test_first, docs_plans_readme_highest_existing_seam, docs_plans_readme_end_of_task_gate, docs_plans_readme_name_the_core_api [INFERRED 0.85]

## Communities (47 total, 31 thin omitted)

### Community 0 - "Activity core design"
Cohesion: 0.07
Nodes (27): Module grade callbacks: reflectjournal_grade_item_update / reflectjournal_update_grades pair, Calendar integration: provide_event_action + event_timestart_updated callbacks + reflectjournal_refresh_events(), Capability mod/reflectjournal:givefeedback (read any entry, open grade.php, save feedback), Capability mod/reflectjournal:grade (grade field and its save action only), Capability mod/reflectjournal:view (open activity, read own entry and feedback), classes/entry.php: entry persistence and queries, single source of DML, core\clock via core\di - never time() in plugin code, Custom completion: completionsubmit rule via classes/completion/custom_completion.php (+19 more)

### Community 1 - "CI workflow config"
Cohesion: 0.05
Nodes (38): DB, MOODLE_BRANCH, POSTGRES_HOST_AUTH_METHOD, POSTGRES_USER, jobs, test, database, moodle-branch (+30 more)

### Community 2 - "Project conventions"
Cohesion: 0.07
Nodes (19): GitHub Actions CI, mod_reflectjournal (Reflection Journal), Moodle 5.3 LTS, documents/pdf/presentations plugins, Plugin bind mount /var/www/html/public/mod/reflectjournal, docker/env.sh (sourced exports), docker/local.yml.example (plugin bind mount), Core-API ledger (docs/architecture.md) (+11 more)

### Community 3 - "Moodle 5.3 platform facts"
Cohesion: 0.07
Nodes (28): FEATURE_MOD_PURPOSE = MOD_PURPOSE_ASSESSMENT, Future: external web service via namespaced core_external API (db/services.php + classes/external/), Future: Hooks API registrations (db/hooks.php, PSR-14 array notation), reflectjournal_supports(): six declared features + deliberately undeclared ones, Post-v1 scope: web service, hooks API, mobile app, Product: prompt -> one entry by deadline -> feedback + optional grade, Out of scope: group mode, individual deadlines, custom grade release, entry deletion, advanced grading, mobile/web service (future), Research - verified Moodle 5.3 facts (+20 more)

### Community 4 - "Grading and privacy decisions"
Cohesion: 0.09
Nodes (22): ADR-0004 (dev stack: plugin at repo root, docker bind-mount, nested moodle/+ci/ shadowed), ADR-0007: Gradebook is the only grade store, grade_update() return codes: OK / ITEM_LOCKED / FAILED / MULTIPLE, ADR-0008: feedbackby privacy semantics (teacher as data subject), mod_assign grader precedent (assign_grades.grader privacy handling), Reflection Journal: Architecture, Backup/restore scope: config always, entries behind user-data setting, Events API logging: entry_submitted, entry_updated, feedback_added, course_module_viewed, course_module_instance_list_viewed (+14 more)

### Community 5 - "Spec and plan workflow"
Cohesion: 0.11
Nodes (23): ADR-0006: Spec/plan workflow replaces per-task prompts, ADR-0004 (docker bind-mount / shadow-volume stack), AGENTS.md, Canonical spec file (docs/specs/NNN-slug.md), code-review, docs/agents/issue-tracker.md, docs/plan.md, docs/workflow.md (+15 more)

### Community 6 - "Agent ops conventions"
Cohesion: 0.11
Nodes (25): browser-use plugin, code-review skill, superpowers:finishing-a-development-branch, grill-me skill, grill-with-docs skill, grilling skill, Milestones M0-M9, moodle-external-api-development skill (+17 more)

### Community 7 - "Testing and CI pipeline"
Cohesion: 0.10
Nodes (23): github plugin, GitHub Issues issue tracker (jeius/moodle-mod_reflectjournal), AGENTS.md (verified commands; workflow preferences), superpowers:test-driven-development, tdd skill, ADR-0005: Testing approach (PHPUnit + Behat in containers, moodle-plugin-ci on GitHub), CI matrix: MOODLE_503_STABLE x PHP 8.3/8.4 x pgsql+mariadb, mod_reflectjournal_testsuite (plugin PHPUnit testsuite) (+15 more)

### Community 8 - "Security and access rules"
Cohesion: 0.12
Nodes (19): Capability mod/reflectjournal:submit (create and edit own entry until deadline), Core-API mapping ledger (the use-core table), get_enrolled_sql($context, 'mod/reflectjournal:submit', 0, true) - submissions list base query, Output: mod_reflectjournal\output\renderer + renderables + Mustache templates, required_param()/optional_param() with PARAM_* (never $_GET/$_POST), require_login() + require_capability() on every route, require_sesskey() / confirm_sesskey() on every write, Submissions list: core_table\sql_table over get_enrolled_sql with LEFT JOIN on entries (+11 more)

### Community 9 - "Workflow phase skills"
Cohesion: 0.11
Nodes (20): Phase 1: Decide, Phase 2: Spec, Phase 3: Tickets, Phase 4: Plan, Phase 5: Execute, Phase 6: PR, Phase 7: Merge, Non-phase skill alternatives (grilling, grill-me, writing-implementation-plans, implement-spec, executing-plans, tdd, code-review) (+12 more)

### Community 10 - "Docker dev environment"
Cohesion: 0.12
Nodes (14): Single-context domain docs, Moodle Docker stack, superpowers:using-git-worktrees, COMPOSE_PROJECT_NAME, MOODLE_DOCKER_BIN, MOODLE_DOCKER_DB, MOODLE_DOCKER_PHP_VERSION, MOODLE_DOCKER_WEB_PORT (+6 more)

### Community 11 - "Moodle domain glossary"
Cohesion: 0.14
Nodes (16): activity module, backup/restore, cm / course module, completion, deadline, entry, feedback, filearea (+8 more)

### Community 12 - "MariaDB container config"
Cohesion: 0.25
Nodes (8): MARIADB_ALLOW_EMPTY_ROOT_PASSWORD, MYSQL_CHARACTER_SET_SERVER, MYSQL_COLLATION_SERVER, env, image, options, ports, mariadb

### Community 15 - "Issue tracker operations"
Cohesion: 0.33
Nodes (5): GitHub issue tracker (jeius/moodle-mod_reflectjournal via gh CLI), Native issue dependencies (blocked-by edges), GitHub sub-issues (parent/child links), Wayfinding operations (map + child tickets), Canonical triage roles mapped to tracker labels

### Community 16 - "Graphify knowledge graph"
Cohesion: 1.00
Nodes (3): Graphify knowledge graph, graphify skill (.agents/skills/graphify/), graphify-out/ (knowledge graph artifacts)

### Community 18 - "Spec-plan lifecycle example"
Cohesion: 0.67
Nodes (3): Plan lifecycle ready -> in-progress -> done; first commit of PR, Spec lifecycle draft -> approved -> on main -> implemented, Worked example: entry-edit-lock (spec 004, issues #17-#19, plan 18)

## Knowledge Gaps
- **116 isolated node(s):** `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB`, `MOODLE_DOCKER_PHP_VERSION`, `MOODLE_DOCKER_WEB_PORT` (+111 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 191 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **31 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `mod_reflectjournal (Reflection Journal)` connect `Project conventions` to `Security and access rules`, `Moodle domain glossary`, `Agent ops conventions`, `Testing and CI pipeline`?**
  _High betweenness centrality (0.139) - this node is a cross-community bridge._
- **Are the 3 inferred relationships involving `mod_reflectjournal (Reflection Journal)` (e.g. with `Moodle 5.3 LTS target (MOODLE_503_STABLE)` and `Repo root = plugin root`) actually correct?**
  _`mod_reflectjournal (Reflection Journal)` has 3 INFERRED edges - model-reasoned connections that need verification._
- **What connects `COMPOSE_PROJECT_NAME`, `MOODLE_DOCKER_BIN`, `MOODLE_DOCKER_DB` to the rest of the system?**
  _116 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Activity core design` be split into smaller, more focused modules?**
  _Cohesion score 0.06923076923076923 - nodes in this community are weakly interconnected._
- **Why does `Seven-phase workflow lifecycle (Decide-Spec-Tickets-Plan-Execute-PR-Merge)` connect `Agent ops conventions` to `Security and access rules`, `Docker dev environment`, `Project conventions`, `Testing and CI pipeline`?**
  _High betweenness centrality (0.128) - this node is a cross-community bridge._
- **Should `CI workflow config` be split into smaller, more focused modules?**
  _Cohesion score 0.05128205128205128 - nodes in this community are weakly interconnected._
- **Why does `Reflection Journal: Progress` connect `Testing and CI pipeline` to `Project conventions`, `Moodle 5.3 platform facts`, `Grading and privacy decisions`, `Spec and plan workflow`, `Agent ops conventions`?**
  _High betweenness centrality (0.113) - this node is a cross-community bridge._