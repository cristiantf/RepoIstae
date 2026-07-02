# Casos de Uso — Repositorio Digital ISTAE
## Instituto Superior Tecnológico Alberto Enríquez

---

## 1. Actores del Sistema

| Actor | Descripcion |
|---|---|
| **Visitante** | Usuario no autenticado. Solo puede buscar y ver documentos publicos. |
| **Estudiante** | Usuario registrado. Puede subir sus propios trabajos y ver el estado de sus envios. |
| **Docente** | Usuario registrado con mas privilegios. Puede subir articulos y materiales. |
| **Bibliotecario** | Revisa, aprueba o rechaza documentos enviados. Gestiona colecciones. |
| **Administrador** | Control total del sistema: usuarios, roles, comunidades, estadisticas. |

---

## 2. Casos de Uso — Modulo de Autenticacion

### CU-01: Registrar Usuario

- **Actor:** Visitante
- **Descripcion:** Un nuevo usuario se registra en el sistema proporcionando datos basicos.
- **Precondicion:** El usuario no tiene cuenta activa.
- **Flujo Principal:**
  1. El visitante accede al formulario de registro.
  2. Ingresa nombre completo, email institucional, carrera y contrasena.
  3. El sistema valida que el email no este registrado.
  4. Se crea la cuenta con rol ESTUDIANTE por defecto.
  5. El sistema envia correo de confirmacion.
- **Flujo Alternativo:** Si el email ya existe, muestra mensaje de error.
- **Postcondicion:** Usuario registrado y pendiente de activacion.

---

### CU-02: Iniciar Sesion

- **Actor:** Todos los actores autenticados
- **Descripcion:** Un usuario accede al sistema con sus credenciales.
- **Precondicion:** El usuario tiene cuenta activa.
- **Flujo Principal:**
  1. Usuario ingresa email y contrasena.
  2. Sistema valida credenciales contra la base de datos.
  3. Si son correctas, crea sesion y redirige al dashboard segun rol.
- **Flujo Alternativo:** Credenciales incorrectas, muestra mensaje de error.
- **Postcondicion:** Sesion activa para el usuario.

---

### CU-03: Cerrar Sesion

- **Actor:** Todos los actores autenticados
- **Descripcion:** El usuario termina su sesion actual de forma segura.
- **Flujo Principal:**
  1. Usuario hace clic en Cerrar Sesion.
  2. Sistema destruye la sesion y redirige al inicio.

---

## 3. Casos de Uso — Modulo de Documentos

### CU-04: Subir Documento

- **Actor:** Estudiante, Docente
- **Descripcion:** Un usuario autenticado sube un nuevo documento al repositorio.
- **Precondicion:** Usuario autenticado con rol Estudiante o Docente.
- **Flujo Principal:**
  1. Usuario accede a Subir Documento.
  2. Completa el formulario de metadatos:
     - Titulo del trabajo
     - Autores
     - Director/Asesor de tesis (si aplica)
     - Resumen (abstract)
     - Palabras clave
     - Tipo de documento (Tesis, Articulo, Proyecto)
     - Carrera
     - Anno de publicacion
  3. Adjunta el archivo PDF (max. 50 MB).
  4. El sistema valida el formato y peso del archivo.
  5. El documento se guarda con estado en_revision.
  6. Se notifica al Bibliotecario por correo.
- **Flujo Alternativo:** Archivo no es PDF o supera el limite, muestra mensaje de error.
- **Postcondicion:** Documento en cola de revision.

---

### CU-05: Ver Mis Documentos

- **Actor:** Estudiante, Docente
- **Descripcion:** El usuario ve el listado de sus documentos subidos con su estado actual.
- **Flujo Principal:**
  1. Usuario accede a Mis Documentos.
  2. Sistema muestra lista con titulo, estado, fecha de envio y acciones disponibles.
- **Postcondicion:** Usuario informado del estado de sus envios.

---

### CU-06: Editar Documento

- **Actor:** Estudiante, Docente
- **Descripcion:** El usuario edita un documento que fue rechazado o esta en borrador.
- **Precondicion:** El documento esta en estado borrador o rechazado.
- **Flujo Principal:**
  1. Usuario selecciona el documento a editar.
  2. Modifica los campos necesarios o reemplaza el archivo.
  3. Re-envia para revision.
- **Postcondicion:** Documento actualizado y en estado en_revision.

---

### CU-07: Revisar y Aprobar Documento

- **Actor:** Bibliotecario
- **Descripcion:** El Bibliotecario revisa los documentos en cola y decide aprobarlos o rechazarlos.
- **Precondicion:** Existen documentos con estado en_revision.
- **Flujo Principal:**
  1. Bibliotecario accede al panel de revision.
  2. Visualiza la lista de documentos pendientes.
  3. Abre el documento (previsualizacion PDF + metadatos).
  4. Verifica que metadatos sean completos y correctos.
  5. Selecciona Aprobar:
     - El estado cambia a publicado.
     - Se notifica al autor por correo.
  6. O selecciona Rechazar:
     - Ingresa comentario/observacion.
     - El estado cambia a rechazado.
     - Se notifica al autor con observaciones.
- **Postcondicion:** Documento publicado o devuelto al autor.

---

### CU-08: Eliminar Documento

- **Actor:** Administrador, Bibliotecario
- **Descripcion:** Se elimina un documento del sistema.
- **Flujo Principal:**
  1. Admin selecciona el documento a eliminar.
  2. Confirma la accion.
  3. Sistema elimina el registro de la BD y el archivo fisico del servidor.
- **Postcondicion:** Documento eliminado permanentemente.

---

## 4. Casos de Uso — Modulo de Busqueda

### CU-09: Busqueda Simple

- **Actor:** Visitante, todos los usuarios
- **Descripcion:** El usuario busca documentos usando palabras clave en la barra de busqueda global.
- **Flujo Principal:**
  1. Usuario escribe termino(s) en la barra de busqueda.
  2. Sistema realiza busqueda Full-Text en titulo, resumen, autor, palabras clave.
  3. Se muestran resultados ordenados por relevancia con paginacion.
- **Postcondicion:** Listado de documentos coincidentes.

---

### CU-10: Busqueda Avanzada

- **Actor:** Visitante, todos los usuarios
- **Descripcion:** El usuario aplica multiples filtros para una busqueda mas precisa.
- **Filtros disponibles:**
  - Titulo, Autor, Director de Tesis
  - Anno (desde / hasta)
  - Tipo de documento, Carrera
  - Palabras clave
- **Flujo Principal:**
  1. Usuario accede a Busqueda Avanzada.
  2. Llena uno o mas campos de filtro.
  3. El sistema combina los filtros con logica AND.
  4. Se muestran resultados con opciones de ordenamiento.
- **Postcondicion:** Resultados filtrados mostrados.

---

### CU-11: Explorar por Comunidades y Colecciones

- **Actor:** Visitante, todos los usuarios
- **Descripcion:** El usuario navega jerarquicamente por la estructura del repositorio.
- **Flujo Principal:**
  1. Usuario accede a la seccion Comunidades.
  2. Ve la lista de comunidades disponibles.
  3. Selecciona una comunidad y ve sus colecciones.
  4. Selecciona una coleccion y ve los documentos que contiene.
- **Postcondicion:** Usuario navega el arbol de contenidos.

---

### CU-12: Ver Detalle de Documento

- **Actor:** Visitante, todos los usuarios
- **Descripcion:** El usuario ve la informacion completa de un documento especifico.
- **Flujo Principal:**
  1. Usuario hace clic en un resultado de busqueda.
  2. Sistema muestra la ficha completa del documento:
     - Titulo, autores, director
     - Resumen, palabras clave
     - Carrera, tipo, anno
     - Visor PDF embebido (PDF.js)
     - Boton de descarga (si esta habilitado)
     - Estadisticas de vistas y descargas
  3. Sistema registra la visita en las estadisticas.
- **Postcondicion:** Visita registrada, usuario informado.

---

## 5. Casos de Uso — Modulo de Administracion

### CU-13: Gestionar Usuarios

- **Actor:** Administrador
- **Acciones:** Listar, cambiar rol, activar/desactivar, eliminar cuentas.
- **Postcondicion:** Cambios aplicados al sistema de usuarios.

---

### CU-14: Gestionar Comunidades y Colecciones

- **Actor:** Administrador, Bibliotecario
- **Acciones:** Crear/editar/eliminar Comunidades y Colecciones, subir logo.
- **Postcondicion:** Estructura organizativa actualizada.

---

### CU-15: Ver Estadisticas del Repositorio

- **Actor:** Administrador, Bibliotecario
- **Datos disponibles:**
  - Total de documentos por estado
  - Documentos por carrera y tipo
  - Top 10 documentos mas visitados y descargados
  - Crecimiento mensual de publicaciones
  - Usuarios registrados por rol
- **Postcondicion:** Dashboard de estadisticas mostrado.

---

### CU-16: Configurar el Sistema

- **Actor:** Administrador
- **Configuraciones:**
  - Nombre y logo del repositorio
  - Correo institucional para notificaciones
  - Tamano maximo de archivo permitido
  - Texto del pie de pagina
  - Carreras disponibles en el sistema
- **Postcondicion:** Configuracion guardada y aplicada.

---

## 6. Matriz de Casos de Uso por Actor

| Caso de Uso | Visitante | Estudiante | Docente | Bibliotecario | Administrador |
|---|:---:|:---:|:---:|:---:|:---:|
| CU-01 Registrar Usuario | X | | | | |
| CU-02 Iniciar Sesion | X | X | X | X | X |
| CU-03 Cerrar Sesion | | X | X | X | X |
| CU-04 Subir Documento | | X | X | | |
| CU-05 Ver Mis Documentos | | X | X | | |
| CU-06 Editar Documento | | X | X | | |
| CU-07 Revisar/Aprobar | | | | X | X |
| CU-08 Eliminar Documento | | | | X | X |
| CU-09 Busqueda Simple | X | X | X | X | X |
| CU-10 Busqueda Avanzada | X | X | X | X | X |
| CU-11 Explorar Colecciones | X | X | X | X | X |
| CU-12 Ver Detalle Documento | X | X | X | X | X |
| CU-13 Gestionar Usuarios | | | | | X |
| CU-14 Gestionar Colecciones | | | | X | X |
| CU-15 Ver Estadisticas | | | | X | X |
| CU-16 Configurar Sistema | | | | | X |

