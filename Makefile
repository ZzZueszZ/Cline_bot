.PHONY: up down restart logs shell test cs cs-fix migrate bake-model bake-controller bake-template bake-all

# ─── Docker ───────────────────────────────────────────────────────────────────

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down && docker compose up -d

logs:
	docker compose logs -f app

shell:
	docker compose exec app bash

# ─── Database ─────────────────────────────────────────────────────────────────

migrate:
	docker compose exec app bin/cake migrations migrate

migrate-status:
	docker compose exec app bin/cake migrations status

rollback:
	docker compose exec app bin/cake migrations rollback

seed:
	docker compose exec app bin/cake migrations seed

# ─── Testing ──────────────────────────────────────────────────────────────────

test:
	docker compose exec app vendor/bin/phpunit

test-file:
	@echo "Usage: make test-file FILE=tests/TestCase/Model/Table/XxxTableTest.php"
	docker compose exec app vendor/bin/phpunit $(FILE)

test-coverage:
	docker compose exec app vendor/bin/phpunit --coverage-html webroot/coverage

# ─── Code Quality ─────────────────────────────────────────────────────────────

cs:
	docker compose exec app vendor/bin/phpcs src/ tests/

cs-fix:
	docker compose exec app vendor/bin/phpcbf src/ tests/

stan:
	docker compose exec app vendor/bin/phpstan analyse

psalm:
	docker compose exec app vendor/bin/psalm

# ─── Bake (Code Generation) ───────────────────────────────────────────────────

bake-model:
	@echo "Usage: make bake-model NAME=Articles"
	docker compose exec app bin/cake bake model $(NAME)

bake-controller:
	@echo "Usage: make bake-controller NAME=Articles"
	docker compose exec app bin/cake bake controller $(NAME)

bake-template:
	@echo "Usage: make bake-template NAME=Articles"
	docker compose exec app bin/cake bake template $(NAME)

bake-all:
	@echo "Usage: make bake-all NAME=Articles"
	docker compose exec app bin/cake bake all $(NAME)

bake-migration:
	@echo "Usage: make bake-migration NAME=CreateArticles"
	docker compose exec app bin/cake bake migration $(NAME)

# ─── Workflow ─────────────────────────────────────────────────────────────────

new-task:
	@echo "Usage: make new-task TASK=task-name"
	@mkdir -p docs/tasks/$(TASK)
	@cp docs/tasks/_TEMPLATE/task_description.md docs/tasks/$(TASK)/task_description.md
	@echo "Created docs/tasks/$(TASK)/task_description.md — edit it to describe your task."

# ─── Composer ─────────────────────────────────────────────────────────────────

composer-install:
	docker compose exec app composer install

composer-update:
	docker compose exec app composer update

# ─── Info ─────────────────────────────────────────────────────────────────────

help:
	@echo ""
	@echo "CakePHP 5 — Available Make Commands"
	@echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
	@echo ""
	@echo "  Docker:"
	@echo "    make up               Start containers"
	@echo "    make down             Stop containers"
	@echo "    make restart          Restart containers"
	@echo "    make logs             Tail app logs"
	@echo "    make shell            Open bash in app container"
	@echo ""
	@echo "  Database:"
	@echo "    make migrate          Run pending migrations"
	@echo "    make migrate-status   Show migration status"
	@echo "    make rollback         Rollback last migration"
	@echo "    make seed             Run seeds"
	@echo ""
	@echo "  Testing:"
	@echo "    make test             Run all tests"
	@echo "    make test-file FILE=  Run a specific test file"
	@echo "    make test-coverage    Generate HTML coverage report"
	@echo ""
	@echo "  Code Quality:"
	@echo "    make cs               Check code style"
	@echo "    make cs-fix           Auto-fix code style"
	@echo "    make stan             Run PHPStan analysis"
	@echo ""
	@echo "  Code Generation (Bake):"
	@echo "    make bake-model NAME=       Bake a Model"
	@echo "    make bake-controller NAME=  Bake a Controller"
	@echo "    make bake-template NAME=    Bake templates"
	@echo "    make bake-all NAME=         Bake Model + Controller + Templates"
	@echo "    make bake-migration NAME=   Bake a Migration"
	@echo ""
	@echo "  Workflow:"
	@echo "    make new-task TASK=   Create a new task folder from template"
	@echo ""
