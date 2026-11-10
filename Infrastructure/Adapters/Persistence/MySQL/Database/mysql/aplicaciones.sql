-- ============================================================
-- Ejercicio 21 - Entidad Aplicacion (MySQL 8)
-- Ejecutar DESPUES de database.sql, con un usuario administrador.
-- Es re-ejecutable: no borra datos existentes.
-- ============================================================

USE crud_usuarios;

-- Tabla de aplicaciones
--   * id: UUID v4 generado por la aplicacion (igual que en users)
--   * categoria:  EDUCACION | PRODUCTIVIDAD | JUEGOS | UTILIDADES | DESARROLLO | COMUNICACION | MULTIMEDIA | OTRA
--   * sistema_operativo: WINDOWS | LINUX | MACOS | ANDROID | IOS | MULTIPLATAFORMA
--   * licencia:   GRATUITA | OPEN_SOURCE | COMERCIAL | SHAREWARE | FREEMIUM
--   * num_bits:   32 | 64
--   * tamano_instalador_mb: tamano del instalador en megabytes
CREATE TABLE IF NOT EXISTS aplicaciones (
    id                    CHAR(36)      NOT NULL,
    nombre                VARCHAR(100)  NOT NULL,
    proveedor             VARCHAR(100)  NOT NULL,
    categoria             VARCHAR(30)   NOT NULL,
    lenguaje_principal    VARCHAR(50)   NOT NULL,
    lenguaje_secundario   VARCHAR(50)   NULL,
    usa_bd                TINYINT(1)    NOT NULL DEFAULT 0,
    requiere_conexion_red TINYINT(1)    NOT NULL DEFAULT 0,
    num_bits              SMALLINT      NOT NULL,
    sistema_operativo     VARCHAR(30)   NOT NULL,
    requisitos_hardware   VARCHAR(500)  NULL,
    licencia              VARCHAR(30)   NOT NULL,
    precio                DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    descripcion           VARCHAR(1000) NULL,
    web                   VARCHAR(255)  NULL,
    correo                VARCHAR(120)  NOT NULL,
    tamano_instalador_mb  DECIMAL(10,2) NOT NULL,
    created_at            DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at            DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_aplicaciones_nombre (nombre),
    CONSTRAINT chk_aplicaciones_num_bits CHECK (num_bits IN (32, 64)),
    CONSTRAINT chk_aplicaciones_precio   CHECK (precio >= 0),
    CONSTRAINT chk_aplicaciones_tamano   CHECK (tamano_instalador_mb > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo (solo se insertan si la tabla esta vacia)
INSERT INTO aplicaciones
    (id, nombre, proveedor, categoria, lenguaje_principal, lenguaje_secundario,
     usa_bd, requiere_conexion_red, num_bits, sistema_operativo, requisitos_hardware,
     licencia, precio, descripcion, web, correo, tamano_instalador_mb)
SELECT * FROM (
    SELECT UUID() AS id, 'Visual Studio Code' AS nombre, 'Microsoft' AS proveedor,
           'DESARROLLO' AS categoria, 'TypeScript' AS lenguaje_principal, 'JavaScript' AS lenguaje_secundario,
           0 AS usa_bd, 0 AS requiere_conexion_red, 64 AS num_bits, 'MULTIPLATAFORMA' AS sistema_operativo,
           '4 GB de RAM y 1 GB de disco' AS requisitos_hardware, 'OPEN_SOURCE' AS licencia, 0.00 AS precio,
           'Editor de codigo fuente ligero y extensible.' AS descripcion,
           'https://code.visualstudio.com' AS web, 'soporte@ejemplo.com' AS correo, 95.50 AS tamano_instalador_mb
    UNION ALL
    SELECT UUID(), 'Moodle Mobile', 'Moodle Pty Ltd', 'EDUCACION', 'Java', 'Kotlin',
           1, 1, 64, 'ANDROID', '2 GB de RAM', 'GRATUITA', 0.00,
           'Cliente movil para plataformas de aprendizaje virtual.',
           'https://moodle.org', 'contacto@ejemplo.com', 42.00
    UNION ALL
    SELECT UUID(), 'Adobe Photoshop', 'Adobe', 'MULTIMEDIA', 'C++', NULL,
           0, 1, 64, 'WINDOWS', '16 GB de RAM y GPU dedicada', 'COMERCIAL', 22.99,
           'Edicion profesional de imagenes por suscripcion mensual.',
           'https://www.adobe.com', 'ventas@ejemplo.com', 1800.00
) AS ejemplos
WHERE NOT EXISTS (SELECT 1 FROM aplicaciones);

-- Verificacion
SELECT id, nombre, proveedor, categoria, sistema_operativo, licencia, precio FROM aplicaciones;
