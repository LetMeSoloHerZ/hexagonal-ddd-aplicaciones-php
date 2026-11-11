-- ============================================================
-- CRUD Usuarios / Aplicaciones - Esquema para la BASE EN LA NUBE (TiDB Cloud / MySQL)
-- Igual que database.sql pero SIN CREATE USER ni GRANT: en la nube el usuario
-- de conexion lo gestiona el proveedor, y las claves no deben ir en el repositorio.
-- Ejecutar con el usuario que entrega el proveedor y DESPUES ejecutar aplicaciones.sql.
-- Es re-ejecutable: no borra datos existentes.
-- ============================================================

CREATE DATABASE IF NOT EXISTS crud_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_usuarios;

-- Tabla de usuarios
--    * id: UUID v4 generado por la aplicacion (36 caracteres)
--    * role: ADMIN | MEMBER | REVIEWER      (UserRoleEnum)
--    * status: ACTIVE | INACTIVE | PENDING | BLOCKED (UserStatusEnum)
--    * password: hash bcrypt
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

-- Usuario administrador base de la nube
--    correo: admin@crud.com   (la clave NO es la de desarrollo local; ver el entregable)
INSERT INTO users (id, name, email, password, role, status)
VALUES (
    UUID(),
    'Administrador',
    'admin@crud.com',
    '$2y$10$4oi2Tlo17SNTCCLiCySR1etXblLUV.BrsG.CPcilFApyDu8Utbj8e',
    'ADMIN',
    'ACTIVE'
)
ON DUPLICATE KEY UPDATE email = email;

-- Verificacion
SELECT id, name, email, role, status, created_at FROM users;