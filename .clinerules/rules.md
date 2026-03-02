# Cline Rules for myapp (CakePHP 5)

## Project Overview
- **Framework**: CakePHP 5.x
- **PHP**: 8.3+
- **Database**: MySQL 8.0
- **Environment**: Docker (see `docker-compose.yml`)
- **App URL**: http://localhost:8765

## Coding Standards

### CakePHP 5 Conventions
- Models in `src/Model/Table/` (suffix `Table.php`) and `src/Model/Entity/`
- Controllers in `src/Controller/` (suffix `Controller.php`)
- Templates in `templates/{ControllerName}/`
- Always use CakePHP ORM — never raw SQL
- Use `$this->request->getData()` for POST data
- Use Flash messages for user feedback
- Always validate at the Model layer (in `Table::validationDefault()`)

### PHP Standards
- `declare(strict_types=1);` at the top of every PHP file
- Type hints on all method parameters and return types
- PSR-12 code style (enforced by `phpcs`)
- PHP 8.3+ features encouraged (enums, readonly, named args, etc.)

### Testing Standards
- Unit tests in `tests/TestCase/`
- Use CakePHP fixtures for database testing
- Test file naming: `{ClassName}Test.php`
- Always test: happy path + validation failure + edge cases

## Workflow
This project follows a structured AI-assisted workflow defined in `.clinerules/workflows/`.
See `docs/tasks/_TEMPLATE/` for document templates.

## Docker Commands (Quick Reference)
- Start: `make up`
- Shell: `make shell`
- Tests: `make test`
- Code style: `make cs`
- Migrations: `make migrate`

## Git Conventions
- Branch: `feature/{task-name}` or `fix/{task-name}`
- Commits: conventional commits (`feat:`, `fix:`, `refactor:`, `test:`, `docs:`)
- Always branch from `master`
