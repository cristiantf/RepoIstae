-- ============================================================
-- REPOSITORIO DIGITAL ISTAE
-- Instituto Superior Tecnológico Alberto Enríquez
-- Schema MySQL (MariaDB 10.4+)
-- Versión: 1.0.0 | Fecha: Julio 2026
-- ============================================================

USE repositorio_istae;

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO';

-- ============================================================
-- TABLA: users
-- Usuarios del sistema (Admin, Bibliotecario, Docente, Estudiante)
-- ============================================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre              VARCHAR(150) NOT NULL COMMENT 'Nombre completo del usuario',
    email               VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email institucional',
    password            VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt de la contraseña',
    rol                 ENUM('admin','bibliotecario','docente','estudiante') NOT NULL DEFAULT 'estudiante',
    carrera             VARCHAR(200) NULL COMMENT 'Carrera a la que pertenece',
    cedula              VARCHAR(20) NULL COMMENT 'Número de cédula ecuatoriana',
    telefono            VARCHAR(20) NULL,
    activo              TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=activo, 0=desactivado',
    email_verified_at   TIMESTAMP NULL DEFAULT NULL,
    remember_token      VARCHAR(100) NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_rol (rol),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Usuarios del sistema Repositorio ISTAE';

-- ============================================================
-- TABLA: comunidades
-- Agrupaciones de alto nivel (equivalente a Facultades/Áreas en DSpace)
-- ============================================================
DROP TABLE IF EXISTS comunidades;
CREATE TABLE comunidades (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(200) NOT NULL,
    descripcion TEXT NULL,
    logo_path   VARCHAR(500) NULL COMMENT 'Ruta relativa al logo en /uploads/logos/',
    slug        VARCHAR(200) NOT NULL UNIQUE COMMENT 'URL amigable (ej: trabajos-titulacion)',
    activo      TINYINT(1) NOT NULL DEFAULT 1,
    orden       INT NOT NULL DEFAULT 0 COMMENT 'Orden de aparición en la lista',
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_activo_orden (activo, orden)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Comunidades del repositorio (Facultades, Áreas temáticas)';

-- ============================================================
-- TABLA: colecciones
-- Sub-agrupaciones dentro de comunidades (Carreras, Tipos de documento)
-- ============================================================
DROP TABLE IF EXISTS colecciones;
CREATE TABLE colecciones (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comunidad_id    BIGINT UNSIGNED NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    descripcion     TEXT NULL,
    slug            VARCHAR(200) NOT NULL UNIQUE,
    activo          TINYINT(1) NOT NULL DEFAULT 1,
    orden           INT NOT NULL DEFAULT 0,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY fk_coleccion_comunidad (comunidad_id) REFERENCES comunidades(id) ON DELETE CASCADE,
    INDEX idx_comunidad (comunidad_id),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Colecciones dentro de cada comunidad (Carreras, especialidades)';

-- ============================================================
-- TABLA: documentos
-- Ítems del repositorio (tesis, artículos, proyectos, etc.)
-- ============================================================
DROP TABLE IF EXISTS documentos;
CREATE TABLE documentos (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    coleccion_id        BIGINT UNSIGNED NOT NULL,
    user_id             BIGINT UNSIGNED NOT NULL COMMENT 'Quien subió el documento',
    -- Metadatos Dublin Core principales
    titulo              VARCHAR(500) NOT NULL,
    resumen             TEXT NULL COMMENT 'Abstract/Resumen del trabajo',
    palabras_clave      TEXT NULL COMMENT 'Keywords separadas por coma',
    autor               VARCHAR(300) NOT NULL COMMENT 'Autor principal (Apellido, Nombre)',
    coautores           VARCHAR(500) NULL COMMENT 'Coautores separados por ;',
    director_tesis      VARCHAR(200) NULL COMMENT 'Director o Asesor de la tesis',
    institucion         VARCHAR(300) NOT NULL DEFAULT 'Instituto Superior Tecnológico Alberto Enríquez',
    carrera             VARCHAR(200) NULL,
    tipo_documento      ENUM('tesis','articulo','proyecto','monografia','informe','otro') NOT NULL,
    fecha_publicacion   DATE NULL,
    anno                YEAR NULL COMMENT 'Año de publicación (para filtros)',
    idioma              VARCHAR(10) NOT NULL DEFAULT 'es',
    derechos            VARCHAR(500) NOT NULL DEFAULT 'Todos los derechos reservados - ISTAE',
    -- Información del archivo
    archivo_nombre      VARCHAR(255) NULL COMMENT 'Nombre original del archivo PDF',
    archivo_url         VARCHAR(500) NOT NULL COMMENT 'Ruta relativa al PDF en el servidor',
    archivo_tamano      BIGINT UNSIGNED NULL COMMENT 'Tamaño del archivo en bytes',
    -- Estado del workflow
    estado              ENUM('borrador','en_revision','aprobado','publicado','rechazado') NOT NULL DEFAULT 'en_revision',
    -- Estadísticas
    vistas              INT UNSIGNED NOT NULL DEFAULT 0,
    descargas           INT UNSIGNED NOT NULL DEFAULT 0,
    -- Identificadores opcionales
    isbn_issn           VARCHAR(50) NULL,
    doi                 VARCHAR(200) NULL,
    url_externa         VARCHAR(500) NULL COMMENT 'URL original si viene de fuente externa',
    created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY fk_doc_coleccion (coleccion_id) REFERENCES colecciones(id) ON DELETE RESTRICT,
    FOREIGN KEY fk_doc_user (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_estado (estado),
    INDEX idx_anno (anno),
    INDEX idx_tipo (tipo_documento),
    INDEX idx_coleccion_estado (coleccion_id, estado),
    INDEX idx_user_estado (user_id, estado),
    FULLTEXT INDEX ft_busqueda (titulo, resumen, autor, palabras_clave)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Documentos del repositorio (tesis, artículos, proyectos)';

-- ============================================================
-- TABLA: metadatos
-- Metadatos adicionales Dublin Core extendidos
-- ============================================================
DROP TABLE IF EXISTS metadatos;
CREATE TABLE metadatos (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id    BIGINT UNSIGNED NOT NULL,
    campo           VARCHAR(100) NOT NULL COMMENT 'Nombre del campo Dublin Core (ej: dc.contributor.advisor)',
    valor           TEXT NOT NULL,
    calificador     VARCHAR(100) NULL COMMENT 'Calificador opcional del campo DC',
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_meta_doc (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    INDEX idx_doc_campo (documento_id, campo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Metadatos Dublin Core extendidos por documento';

-- ============================================================
-- TABLA: workflow_historial
-- Registro de todos los cambios de estado de un documento
-- ============================================================
DROP TABLE IF EXISTS workflow_historial;
CREATE TABLE workflow_historial (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id        BIGINT UNSIGNED NOT NULL,
    user_id             BIGINT UNSIGNED NULL COMMENT 'Quien realizó el cambio',
    estado_anterior     VARCHAR(50) NULL,
    estado_nuevo        VARCHAR(50) NOT NULL,
    comentario          TEXT NULL COMMENT 'Observaciones del revisor',
    created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_wf_doc (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    FOREIGN KEY fk_wf_user (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_documento (documento_id),
    INDEX idx_fecha (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Historial de cambios de estado del workflow de aprobación';

-- ============================================================
-- TABLA: estadisticas
-- Registro de vistas y descargas por documento
-- ============================================================
DROP TABLE IF EXISTS estadisticas;
CREATE TABLE estadisticas (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id    BIGINT UNSIGNED NOT NULL,
    accion          ENUM('vista','descarga') NOT NULL,
    ip              VARCHAR(45) NULL COMMENT 'IP del visitante (IPv4 o IPv6)',
    user_agent      VARCHAR(500) NULL,
    user_id         BIGINT UNSIGNED NULL COMMENT 'NULL si es visitante anónimo',
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_stats_doc (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    FOREIGN KEY fk_stats_user (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_doc_accion (documento_id, accion),
    INDEX idx_fecha (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Estadísticas de acceso (vistas y descargas) por documento';

-- ============================================================
-- TABLA: configuraciones
-- Parámetros de configuración del sistema
-- ============================================================
DROP TABLE IF EXISTS configuraciones;
CREATE TABLE configuraciones (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    clave       VARCHAR(100) NOT NULL UNIQUE COMMENT 'Clave única del parámetro',
    valor       TEXT NULL COMMENT 'Valor del parámetro',
    descripcion VARCHAR(300) NULL COMMENT 'Descripción del parámetro',
    updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Configuración general del sistema repositorio';

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- DATOS INICIALES (SEED)
-- ============================================================

-- Usuario Administrador por defecto
-- Contraseña: Admin@ISTAE2026 (se cambia al iniciar)
INSERT INTO users (nombre, email, password, rol, activo, email_verified_at) VALUES
('Administrador ISTAE', 'admin@istae.edu.ec', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NOW());

-- Comunidades del ISTAE
INSERT INTO comunidades (nombre, descripcion, slug, orden) VALUES
('Trabajos de Titulación', 'Tesis y proyectos de grado de los estudiantes del ISTAE', 'trabajos-de-titulacion', 1),
('Artículos Científicos', 'Publicaciones científicas y académicas de docentes e investigadores', 'articulos-cientificos', 2),
('Proyectos de Investigación', 'Proyectos de investigación institucional del ISTAE', 'proyectos-investigacion', 3),
('Documentos Institucionales', 'Documentos administrativos y normativos del instituto', 'documentos-institucionales', 4);

-- Colecciones de Trabajos de Titulación
INSERT INTO colecciones (comunidad_id, nombre, descripcion, slug, orden) VALUES
(1, 'Tecnología en Desarrollo de Software', 'Proyectos integradores y tesis de la carrera de Sistemas', 'tec-desarrollo-software', 1),
(1, 'Tecnología en Mecatrónica', 'Trabajos de titulación de Mecatrónica', 'tec-mecatronica', 2),
(1, 'Tecnología en Electrónica', 'Trabajos de titulación de Electrónica', 'tec-electronica', 3),
(1, 'Tecnología en Administración', 'Trabajos de titulación de Administración de Empresas', 'tec-administracion', 4),
(1, 'Tecnología en Contabilidad', 'Trabajos de titulación de Contabilidad y Auditoría', 'tec-contabilidad', 5);

-- Colecciones de Artículos Científicos
INSERT INTO colecciones (comunidad_id, nombre, descripcion, slug, orden) VALUES
(2, 'Artículos de Docentes', 'Publicaciones académicas del cuerpo docente', 'articulos-docentes', 1),
(2, 'Artículos de Estudiantes', 'Artículos científicos co-publicados por estudiantes', 'articulos-estudiantes', 2);

-- Colecciones de Proyectos de Investigación
INSERT INTO colecciones (comunidad_id, nombre, descripcion, slug, orden) VALUES
(3, 'Proyectos Institucionales', 'Investigaciones financiadas por el ISTAE', 'proyectos-institucionales', 1),
(3, 'Vinculación con la Comunidad', 'Proyectos de vinculación y responsabilidad social', 'vinculacion-comunidad', 2);

-- Configuración inicial del sistema
INSERT INTO configuraciones (clave, valor, descripcion) VALUES
('app_nombre', 'Repositorio Digital ISTAE', 'Nombre del repositorio'),
('app_descripcion', 'Repositorio Institucional del Instituto Superior Tecnológico Alberto Enríquez', 'Descripción del repositorio'),
('institucion_nombre', 'Instituto Superior Tecnológico Alberto Enríquez', 'Nombre completo de la institución'),
('email_contacto', 'repositorio@istae.edu.ec', 'Email de contacto del repositorio'),
('max_tamano_archivo_mb', '50', 'Tamaño máximo de archivo en MB'),
('descargas_publicas', '1', '1=descarga libre, 0=solo visualización'),
('registro_abierto', '1', '1=cualquiera puede registrarse, 0=solo por invitación'),
('color_primario', '#1a3c6e', 'Color primario del tema (azul ISTAE)'),
('color_secundario', '#c8102e', 'Color secundario del tema');

-- ============================================================
-- FIN DEL SCHEMA
-- ============================================================
-- Verificación final
SELECT 'Schema creado exitosamente' AS resultado;
SHOW TABLES;
