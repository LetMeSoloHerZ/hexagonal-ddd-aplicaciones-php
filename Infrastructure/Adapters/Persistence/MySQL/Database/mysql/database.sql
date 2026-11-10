-- ============================================================
-- CRUD Usuarios / Aplicaciones - Esquema inicial (MySQL 8)
-- Ejecutar con un usuario administrador (root).
-- Es re-ejecutable: no borra datos existentes.
-- ============================================================

-- 1. Usuario de base de datos para la aplicacion
CREATE USER IF NOT EXISTS 'Estudiante'@'%' IDENTIFIED BY 'Developer';

-- 2. Base de datos
CREATE DATABASE IF NOT EXISTS crud_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- 3. Permisos
GRANT ALL PRIVILEGES ON crud_usuarios.* TO 'Estudiante'@'%';
FLUSH PRIVILEGES;

USE crud_usuarios;

-- 4. Tabla de usuarios
--    * id: UUID v4 generado por la aplicacion (36 caracteres)
--    * role: ADMIN | MEMBER | REVIEWER      (UserRoleEnum)
--    * status: ACTIVE | INACTIVE | PENDING | BLOCKED (UserStatusEnum)
--    * password: hash bcrypt (60 caracteres)
CREATE TABLE IF NOT EXISTS users (
    id         CHAR(36)     NOT NULL,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(120) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    role       VARCHAR(20)  NOT NULL DEFAULT 'MEMBER',
    status     VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Usuario administrador base
--    correo: admin@crud.com   clave: admin123   (hash bcrypt)
INSERT INTO users (id, name, email, password, role, status)
VALUES (
    UUID(),
    'Administrador',
    'admin@crud.com',
    '$2y$10$l2DPwTQpUOjFXq.APrtFBO26x2hZ0bt1NFJRrteg7ae/1pPSbCaji',
    'ADMIN',
    'ACTIVE'
)
ON DUPLICATE KEY UPDATE email = email;

-- 6. Verificacion
SELECT id, name, email, role, status, created_at FROM users;
