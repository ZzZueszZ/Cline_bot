## Task ID
TASK-001

## Summary
Build a full CRUD feature for Camera management in CakePHP 5. Implements the complete ORM layer (Table + Entity), a CamerasController with 5 standard actions, 4 Blade-free CakePHP templates, and full test coverage (fixture, Table unit tests, Controller integration tests). Also includes a `docker-compose.yml` startup fix to ensure `tmp/` and `logs/` are always writable after a volume mount.

## Type of Change
- [x] ✨ Feature

## Changes Made

### Files Created
| File | Description |
|------|-------------|
| `src/Model/Table/CamerasTable.php` | ORM Table with `initialize()`, `validationDefault()`, timestamps |
| `src/Model/Entity/Camera.php` | Entity with `$_accessible` whitelist |
| `src/Controller/CamerasController.php` | 5 actions: index, view, add, edit, delete |
| `templates/Cameras/index.php` | List all cameras with action links |
| `templates/Cameras/view.php` | Detail page for one camera |
| `templates/Cameras/add.php` | Create form |
| `templates/Cameras/edit.php` | Edit form (pre-filled) |
| `tests/Fixture/CamerasFixture.php` | 3 sample camera records |
| `tests/TestCase/Model/Table/CamerasTableTest.php` | 9 validation unit tests |
| `tests/TestCase/Controller/CamerasControllerTest.php` | 11 HTTP integration tests |

### Files Modified
| File | Changes |
|------|---------|
| `config/routes.php` | Added `$builder->resources('Cameras')` before fallbacks |
| `tests/schema.sql` | Appended `cameras` table DDL |
| `docker-compose.yml` | Added startup command to fix `tmp/` and `logs/` permissions after volume mount |

## Testing
- [x] All existing tests pass (ApplicationTest, PagesControllerTest)
- [x] New tests written and passing (20 tests, 37 assertions — 0 failures)
- [x] Code style check passes (`phpcs`)

## Definition of Done
- [x] `tests/schema.sql` contains the `cameras` table DDL
- [x] `config/routes.php` registers the Cameras resource route
- [x] All 5 controller actions work end-to-end (verified via tests + browser at http://localhost:8080/cameras)
- [x] Validation rejects: empty name, empty/invalid IP address, non-boolean status
- [x] Flash messages appear for add, edit, and delete operations
- [x] Delete uses HTTP POST only (no GET delete)
- [x] All new tests pass (`make test`) — 20/20
- [x] `phpcs` reports zero violations (`make cs`)
- [x] No regressions in `ApplicationTest` or `PagesControllerTest`
