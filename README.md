# Repositorio Digital ISTAE
## Instituto Superior Tecnológico Alberto Enríquez

Sistema de repositorio digital institucional inspirado en DSpace, desarrollado con PHP + MySQL para el ISTAE.

---

## Stack Tecnológico

- **Backend:** PHP 8.2 + Laravel 11
- **Base de Datos:** MySQL 8.0 / MariaDB 10.4
- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript ES6+
- **Visor PDF:** PDF.js
- **Servidor:** Apache (XAMPP local / cPanel producción)

## Estructura del Proyecto

```
RepoIstae/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Mail/
│   └── Services/
├── database/
│   ├── schema.sql          ← Schema completo de la BD
│   └── migrations/
├── public/
│   ├── css/
│   ├── js/
│   └── uploads/
├── resources/views/
├── routes/
├── .env.example
└── README.md
```

## Instalación Local (XAMPP)

### Requisitos
- XAMPP con PHP 8.1+ y MariaDB/MySQL
- Composer 2.x
- Git

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/RepoIstae.git
cd RepoIstae

# 2. Instalar dependencias PHP
composer install

# 3. Copiar configuración
cp .env.example .env

# 4. Crear la base de datos
mysql -u root < database/schema.sql

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Servidor de desarrollo
php artisan serve
```

### Base de Datos

```bash
# Crear la BD manualmente (si no usas el schema.sql completo)
mysql -u root -e "CREATE DATABASE repositorio_istae CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root repositorio_istae < database/schema.sql
```

## Credenciales por Defecto (Solo desarrollo)

| Campo | Valor |
|---|---|
| Email | admin@istae.edu.ec |
| Contraseña | Admin@ISTAE2026 |
| Rol | Administrador |

> ⚠️ **CAMBIAR LA CONTRASEÑA** antes de cualquier despliegue en producción.

## Documentación

Ver carpeta `/docs` o el directorio de documentación del proyecto:
- `plan_de_desarrollo.md`
- `casos_de_uso.md`
- `estado_del_proyecto_seguimiento.md`
- `documentacion_tecnica.md`

## Metodología

Proyecto desarrollado con **SCRUM** — 10 Sprints de 2 semanas (5 meses total).

## Licencia

Propiedad del Instituto Superior Tecnológico Alberto Enríquez — Todos los derechos reservados.
