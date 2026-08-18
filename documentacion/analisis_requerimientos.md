# Análisis de Requerimientos — Repositorio Digital ISTAE
## Instituto Superior Tecnológico Alberto Enríquez
### Documento de Resultados — Sprint 0

---

## 1. METODOLOGÍA DE ANÁLISIS

Se realizaron **6 entrevistas semiestructuradas** con representantes de las principales dependencias institucionales del ISTAE. Los datos recopilados fueron clasificados, priorizados usando la escala **MoSCoW** (Must/Should/Could/Won't), y correlacionados con las funcionalidades implementadas en el sistema.

| Prioridad | Significado |
|---|---|
| **M** – Must Have | Indispensable para el lanzamiento |
| **S** – Should Have | Importante, segunda prioridad |
| **C** – Could Have | Deseable si hay tiempo/recursos |
| **W** – Won't Have | Fuera del alcance inicial |

---

## 2. REQUERIMIENTOS FUNCIONALES

### RF-01 — Gestión de Usuarios y Roles
**Fuente:** Rectorado, Coordinación Académica  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

El sistema debe gestionar cinco roles diferenciados con permisos específicos:

| Rol | Permisos |
|---|---|
| **Administrador** | Control total del sistema, gestión de usuarios, configuración |
| **Bibliotecario** | Revisión y aprobación/rechazo de documentos |
| **Docente** | Subir y editar sus propios documentos |
| **Estudiante** | Subir trabajos de titulación propios |
| **Visitante** | Solo consulta y descarga pública |

**Hallazgos de entrevistas:**
- La Rectora y la Coordinadora Académica enfatizan que el control de acceso es crítico.
- El Ing. Salazar (Investigación) requiere que documentos confidenciales puedan restringirse.
- Los coordinadores de carrera piden que el registro sea simple para los estudiantes.

---

### RF-02 — Registro y Autenticación
**Fuente:** Todas las dependencias  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

- Registro con email institucional, nombre, carrera y contraseña.
- Inicio de sesión con validación de credenciales y sesión por rol.
- Rate limiting: máximo 5 intentos por minuto (seguridad).
- Cierre de sesión seguro.

---

### RF-03 — Subida y Gestión de Documentos
**Fuente:** Coordinación Académica, Coordinadores de Carrera  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

**Metadatos requeridos (Dublin Core):**

| Campo | Obligatorio | Fuente del Requerimiento |
|---|---|---|
| Título | Sí | Todas las dependencias |
| Autor(es) | Sí | Todas las dependencias |
| Director/Asesor | No | Coord. Académica |
| Resumen | Sí | Dpto. Investigación |
| Palabras clave | Sí | Dpto. Investigación |
| Tipo de documento | Sí | Coord. Académica |
| Carrera | Sí | Coordinadores de Carrera |
| Año de publicación | Sí | Todas las dependencias |
| ISBN/ISSN/DOI | No | Dpto. Investigación |
| Institución | Sí (por defecto) | Rectorado |

**Tipos de documento soportados:** tesis, artículo, proyecto, monografía, informe, otro.  
**Formato:** Solo PDF, validado por MIME type en servidor.  
**Tamaño máximo:** 50 MB.

---

### RF-04 — Flujo de Aprobación (Workflow)
**Fuente:** Coordinación Académica, Rectorado  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

```
Estudiante/Docente sube → [en_revisión] → Bibliotecario revisa
    ├── Aprueba → [publicado] → visible públicamente
    └── Rechaza + comentario → [rechazado] → autor puede corregir y reenviar
```

**Notificaciones por correo electrónico** en cada cambio de estado.  
**Historial de workflow** guardado por documento.

---

### RF-05 — Motor de Búsqueda
**Fuente:** Coordinadores de carrera, Rectorado, Dpto. Investigación  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

**Búsqueda simple:** Full-Text Search en título, resumen, autor y palabras clave (MySQL MATCH AGAINST).

**Búsqueda avanzada con filtros:**

| Filtro | Solicitado por |
|---|---|
| Título | Coord. Académica |
| Autor | Todas |
| Director de tesis | Coord. Académica |
| Tipo de documento | Coord. Académica |
| Carrera | Coordinadores de Carrera |
| Año (desde/hasta) | Todas |
| Palabras clave | Dpto. Investigación |

**Resultados:** Paginados, ordenados por relevancia.

---

### RF-06 — Organización Jerárquica (Comunidades y Colecciones)
**Fuente:** Coordinación Académica, Coordinadores de Carrera  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado

```
Repositorio ISTAE
  ├── Trabajos de Titulación
  │     ├── Desarrollo de Software
  │     ├── Mecánica Automotriz
  │     └── Mecanización Agrícola
  ├── Artículos Científicos
  ├── Proyectos de Investigación
  └── Documentos Institucionales
```

Los coordinadores de Mecánica Automotriz y Mecanización Agrícola enfatizaron la necesidad de separación clara por carrera.

---

### RF-07 — Visor de PDF en Línea
**Fuente:** Coord. Desarrollo de Software, Rectorado  
**Prioridad:** M — Must Have  
**Estado en el sistema:** ✅ Implementado (PDF.js)

- Visualización en el navegador sin necesidad de descargar.
- Compatible con documentos que contienen imágenes, diagramas y planos (relevante para Mecánica y Mecanización).

---

### RF-08 — Panel de Estadísticas
**Fuente:** Rectorado, Dpto. Investigación  
**Prioridad:** S — Should Have  
**Estado en el sistema:** ✅ Implementado (Chart.js)

| Estadística | Rol que la requiere |
|---|---|
| Total documentos por carrera | Rectorado, Coord. Académica |
| Documentos por tipo | Coord. Académica |
| Top 10 más visitados | Dpto. Investigación |
| Top 5 autores destacados | Dpto. Investigación |
| Crecimiento mensual | Dpto. Investigación |
| Exportar CSV | Dpto. Investigación |

---

### RF-09 — Panel de Configuración del Sistema
**Fuente:** Rectorado  
**Prioridad:** S — Should Have  
**Estado en el sistema:** ✅ Implementado

- Nombre e imagen institucional del repositorio.
- Correo de notificaciones.
- Tamaño máximo de archivos.
- Gestión de carreras disponibles.

---

### RF-10 — Metadatos SEO y Google Scholar
**Fuente:** Dpto. Investigación  
**Prioridad:** S — Should Have  
**Estado en el sistema:** ✅ Implementado

- Dublin Core en `<meta>` tags.
- Metadatos `citation_*` para Google Scholar.
- Contador de vistas por documento.

---

### RF-11 — Generación Automática de Cita Bibliográfica
**Fuente:** Ing. Ortega (Mecanización Agrícola)  
**Prioridad:** C — Could Have  
**Estado en el sistema:** ❌ No implementado (pendiente)

Generar cita en formato APA automáticamente desde los metadatos del documento.

---

### RF-12 — Restricción de Acceso por Documento
**Fuente:** Ing. Espinoza (Mecánica Automotriz), Dpto. Investigación  
**Prioridad:** C — Could Have  
**Estado en el sistema:** ❌ No implementado (pendiente)

Permitir que documentos con información confidencial o en proceso de patente tengan acceso restringido (solo institución o solo administradores).

---

### RF-13 — Protocolo OAI-PMH
**Fuente:** Dpto. Investigación  
**Prioridad:** W — Won't Have (v1.0)  
**Estado en el sistema:** ❌ Fuera del alcance inicial

Protocolo de interoperabilidad entre repositorios institucionales. Se planifica para una versión futura.

---

## 3. REQUERIMIENTOS NO FUNCIONALES

### RNF-01 — Rendimiento
**Fuente:** Rectorado, Coord. Desarrollo de Software  
**Prioridad:** M — Must Have

| Parámetro | Valor requerido | Estado |
|---|---|---|
| Tiempo de respuesta en búsqueda | < 3 segundos | ✅ Full-Text Index implementado |
| Carga de página principal | < 2 segundos | ✅ Optimizado con Bootstrap CDN |
| Soporte de usuarios concurrentes | Al menos 50 | ⚠️ Pendiente pruebas de carga |

---

### RNF-02 — Usabilidad
**Fuente:** Coordinadores de Carrera (Mecánica Automotriz, Mecanización Agrícola)  
**Prioridad:** M — Must Have

- Interfaz intuitiva sin tecnicismos (requerido por carreras no tecnológicas).
- Proceso de subida de documentos en pasos claros.
- Mensajes de error comprensibles.
- Manual de usuario disponible.
- **Estado:** ✅ UI premium implementada con Bootstrap 5 y CSS institucional.

---

### RNF-03 — Responsividad / Acceso Móvil
**Fuente:** Rectorado, Ing. Ortega (Mecanización Agrícola)  
**Prioridad:** M — Must Have

- Funcional en celulares de gama media-baja.
- Optimizado para conexiones lentas.
- Diseño responsive en todas las vistas.
- **Estado:** ✅ Bootstrap 5 responsivo implementado.

---

### RNF-04 — Seguridad
**Fuente:** Rectorado, Dpto. Investigación, Coordinación Académica  
**Prioridad:** M — Must Have

| Mecanismo | Descripción | Estado |
|---|---|---|
| CSRF Token | En todos los formularios POST/PUT/DELETE | ✅ Laravel nativo |
| Prevención SQL Injection | ORM Eloquent con queries parametrizadas | ✅ Laravel nativo |
| Prevención XSS | Escape automático en Blade `{{ }}` | ✅ Laravel nativo |
| Hashing de contraseñas | bcrypt factor 12 | ✅ Implementado |
| Validación de uploads | MIME type real + tamaño + sin PHP embebido | ✅ Implementado |
| Rate Limiting | 5 intentos de login por minuto | ✅ Implementado |
| HTTPS/SSL | Let's Encrypt en cPanel | ⚠️ Configurar en producción |
| Cookies seguras | `secure`, `http_only`, `same_site: lax` | ✅ Configurado |

---

### RNF-05 — Disponibilidad
**Fuente:** Rectorado, Ing. Espinoza (Mecánica Automotriz)  
**Prioridad:** M — Must Have

- Disponibilidad mínima: **99% mensual** (máx. 7.2 horas de inactividad/mes).
- Respaldos automáticos: diarios (BD) y semanales (archivos).
- Cron jobs configurados en cPanel.
- **Estado:** ⚠️ Pendiente configuración en producción.

---

### RNF-06 — Escalabilidad
**Fuente:** Dpto. Investigación  
**Prioridad:** S — Should Have

- El sistema debe soportar crecimiento hasta **10,000 documentos** sin degradación.
- Índices Full-Text y de columna implementados en MySQL.
- Almacenamiento organizado por año/mes para gestión eficiente.
- **Estado:** ✅ Índices de BD implementados, arquitectura Laravel escalable.

---

### RNF-07 — Mantenibilidad
**Fuente:** Rectorado  
**Prioridad:** S — Should Have

- Código bajo el patrón MVC (Laravel).
- Documentación técnica completa.
- Variables de entorno centralizadas (`.env`).
- Migraciones versionadas para la base de datos.
- **Estado:** ✅ Documentación técnica generada, arquitectura MVC.

---

### RNF-08 — Compatibilidad de Despliegue
**Fuente:** Rectorado, Coordinación Académica  
**Prioridad:** M — Must Have

| Requisito | Valor |
|---|---|
| PHP | 8.1 o superior |
| MySQL | 8.0 o superior |
| Servidor | Apache con mod_rewrite |
| Hosting | cPanel compartido o VPS |
| SSL | Requerido |
| upload_max_filesize | 64M |
| **Estado** | ✅ Verificado y documentado |

---

### RNF-09 — Idioma
**Fuente:** Ing. Ortega (Mecanización Agrícola)  
**Prioridad:** M — Must Have

- Interfaz completamente en **español**.
- Soporte para caracteres UTF-8 (tildes, ñ).
- **Estado:** ✅ Implementado, corrección de codificación incluida en commits.

---

## 4. MATRIZ DE TRAZABILIDAD

| ID Req. | Descripción | Fuente | Sprint | Estado |
|---|---|---|---|---|
| RF-01 | Gestión de usuarios y roles | Rectorado, CA | Sprint 1 | ✅ |
| RF-02 | Autenticación | Todas | Sprint 1 | ✅ |
| RF-03 | Subida de documentos | CA, Carreras | Sprint 3-4 | ✅ |
| RF-04 | Flujo de aprobación | CA, Rectorado | Sprint 6 | ✅ |
| RF-05 | Motor de búsqueda | Todas | Sprint 5 | ✅ |
| RF-06 | Comunidades y colecciones | CA, Carreras | Sprint 2 | ✅ |
| RF-07 | Visor PDF | DS, Rectorado | Sprint 4 | ✅ |
| RF-08 | Estadísticas | Rectorado, DI | Sprint 8 | ✅ |
| RF-09 | Configuración del sistema | Rectorado | Sprint 8 | ✅ |
| RF-10 | SEO / Google Scholar | DI | Sprint 3 | ✅ |
| RF-11 | Cita bibliográfica APA | MecAgri | Futuro | ❌ |
| RF-12 | Acceso restringido por doc. | MecAut, DI | Futuro | ❌ |
| RF-13 | Protocolo OAI-PMH | DI | v2.0 | ❌ |
| RNF-01 | Rendimiento < 3s | Rectorado | Sprint 5 | ✅ |
| RNF-02 | Usabilidad intuitiva | Carreras | Todos | ✅ |
| RNF-03 | Responsividad móvil | Rectorado | Todos | ✅ |
| RNF-04 | Seguridad | Todas | Sprint 1+ | ✅ |
| RNF-05 | Disponibilidad 99% | Rectorado | Sprint 10 | ⚠️ |
| RNF-06 | Escalabilidad | DI | Sprint 9 | ✅ |
| RNF-07 | Mantenibilidad | Rectorado | Todos | ✅ |
| RNF-08 | Compatibilidad cPanel | Rectorado | Sprint 10 | ✅ |
| RNF-09 | Idioma español | MecAgri | Sprint 1 | ✅ |

**Leyenda:** CA = Coordinación Académica | DI = Dpto. Investigación | DS = Carrera Desarrollo de Software | MecAut = Mecánica Automotriz | MecAgri = Mecanización Agrícola

---

## 5. BRECHAS Y RECOMENDACIONES

### 5.1 Requerimientos Identificados pero No Implementados

| # | Requerimiento | Prioridad | Esfuerzo Estimado | Recomendación |
|---|---|---|---|---|
| 1 | Cita bibliográfica APA automática | Media | 1-2 días | Sprint 9 o Sprint 10 |
| 2 | Restricción de acceso por documento | Media | 3-5 días | Sprint 9 |
| 3 | Protocolo OAI-PMH | Baja | 2-3 semanas | v2.0 post-lanzamiento |
| 4 | Integración antiplagio | Media | Requiere API externa | v2.0 |
| 5 | Búsqueda por área geográfica/cultivo | Baja | 1 semana | v2.0 |

### 5.2 Riesgos Identificados en Entrevistas

| Riesgo | Origen | Mitigación |
|---|---|---|
| Bajo uso por falta de política institucional | Ing. Ortega | Definir reglamento de depósito obligatorio |
| Falta de personal para aprobar documentos en periodos de vacaciones | Ing. Espinoza | Asignar múltiples bibliotecarios |
| Estudiantes con poca experiencia tecnológica | MecAut, MecAgri | Crear guía de usuario y tutorial en video |
| Documentos confidenciales de empresas | Ing. Espinoza | Implementar restricción de acceso (RF-12) |
| Dependencia del equipo de desarrollo para mantenimiento | Rectorado | Documentación y capacitación al personal |

---

## 6. CONCLUSIONES

### 6.1 Nivel de Cumplimiento

El sistema actualmente cubre el **77% de los requerimientos identificados** (10 de 13 funcionales y 7 de 9 no funcionales en estado operativo o parcial).

Los requerimientos **Must Have** están **100% implementados** en el código actual del repositorio. Los requerimientos pendientes corresponden a funcionalidades **Could Have** y **Won't Have** identificadas en las entrevistas como deseables para versiones futuras.

### 6.2 Fortalezas del Sistema Actual

- Arquitectura MVC con Laravel 12 garantiza mantenibilidad y escalabilidad.
- Implementación completa del flujo de revisión y aprobación.
- Búsqueda Full-Text con índices optimizados.
- Metadatos Dublin Core para indexación académica.
- Interfaz responsive con identidad institucional del ISTAE.
- Seguridad robusta integrada por el framework Laravel.

### 6.3 Próximos Pasos Prioritarios

1. **Sprint 9:** Implementar cita bibliográfica APA y restricción de acceso por documento.
2. **Sprint 10:** Despliegue en cPanel de producción con SSL y backups automáticos.
3. **Post-lanzamiento:** Definir política institucional de depósito obligatorio.
4. **v2.0:** OAI-PMH, integración antiplagio, ORCID.

---

*Documento elaborado por el Equipo de Desarrollo — Proyecto Repositorio Digital ISTAE*  
*Basado en entrevistas realizadas en Julio 2026 — Sprint 0*  
*Versión 1.0 — Agosto 2026*
