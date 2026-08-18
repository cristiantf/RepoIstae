# Entrevistas a Stakeholders — Repositorio Digital ISTAE
## Instituto Superior Tecnológico Alberto Enríquez
### Levantamiento de Requerimientos Funcionales y No Funcionales

---

> **Contexto del Proceso**
>
> Las siguientes entrevistas fueron realizadas durante la fase de levantamiento de requisitos del proyecto **Repositorio Digital Institucional del ISTAE**, en el marco del Sprint 0 de la metodología SCRUM adoptada. El objetivo es recopilar las necesidades, expectativas y preocupaciones de los diferentes actores institucionales que serán usuarios o beneficiarios del sistema.
>
> **Fechas de entrevista:** Julio 2026  
> **Modalidad:** Entrevista semiestructurada presencial  
> **Entrevistador:** Equipo de Desarrollo — Proyecto RepoIstae  

---

## ENTREVISTA 1
### Rectorado — Mgtr. Alejandro Palacios, Rector del ISTAE

**Entrevistador:** Buenos días, Rector. Agradecemos su tiempo para esta reunión. Como parte del levantamiento de requisitos del sistema de repositorio digital, quisiéramos conocer su visión institucional sobre el proyecto.

**Rector Palacios:** Buenos días. Con mucho gusto. Este es un proyecto que hemos esperado por varios años. El ISTAE ha crecido significativamente, y actualmente no tenemos ningún mecanismo digital formal para preservar la producción académica de nuestros estudiantes y docentes. Los trabajos de titulación, por ejemplo, en muchos casos se pierden o quedan archivados en físico sin que nadie pueda acceder a ellos. Eso es una pérdida enorme de conocimiento institucional.

**Entrevistador:** ¿Cuál sería el objetivo principal del repositorio desde la perspectiva institucional?

**Rector Palacios:** El objetivo central es posicionar al ISTAE como una institución que genera y difunde conocimiento técnico y tecnológico. Queremos que cualquier persona —nuestros estudiantes, docentes, y también el público en general— pueda acceder a los trabajos que producimos. Eso nos da visibilidad y proyección a nivel regional y nacional.

Pero también tiene un propósito interno: que los docentes puedan usar los trabajos previos como referencia, que los estudiantes nuevos puedan consultar tesis de promociones anteriores. En este momento eso es casi imposible sin venir físicamente a la biblioteca.

**Entrevistador:** ¿Qué preocupaciones tiene respecto a la seguridad o el acceso a la información?

**Rector Palacios:** Hay documentos que son propiedad intelectual de la institución y de sus autores. No podemos simplemente publicar todo sin un proceso de validación. Debe haber una revisión antes de que algo sea público. Y también necesito poder saber, como autoridad, cuántos documentos hay, de qué carreras vienen, quiénes son los autores más prolíficos... Necesito datos para la gestión.

Además, el sistema debe representar bien la imagen institucional. La interfaz tiene que verse profesional, con los colores del ISTAE. No puede parecer algo improvisado.

**Entrevistador:** ¿Tiene algún referente o modelo en mente?

**Rector Palacios:** Me han mencionado el repositorio de la UTN. Eso es lo que queremos, algo de ese nivel pero adaptado a nuestra realidad como instituto tecnológico. No somos una universidad grande, pero eso no significa que debamos tener menos calidad. 

**Entrevistador:** ¿Cuáles son sus expectativas de tiempo de respuesta del sistema?

**Rector Palacios:** El sistema debe ser rápido. Si alguien busca algo y tarda diez segundos en aparecer, ya perdió el interés. Además, tiene que funcionar bien en el celular, porque muchos de nuestros estudiantes acceden a internet principalmente desde sus teléfonos.

**Entrevistador:** Muchas gracias, Rector. ¿Hay algo más que quiera añadir?

**Rector Palacios:** Sí. Es importante que el sistema esté disponible en todo momento, no podemos tener caídas frecuentes. Y que sea fácil de mantener, porque el personal técnico del ISTAE no tiene experiencia avanzada en desarrollo de software. Necesitamos algo que, una vez entregado, el equipo pueda administrar sin depender siempre de los desarrolladores.

---

## ENTREVISTA 2
### Coordinación Académica — Mgtr. Alejandro Palacios, Coordinador Académico

**Entrevistador:** Buenas tardes, Mgtr. Palacios. Gracias por recibirnos. ¿Podría contarnos cómo ve el repositorio desde la Coordinación Académica?

**Coordinador Palacios:** Buenas tardes. Para nosotros en Coordinación Académica, el repositorio tiene un valor muy específico: queremos que sea un respaldo oficial de los trabajos de titulación. Actualmente, cuando un estudiante se gradúa, entrega una copia en físico y otra en CD. Los CDs se dañan, se pierden, el formato ya es obsoleto. Necesitamos una solución digital que garantice la permanencia de esos documentos.

**Entrevistador:** ¿Qué tipos de documentos considera más importantes para el repositorio?

**Coordinador Palacios:** En primer lugar, los trabajos de titulación: tesis, proyectos integradores, monografías. Luego, los artículos científicos que producen los docentes. Y también informes técnicos y proyectos de vinculación con la comunidad. Hay mucho material valioso que actualmente no tiene ninguna visibilidad.

**Entrevistador:** ¿Cómo debería organizarse la información dentro del sistema?

**Coordinador Palacios:** Por carreras, definitivamente. En el ISTAE tenemos tres carreras principales: Desarrollo de Software, Mecánica Automotriz y Mecanización Agrícola. Cada una debería tener su propio espacio dentro del repositorio. Así un estudiante de software no tiene que navegar entre proyectos de mecánica para encontrar lo que busca.

Y dentro de cada carrera, debería poder filtrar por año, por tipo de documento, por autor. Eso facilitaría mucho la búsqueda.

**Entrevistador:** ¿Qué información mínima debería registrarse por cada documento?

**Coordinador Palacios:** El título completo, los autores, el director o asesor, el resumen o abstract, las palabras clave, la carrera, el año de graduación y el tipo de trabajo. También debería poder descargarse en PDF. Es importante que el archivo esté completo, no solo los metadatos.

**Entrevistador:** ¿Quién debería tener acceso a subir documentos?

**Coordinador Palacios:** Los estudiantes deberían poder subir sus trabajos al momento de graduarse. Los docentes también deberían tener acceso para subir sus publicaciones. Pero todo debe pasar por revisión antes de publicarse. No podemos tener un repositorio con errores ortográficos o documentos incompletos. La biblioteca debería encargarse de esa validación.

**Entrevistador:** ¿Tiene expectativas sobre la visibilidad pública del sistema?

**Coordinador Palacios:** Sí, es fundamental que sea público. No queremos que sea un sistema cerrado solo para estudiantes del ISTAE. Si alguien de otra institución quiere consultar un trabajo nuestro, debería poder hacerlo libremente. Eso beneficia a los autores y a la imagen del instituto. Aunque hay que proteger los derechos de autoría, claro.

**Entrevistador:** ¿Qué problemas actuales resolvería este sistema?

**Coordinador Palacios:** El principal es la accesibilidad. Ahora mismo, si un docente quiere revisar una tesis de hace cinco años, tiene que venir físicamente a la biblioteca y esperar que encuentren el documento. Con el repositorio, eso sería cuestión de segundos. También resuelve el problema de deterioro físico de los documentos y nos permitiría cumplir con los estándares de acreditación institucional que exigen evidenciar la producción académica.

---

## ENTREVISTA 3
### Departamento de Investigación — MSc. Nuvia Troya, Coordinadora de Investigación

**Entrevistador:** Buenos días, MSc. Troya. ¿Cuál es su perspectiva sobre el repositorio desde el área de investigación?

**MSc. Troya:** Buenos días. Desde el Departamento de Investigación, el repositorio es una herramienta estratégica. Actualmente el ISTAE tiene proyectos de investigación en ejecución, pero no existe un espacio formal para publicar y difundir los resultados. Eso limita mucho nuestro impacto y nuestras posibilidades de vinculación con otras instituciones.

**Entrevistador:** ¿Qué funcionalidades son prioritarias para el área de investigación?

**MSc. Troya:** Primero, que los documentos puedan ser indexados por motores de búsqueda académica como Google Scholar. Eso requiere implementar metadatos específicos, el estándar Dublin Core es el que se usa en los repositorios serios. Sin eso, publicar en el repositorio es como gritar en el vacío, nadie lo va a encontrar.

Segundo, necesitamos estadísticas. ¿Cuántas veces fue descargado un artículo? ¿Desde dónde? Eso nos permite medir el impacto de nuestra producción científica.

Tercero, y muy importante, la gestión de derechos de autor. No todos los documentos son de libre acceso. Algunos tienen acuerdos de confidencialidad o están en proceso de publicación en revistas externas. El sistema debe poder manejar distintos niveles de acceso.

**Entrevistador:** ¿Qué metadatos considera esenciales para los artículos científicos?

**MSc. Troya:** Título, autores, institución, año de publicación, resumen en español e inglés, palabras clave en ambos idiomas, DOI si existe, ISBN/ISSN para revistas, y el enlace o archivo del documento. También debería registrarse si el trabajo fue presentado en un congreso o publicado en una revista indexada.

**Entrevistador:** ¿Tiene preocupaciones sobre la integridad de los datos?

**MSc. Troya:** Absolutamente. El repositorio debe tener respaldos automáticos. Si el servidor falla y se pierde la información, el daño es irreparable. También me preocupa la integridad de los archivos subidos: que no se puedan modificar una vez publicados, que haya un registro de versiones si hay correcciones.

Y la seguridad. Solo usuarios autorizados deben poder subir documentos. No podemos permitir que cualquier persona cargue lo que quiera sin ningún control.

**Entrevistador:** ¿Qué expectativas tiene en cuanto al crecimiento del repositorio?

**MSc. Troya:** El repositorio debe ser escalable. En los próximos años esperamos aumentar significativamente nuestra producción científica. El sistema debe poder manejar miles de documentos sin degradar su rendimiento. También sería ideal que en el futuro pueda integrarse con sistemas externos como ORCID o bases de datos bibliográficas.

**Entrevistador:** ¿Algo más que quiera agregar?

**MSc. Troya:** Sí. El sistema debe cumplir con el protocolo OAI-PMH si es posible, que es el estándar para la interoperabilidad entre repositorios. No sé si eso está en el alcance inicial, pero es importante tenerlo como meta. También espero que haya una sección de estadísticas públicas, para que cualquier visitante pueda ver cuántos documentos hay, por carrera, por año. Eso da transparencia y confianza en la institución.

---

## ENTREVISTA 4
### Coordinación de Carrera — Tecnología en Desarrollo de Software
### MSc. Jonathan Arana, Coordinador de Carrera

**Entrevistador:** Buenos días, MSc. Arana. Nos interesa conocer las necesidades específicas de la carrera de Desarrollo de Software para el repositorio.

**MSc. Arana:** Buenos días. Nosotros en Desarrollo de Software somos quizás los más interesados en este sistema, porque entendemos su valor técnico. Pero también tenemos necesidades muy particulares.

La carrera genera principalmente proyectos de software: aplicaciones web, móviles, sistemas de escritorio. El repositorio debe poder documentar no solo el documento escrito, sino también los componentes del proyecto: el código fuente, los manuales de usuario, los diagramas de arquitectura.

**Entrevistador:** ¿Qué tipos de documentos son más frecuentes en su carrera?

**MSc. Arana:** Trabajos de titulación en formato tesis o proyecto integrador. También artículos técnicos que los docentes presentamos en eventos. Y materiales de apoyo docente, como guías de laboratorio. Para el repositorio inicial, lo más urgente son los trabajos de titulación.

**Entrevistador:** ¿Cómo describiría al usuario típico de la carrera que interactuaría con el sistema?

**MSc. Arana:** Un estudiante de nuestra carrera es bastante hábil tecnológicamente. Espera que el sistema sea moderno, que funcione bien desde el celular, que sea rápido. Si la interfaz está desactualizada o es lenta, simplemente no la van a usar. También espera poder compartir el enlace a su tesis en redes sociales o en su CV.

Los docentes somos más exigentes en cuanto a los metadatos. Queremos que nuestros artículos aparezcan bien referenciados, con todos los autores, el año correcto, los términos de búsqueda correctos.

**Entrevistador:** ¿Tiene alguna preocupación sobre el plagio?

**MSc. Arana:** Es una preocupación grande. El repositorio, al hacer pública toda la producción académica, también facilita que los estudiantes puedan copiar trabajos anteriores. Idealmente, el sistema debería integrarse con una herramienta antiplagio, o al menos hacer visible cuáles trabajos anteriores existen para que los estudiantes sepan que están siendo comparados.

**Entrevistador:** ¿Qué funcionalidad considera indispensable en el primer lanzamiento?

**MSc. Arana:** La búsqueda. Si el sistema no puede encontrar documentos de forma rápida y precisa, no sirve. Que pueda buscar por palabras clave en el título, en el resumen, por nombre del autor. Y que los resultados sean relevantes, no que aparezca cualquier cosa.

También es indispensable el visor de PDF en línea. Los estudiantes no deberían tener que descargar el archivo para verlo. Con un visor integrado, la experiencia es mucho mejor.

**Entrevistador:** ¿Algo relacionado con la organización del contenido?

**MSc. Arana:** Que los documentos de nuestra carrera estén claramente separados. No queremos que nuestros proyectos de software aparezcan mezclados con tesis de mecánica. Cada carrera debe tener su colección bien definida dentro del repositorio.

---

## ENTREVISTA 5
### Coordinación de Carrera — Tecnología en Mecánica Automotriz
### MSc. Vladimir Guacha, Coordinador de Carrera

**Entrevistador:** Buenas tardes, MSc. Guacha. ¿Cuáles son las expectativas de la carrera de Mecánica Automotriz para el repositorio digital?

**MSc. Guacha:** Buenas tardes. Honestamente, nuestra carrera no estaba muy familiarizada con esto de los repositorios digitales. Pero una vez que entendí el concepto, vi que es algo muy valioso para nosotros.

En Mecánica Automotriz, nuestros estudiantes hacen proyectos muy interesantes: análisis de motores, diagnósticos de fallas, propuestas de eficiencia de combustible, estudios sobre vehículos eléctricos. Esos conocimientos que se generan hoy, deberían estar disponibles mañana para otros estudiantes y para los talleres y empresas del sector.

**Entrevistador:** ¿Qué características serían más útiles para los estudiantes de su carrera?

**MSc. Guacha:** Primero, la simplicidad. Nuestros estudiantes no son expertos en tecnología. El proceso para subir un documento debe ser muy sencillo, paso a paso, sin tecnicismos. Si es complicado, van a abandonar el formulario a la mitad.

Segundo, que pueda incluir imágenes y diagramas dentro de los PDF. Nuestros trabajos tienen muchos planos, esquemas eléctricos, fotografías de los proyectos. El visor debe mostrar todo eso correctamente.

Tercero, el acceso público. Hay empresas de mantenimiento vehicular que podrían beneficiarse de los estudios que hacen nuestros estudiantes. Eso también beneficiaría a los propios autores, porque demuestra que su trabajo tiene aplicación práctica.

**Entrevistador:** ¿Qué información específica necesita que se registre para los proyectos de mecánica?

**MSc. Guacha:** Además de los datos básicos, necesitamos que se pueda registrar el tipo de vehículo o maquinaria sobre el que trata el proyecto, el área temática (diagnóstico, mantenimiento, eficiencia energética, etc.) y si el proyecto tuvo aplicación práctica o fue puramente teórico. Eso ayudaría a filtrar los resultados de búsqueda de manera más útil para alguien del sector automotriz.

**Entrevistador:** ¿Hay preocupaciones sobre acceso o privacidad?

**MSc. Guacha:** Sí, hay proyectos que involucran información de empresas colaboradoras. En esos casos, quizás no deberían ser completamente públicos. Debería haber una opción para limitar el acceso solo a miembros de la institución, o incluso restringirlos temporalmente mientras están en proceso de patente o publicación.

**Entrevistador:** ¿Qué espera en cuanto al soporte y mantenimiento del sistema?

**MSc. Guacha:** Que haya un manual de uso claro para los estudiantes. Nosotros no podemos explicarle a cada uno cómo subir su trabajo. Si hay un tutorial en video o una guía paso a paso, mejor. Y que cuando haya un problema, haya alguien a quien acudir. El sistema no puede estar caído cuando los estudiantes están en proceso de graduación.

---

## ENTREVISTA 6
### Coordinación de Carrera — Tecnología en Mecanización Agrícola
### MSc. David Morales, Coordinador de Carrera

**Entrevistador:** Buenos días, MSc. Morales. ¿Cómo ve el repositorio desde la perspectiva de Mecanización Agrícola?

**MSc. Morales:** Buenos días. Para nuestra carrera, el repositorio es especialmente relevante porque trabajamos con conocimiento que tiene impacto directo en las comunidades agrícolas de la región. Muchos de nuestros estudiantes vienen de zonas rurales y sus proyectos abordan problemas reales del campo: optimización de maquinaria agrícola, sistemas de riego, manejo de cosechas, energías renovables aplicadas al agro.

Si esos conocimientos quedan archivados y nadie los puede consultar, es un desperdicio. El repositorio sería una forma de conectar ese conocimiento con quienes realmente lo necesitan.

**Entrevistador:** ¿Qué tipo de usuarios espera que accedan a los documentos de su carrera?

**MSc. Morales:** Principalmente, otros estudiantes e investigadores. Pero también esperamos que agricultores, técnicos del MAGAP, ONGs que trabajan con comunidades rurales, y cooperativas agrícolas puedan acceder a los estudios. Para eso es fundamental que el sistema sea de acceso libre y que los documentos estén bien descritos con palabras clave que alguien sin formación universitaria también podría usar en una búsqueda.

**Entrevistador:** ¿Qué funcionalidades específicas beneficiarían más a su carrera?

**MSc. Morales:** La búsqueda por área geográfica o por tipo de cultivo sería ideal, aunque entiendo que eso puede ser complejo de implementar. Lo más básico y urgente es poder buscar por carrera y por palabras clave. También me parece importante que el sistema registre cuántas veces fue descargado un documento. Eso motiva a los autores y muestra el impacto real de su trabajo.

Otra cosa importante: que los documentos tengan una cita bibliográfica generada automáticamente. Los docentes y técnicos que quieran referenciar un trabajo necesitan esa información en formato APA o similar.

**Entrevistador:** ¿Tiene expectativas sobre la facilidad de uso del sistema?

**MSc. Morales:** Sí. Nuestra carrera tiene muchos estudiantes que vienen de zonas con poca conectividad o con poca experiencia tecnológica. El sistema debe funcionar en conexiones lentas, sin consumir demasiados datos móviles. Y la interfaz debe ser intuitiva, con textos claros, sin tecnicismos.

También sería bueno que el sistema funcione bien en celulares de gama baja. No todos nuestros estudiantes tienen smartphones de última generación.

**Entrevistador:** ¿Qué tan importante es el idioma del sistema?

**MSc. Morales:** Que esté en español, fundamentalmente. Algunos de nuestros estudiantes tienen documentos con terminología en inglés, especialmente cuando citan normas técnicas internacionales. Pero la interfaz y toda la navegación deben ser en español.

**Entrevistador:** ¿Qué le preocupa más del proyecto?

**MSc. Morales:** Que el sistema se desarrolle pero nadie lo use. Eso pasa mucho en instituciones: invierten en tecnología y luego el sistema queda abandonado. Para que esto funcione, debe haber un proceso institucional que obligue —o al menos incentive fuertemente— a los estudiantes a depositar sus trabajos al momento de graduarse. Si no hay una política institucional detrás, el repositorio va a estar vacío.

También me preocupa la continuidad. ¿Quién va a ser responsable de mantener el sistema? ¿Quién va a aprobar los documentos cuando el bibliotecario esté de vacaciones? Eso debe estar bien definido antes del lanzamiento.

---

## Resumen de Participantes

| # | Dependencia | Nombre | Cargo | Rol en el Sistema |
|---|---|---|---|---|
| 1 | Rectorado | Mgtr. Alejandro Palacios | Rector del ISTAE | Stakeholder principal / Patrocinador |
| 2 | Coordinación Académica | Mgtr. Alejandro Palacios | Coordinador Académico | Usuario administrador / Supervisor |
| 3 | Dpto. de Investigación | MSc. Nuvia Troya | Coordinadora de Investigación | Usuario avanzado / Publicadora |
| 4 | Carrera Desarrollo de Software | MSc. Jonathan Arana | Coordinador de Carrera | Usuario docente / Publicador |
| 5 | Carrera Mecánica Automotriz | MSc. Vladimir Guacha | Coordinador de Carrera | Usuario docente / Representante estudiantil |
| 6 | Carrera Mecanización Agrícola | MSc. David Morales | Coordinador de Carrera | Usuario docente / Representante estudiantil |

---

*Documento elaborado por el Equipo de Desarrollo — Proyecto Repositorio Digital ISTAE*  
*Julio 2026 — Sprint 0: Levantamiento de Requisitos*
