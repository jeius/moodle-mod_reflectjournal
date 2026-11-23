# 0001. Record architecture decisions

Date: 2026-11-23
Status: Accepted

## Context

This repo is developed agent-first across many cold-start sessions; decisions and their
reasoning vanish unless written down.

## Decision

Keep lightweight ADRs in `docs/adr/` (context, decision, alternatives, consequences).
Anything deviating from the "use Moodle core" ledger in `docs/architecture.md` requires
an ADR before implementation.

## Alternatives considered

- No ADRs: decisions get relitigated or silently contradicted.
- Heavyweight design docs: go stale; context cost every session.

## Consequences

One small file per decision; `docs/architecture.md` links to them; progress notes
reference them.
