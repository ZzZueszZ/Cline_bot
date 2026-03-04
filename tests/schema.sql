-- Test database schema.
--
-- If you are not using CakePHP migrations you can put
-- your application's schema in this file and use it in tests.

CREATE TABLE stores (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name      VARCHAR(150) NOT NULL,
    address   VARCHAR(255) DEFAULT NULL,
    latitude  DECIMAL(10,7) DEFAULT NULL,
    longitude DECIMAL(10,7) DEFAULT NULL,
    created   DATETIME NOT NULL,
    modified  DATETIME NOT NULL
);

CREATE TABLE cameras (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    store_id    INT UNSIGNED DEFAULT NULL,
    name        VARCHAR(100) NOT NULL,
    ip_address  VARCHAR(45)  NOT NULL,
    location    VARCHAR(255) DEFAULT NULL,
    status      TINYINT(1)   NOT NULL DEFAULT 1,
    created     DATETIME     NOT NULL,
    modified    DATETIME     NOT NULL,
    CONSTRAINT fk_cameras_store FOREIGN KEY (store_id) REFERENCES stores (id) ON DELETE SET NULL
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
