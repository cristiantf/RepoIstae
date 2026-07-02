# Documentacion Tecnica — Repositorio Digital ISTAE
## Instituto Superior Tecnologico Alberto Enriquez

---

## 1. RESUMEN EJECUTIVO TECNICO

Este documento describe la arquitectura tecnica, la base de datos, los endpoints de la aplicacion, la estructura de archivos y los procedimientos de despliegue para el **Repositorio Digital Institucional del ISTAE**.

El sistema es una aplicacion web full-stack desarrollada con **PHP 8.2 + Laravel 11** en el backend, **MySQL 8.0** como motor de base de datos, y **HTML5/CSS3/JavaScript** vanilla en el frontend, con Bootstrap 5 para el diseno responsivo. Disenada especificamente para ser desplegada en entornos **cPanel** de hosting compartido o VPS.

---

## 2. STACK TECNOLOGICO DETALLADO

### 2.1 Backend

| Tecnologia | Version | Uso |
|---|---|---|
| PHP | 8.2+ | Lenguaje principal del servidor |
| Laravel | 11.x | Framework MVC backend |
| Composer | 2.x | Gestor de dependencias PHP |
| Laravel Sanctum | 4.x | Autenticacion de sesiones y tokens |
| Laravel Mail | Nativo | Envio de correos electronicos |
| Intervention Image | 3.x | Procesamiento de imagenes (logos) |
| Laravel Pagination | Nativo | Paginacion de resultados |

### 2.2 Base de Datos

| Tecnologia | Version | Uso |
|---|---|---|
| MySQL | 8.0+ | Motor de base de datos principal |
| phpMyAdmin | Cualquiera | Administracion visual de BD en cPanel |
| Laravel Migrations | Nativo | Control de versiones del schema |
| Laravel Seeders | Nativo | Datos iniciales y datos de prueba |

### 2.3 Frontend

| Tecnologia | Version | Uso |
|---|---|---|
| HTML5 | - | Estructura de paginas |
| CSS3 | - | Estilos personalizados |
| JavaScript | ES6+ | Logica del cliente |
| Bootstrap | 5.3 | Framework CSS responsivo |
| PDF.js | 4.x | Visor de PDF en el navegador |
| Chart.js | 4.x | Graficos de estadisticas |
| Alpine.js | 3.x | Reactividad ligera para UI |

### 2.4 Infraestructura y Despliegue

| Componente | Tecnologia |
|---|---|
| Servidor Web | Apache 2.4 (cPanel) |
| Sistema Operativo | Linux (CentOS/Ubuntu en hosting) |
| Panel de Control | cPanel con WHM |
| SSL/HTTPS | Let's Encrypt (Certbot) |
| Correo | SMTP configurado en cPanel (o SendGrid) |
| Almacenamiento | Sistema de archivos local del servidor |
| Backup | Cron Job automatico via cPanel |

---

## 3. DISENO DE BASE DE DATOS MYSQL

### 3.1 Diagrama Entidad-Relacion (Descripcion)

```
users (1) ----< documentos (N)
comunidades (1) ----< colecciones (N)
colecciones (1) ----< documentos (N)
documentos (1) ----< metadatos (N)
documentos (1) ----< workflow_historial (N)
documentos (1) ----< estadisticas (N)
```

### 3.2 Schema Completo de Tablas

#### Tabla: users

```sql
CREATE TABLE users (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(150) NOT NULL,
    email           VARCHAR(255) UNIQUE NOT NULL,
    password        VARCHAR(255) NOT NULL,
    rol             ENUM('admin','bibliotecario','docente','estudiante') DEFAULT 'estudiante',
    carrera         VARCHAR(150) NULL,
    cedula          VARCHAR(20) NULL,
    telefono        VARCHAR(20) NULL,
    activo          TINYINT(1) DEFAULT 1,
    email_verified_at TIMESTAMP NULL,
    remember_token  VARCHAR(100) NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### Tabla: comunidades

```sql
CREATE TABLE comunidades (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(200) NOT NULL,
    descripcion TEXT NULL,
    logo_path   VARCHAR(500) NULL,
    slug        VARCHAR(200) UNIQUE NOT NULL,
    activo      TINYINT(1) DEFAULT 1,
    orden       INT DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### Tabla: colecciones

```sql
CREATE TABLE colecciones (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comunidad_id    BIGINT UNSIGNED NOT NULL,
    nombre          VARCHAR(200) NOT NULL,
    descripcion     TEXT NULL,
    slug            VARCHAR(200) UNIQUE NOT NULL,
    activo          TINYINT(1) DEFAULT 1,
    orden           INT DEFAULT 0,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (comunidad_id) REFERENCES comunidades(id) ON DELETE CASCADE
);
```

#### Tabla: documentos

```sql
CREATE TABLE documentos (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    coleccion_id        BIGINT UNSIGNED NOT NULL,
    user_id             BIGINT UNSIGNED NOT NULL,
    titulo              VARCHAR(500) NOT NULL,
    resumen             TEXT NULL,
    palabras_clave      TEXT NULL,
    autor               VARCHAR(300) NOT NULL,
    coautores           VARCHAR(500) NULL,
    director_tesis      VARCHAR(200) NULL,
    institucion         VARCHAR(300) DEFAULT 'Instituto Superior Tecnologico Alberto Enriquez',
    carrera             VARCHAR(200) NULL,
    tipo_documento      ENUM('tesis','articulo','proyecto','monografia','informe','otro') NOT NULL,
    fecha_publicacion   DATE NULL,
    anno                YEAR NULL,
    idioma              VARCHAR(10) DEFAULT 'es',
    derechos            VARCHAR(500) DEFAULT 'Todos los derechos reservados - ISTAE',
    archivo_url         VARCHAR(500) NOT NULL,
    archivo_nombre      VARCHAR(255) NULL,
    archivo_tamano      BIGINT NULL,
    estado              ENUM('borrador','en_revision','aprobado','publicado','rechazado') DEFAULT 'en_revision',
    vistas              INT UNSIGNED DEFAULT 0,
    descargas           INT UNSIGNED DEFAULT 0,
    isbn_issn           VARCHAR(50) NULL,
    doi                 VARCHAR(200) NULL,
    url_externa         VARCHAR(500) NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (coleccion_id) REFERENCES colecciones(id) ON DELETE RESTRICT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    FULLTEXT INDEX ft_busqueda (titulo, resumen, autor, palabras_clave)
);
```

#### Tabla: metadatos

```sql
CREATE TABLE metadatos (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id    BIGINT UNSIGNED NOT NULL,
    campo           VARCHAR(100) NOT NULL,
    valor           TEXT NOT NULL,
    calificador     VARCHAR(100) NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    INDEX idx_documento_campo (documento_id, campo)
);
```

#### Tabla: workflow_historial

```sql
CREATE TABLE workflow_historial (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id        BIGINT UNSIGNED NOT NULL,
    user_id             BIGINT UNSIGNED NULL,
    estado_anterior     VARCHAR(50) NULL,
    estado_nuevo        VARCHAR(50) NOT NULL,
    comentario          TEXT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

#### Tabla: estadisticas

```sql
CREATE TABLE estadisticas (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    documento_id    BIGINT UNSIGNED NOT NULL,
    accion          ENUM('vista','descarga') NOT NULL,
    ip              VARCHAR(45) NULL,
    user_agent      VARCHAR(500) NULL,
    user_id         BIGINT UNSIGNED NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (documento_id) REFERENCES documentos(id) ON DELETE CASCADE,
    INDEX idx_doc_accion (documento_id, accion),
    INDEX idx_fecha (created_at)
);
```

#### Tabla: configuraciones

```sql
CREATE TABLE configuraciones (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    clave       VARCHAR(100) UNIQUE NOT NULL,
    valor       TEXT NULL,
    descripcion VARCHAR(300) NULL,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 3.3 Indices Recomendados

```sql
-- Indice para busqueda por estado de documento
ALTER TABLE documentos ADD INDEX idx_estado (estado);
ALTER TABLE documentos ADD INDEX idx_anno (anno);
ALTER TABLE documentos ADD INDEX idx_tipo (tipo_documento);
ALTER TABLE documentos ADD INDEX idx_coleccion_estado (coleccion_id, estado);
ALTER TABLE documentos ADD INDEX idx_user_estado (user_id, estado);

-- Indice para estadisticas
ALTER TABLE estadisticas ADD INDEX idx_created (created_at);
```

---

## 4. ESTRUCTURA DE ARCHIVOS DEL PROYECTO LARAVEL

```
repositorio-istae/
|-- app/
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- Auth/
|   |   |   |   |-- LoginController.php
|   |   |   |   |-- RegisterController.php
|   |   |   |   |-- LogoutController.php
|   |   |   |-- DocumentoController.php     (CRUD documentos)
|   |   |   |-- BusquedaController.php      (Busqueda simple/avanzada)
|   |   |   |-- ComunidadController.php     (Gestion comunidades)
|   |   |   |-- ColeccionController.php     (Gestion colecciones)
|   |   |   |-- WorkflowController.php      (Aprobacion/rechazo)
|   |   |   |-- EstadisticaController.php   (Dashboard stats)
|   |   |   |-- AdminController.php         (Panel admin)
|   |   |   |-- PublicoController.php       (Paginas publicas)
|   |   |   |-- ConfiguracionController.php (Config del sistema)
|   |   |-- Middleware/
|   |   |   |-- RoleMiddleware.php          (Control acceso por rol)
|   |   |   |-- CheckDocumentOwner.php      (Solo el dueno edita)
|   |   |-- Requests/
|   |       |-- DocumentoRequest.php        (Validacion de formularios)
|   |       |-- UserRequest.php
|   |-- Models/
|   |   |-- User.php
|   |   |-- Documento.php
|   |   |-- Comunidad.php
|   |   |-- Coleccion.php
|   |   |-- Metadato.php
|   |   |-- WorkflowHistorial.php
|   |   |-- Estadistica.php
|   |   |-- Configuracion.php
|   |-- Mail/
|   |   |-- DocumentoEnviadoMail.php        (Notif al bibliotecario)
|   |   |-- DocumentoAprobadoMail.php       (Notif al autor)
|   |   |-- DocumentoRechazadoMail.php      (Notif con observaciones)
|   |-- Services/
|       |-- DocumentoService.php            (Logica de negocio)
|       |-- BusquedaService.php             (Logica de busqueda)
|       |-- EstadisticaService.php
|-- database/
|   |-- migrations/
|   |   |-- xxxx_create_users_table.php
|   |   |-- xxxx_create_comunidades_table.php
|   |   |-- xxxx_create_colecciones_table.php
|   |   |-- xxxx_create_documentos_table.php
|   |   |-- xxxx_create_metadatos_table.php
|   |   |-- xxxx_create_workflow_historial_table.php
|   |   |-- xxxx_create_estadisticas_table.php
|   |   |-- xxxx_create_configuraciones_table.php
|   |-- seeders/
|       |-- AdminSeeder.php                 (Usuario admin inicial)
|       |-- ComunidadSeeder.php             (Comunidades ISTAE)
|       |-- ColeccionSeeder.php             (Colecciones por carrera)
|       |-- ConfiguracionSeeder.php         (Config inicial)
|-- resources/
|   |-- views/
|   |   |-- layouts/
|   |   |   |-- app.blade.php              (Layout publico)
|   |   |   |-- admin.blade.php            (Layout admin)
|   |   |   |-- auth.blade.php             (Layout login/register)
|   |   |-- publico/
|   |   |   |-- home.blade.php             (Pagina inicio)
|   |   |   |-- busqueda.blade.php         (Resultados busqueda)
|   |   |   |-- busqueda-avanzada.blade.php
|   |   |   |-- comunidades.blade.php
|   |   |   |-- coleccion.blade.php
|   |   |   |-- documento.blade.php        (Ficha del documento)
|   |   |-- auth/
|   |   |   |-- login.blade.php
|   |   |   |-- register.blade.php
|   |   |-- usuario/
|   |   |   |-- mis-documentos.blade.php
|   |   |   |-- subir-documento.blade.php
|   |   |   |-- editar-documento.blade.php
|   |   |-- bibliotecario/
|   |   |   |-- revision.blade.php
|   |   |   |-- revisar-documento.blade.php
|   |   |-- admin/
|   |       |-- dashboard.blade.php
|   |       |-- usuarios.blade.php
|   |       |-- estadisticas.blade.php
|   |       |-- configuracion.blade.php
|   |-- emails/                             (Plantillas de email)
|-- routes/
|   |-- web.php                             (Rutas de la aplicacion)
|   |-- api.php                             (API REST opcional)
|-- public/
|   |-- css/
|   |   |-- app.css                         (Estilos principales)
|   |   |-- admin.css
|   |-- js/
|   |   |-- app.js
|   |   |-- pdf-viewer.js                   (PDF.js integration)
|   |-- images/
|   |   |-- logo-istae.png
|   |   |-- banner-repositorio.jpg
|   |-- .htaccess                           (Reescritura URLs Apache)
|-- storage/
|   |-- app/
|       |-- public/
|           |-- uploads/
|               |-- documentos/             (Archivos PDF subidos)
|               |-- logos/                  (Logos de comunidades)
|-- .env                                    (Variables de entorno)
|-- composer.json
|-- artisan
```

---

## 5. RUTAS PRINCIPALES (routes/web.php)

```php
// Rutas Publicas
Route::get('/', [PublicoController::class, 'home'])->name('home');
Route::get('/busqueda', [BusquedaController::class, 'simple'])->name('busqueda');
Route::get('/busqueda-avanzada', [BusquedaController::class, 'avanzada'])->name('busqueda.avanzada');
Route::get('/comunidades', [ComunidadController::class, 'index'])->name('comunidades');
Route::get('/comunidad/{slug}', [ComunidadController::class, 'show'])->name('comunidad.show');
Route::get('/coleccion/{slug}', [ColeccionController::class, 'show'])->name('coleccion.show');
Route::get('/documento/{id}', [DocumentoController::class, 'show'])->name('documento.show');
Route::get('/documento/{id}/descargar', [DocumentoController::class, 'descargar'])->name('documento.descargar');

// Rutas de Autenticacion
Route::get('/login', [LoginController::class, 'form'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'form'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Rutas Autenticadas (cualquier rol)
Route::middleware('auth')->group(function () {
    Route::get('/mis-documentos', [DocumentoController::class, 'miDocumentos'])->name('mis.documentos');
    Route::get('/subir-documento', [DocumentoController::class, 'create'])->name('documento.create');
    Route::post('/subir-documento', [DocumentoController::class, 'store'])->name('documento.store');
    Route::get('/documento/{id}/editar', [DocumentoController::class, 'edit'])->name('documento.edit');
    Route::put('/documento/{id}', [DocumentoController::class, 'update'])->name('documento.update');
});

// Rutas Bibliotecario
Route::middleware(['auth', 'role:bibliotecario,admin'])->prefix('revision')->group(function () {
    Route::get('/', [WorkflowController::class, 'index'])->name('revision.index');
    Route::get('/documento/{id}', [WorkflowController::class, 'show'])->name('revision.show');
    Route::post('/documento/{id}/aprobar', [WorkflowController::class, 'aprobar'])->name('revision.aprobar');
    Route::post('/documento/{id}/rechazar', [WorkflowController::class, 'rechazar'])->name('revision.rechazar');
});

// Rutas Administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/usuarios', AdminController::class);
    Route::resource('/comunidades', ComunidadController::class);
    Route::resource('/colecciones', ColeccionController::class);
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('admin.estadisticas');
    Route::get('/estadisticas/export-csv', [EstadisticaController::class, 'exportCsv']);
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('admin.configuracion');
    Route::put('/configuracion', [ConfiguracionController::class, 'update'])->name('admin.configuracion.update');
});
```

---

## 6. BUSQUEDA FULL-TEXT EN MYSQL

### 6.1 Consulta de Busqueda Simple

```sql
SELECT d.*, c.nombre as coleccion_nombre, co.nombre as comunidad_nombre
FROM documentos d
JOIN colecciones c ON d.coleccion_id = c.id
JOIN comunidades co ON c.comunidad_id = co.id
WHERE d.estado = 'publicado'
AND MATCH(d.titulo, d.resumen, d.autor, d.palabras_clave)
    AGAINST (:termino IN BOOLEAN MODE)
ORDER BY MATCH(d.titulo, d.resumen, d.autor, d.palabras_clave)
         AGAINST (:termino IN BOOLEAN MODE) DESC
LIMIT 15 OFFSET :offset;
```

### 6.2 Consulta de Busqueda Avanzada

```sql
SELECT d.*, c.nombre as coleccion_nombre
FROM documentos d
JOIN colecciones c ON d.coleccion_id = c.id
WHERE d.estado = 'publicado'
  AND (:titulo IS NULL OR d.titulo LIKE CONCAT('%', :titulo, '%'))
  AND (:autor IS NULL OR d.autor LIKE CONCAT('%', :autor, '%'))
  AND (:tipo IS NULL OR d.tipo_documento = :tipo)
  AND (:carrera IS NULL OR d.carrera = :carrera)
  AND (:anno_desde IS NULL OR d.anno >= :anno_desde)
  AND (:anno_hasta IS NULL OR d.anno <= :anno_hasta)
ORDER BY d.fecha_publicacion DESC
LIMIT 15 OFFSET :offset;
```

---

## 7. MANEJO DE ARCHIVOS PDF

### 7.1 Validacion en el Servidor (PHP)

```php
// En DocumentoRequest.php
public function rules(): array
{
    return [
        'titulo'            => 'required|string|max:500',
        'resumen'           => 'required|string|max:3000',
        'autor'             => 'required|string|max:300',
        'tipo_documento'    => 'required|in:tesis,articulo,proyecto,monografia,informe,otro',
        'coleccion_id'      => 'required|exists:colecciones,id',
        'fecha_publicacion' => 'nullable|date',
        'archivo'           => 'required|file|mimes:pdf|max:51200', // 50MB max
    ];
}
```

### 7.2 Almacenamiento del Archivo

```php
// En DocumentoController.php - metodo store()
$archivo = $request->file('archivo');
$nombreArchivo = time() . '_' . Str::slug($request->titulo) . '.pdf';
$rutaArchivo = $archivo->storeAs(
    'uploads/documentos/' . date('Y/m'),
    $nombreArchivo,
    'public'
);
```

### 7.3 Ruta del Archivo en el Servidor

```
/public_html/storage/app/public/uploads/documentos/2026/07/timestamp_titulo.pdf
```

---

## 8. INTEGRACION PDF.JS

```javascript
// En pdf-viewer.js
const url = '/documento/' + documentoId + '/stream';
const pdfjsLib = window['pdfjs-dist/build/pdf'];
pdfjsLib.GlobalWorkerOptions.workerSrc = '/js/pdf.worker.min.js';

const loadingTask = pdfjsLib.getDocument(url);
loadingTask.promise.then(function(pdf) {
    pdf.getPage(1).then(function(page) {
        const canvas = document.getElementById('pdf-canvas');
        const context = canvas.getContext('2d');
        const viewport = page.getViewport({ scale: 1.5 });
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        page.render({ canvasContext: context, viewport: viewport });
    });
});
```

---

## 9. METADATOS DUBLIN CORE (Para SEO/Google Scholar)

En la vista del documento se incluyen los siguientes metadatos:

```html
<!-- Dublin Core -->
<meta name="DC.title" content="Titulo del documento" />
<meta name="DC.creator" content="Apellido, Nombre" />
<meta name="DC.subject" content="Palabras clave" />
<meta name="DC.description" content="Resumen del documento" />
<meta name="DC.publisher" content="Instituto Superior Tecnologico Alberto Enriquez" />
<meta name="DC.date" content="2026-07-01" />
<meta name="DC.type" content="Text" />
<meta name="DC.format" content="application/pdf" />
<meta name="DC.language" content="es" />
<meta name="DC.rights" content="Todos los derechos reservados" />

<!-- Google Scholar -->
<meta name="citation_title" content="Titulo del documento" />
<meta name="citation_author" content="Apellido, Nombre" />
<meta name="citation_publication_date" content="2026/07/01" />
<meta name="citation_dissertation_institution" content="ISTAE" />
<meta name="citation_pdf_url" content="https://repositorio.istae.edu.ec/documento/1/pdf" />
<meta name="citation_language" content="es" />
```

---

## 10. CONFIGURACION PARA CPANEL

### 10.1 Archivo .htaccess (en /public_html/)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>

# Forzar HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Proteger directorio uploads
<FilesMatch "\.(php|php3|php4|php5|phtml)$">
    Deny from all
</FilesMatch>
```

### 10.2 Archivo .env de Produccion

```env
APP_NAME="Repositorio Digital ISTAE"
APP_ENV=production
APP_KEY=base64:generada_automaticamente
APP_DEBUG=false
APP_URL=https://repositorio.istae.edu.ec

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=istae_repositorio
DB_USERNAME=istae_repo_user
DB_PASSWORD=contrasena_segura

MAIL_MAILER=smtp
MAIL_HOST=mail.istae.edu.ec
MAIL_PORT=587
MAIL_USERNAME=repositorio@istae.edu.ec
MAIL_PASSWORD=contrasena_email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=repositorio@istae.edu.ec
MAIL_FROM_NAME="Repositorio Digital ISTAE"

FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 10.3 Pasos para Subir a cPanel

1. Comprimir el proyecto sin la carpeta node_modules y vendor
2. Subir el .zip via cPanel File Manager o FTP
3. Descomprimir en /home/usuario/repositorio_istae/
4. Ejecutar: composer install --no-dev --optimize-autoloader
5. Copiar la carpeta public/ al directorio web (public_html/)
6. Crear enlace simbolico: php artisan storage:link
7. Configurar el .env de produccion
8. Ejecutar: php artisan migrate --force
9. Ejecutar: php artisan db:seed --class=AdminSeeder
10. Ejecutar: php artisan config:cache && php artisan route:cache
11. Configurar permisos: chmod -R 755 storage bootstrap/cache
12. Configurar SSL en cPanel con Let's Encrypt

### 10.4 Cron Job para Backups (cPanel Cron Manager)

```bash
# Backup diario de la base de datos a las 2:00 AM
0 2 * * * cd /home/usuario/repositorio_istae && php artisan db:backup 2>&1

# Backup semanal de archivos los domingos a las 3:00 AM
0 3 * * 0 tar -czf /home/usuario/backups/uploads_$(date +%Y%m%d).tar.gz /home/usuario/repositorio_istae/storage/app/public/uploads/
```

---

## 11. SEGURIDAD

### 11.1 Protecciones Implementadas por Laravel

- **CSRF Token:** En todos los formularios POST, PUT, DELETE
- **SQL Injection:** Laravel Eloquent ORM previene inyeccion SQL
- **XSS:** Escape automatico en plantillas Blade con {{ }}
- **Rate Limiting:** Throttle en rutas de login (5 intentos / minuto)
- **Hashing:** Contrasenas hasheadas con bcrypt (factor 12)
- **Mass Assignment Protection:** Listas $fillable en cada modelo

### 11.2 Validaciones de Seguridad en Uploads

```php
// Validacion de MIME type real (no solo extension)
$archivo = $request->file('archivo');
$mimeType = $archivo->getMimeType();
if ($mimeType !== 'application/pdf') {
    return back()->withErrors(['archivo' => 'Solo se permiten archivos PDF']);
}

// Verificar que no sea ejecutable PHP disfrazado
$contenido = file_get_contents($archivo->path());
if (strpos($contenido, '<?php') !== false) {
    return back()->withErrors(['archivo' => 'Archivo no valido']);
}
```

### 11.3 Configuracion de Sesiones

```php
// config/session.php
'lifetime' => 120,  // 2 horas
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'lax',
```

---

## 12. PRUEBAS

### 12.1 Pruebas Unitarias (PHPUnit)

```bash
# Ejecutar todas las pruebas
php artisan test

# Con cobertura de codigo
php artisan test --coverage

# Solo pruebas especificas
php artisan test --filter DocumentoTest
```

### 12.2 Pruebas de Integracion Recomendadas

| Modulo | Prueba |
|---|---|
| Autenticacion | Login/Logout/Registro correcto e incorrecto |
| Subida de PDF | PDF valido, PDF invalido, archivo muy grande |
| Busqueda | Termino existente, termino inexistente, caracteres especiales |
| Workflow | Aprobar, rechazar, verificar cambio de estado |
| Seguridad | Acceso sin autenticar, acceso con rol incorrecto |
| Admin | CRUD de usuarios, comunidades, colecciones |

---

## 13. DEPENDENCIAS COMPOSER (composer.json)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "laravel/sanctum": "^4.0",
        "intervention/image": "^3.0",
        "barryvdh/laravel-dompdf": "^2.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^11.0",
        "laravel/pint": "^1.0",
        "fakerphp/faker": "^1.23"
    }
}
```

---

## 14. GLOSARIO TECNICO

| Termino | Definicion |
|---|---|
| **MVC** | Model-View-Controller — patron de arquitectura de software |
| **ORM** | Object-Relational Mapping — mapeo de objetos a tablas de BD |
| **CSRF** | Cross-Site Request Forgery — ataque de falsificacion de peticion |
| **XSS** | Cross-Site Scripting — inyeccion de scripts maliciosos |
| **Full-Text Search** | Busqueda de texto completo en campos de texto de MySQL |
| **Workflow** | Flujo de trabajo automatizado (estados del documento) |
| **Bitstream** | Termino DSpace para el archivo fisico adjunto a un item |
| **Dublin Core** | Estandar de metadatos para descripcion de recursos digitales |
| **cPanel** | Panel de control de hosting web para gestion del servidor |
| **Slug** | Version de URL amigable de un texto (ej: "mi-tesis-2026") |
| **Middleware** | Capa intermedia que procesa peticiones HTTP antes del controlador |
| **Migration** | Script que define/modifica el schema de la base de datos |
| **Seeder** | Script para poblar la base de datos con datos iniciales |

---

*Documento Version 1.0 — Julio 2026*
*Repositorio Digital ISTAE — Instituto Superior Tecnologico Alberto Enriquez*

