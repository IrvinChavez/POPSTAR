CREATE DATABASE IF NOT EXISTS popstar
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE popstar;

CREATE TABLE IF NOT EXISTS usuarios_popstar (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(120) NOT NULL,
    correo VARCHAR(254) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    telefono VARCHAR(30) NULL,
    acepta_promociones TINYINT(1) NOT NULL DEFAULT 0,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY usuarios_popstar_correo_unico (correo)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
