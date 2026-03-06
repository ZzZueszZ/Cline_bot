# System Patterns

## System Architecture
SurveillanceHub is built on the [CakePHP 5](https://cakephp.org/) framework, following its MVC (Model-View-Controller) architectural pattern. It is designed as a monolithic application, with business logic, data access, and presentation layers tightly coupled within the CakePHP structure.

### Key Components:
- **Web Server**: Nginx/Apache (handled by Docker setup)
- **Application Framework**: CakePHP 5 (PHP 8.3+)
- **Database**: MySQL 8.0
- **Client-side**: HTML, CSS (Tailwind CSS), JavaScript (minimal)

## Design Patterns in Use
- **MVC (Model-View-Controller)**: Core architectural pattern of CakePHP.
- **ORM (Object-Relational Mapping)**: Handled by CakePHP's ORM for database interactions.
- **Active Record**: Entities represent rows in database tables.
- **Table Data Gateway**: Table classes act as gateways to the database tables.

## Component Relationships
- **Users**: Manage authentication and authorization.
- **Stores**: Managed by `StoresController`, `StoresTable`, and `Store` entity. Can have multiple associated `Cameras`.
- **Cameras**: Managed by `CamerasController`, `CamerasTable`, and `Camera` entity. Each `Camera` belongs to a `Store`.
- **Dashboard**: Provides an overview of the system, acting as a central entry point.

## Critical Implementation Paths
1.  **User Authentication**: Login, registration, password reset flows are critical for secure access.
2.  **CRUD Operations for Stores**: Adding, viewing, editing, and deleting stores directly impacts the core data management.
3.  **CRUD Operations for Cameras**: Managing cameras, especially linking them to stores, is central to the application's purpose.
