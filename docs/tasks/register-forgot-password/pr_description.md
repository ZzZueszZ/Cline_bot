# PR: feat: Register & Forgot Password

## Branch
`feature/register-forgot-password` → `master`

## Summary
Ships user self-registration and a token-based forgot-password / reset-password flow on top of the existing session authentication.

## Changes

### New Files
| File | Purpose |
|------|---------|
| `src/Mailer/UserMailer.php` | Sends the reset-password email (html + text) |
| `templates/email/html/reset_password.php` | HTML email body |
| `templates/email/text/reset_password.php` | Plain-text email body |
| `templates/Users/register.php` | Registration form (username, email, password, confirm) |
| `templates/Users/forgot_password.php` | Email request form |
| `templates/Users/reset_password.php` | New-password form (token-gated) |

### Modified Files
| File | Changes |
|------|---------|
| `src/Model/Table/UsersTable.php` | Added `validationRegister`, `validationForgotPassword`, `validationResetPassword`; email uniqueness rule |
| `src/Model/Entity/User.php` | Exposed `email`, `password_confirm`, `password_reset_token`, `token_expires` in `$_accessible`; hidden `password_reset_token` |
| `src/Controller/UsersController.php` | Added `register()`, `forgotPassword()`, `resetPassword()` actions; updated `beforeFilter` allowlist |
| `config/routes.php` | Added `/register`, `/forgot-password`, `/reset-password/{token}` routes |
| `tests/schema.sql` | Added `email`, `password_reset_token`, `token_expires` columns to `users` table |
| `tests/Fixture/UsersFixture.php` | Extended to 3 fixture users (admin, valid-token user, expired-token user) |
| `tests/TestCase/Controller/UsersControllerTest.php` | Added 19 new controller integration tests |
| `tests/TestCase/Model/Table/UsersTableTest.php` | Added 10 new model validation unit tests |

## Test Results
```
OK (55 tests, 133 assertions)   # 0 failures, 0 errors
phpcs: 0 violations
```

## Security (OWASP Top 10)
| Risk | Mitigation |
|------|-----------|
| A02 Cryptographic Failures | Passwords hashed with bcrypt (`DefaultPasswordHasher`) |
| A07 Identification & Auth Failures | `forgotPassword` always returns the same flash message — no email enumeration |
| A07 | Reset tokens are single-use (cleared on success) and expire in 1 hour |
| A03 Injection | CakePHP ORM only — no raw SQL |
| A05 Security Misconfiguration | CSRF protection on all forms (existing middleware) |

## DB Migration (production)
```sql
ALTER TABLE users
    ADD COLUMN email                VARCHAR(255) NULL         AFTER password,
    ADD COLUMN password_reset_token VARCHAR(255) NULL         AFTER email,
    ADD COLUMN token_expires        DATETIME     NULL         AFTER password_reset_token,
    ADD UNIQUE KEY uq_users_email (email);
```

## Out of Scope
- Email verification on registration
- Rate-limiting on forgot-password endpoint
- "Remember me" / persistent sessions
