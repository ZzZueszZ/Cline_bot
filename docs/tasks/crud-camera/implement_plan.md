## STATUS: APPROVED
<!-- Change to APPROVED when ready to implement -->

# Implementation Plan: crud-camera

## Task ID
`TASK-001`

## Summary
Build a full CRUD feature for Camera management in CakePHP 5. This includes the database schema, ORM layer (Table + Entity), a CamerasController with 5 standard actions, 4 CakePHP templates, and complete test coverage (fixture, Table unit tests, Controller integration tests).

---

## Files to Create

| File | Description |
|------|-------------|
| `src/Model/Table/CamerasTable.php` | ORM Table — `initialize()`, `validationDefault()`, timestamps |
| `src/Model/Entity/Camera.php` | Entity — `$_accessible` whitelist for mass-assignment |
| `src/Controller/CamerasController.php` | 5 actions: index, view, add, edit, delete |
| `templates/Cameras/index.php` | Table listing all cameras with action links |
| `templates/Cameras/view.php` | Detail page for one camera |
| `templates/Cameras/add.php` | Create form |
| `templates/Cameras/edit.php` | Edit form (pre-filled) |
| `tests/Fixture/CamerasFixture.php` | 3 sample camera records for tests |
| `tests/TestCase/Model/Table/CamerasTableTest.php` | Validation unit tests |
| `tests/TestCase/Controller/CamerasControllerTest.php` | HTTP integration tests for all 5 actions |

## Files to Modify

| File | Changes |
|------|---------|
| `config/routes.php` | Add `$builder->resources('Cameras');` before `$builder->fallbacks()` |
| `tests/schema.sql` | Append `cameras` table DDL |

---

## Database Migrations

> No CakePHP Migrations plugin is required — schema is managed via SQL directly.

Add to `tests/schema.sql` (used by test runner):

```sql
CREATE TABLE cameras (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    ip_address  VARCHAR(45)  NOT NULL,
    location    VARCHAR(255) DEFAULT NULL,
    status      TINYINT(1)   NOT NULL DEFAULT 1,
    created     DATETIME     NOT NULL,
    modified    DATETIME     NOT NULL
);
```

For the **production database**, run this DDL manually inside the Docker container:
```bash
make shell
# then inside container:
mysql -u root -p app < /path/to/cameras.sql
```

---

## Implementation Steps

- [ ] **Step 1 — Schema**: Add `cameras` DDL to `tests/schema.sql`
- [ ] **Step 2 — Routes**: Add `$builder->resources('Cameras');` to `config/routes.php`
- [ ] **Step 3 — Entity**: Create `src/Model/Entity/Camera.php` with `$_accessible`
- [ ] **Step 4 — Table**: Create `src/Model/Table/CamerasTable.php` with `initialize()` and `validationDefault()`
- [ ] **Step 5 — Controller**: Create `src/Controller/CamerasController.php` with index / view / add / edit / delete
- [ ] **Step 6 — Template index**: Create `templates/Cameras/index.php`
- [ ] **Step 7 — Template view**: Create `templates/Cameras/view.php`
- [ ] **Step 8 — Template add**: Create `templates/Cameras/add.php`
- [ ] **Step 9 — Template edit**: Create `templates/Cameras/edit.php`
- [ ] **Step 10 — Fixture**: Create `tests/Fixture/CamerasFixture.php`
- [ ] **Step 11 — Table tests**: Create `tests/TestCase/Model/Table/CamerasTableTest.php`
- [ ] **Step 12 — Controller tests**: Create `tests/TestCase/Controller/CamerasControllerTest.php`
- [ ] **Step 13 — Verify**: Run `make test` and `make cs`; fix any failures

---

## Tests to Write

### `CamerasTableTest`

| Method | Description |
|--------|-------------|
| `testValidationRequiresName()` | Empty `name` fails validation |
| `testValidationNameMaxLength()` | `name` > 100 chars fails validation |
| `testValidationRequiresIpAddress()` | Empty `ip_address` fails validation |
| `testValidationInvalidIpAddress()` | Non-IP string fails validation |
| `testValidationValidIpv4()` | Valid IPv4 passes validation |
| `testValidationValidIpv6()` | Valid IPv6 passes validation |
| `testValidationLocationOptional()` | Record saves without `location` |
| `testValidationStatusBoolean()` | Non-boolean `status` fails validation |
| `testSaveValidRecord()` | A fully valid entity is saved successfully |

### `CamerasControllerTest`

| Method | Description |
|--------|-------------|
| `testIndex()` | `GET /cameras` → 200, contains camera names from fixture |
| `testView()` | `GET /cameras/view/1` → 200, shows correct camera data |
| `testViewNotFound()` | `GET /cameras/view/9999` → 404 |
| `testAdd()` | `GET /cameras/add` → 200, renders form |
| `testAddPost()` | `POST /cameras/add` valid data → redirect to index, record created |
| `testAddPostValidationFail()` | `POST /cameras/add` empty name → 200, errors shown |
| `testEdit()` | `GET /cameras/edit/1` → 200, form pre-filled |
| `testEditNotFound()` | `GET /cameras/edit/9999` → 404 |
| `testEditPost()` | `POST /cameras/edit/1` valid data → redirect to index, record updated |
| `testDeletePost()` | `POST /cameras/delete/1` → redirect to index, record removed |
| `testDeleteNotFound()` | `POST /cameras/delete/9999` → 404 |

---

## Commands to Run

```bash
# Run all tests
make test

# Check code style
make cs

# Start the application (verify UI manually)
make up
# then open http://localhost:8765/cameras
```

---

## Definition of Done

- [ ] `tests/schema.sql` contains the `cameras` table DDL
- [ ] `config/routes.php` registers the Cameras resource route
- [ ] All 5 controller actions work end-to-end (verified via tests + browser)
- [ ] Validation rejects: empty name, empty/invalid IP address, non-boolean status
- [ ] Flash messages appear for add, edit, and delete operations
- [ ] Delete uses HTTP POST only (no GET delete)
- [ ] All new tests pass (`make test`)
- [ ] `phpcs` reports zero violations (`make cs`)
- [ ] No regressions in `ApplicationTest` or `PagesControllerTest`
