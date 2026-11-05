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

CREATE TABLE IF NOT EXISTS resultados_quiz (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    perfil VARCHAR(30) NOT NULL,
    respuestas_json JSON NOT NULL,
    realizado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY resultados_quiz_usuario_fecha (usuario_id, realizado_en),
    CONSTRAINT resultados_quiz_usuario_fk
        FOREIGN KEY (usuario_id) REFERENCES usuarios_popstar (id)
        ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS catalogo_discos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(180) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    artista VARCHAR(200) NOT NULL,
    precio DECIMAL(10,2) UNSIGNED NOT NULL,
    imagen VARCHAR(1024) NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 5,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY catalogo_discos_codigo_unico (codigo),
    KEY catalogo_discos_titulo_artista (titulo, artista)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ordenes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NULL,
    subtotal DECIMAL(10,2) UNSIGNED NOT NULL,
    descuento DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT 0,
    envio DECIMAL(10,2) UNSIGNED NOT NULL,
    total DECIMAL(10,2) UNSIGNED NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'confirmado_demo',
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY ordenes_usuario_fecha (usuario_id, creado_en),
    CONSTRAINT ordenes_usuario_fk
        FOREIGN KEY (usuario_id) REFERENCES usuarios_popstar (id)
        ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ordenes_discos (
    orden_id BIGINT UNSIGNED NOT NULL,
    disco_id INT UNSIGNED NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    artista VARCHAR(200) NOT NULL,
    precio_unitario DECIMAL(10,2) UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    PRIMARY KEY (orden_id, disco_id),
    CONSTRAINT ordenes_discos_orden_fk
        FOREIGN KEY (orden_id) REFERENCES ordenes (id)
        ON DELETE CASCADE,
    CONSTRAINT ordenes_discos_disco_fk
        FOREIGN KEY (disco_id) REFERENCES catalogo_discos (id)
        ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
