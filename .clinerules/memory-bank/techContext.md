# Tech Context

## Technologies Used
- **Backend**: CakePHP 5 (PHP 8.3+)
- **Database**: MySQL 8.0
- **Frontend**: HTML, Tailwind CSS, minimal JavaScript
- **Containerization**: Docker

## Development Setup
- **Local Environment**: Docker Compose for PHP-FPM, Nginx, MySQL (see `docker-compose.yml`)
- **Dependencies**: Managed by Composer.

## Technical Constraints
- **PHP Version**: Must be 8.3 or higher.
- **Database Version**: MySQL 8.0 is required.
- **CakePHP ORM**: All database interactions must use CakePHP ORM; raw SQL is prohibited.
- **Coding Standards**: PSR-12 and CakePHP 5 conventions must be followed (enforced by `phpcs`).

## Dependencies
- **Composer**: For PHP package management.
- **Docker**: For containerized development environment.
- **Node.js/NPM (optional)**: For frontend asset compilation (e.g., Tailwind CSS JIT) if custom builds are needed beyond CDN.

## Tool Usage Patterns
- **CLI**: `make` commands (e.g., `make up`, `make shell`, `make test`, `make cs`, `make migrate`) are preferred for common tasks.
- **IDE**: IntelliJ IDEA Ultimate (as detected by the environment).
- **Version Control**: Git, with conventional commits.`
