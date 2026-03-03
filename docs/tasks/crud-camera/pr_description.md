## Task ID
TASK-001

## Summary
Build a full CRUD feature for Camera management in CakePHP 5, including database schema, ORM layer (Table + Entity), CamerasController with 5 standard actions, 4 Blade-style CakePHP templates, authentication middleware, and complete test coverage (fixture + Table unit tests + Controller integration tests).

## Type of Change
- [x] ✨ Feature

## Changes Made

### Files Created
| File | Description |
|------|-------------|
| `src/Model/Table/CamerasTable.php` | ORM Table with `initialize()`, `validationDefault()`, timestamps |
| `src/Model/Entity/Camera.php` | Entity with `$_accessible` whitelist |
| `src/Controller/CamerasController.php` | 5 actions: index, view, add, edit, delete |
| `templates/Cameras/index.php` | Table listing all cameras with action links |
| `templates/Cameras/view.php` | Detail page for one camera |
| `templates/Cameras/add.php` | Create form |
| `templates/Cameras/edit.php` | Edit form (pre-filled) |
| `tests/Fixture/CamerasFixture.php` | 3 sample camera records for tests |
| `tests/TestCase/Model/Table/CamerasTableTest.php` | 9 validation unit tests |
| `tests/TestCase/Controller/CamerasControllerTest.php` | 11 HTTP integration tests |
| `docs/tasks/crud-camera/task_prompt.md` | Task prompt document |
| `docs/tasks/crud-camera/implement_plan.md` | Implementation plan |

### Files Modified
| File | Changes |
|------|---------|
| `composer.json` / `composer.lock` | Added `cakephp/authentication` plugin |
| `src/Application.php` | Wired `AuthenticationMiddleware` with session + form authenticators |
| `src/Controller/AppController.php` | Added `requireLogin()` with per-controller allowlists |
| `src/Controller/PagesController.php` | Allow unauthenticated access to `/pages/*` |
| `config/routes.php` | Added `$builder->resources('Cameras')` |
| `config/app.php` | Added `_cake_translations_` cache config; added `ignoredDeprecationPaths` |
| `tests/schema.sql` | Appended `cameras` table DDL |
| `tests/TestCase/Controller/CamerasControllerTest.php` | Fixed tests to use session login helper |

## Testing
- [x] All existing tests pass (39/39)
- [x] New tests written and passing (20 new: 9 Table + 11 Controller)
- [x] No regressions in `ApplicationTest` or `PagesControllerTest`
- [x] Code style: `phpcs.xml` uses Slevomat sniffs not installed in project (pre-existing broken config); PSR-12 header issues are project-wide in all CakePHP scaffold files

## Definition of Done
- [x] `tests/schema.sql` contains the `cameras` table DDL
- [x] `config/routes.php` registers the Cameras resource route
- [x] All 5 controller actions work end-to-end (verified via tests)
- [x] Validation rejects: empty name, empty/invalid IP address, non-boolean status
- [x] Flash messages appear for add, edit, and delete operations
- [x] Delete uses HTTP POST only (no GET delete)
- [x] All new tests pass (`make test` → 39/39)
- [x] No regressions in `ApplicationTest` or `PagesControllerTest`
