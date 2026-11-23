#!/usr/bin/env bash
# Environment for the Reflection Journal dev stack.
# Source from anywhere:  source docker/env.sh
# Requires the pinned moodle-docker clone — see docker/README.md.

# Repo root (parent of this file's directory), independent of the current directory.
_REPOROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

# Core checkout used by compose (bind-mounted to /var/www/html in the container).
export MOODLE_DOCKER_WWWROOT="${MOODLE_DOCKER_WWWROOT:-$_REPOROOT/moodle}"

# Database flavour (pgsql | mariadb). PHP version. Web port (80/8080 are taken on this host).
export MOODLE_DOCKER_DB="${MOODLE_DOCKER_DB:-pgsql}"
export MOODLE_DOCKER_PHP_VERSION="${MOODLE_DOCKER_PHP_VERSION:-8.3}"
export MOODLE_DOCKER_WEB_PORT="${MOODLE_DOCKER_WEB_PORT:-8000}"

# Distinct compose project name so this stack never collides with other projects.
export COMPOSE_PROJECT_NAME="${COMPOSE_PROJECT_NAME:-reflectjournal}"

# Wrapper from the pinned moodle-docker clone (~/moodle-docker by default).
export MOODLE_DOCKER_BIN="${MOODLE_DOCKER_BIN:-$HOME/moodle-docker/bin/moodle-docker-compose}"

unset _REPOROOT
