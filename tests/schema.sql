-- Test database schema.
--
-- If you are not using CakePHP migrations you can put
-- your application's schema in this file and use it in tests.

CREATE TABLE cameras (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    ip_address  VARCHAR(45)  NOT NULL,
    location    VARCHAR(255) DEFAULT NULL,
    status      TINYINT(1)   NOT NULL DEFAULT 1,
    created     DATETIME     NOT NULL,
    modified    DATETIME     NOT NULL
);

CREATE TABLE users (
    id                   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username             VARCHAR(100) NOT NULL,
    password             VARCHAR(255) NOT NULL,
    email                VARCHAR(255) NULL,
    password_reset_token VARCHAR(255) NULL,
    token_expires        DATETIME     NULL,
    created              DATETIME     NOT NULL,
    modified             DATETIME     NOT NULL
);
