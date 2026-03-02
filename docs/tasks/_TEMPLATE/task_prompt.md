## STATUS: DRAFT
<!-- Change to APPROVED when ready for planning -->

# Task Prompt: [TASK NAME]

## Task ID
`TASK-XXX`

## Context

### Existing Codebase
<!-- AI-generated: relevant existing code snippets and structure -->

### Technology Stack
- CakePHP 5.x
- PHP 8.3+
- MySQL 8.0
- Docker

## Objective
<!-- Clear, concise statement of what needs to be built -->

## Constraints
- Must follow CakePHP 5 conventions
- PHP 8.3+ with strict types
- PSR-12 code style
- All logic must be covered by unit tests
- No raw SQL (use CakePHP ORM)
- <!-- Add task-specific constraints -->

## Expected Output

### Files to Create
<!-- List files AI should create -->
- `src/Model/Table/XxxTable.php`
- `src/Model/Entity/Xxx.php`
- `src/Controller/XxxController.php`
- `templates/Xxx/index.php`
- `tests/TestCase/Model/Table/XxxTableTest.php`
- `tests/TestCase/Controller/XxxControllerTest.php`

### Files to Modify
<!-- List existing files to modify -->
- `src/Application.php` — register routes/middleware

## Acceptance Criteria
<!-- Testable pass/fail criteria -->
- [ ] Feature X works correctly
- [ ] Validation rejects invalid input
- [ ] All unit tests pass
- [ ] Code style check passes (`phpcs`)
- [ ] No regressions in existing tests

## Out of Scope
<!-- Explicitly state what NOT to build -->
- Authentication/authorization
- API endpoints
- Email notifications
