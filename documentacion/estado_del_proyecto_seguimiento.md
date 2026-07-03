# Estado del Proyecto y Seguimiento — Repositorio Digital ISTAE
## Instituto Superior Tecnologico Alberto Enriquez
## Metodologia: SCRUM con Sprints de 2 semanas

---

## INFORMACION GENERAL DEL PROYECTO

| Campo | Valor |
|---|---|
| **Nombre del Proyecto** | Repositorio Digital ISTAE |
| **Institucion** | Instituto Superior Tecnologico Alberto Enriquez |
| **Fecha de Inicio** | Julio 2026 |
| **Fecha Estimada de Fin** | Noviembre 2026 |
| **Duracion Total** | 5 meses (10 Sprints x 2 semanas) |
| **Metodologia** | SCRUM |
| **Estado Actual** | Sprint 1 EN CURSO — Instalacion Laravel 11 |
| **Version Actual** | v0.2.0 - Base del sistema |
| **Repositorio GitHub** | https://github.com/cristiantf/RepoIstae |
| **Directorio Local** | C:\xampp\htdocs\RepoIstae |

---

## EQUIPO SCRUM

| Rol | Nombre | Responsabilidad |
|---|---|---|
| **Product Owner** | ISTAE (Institucion) | Define prioridades y objetivos de negocio |
| **Scrum Master** | Por definir | Facilita el proceso Scrum, elimina impedimentos |
| **Dev. Backend** | Por definir | PHP/Laravel, base de datos MySQL |
| **Dev. Frontend** | Por definir | HTML/CSS/JavaScript, diseño UI |
| **Tester/QA** | Por definir | Pruebas funcionales y de integracion |
| **Disenador** | Por definir | UI/UX, identidad visual |

---

## RESUMEN DE ESTADO POR FASE

| Fase | Descripcion | Sprints | Estado | Avance |
|---|---|---|---|---|
| **Fase 0** | Planificacion e Investigacion | Sprint 0 | COMPLETADO | 100% |
| **Fase 1** | Configuracion y Base del Sistema | Sprint 1-2 | COMPLETADO | 100% |
| **Fase 2** | Gestion de Documentos | Sprint 3-4 | COMPLETADO | 100% |
| **Fase 3** | Busqueda y Flujo de Aprobacion | Sprint 5-6 | COMPLETADO | 100% |
| **Fase 4** | Panel Publico y Estadisticas | Sprint 7-8 | COMPLETADO | 100% |
| **Fase 5** | Despliegue, Pruebas y Lanzamiento | Sprint 9-10 | PENDIENTE | 0% |

---

## SPRINT 0 — Planificacion e Investigacion
**Duracion:** Semana 1-2 (Julio 1-14, 2026)
**Estado:** COMPLETADO ✅

### Objetivos del Sprint 0
- [x] Investigar DSpace y repositorios de referencia (UTN)
- [x] Analizar sitio web ISTAE para entender contexto institucional
- [x] Definir arquitectura tecnologica (PHP + Laravel + MySQL + cPanel)
- [x] Crear documentacion inicial del proyecto (4 archivos .md)
- [x] Configurar repositorio de codigo GitHub (cristiantf/RepoIstae)
- [x] Preparar entorno de desarrollo local (XAMPP + MariaDB)
- [x] Crear base de datos repositorio_istae en MySQL local
- [x] Schema SQL completo con 8 tablas y datos semilla
- [ ] Reunion con stakeholders del ISTAE para validar requisitos
- [ ] Definir equipo de desarrollo

### Entregables Sprint 0 — TODOS COMPLETADOS
- [x] plan_de_desarrollo.md
- [x] casos_de_uso.md
- [x] estado_del_proyecto_seguimiento.md
- [x] documentacion_tecnica.md
- [x] Repositorio GitHub: https://github.com/cristiantf/RepoIstae
- [x] Base de datos MySQL local: repositorio_istae (8 tablas)
- [x] Schema SQL: database/schema.sql
- [x] Estructura de carpetas del proyecto

### Impedimentos Resueltos
- Base de datos creada localmente con XAMPP (MariaDB 10.4)
- GitHub configurado con usuario cristiantf
- PHP 8.2.12 disponible en XAMPP
- Composer 2.10.2 instalado en C:\xampp\php\

---

## SPRINT 1 — Configuracion del Entorno y Autenticacion
**Duracion:** Semana 3-4 (Julio 15-28, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 1
- [ ] Instalar Laravel 11 en entorno local
- [ ] Configurar conexion a MySQL
- [ ] Crear migraciones de base de datos (tablas principales)
- [ ] Implementar sistema de autenticacion (Login/Logout)
- [ ] Crear roles de usuario (Admin, Bibliotecario, Docente, Estudiante)
- [ ] Crear middleware de control de acceso por rol
- [ ] Diseno inicial del layout principal (header, footer, navbar)
- [ ] Configurar .htaccess para Apache/cPanel

### Historias de Usuario del Sprint 1
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-01 | Como visitante quiero registrarme con email y contrasena | 5 | Pendiente |
| HU-02 | Como usuario quiero iniciar sesion de forma segura | 3 | Pendiente |
| HU-03 | Como admin quiero gestionar roles de usuario | 8 | Pendiente |
| HU-04 | Como dev quiero tener la BD estructurada con todas las tablas | 13 | Pendiente |

### Definition of Done Sprint 1
- Codigo subido a repositorio Git con commits limpios
- Tests unitarios para autenticacion pasando
- Login/Logout funcional en entorno local
- Roles y permisos verificados

---

## SPRINT 2 — Estructura Base y Panel Administrativo
**Duracion:** Semana 5-6 (Julio 29 - Agosto 11, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 2
- [ ] Crear panel de administracion (dashboard)
- [ ] Modulo de gestion de Comunidades (CRUD)
- [ ] Modulo de gestion de Colecciones (CRUD)
- [ ] Interfaz de listado y gestion de usuarios
- [ ] Upload de logos para comunidades
- [ ] Navegacion publica: pagina de inicio con listado de comunidades
- [ ] Diseno responsivo (Bootstrap 5)

### Historias de Usuario del Sprint 2
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-05 | Como admin quiero crear comunidades con nombre, descripcion y logo | 8 | Pendiente |
| HU-06 | Como admin quiero crear colecciones dentro de comunidades | 5 | Pendiente |
| HU-07 | Como visitante quiero navegar por la lista de comunidades | 3 | Pendiente |
| HU-08 | Como admin quiero ver y gestionar usuarios registrados | 5 | Pendiente |

---

## SPRINT 3 — Subida de Documentos
**Duracion:** Semana 7-8 (Agosto 12-25, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 3
- [ ] Formulario de subida de documentos con metadatos Dublin Core
- [ ] Validacion de archivos PDF en el servidor (MIME type, tamano)
- [ ] Almacenamiento seguro de archivos en servidor
- [ ] Estado inicial del documento: en_revision
- [ ] Notificacion por email al Bibliotecario
- [ ] Vista "Mis Documentos" para autores

### Historias de Usuario del Sprint 3
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-09 | Como estudiante quiero subir mi tesis en PDF con metadatos | 13 | Pendiente |
| HU-10 | Como docente quiero subir articulos con metadatos completos | 8 | Pendiente |
| HU-11 | Como usuario quiero ver el estado de mis envios | 5 | Pendiente |
| HU-12 | Como bibliotecario quiero recibir notificacion cuando llega un documento | 3 | Pendiente |

---

## SPRINT 4 — Gestion de Documentos y CRUD Completo
**Duracion:** Semana 9-10 (Agosto 26 - Septiembre 8, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 4
- [ ] Edicion de metadatos de documentos
- [ ] Reemplazo de archivo PDF adjunto
- [ ] Eliminacion segura de documentos (BD + archivo fisico)
- [ ] Vista de detalle de documento (ficha completa)
- [ ] Visor PDF integrado con PDF.js
- [ ] Contador de vistas de documento

### Historias de Usuario del Sprint 4
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-13 | Como usuario quiero editar el titulo y metadatos de mis documentos | 5 | Pendiente |
| HU-14 | Como visitante quiero ver la ficha completa de un documento | 5 | Pendiente |
| HU-15 | Como visitante quiero visualizar el PDF en el navegador sin descargar | 8 | Pendiente |
| HU-16 | Como admin quiero eliminar documentos con confirmacion | 3 | Pendiente |

---

## SPRINT 5 — Motor de Busqueda
**Duracion:** Semana 11-12 (Septiembre 9-22, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 5
- [ ] Busqueda simple con Full-Text Search en MySQL
- [ ] Busqueda avanzada con multiples filtros combinados
- [ ] Filtros facetados por tipo, carrera, anno
- [ ] Resultados paginados y ordenables
- [ ] Highlighting de terminos encontrados en resultados

### Historias de Usuario del Sprint 5
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-17 | Como visitante quiero buscar documentos por palabras clave | 8 | Pendiente |
| HU-18 | Como visitante quiero busqueda avanzada por autor, carrera, anno | 13 | Pendiente |
| HU-19 | Como visitante quiero filtrar por tipo de documento | 5 | Pendiente |
| HU-20 | Como visitante quiero navegar los resultados de forma paginada | 3 | Pendiente |

---

## SPRINT 6 — Flujo de Aprobacion y Notificaciones
**Duracion:** Semana 13-14 (Septiembre 23 - Octubre 6, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 6
- [ ] Panel de revision para Bibliotecario
- [ ] Aprobar/Rechazar documentos con comentarios
- [ ] Historial de estados del documento
- [ ] Sistema de notificaciones por correo electronico
- [ ] Edicion de documentos rechazados y re-envio

### Historias de Usuario del Sprint 6
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-21 | Como bibliotecario quiero ver todos los documentos en revision | 5 | Pendiente |
| HU-22 | Como bibliotecario quiero aprobar documentos con un click | 5 | Pendiente |
| HU-23 | Como bibliotecario quiero rechazar con comentario de observacion | 8 | Pendiente |
| HU-24 | Como autor quiero recibir email con resultado de revision | 5 | Pendiente |
| HU-25 | Como autor quiero corregir y reenviar mi documento rechazado | 5 | Pendiente |

---

## SPRINT 7 — Panel Publico y Navegacion
**Duracion:** Semana 15-16 (Octubre 7-20, 2026)
**Estado:** COMPLETADO ✅

### Objetivos del Sprint 7
- [ ] Pagina de inicio publica con diseno institucional ISTAE
- [ ] Listado de ultimas publicaciones en el home
- [ ] Navegacion por Comunidades y Colecciones
- [ ] Pagina de coleccion con lista de documentos
- [ ] Metadatos SEO (Google Scholar, Open Graph)
- [ ] RSS Feed de ultimas publicaciones

### Historias de Usuario del Sprint 7
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-26 | Como visitante quiero ver las ultimas publicaciones en el inicio | 5 | Pendiente |
| HU-27 | Como visitante quiero navegar por carreras y ver sus documentos | 5 | Pendiente |
| HU-28 | Como motor de busqueda quiero indexar los documentos del repositorio | 8 | Pendiente |

---

## SPRINT 8 — Estadisticas y Dashboard
**Duracion:** Semana 17-18 (Octubre 21 - Noviembre 3, 2026)
**Estado:** COMPLETADO ✅

### Objetivos del Sprint 8
- [ ] Dashboard de estadisticas para Admin/Bibliotecario
- [ ] Graficos de documentos por carrera y tipo
- [ ] Top 10 documentos mas visitados
- [ ] Contador de descargas por documento
- [ ] Graficos de crecimiento mensual
- [ ] Exportar estadisticas a CSV

### Historias de Usuario del Sprint 8
| ID | Historia | Puntos | Estado |
|---|---|---|---|
| HU-29 | Como admin quiero ver cuantos documentos hay por carrera | 8 | Pendiente |
| HU-30 | Como admin quiero ver los documentos mas descargados | 5 | Pendiente |
| HU-31 | Como admin quiero exportar estadisticas | 5 | Pendiente |

---

## SPRINT 9 — Pruebas y Optimizacion
**Duracion:** Semana 19-20 (Noviembre 4-17, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 9
- [ ] Pruebas funcionales de todos los modulos
- [ ] Pruebas de seguridad (CSRF, SQL Injection, XSS)
- [ ] Pruebas de carga (rendimiento con multiples usuarios)
- [ ] Pruebas de compatibilidad movil (responsivo)
- [ ] Correccion de bugs criticos y medios
- [ ] Optimizacion de consultas MySQL lentas
- [ ] Documentacion de usuario final

---

## SPRINT 10 — Despliegue a Produccion
**Duracion:** Semana 21-22 (Noviembre 18 - Diciembre 1, 2026)
**Estado:** PENDIENTE

### Objetivos del Sprint 10
- [ ] Configurar servidor cPanel de produccion
- [ ] Crear base de datos MySQL en produccion
- [ ] Subir archivos del proyecto via FTP/cPanel File Manager
- [ ] Configurar variables de entorno (.env produccion)
- [ ] Ejecutar migraciones en produccion
- [ ] Configurar SSL/HTTPS con Let's Encrypt
- [ ] Configurar cron jobs para backups automaticos
- [ ] Capacitacion al personal del ISTAE
- [ ] Lanzamiento oficial del Repositorio Digital ISTAE

---

## REGISTRO DE CAMBIOS Y VERSIONES

| Version | Fecha | Descripcion | Responsable |
|---|---|---|---|
| v0.1.0 | 2026-07-02 | Documentacion inicial del proyecto | Equipo Dev |
| v0.2.0 | Por definir | Setup inicial Laravel y BD | Por definir |
| v1.0.0 | Nov 2026 | Lanzamiento oficial | Por definir |

---

## REGISTRO DE RIESGOS

| ID | Riesgo | Probabilidad | Impacto | Mitigacion |
|---|---|---|---|---|
| R01 | Hosting cPanel no compatible con Laravel | Media | Alto | Verificar version PHP antes de iniciar |
| R02 | Cambio de requisitos por parte del ISTAE | Alta | Medio | Revisiones frecuentes con stakeholders |
| R03 | Equipo de desarrollo incompleto | Media | Alto | Definir equipo en Sprint 0 |
| R04 | Falta de datos de prueba para testing | Baja | Bajo | Crear seeders con datos ficticios |
| R05 | Vulnerabilidades de seguridad en uploads | Media | Alto | Validacion estricta + escaneo de archivos |

---

## METRICAS DEL PROYECTO

| Metrica | Valor Actual | Meta |
|---|---|---|
| Sprints completados | 0 de 10 | 10 |
| Historias de usuario completadas | 0 de 31 | 31 |
| Cobertura de pruebas | 0% | 80% |
| Documentos cargados en el sistema | 0 | - |
| Usuarios registrados | 0 | - |
| Bugs criticos abiertos | 0 | 0 |

---

*Ultima actualizacion: 02 de Julio de 2026*
*Documento gestionado por: Equipo de Desarrollo ISTAE*

