# 📘 Plan de Desarrollo — Repositorio Digital ISTAE
## Instituto Superior Tecnológico Alberto Enríquez

---

## 1. Descripción General del Proyecto

### 1.1 Contexto

El **Instituto Superior Tecnológico Alberto Enríquez (ISTAE)**, ubicado en Ecuador, necesita un sistema de **repositorio digital institucional** que permita preservar, organizar y difundir la producción académica y científica generada por sus estudiantes, docentes e investigadores.

Este proyecto toma como referencia el **Repositorio Digital de la Universidad Técnica del Norte (UTN)** — [repositorio.utn.edu.ec](https://repositorio.utn.edu.ec/) — que utiliza DSpace 6.4, y adapta sus funcionalidades a una solución propia desarrollada en **PHP + MySQL**, desplegable en **cPanel**.

### 1.2 Objetivo General

Desarrollar una aplicación web de repositorio digital institucional para el ISTAE que permita subir, gestionar, buscar y visualizar documentos académicos (tesis, artículos científicos, proyectos de grado y monografías), accesible en internet a través de hosting cPanel con base de datos MySQL.

### 1.3 Objetivos Específicos

- Implementar un sistema de gestión de usuarios con roles diferenciados (Administrador, Bibliotecario, Docente, Estudiante, Visitante).
- Crear un módulo de carga de documentos con metadatos basados en el estándar **Dublin Core**.
- Desarrollar un motor de búsqueda avanzada con filtros por autor, título, fecha, carrera y tipo de documento.
- Implementar un flujo de revisión/aprobación de documentos antes de su publicación pública.
- Garantizar la compatibilidad y despliegue en entornos cPanel con soporte PHP 8.x y MySQL 8.x.
- Asegurar accesibilidad pública de los documentos aprobados con visor PDF integrado.

---

## 2. Análisis del Referente — DSpace

### 2.1 ¿Qué es DSpace?

DSpace es el software de repositorio institucional de código abierto más utilizado en universidades y centros de investigación del mundo. Fue desarrollado por el MIT (Massachusetts Institute of Technology) y HP Labs en 2002.

### 2.2 Arquitectura de DSpace

```
┌─────────────────────────────────────┐
│          CAPA DE APLICACIÓN         │
│  (Interfaz Web / Angular / REST API)│
└─────────────────────┬───────────────┘
                      │
┌─────────────────────▼───────────────┐
│        CAPA DE LÓGICA DE NEGOCIO    │
│  (Autenticación, Workflow, Búsqueda)│
│         Apache Solr (Indexación)    │
└─────────────────────┬───────────────┘
                      │
┌─────────────────────▼───────────────┐
│          CAPA DE ALMACENAMIENTO     │
│  PostgreSQL (Metadatos)             │
│  Sistema de Archivos (Bitstreams)   │
└─────────────────────────────────────┘
```

### 2.3 Jerarquía de Contenidos en DSpace

```
Repositorio
  └── Comunidades (Ej: Trabajos de Titulación)
        └── Colecciones (Ej: Carrera de Sistemas)
              └── Ítems (Ej: Tesis de Grado)
                    └── Bitstreams (Archivos PDF)
```

### 2.4 Funcionalidades Clave Observadas en UTN

Del análisis del repositorio UTN se identificaron:

| Funcionalidad | Descripción |
|---|---|
| **Comunidades** | Administrativo, Publicaciones UTN, Trabajos de Titulación (18,124 documentos) |
| **Navegación** | Por fecha, autor, título, materia, asesor |
| **Búsqueda** | Simple y avanzada con filtros facetados |
| **Envío de ítems** | Workflow de aprobación multi-paso |
| **Acceso abierto** | Descarga directa de PDF |
| **Metadatos Google Scholar** | citation_language, citation_dissertation_institution |
| **RSS/Atom Feeds** | Integración con agregadores |
| **Multi-idioma** | Español / English |

---

## 3. Arquitectura Propuesta para ISTAE

### 3.1 Stack Tecnológico

| Componente | Tecnología |
|---|---|
| **Frontend** | HTML5, CSS3 (Vanilla), JavaScript (ES6+) |
| **Backend** | PHP 8.2 |
| **Framework PHP** | Laravel 11 (MVC) |
| **Base de Datos** | MySQL 8.0 |
| **Servidor Web** | Apache (cPanel) |
| **Gestor de Paquetes** | Composer (PHP), NPM (Assets) |
| **Autenticación** | Laravel Sanctum / Auth |
| **Búsqueda** | MySQL Full-Text Search (MATCH AGAINST) |
| **Visor PDF** | PDF.js (Mozilla) |
| **Almacenamiento** | Sistema de archivos local (/uploads/) |
| **Estilos** | Bootstrap 5 + CSS personalizado |

### 3.2 Estructura Jerárquica ISTAE

```
Repositorio ISTAE
  ├── Trabajos de Titulación
  │     ├── Tecnología en Desarrollo de Software
  │     ├── Tecnología en Mecatrónica
  │     ├── Tecnología en Electrónica
  │     └── Tecnología en Administración
  ├── Artículos Científicos
  │     ├── Publicados por Docentes
  │     └── Publicados por Estudiantes
  ├── Proyectos de Investigación
  └── Documentos Institucionales
```

---

## 4. Módulos del Sistema

### 4.1 Módulo de Autenticación y Roles

- **ADMIN** — Control total del sistema
- **BIBLIOTECARIO** — Gestión y aprobación de documentos
- **DOCENTE** — Subir documentos, ver estadísticas
- **ESTUDIANTE** — Subir trabajos propios
- **VISITANTE** — Solo lectura pública

### 4.2 Módulo de Gestión de Documentos

- CRUD completo de documentos
- Subida de archivos: Solo PDF, validado en servidor (máx. 50 MB)
- Metadatos Dublin Core: Título, Autor, Fecha, Resumen, Palabras Clave, Carrera, Tipo, Director de Tesis
- Estados: borrador → en_revisión → aprobado → publicado

### 4.3 Módulo de Búsqueda

- Búsqueda simple (barra global)
- Búsqueda avanzada (combinación de campos)
- Filtros facetados (Tipo, Carrera, Año, Autor)
- Resultados paginados

### 4.4 Módulo de Flujo de Aprobación

1. Estudiante/Docente sube documento (estado: en_revisión)
2. Notificación al Bibliotecario
3. Bibliotecario revisa metadatos y archivo
4. Aprueba → estado pasa a publicado
5. Rechaza → Regresa al autor con observaciones

### 4.5 Módulo de Estadísticas

- Total de documentos por carrera
- Documentos por tipo
- Descargas/visitas por documento
- Gráficas de crecimiento del repositorio

---

## 5. Esquema de Base de Datos (MySQL)

```sql
-- Usuarios del sistema
users (id, nombre, email, password, rol, carrera_id, activo, created_at)

-- Comunidades (equivalente a Facultades/Áreas)
comunidades (id, nombre, descripcion, logo, slug, created_at)

-- Colecciones (equivalente a Carreras/Tipos de doc.)
colecciones (id, comunidad_id, nombre, descripcion, slug, created_at)

-- Documentos/Ítems
documentos (
  id, coleccion_id, user_id, titulo, resumen,
  palabras_clave, autor, director_tesis,
  fecha_publicacion, tipo_documento, carrera,
  archivo_url, estado, vistas, descargas, created_at
)

-- Metadatos adicionales (Dublin Core extendido)
metadatos (id, documento_id, campo, valor)

-- Historial de flujo de trabajo
workflow_historial (id, documento_id, user_id, estado_anterior, estado_nuevo, comentario, created_at)

-- Estadísticas de acceso
estadisticas (id, documento_id, accion, ip, user_agent, created_at)
```

---

## 6. Cronograma General del Proyecto

| Fase | Sprint | Duración | Período |
|---|---|---|---|
| **Fase 1:** Fundamentos | Sprint 1-2 | 4 semanas | Semana 1-4 |
| **Fase 2:** Gestión de Documentos | Sprint 3-4 | 4 semanas | Semana 5-8 |
| **Fase 3:** Búsqueda y Flujo | Sprint 5-6 | 4 semanas | Semana 9-12 |
| **Fase 4:** Panel Público | Sprint 7-8 | 4 semanas | Semana 13-16 |
| **Fase 5:** Despliegue y Calidad | Sprint 9-10 | 4 semanas | Semana 17-20 |

**Duración Total Estimada:** 5 meses (20 semanas)

---

## 7. Requisitos de Hosting cPanel

| Recurso | Mínimo Recomendado |
|---|---|
| PHP | 8.1 o superior |
| MySQL | 8.0 o superior |
| Espacio en disco | 10 GB |
| RAM | 512 MB (mínimo) |
| Apache mod_rewrite | Habilitado |
| SSL/HTTPS | Requerido (Let's Encrypt) |
| upload_max_filesize | 64M |

---

## 8. Criterios de Éxito

- [ ] Sistema accesible vía web en dominio del ISTAE
- [ ] Carga de documentos PDF funcionando correctamente
- [ ] Motor de búsqueda con resultados relevantes
- [ ] Panel administrativo para gestión de documentos
- [ ] Flujo de aprobación operativo
- [ ] Estadísticas básicas visibles para el admin
- [ ] Al menos 3 tipos de documentos soportados
- [ ] Tiempo de respuesta < 3 segundos en búsqueda
- [ ] Compatible con dispositivos móviles (responsive)
