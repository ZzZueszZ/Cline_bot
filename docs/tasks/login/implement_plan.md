## STATUS: APPROVED

# Implementation Plan: login

## Task ID
`TASK-002`

## Summary
Install the `cakephp/authentication` plugin and wire up session-based authentication for the entire application. A `users` table will store bcrypt-hashed passwords. Only `/login` and `/logout` are publicly accessible; all other routes (including `/cameras`) redirect unauthenticated visitors to `/login`. Implementation follows OWASP Top 10 guidance: bcrypt storage, generic error messages, CSRF protection on the login form, and no information leakage.

---

## Files to Create

| File | Description |
|------|-------------|
| `src/Model/Table/UsersTable.php` | ORM Table — `initialize()`, `validationDefault()`, `buildRules()` (unique username), Timestamp behaviour |
| `src/Model/Entity/User.php` | Entity — `$_accessible`, `$_hidden = ['password']`, `_setPassword()` with `DefaultPasswordHasher` |
| `src/Controller/UsersController.php` | `login()` and `logout()` actions |
| `templates/Users/login.php` | Login form — username + password, flash messages |
| `tests/Fixture/UsersFixture.php` | 2 records with bcrypt-hashed passwords |
| `tests/TestCase/Model/Table/UsersTableTest.php` | 7 validation / rule unit tests |
| `tests/TestCase/Controller/UsersControllerTest.php` | 5 integration tests |

## Files to Modify

| File | Changes |
|------|---------|
| `composer.json` | Add `"cakephp/authentication": "^3.0"` to `require` |
| `src/Application.php` | Implement `AuthenticationServiceProviderInterface`; add `AuthenticationMiddleware` after `RoutingMiddleware` |
| `src/Controller/AppController.php` | Load `Authentication.Authentication` component; `allowUnauthenticated` in `UsersController` |
| `config/routes.php` | Add `/login` → `Users::login`, `/logout` → `Users::logout` before `fallbacks()` |
| `tests/schema.sql` | Append `users` table DDL |

---

## Database Migrations

### Test schema (`tests/schema.sql`)
```sql
CREATE TABLE users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    created    DATETIME     NOT NULL,
    modified   DATETIME     NOT NULL
);
```

### Production (run inside Docker)
```bash
make shell
# inside container:
bin/cake migrations create CreateUsers
# edit the generated migration, then:
bin/cake migrations migrate
```

Or apply directly:
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

## Implementation Steps

- [ ] **Step 1 — Install plugin**
  - Run `composer require cakephp/authentication:^3.0` inside Docker (`make shell`)
  - Confirm `vendor/cakephp/authentication` directory exists

- [ ] **Step 2 — Database schema**
  - Append `users` DDL to `tests/schema.sql`
  - Run migration (or raw SQL) in the running Docker container

- [ ] **Step 3 — `UsersTable`**
  - Create `src/Model/Table/UsersTable.php`
  - `initialize()`: `setTable('users')`, `setDisplayField('username')`, `addBehavior('Timestamp')`
  - `validationDefault()`: `username` (required, scalar, max 100), `password` (required, scalar, min 8)
  - `buildRules()`: `$rules->isUnique(['username'])`

- [ ] **Step 4 — `User` entity**
  - Create `src/Model/Entity/User.php`
  - `$_accessible = ['username' => true, 'password' => true]`
  - `$_hidden = ['password']`
  - `_setPassword(string $password): string` — returns `(new DefaultPasswordHasher())->hash($password)`

- [ ] **Step 5 — `Application.php`**
  - Implement `AuthenticationServiceProviderInterface`
  - `getAuthenticationService()`:
    - `unauthenticatedRedirect => '/login'`, `queryParam => 'redirect'`
    - Identifier: `Authentication.Password` (fields: username/password)
    - Authenticators: `Authentication.Session`, `Authentication.Form` (loginUrl: `/login`)
  - Add `new AuthenticationMiddleware($this)` **after** `RoutingMiddleware` and **before** `BodyParserMiddleware`

- [ ] **Step 6 — `AppController.php`**
  - Add `$this->loadComponent('Authentication.Authentication');`
  - The component enforces auth globally; individual controllers allow exceptions via `allowUnauthenticated()`

- [ ] **Step 7 — `UsersController.php`**
  - `beforeFilter()`: `$this->Authentication->allowUnauthenticated(['login'])`
  - `login()`:
    - GET: render form
    - POST: check `$this->Authentication->getResult()`; if success redirect to `/cameras`; else set error flash and re-render
  - `logout()`:
    - POST only (method check)
    - `$this->Authentication->logout()`; redirect to `/login`

- [ ] **Step 8 — `templates/Users/login.php`**
  - Use `$this->Form->create()` / `$this->Form->end()`
  - Fields: `username` (text), `password` (password)
  - Flash messages output: `$this->Flash->render()`
  - Generic error message only (no username-not-found vs wrong-password differentiation — OWASP)

- [ ] **Step 9 — `config/routes.php`**
  - Add before `$builder->fallbacks()`:
    ```php
    $builder->connect('/login',  ['controller' => 'Users', 'action' => 'login']);
    $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    ```

- [ ] **Step 10 — `UsersFixture.php`**
  - 2 records:
    - `admin` / `password_hash_of_Password1!`
    - `editor` / `password_hash_of_Password2@`
  - Pre-hash passwords with `password_hash('Password1!', PASSWORD_BCRYPT)`

- [ ] **Step 11 — `UsersTableTest.php`**
  - Write 7 unit tests (see Tests section below)

- [ ] **Step 12 — `UsersControllerTest.php`**
  - Write 5 integration tests (see Tests section below)
  - Update existing `CamerasControllerTest` to log in before each request (or use `$this->session(...)` to inject auth identity)

- [ ] **Step 13 — Run tests & fix**
  - `make test` — all pass
  - `make cs` — zero violations

---

## Tests to Write

### `UsersTableTest`
- `testValidationRequiresUsername()` — empty `username` → validation error
- `testValidationUsernameMaxLength()` — 101-char `username` → validation error
- `testValidationRequiresPassword()` — empty `password` → validation error
- `testValidationPasswordMinLength()` — 7-char `password` → validation error
- `testBuildRulesUniqueUsername()` — duplicate `username` → `isUnique` fails save
- `testPasswordIsHashed()` — after save, `$entity->password !== 'rawPassword'` and `password_verify()` returns true
- `testSaveValidUser()` — valid data saves successfully, returns entity with `id`

### `UsersControllerTest`
- `testLoginGet()` — `GET /login` → 200, response contains `<form`
- `testLoginPostSuccess()` — `POST /login` with fixture credentials → redirect to `/cameras`
- `testLoginPostFail()` — `POST /login` with wrong password → 200, stays on login page, contains error indicator
- `testLogout()` — authenticated `POST /logout` → redirect to `/login`
- `testCamerasRequiresAuth()` — unauthenticated `GET /cameras` → redirect to `/login`

> **Note**: `CamerasControllerTest` must be updated to inject a session identity so existing tests continue to pass after auth is enforced.

---

## OWASP Top 10 Checklist

| Risk | Mitigation |
|------|-----------|
| A01 Broken Access Control | All routes protected; only `/login` and `/logout` are public |
| A02 Cryptographic Failures | bcrypt (`DefaultPasswordHasher`, cost ≥ 10) — never MD5/SHA1 |
| A03 Injection | CakePHP ORM parameterised queries only — no raw SQL |
| A05 Security Misconfiguration | CSRF token on every form (existing middleware); `httponly` cookie |
| A07 Identification & Auth Failures | Generic "Invalid credentials" message; no username enumeration |

---

## Commands to Run

```bash
# 1. Install plugin (inside Docker)
make shell
composer require cakephp/authentication:^3.0

# 2. Apply DB migration
bin/cake migrations migrate   # if using Migrations plugin
# or raw SQL (see Database Migrations section above)

# 3. Run tests
make test

# 4. Code style check
make cs
```

---

## Definition of Done

- [ ] `composer require cakephp/authentication:^3.0` completed without errors
- [ ] `users` table exists in test schema and production DB
- [ ] `GET /login` returns 200 with login form
- [ ] `POST /login` valid credentials → session created → redirect to `/cameras`
- [ ] `POST /login` invalid credentials → generic error, no username enumeration
- [ ] `GET /cameras` unauthenticated → redirect to `/login`
- [ ] `POST /logout` → session destroyed → redirect to `/login`
- [ ] Passwords stored as bcrypt hashes (verified by `testPasswordIsHashed`)
- [ ] All 12 new tests pass (`make test`)
- [ ] `CamerasControllerTest` (existing 11 tests) still pass with auth injected
- [ ] `phpcs` reports zero violations (`make cs`)
- [ ] No regressions in `ApplicationTest` or `PagesControllerTest`
