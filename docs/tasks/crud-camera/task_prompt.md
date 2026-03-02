## STATUS: APPROVED
<!-- Change to APPROVED when ready for planning -->

# Task Prompt: crud-camera

## Task ID
`TASK-001`

## Context

### Existing Codebase

**`src/Controller/AppController.php`** — base controller, loads `Flash` component:
```php
declare(strict_types=1);
namespace App\Controller;
use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}
```

**`config/routes.php`** — uses `DashedRoute`, has `$builder->fallbacks()` inside `scope('/')`. A `$builder->resources('Cameras')` call should be added here for clean RESTful routing.

**`tests/schema.sql`** — currently empty. Must add the `cameras` table DDL so test fixtures resolve correctly.

**Project structure** — `src/Model/Table/`, `src/Model/Entity/`, `src/Controller/`, `templates/` and `tests/` directories all exist but are empty (no existing models or controllers beyond defaults).

### Technology Stack
- CakePHP 5.x
- PHP 8.3+
- MySQL 8.0
- Docker

---

## Objective

Build a complete CRUD feature for **Camera** management. Users must be able to list all cameras, view a single camera's detail, add a new camera, edit an existing camera, and delete a camera. The feature covers: database schema, ORM layer (Table + Entity), Controller (5 standard actions), Blade-free CakePHP templates, server-side validation with Flash feedback, and full test coverage.

---

## Constraints
- Must follow CakePHP 5 conventions (Table/Entity/Controller/template naming)
- `declare(strict_types=1);` at the top of every PHP file
- Type hints on all method parameters and return types
- PSR-12 code style (enforced by `make cs`)
- No raw SQL — use CakePHP ORM exclusively
- Validation defined in `CamerasTable::validationDefault()`
- Flash messages for every mutating operation (add / edit / delete)
- POST-Redirect-GET pattern for all form submissions
- `delete` action must only accept HTTP POST (not GET)

---

## Expected Output

### Files to Create

| File | Purpose |
|------|---------|
| `src/Model/Table/CamerasTable.php` | ORM Table class with validation rules |
| `src/Model/Entity/Camera.php` | Entity class with `$_accessible` fields |
| `src/Controller/CamerasController.php` | index / view / add / edit / delete |
| `templates/Cameras/index.php` | List all cameras |
| `templates/Cameras/view.php` | Single camera detail page |
| `templates/Cameras/add.php` | Create-camera form |
| `templates/Cameras/edit.php` | Edit-camera form |
| `tests/Fixture/CamerasFixture.php` | Test fixture with sample records |
| `tests/TestCase/Model/Table/CamerasTableTest.php` | Table / validation unit tests |
| `tests/TestCase/Controller/CamerasControllerTest.php` | Controller integration tests |

### Files to Modify

| File | Change |
|------|--------|
| `config/routes.php` | Add `$builder->resources('Cameras');` inside `scope('/')` before `fallbacks()` |
| `tests/schema.sql` | Append `cameras` table DDL (used by test fixtures) |

---

## Data Model

```sql
CREATE TABLE cameras (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    ip_address  VARCHAR(45)  NOT NULL,   -- supports IPv4 and IPv6
    location    VARCHAR(255) DEFAULT NULL,
    status      TINYINT(1)   NOT NULL DEFAULT 1,  -- 1 = active, 0 = inactive
    created     DATETIME     NOT NULL,
    modified    DATETIME     NOT NULL
);
```

---

## Validation Rules (`CamerasTable::validationDefault`)

| Field | Rules |
|-------|-------|
| `name` | required on create, not empty, maxLength 100 |
| `ip_address` | required on create, not empty, valid IP (custom regex or `->ip()`) |
| `location` | optional, maxLength 255 |
| `status` | boolean (0 or 1) |

---

## Controller Action Signatures

```php
public function index(): void
public function view(int $id): void
public function add(): \Cake\Http\Response|null
public function edit(int $id): \Cake\Http\Response|null
public function delete(int $id): \Cake\Http\Response
```

---

## Template Specifications

### `index.php`
Columns: **ID**, **Name**, **IP Address**, **Location**, **Status** (Active / Inactive text), **Actions** (View | Edit | Delete)
Delete button must use a POST form (not a plain link).

### `view.php`
Display all fields. Provide links to **Edit** and **Back to list**.

### `add.php` / `edit.php`
Form fields: `name` (text), `ip_address` (text), `location` (text), `status` (select: Active / Inactive).
Show validation errors inline. Provide a **Cancel** link back to index.

---

## Acceptance Criteria

- [ ] `GET /cameras` returns HTTP 200 and renders the camera list
- [ ] `GET /cameras/view/{id}` returns HTTP 200 with correct camera data
- [ ] `GET /cameras/add` returns HTTP 200 with an empty form
- [ ] `POST /cameras/add` with valid data creates a record, sets a success Flash, and redirects to index
- [ ] `POST /cameras/add` with invalid data (empty name / bad IP) re-renders the form with validation errors and sets an error Flash
- [ ] `GET /cameras/edit/{id}` returns HTTP 200 with the form pre-filled
- [ ] `POST /cameras/edit/{id}` with valid data updates the record and redirects to index
- [ ] `POST /cameras/delete/{id}` deletes the record, sets a success Flash, and redirects to index
- [ ] Accessing a non-existent camera ID (`view`, `edit`, `delete`) throws a `NotFoundException` (HTTP 404)
- [ ] All unit tests pass (`make test`)
- [ ] Code style check passes (`make cs`)
- [ ] No regressions in existing tests (`ApplicationTest`, `PagesControllerTest`)

---

## Out of Scope

- Authentication / authorization (no login required for now)
- Pagination / search / filtering on the index page
- REST/JSON API endpoints
- Image or file uploads
- Camera brand / model metadata fields
- Email notifications
