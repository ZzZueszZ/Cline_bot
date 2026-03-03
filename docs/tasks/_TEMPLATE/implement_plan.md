## STATUS: DRAFT
<!-- Change to APPROVED when ready for implementation -->

# Implementation Plan: [TASK NAME]

## Task ID
`TASK-XXX`

## Summary
<!-- Brief description of what will be built -->

---

## Files to Create

| File | Description |
|------|-------------|
| `src/Model/Table/XxxTable.php` | Table class with associations and validation rules |
| `src/Model/Entity/Xxx.php` | Entity class with accessible fields |
| `src/Controller/XxxController.php` | Controller with CRUD actions |
| `templates/Xxx/index.php` | List view |
| `templates/Xxx/view.php` | Detail view |
| `templates/Xxx/add.php` | Add form |
| `templates/Xxx/edit.php` | Edit form |
| `tests/TestCase/Model/Table/XxxTableTest.php` | Table unit tests |
| `tests/TestCase/Controller/XxxControllerTest.php` | Controller integration tests |
| `config/Migrations/YYYYMMDDHHIISS_CreateXxx.php` | Database migration |

## Files to Modify

| File | Changes |
|------|---------|
| `config/routes.php` | Add routes for Xxx |
| `src/Application.php` | Register plugin/middleware if needed |

---

## Database Migrations

```sql
-- Table: xxx
CREATE TABLE xxx (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created DATETIME,
    modified DATETIME
);
```

---

## Implementation Steps

- [ ] **Step 1**: Create migration file
  - Run: `docker compose exec app bin/cake bake migration CreateXxx`
  - Add fields to migration
  - Run: `docker compose exec app bin/cake migrations migrate`

- [ ] **Step 2**: Bake Model
  - Run: `docker compose exec app bin/cake bake model Xxx`
  - Add validation rules to `XxxTable.php`
  - Set accessible fields in `Xxx.php`

- [ ] **Step 3**: Bake Controller
  - Run: `docker compose exec app bin/cake bake controller Xxx`
  - Customize actions as needed

- [ ] **Step 4**: Bake Templates
  - Run: `docker compose exec app bin/cake bake template Xxx`
  - Customize views

- [ ] **Step 5**: Add Routes
  - Add to `config/routes.php`

- [ ] **Step 6**: Write Tests
  - Create `XxxTableTest.php`
  - Create `XxxControllerTest.php`
  - Create fixtures if needed

---

## Tests to Write

### XxxTableTest
- `testValidationRequiredFields()` — required fields fail without data
- `testValidationSuccess()` — valid data passes
- `testSaveAndFind()` — save entity and retrieve it

### XxxControllerTest
- `testIndex()` — GET /xxx returns 200
- `testView()` — GET /xxx/view/1 returns 200
- `testAddGet()` — GET /xxx/add returns 200
- `testAddPost()` — POST /xxx/add with valid data redirects
- `testAddPostInvalid()` — POST /xxx/add with invalid data shows errors
- `testEdit()` — POST /xxx/edit/1 updates record
- `testDelete()` — POST /xxx/delete/1 removes record

---

## Commands to Run

```bash
# Run all tests
docker compose exec app vendor/bin/phpunit

# Run specific test file
docker compose exec app vendor/bin/phpunit tests/TestCase/Model/Table/XxxTableTest.php

# Code style check
docker compose exec app vendor/bin/phpcs src/

# Fix code style automatically
docker compose exec app vendor/bin/phpcbf src/
```

---

## Definition of Done

- [ ] Migration runs without errors
- [ ] All CRUD operations work in browser
- [ ] All unit tests pass
- [ ] `phpcs` reports no violations
- [ ] No regressions in existing test suite
- [ ] Code reviewed and approved
