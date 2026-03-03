## STATUS: APPROVED

# Task Prompt: login

## Task ID
`TASK-002`

## Context

### Existing Codebase

**`src/Application.php`** — no authentication middleware yet; currently loads DebugKit, Migrations, CSRF, BodyParser:
```php
public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
{
    $middlewareQueue
        ->add(new ErrorHandlerMiddleware(...))
        ->add(new AssetMiddleware(...))
        ->add(new RoutingMiddleware($this))
        ->add(new BodyParserMiddleware())
        ->add(new CsrfProtectionMiddleware(['httponly' => true]));
    return $middlewareQueue;
}
```

**`src/Controller/AppController.php`** — loads only Flash component, no auth check:
```php
public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('Flash');
}
```

**`config/routes.php`** — has `/cameras` resource routes and `fallbacks()`. No `/login` or `/logout` routes yet.

**`tests/schema.sql`** — only has `cameras` table. No `users` table yet.

**Existing test pattern** (`CamerasControllerTest`):
```php
class CamerasControllerTest extends TestCase
{
    use IntegrationTestTrait;
    protected array $fixtures = ['app.Cameras'];

    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }
}
```

**Existing validation pattern** (`CamerasTable`):
```php
public function validationDefault(Validator $validator): Validator
{
    $validator
        ->scalar('username')
        ->maxLength('username', 100)
        ->requirePresence('username', 'create')
        ->notEmptyString('username');
    return $validator;
}
```

### Technology Stack
- CakePHP 5.x, PHP 8.3+, MySQL 8.0, Docker
- Authentication: `cakephp/authentication` plugin (already available via composer or to be required)
- No frontend framework — plain CakePHP templates with existing CSS (`milligram.min.css`)

---

## Objective

Implement a session-based login/logout system using the official `cakephp/authentication` plugin. Users authenticate with `username` + `password` (bcrypt hashed). All existing routes (starting with `/cameras`) must be protected and redirect unauthenticated visitors to `/login`. The login page itself and `/logout` must be publicly accessible.

---

## Constraints
- CakePHP 5 conventions (Table/Entity/Controller naming, templates in `templates/Users/`)
- PHP 8.3+ strict types (`declare(strict_types=1)` in every file)
- PSR-12 code style
- No raw SQL — use CakePHP ORM only
- Use `cakephp/authentication` plugin — **not** the legacy `AuthComponent`
- Passwords must be stored as bcrypt hashes (`DefaultPasswordHasher`)
- Session-based authentication (not JWT or API tokens)
- Login form must be CSRF-protected (existing `CsrfProtectionMiddleware` covers this)
- Delete action must remain POST-only (no change needed from camera CRUD)

---

## Expected Output

### Files to Create

| File | Description |
|------|-------------|
| `src/Model/Table/UsersTable.php` | ORM Table — `initialize()`, `validationDefault()`, `buildRules()` (unique username), timestamps |
| `src/Model/Entity/User.php` | Entity — `$_accessible` whitelist, `$_hidden = ['password']`, password hashing via `_setPassword()` |
| `src/Controller/UsersController.php` | `login()` and `logout()` actions only |
| `templates/Users/login.php` | Login form (username + password fields, submit button) |
| `tests/Fixture/UsersFixture.php` | 2 user records with bcrypt-hashed passwords |
| `tests/TestCase/Model/Table/UsersTableTest.php` | Validation unit tests |
| `tests/TestCase/Controller/UsersControllerTest.php` | Integration tests for login/logout |

### Files to Modify

| File | Changes |
|------|---------|
| `composer.json` | Add `cakephp/authentication` if not already present |
| `src/Application.php` | Add `AuthenticationMiddleware` + implement `AuthenticationServiceProviderInterface` |
| `src/Controller/AppController.php` | Load `Authentication` component; call `$this->Authentication->allowUnauthenticated(['login'])` via controller |
| `config/routes.php` | Add `/login` → `Users::login`, `/logout` → `Users::logout` |
| `tests/schema.sql` | Append `users` table DDL |

---

## Database Schema

Add to `tests/schema.sql`:

```sql
CREATE TABLE users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    created    DATETIME     NOT NULL,
    modified   DATETIME     NOT NULL
);
```

Run in production Docker container:
```bash
make shell
mysql -u cakephp -pcakephp cakephp -e "
CREATE TABLE IF NOT EXISTS users (
    id       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created  DATETIME NOT NULL,
    modified DATETIME NOT NULL
);"
```

---

## Authentication Plugin Setup Pattern

```php
// src/Application.php
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        $service->setConfig([
            'unauthenticatedRedirect' => '/login',
            'queryParam' => 'redirect',
        ]);
        $service->loadIdentifier('Authentication.Password', [
            'fields' => ['username' => 'username', 'password' => 'password'],
        ]);
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => ['username' => 'username', 'password' => 'password'],
            'loginUrl' => '/login',
        ]);
        return $service;
    }
}
```

```php
// AppController — allow login page, protect everything else
public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('Flash');
    $this->loadComponent('Authentication.Authentication');
}
```

---

## Acceptance Criteria

- [ ] `GET /login` returns 200 and shows a login form (username + password fields)
- [ ] `POST /login` with valid credentials creates a session and redirects to `/cameras`
- [ ] `POST /login` with invalid credentials stays on `/login` and shows an error flash message
- [ ] `GET /cameras` (and all other protected routes) redirects unauthenticated users to `/login`
- [ ] `POST /logout` destroys the session and redirects to `/login`
- [ ] Passwords are stored as bcrypt hashes (never plain text)
- [ ] `UsersTable` validation: `username` required, max 100 chars, must be unique; `password` required, min 8 chars
- [ ] All new tests pass (`make test`) — 0 failures
- [ ] `phpcs` reports zero violations (`make cs`)
- [ ] No regressions in `ApplicationTest`, `PagesControllerTest`, or `CamerasControllerTest`

---

## Tests to Write

### `UsersTableTest`

| Method | Description |
|--------|-------------|
| `testValidationRequiresUsername()` | Empty `username` fails validation |
| `testValidationUsernameMaxLength()` | `username` > 100 chars fails validation |
| `testValidationRequiresPassword()` | Empty `password` fails validation |
| `testValidationPasswordMinLength()` | `password` < 8 chars fails validation |
| `testBuildRulesUniqueUsername()` | Duplicate `username` fails `isUnique` rule |
| `testPasswordIsHashed()` | Saved entity has bcrypt-hashed password (not plain text) |
| `testSaveValidUser()` | Valid user entity saves successfully |

### `UsersControllerTest`

| Method | Description |
|--------|-------------|
| `testLoginGet()` | `GET /login` → 200, contains login form |
| `testLoginPostSuccess()` | `POST /login` valid creds → redirect to `/cameras` |
| `testLoginPostFail()` | `POST /login` wrong password → stays on `/login`, error shown |
| `testLogout()` | `POST /logout` → redirect to `/login` |
| `testCamerasRequiresAuth()` | `GET /cameras` unauthenticated → redirect to `/login` |

---

## Out of Scope
- User registration (sign-up) UI — seed users via fixture/migration only
- Role-based access control (RBAC) / permissions
- "Remember me" / persistent sessions
- Password reset / forgot-password flow
- Email field (username only for now)
- API token / JWT authentication
- User profile editing
