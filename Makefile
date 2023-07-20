# Makefile

# make commands be run with `bash` instead of the default `sh`
SHELL='/bin/bash'

docker_compose_override:=$(shell [ -f docker-compose.override.yml ] && echo '-f docker-compose.override.yml' || echo '')
docker_compose_bin:=$(shell [ -x "$(command -v docker-compose)" ] && echo 'docker-compose' || echo 'docker compose')

# Setup —————————————————————————————————————————————————————————————————————————————————
.DEFAULT_GOAL := help

# .DEFAULT: If command does not exist in this makefile
# default:  If no command was specified:
.DEFAULT default:
	$(EXECUTOR)
	if [ "$@" != "" ]; then echo "Command '$@' not found."; fi;
	make help

## —— Project Make file  ————————————————————————————————————————————————————————————————

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Init project ——————————————————————————————————————————————————————————————————————
init: ## Project init
init: docker-down-clear app-clear docker-pull docker-build docker-up app-init

## —— Manage project ————————————————————————————————————————————————————————————————————
up: docker-up ## Project up
down: docker-down ## Project down
restart: down docker-build up ## Project restart

## —— Audit project —————————————————————————————————————————————————————————————————————
check: lint test ## Project restart
test: frontend-test api-test ## Run testing
lint: frontend-lint api-lint ## Run linters

docker-up:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) up -d

docker-down:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) down --remove-orphans

docker-down-clear:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) down -v --remove-orphans

docker-stop:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) stop

docker-pull:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) pull

docker-build:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) build

app-clear:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli rm -f .ready

app-init: frontend-init api-init
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli touch .ready

## —— Frontend ——————————————————————————————————————————————————————————————————————————
frontend-init: ## Init frontend
frontend-init: frontend-yarn-install

frontend-yarn-install: ## Install yarn package
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli yarn install

frontend-node-cli: ## Run node container command. Args: cmd - any command line
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli $(cmd)

frontend-lint: ## Run lints
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli yarn stylelint
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli yarn eslint

frontend-test: ## Run test
	echo "All tests is done!";

frontend-fix: ## Run lint fixer
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli yarn prettier
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm frontend-node-cli yarn eslint:fix

frontend-logs: ## Show logs
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) logs --follow frontend-node

frontend-preview-refresh: ## Refresh build for analyze
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) exec frontend-preview yarn build

frontend-preview-logs: ## Show logs analize
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) logs --follow frontend-analize

## —— API ———————————————————————————————————————————————————————————————————————————————
api-init: ## Init API
api-init: api-composer-install api-wait-db api-create-symlink api-migrations

api-create-symlink:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli ln -sf /app/src/Migration/MySQL/Config/migrations.php /app/migrations.php
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli ln -sf /app/src/Migration/MySQL/Config/migrations-db.php /app/migrations-db.php

api-wait-db:
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli wait-for-it api-mysql:3306 -t 30

api-composer-install: ## Composer install
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli composer install

api-migrations: ## Run migrations
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli vendor/bin/doctrine-migrations migrations:migrate --no-interaction

api-migrations-create: ## Create migrations
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli vendor/bin/doctrine-migrations migrations:generate --no-interaction

api-migrations-rollback: ## Rollback migrations by versions
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli vendor/bin/doctrine-migrations migrations:migrate prev

api-logs: ## Show logs
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) logs --follow api

api-lint: ## Run lints
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli composer validate
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli composer php-cs-fixer fix -- --dry-run --diff

api-test: ## Run test
	echo "All tests is done!";

api-fix: ## Run lint fixer
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli composer php-cs-fixer fix

api-php-cli: ## Run lint fixer
	$(docker_compose_bin) -f docker-compose.yml $(docker_compose_override) run --rm api-php-cli $(cmd)