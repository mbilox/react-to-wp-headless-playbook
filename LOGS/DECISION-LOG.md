# Decision Log — React to WordPress Headless

> Registro de decisiones técnicas importantes tomadas durante el proyecto WE Digital.  
> **Objetivo:** Documentar el POR QUÉ detrás de cada decisión para futuros proyectos.

---

## D001: Mu-plugin vs Plugin Regular

**Decisión:** Usar mu-plugin (`wp-content/mu-plugins/`)

**Contexto:**
Necesitábamos registrar meta campos y un metabox para el home page. Esto debe estar siempre activo.

**Opciones consideradas:**
- **A) Mu-plugin:** Se carga automáticamente, no requiere activación manual
- **B) Plugin regular:** Requiere activación desde el admin, puede desactivarse por error

**Decisión:** Opción A (mu-plugin)

**Rationale:**
- Garantiza que los meta campos siempre estén registrados
- No depende de que un usuario haga clic en "Activar"
- Apropiado para funcionalidades críticas del tema
- Reduce el riesgo de que alguien desactive el plugin por accidente

**Consecuencias:**
- ✅ Positiva: Siempre activo, sin mantenimiento de activación
- ⚠️ Negativa: No se puede desactivar desde el admin (requiere borrar el archivo)

**Aplica a:** Todos los proyectos con meta campos críticos

---

## D002: Detección por Template vs Detección por ID Fijo

**Decisión:** Crear `home-template.php` y detectar por `get_page_template_slug()`

**Contexto:**
Necesitábamos que el metabox solo aparezca en la página de inicio.

**Opciones consideradas:**
- **A) Template (`home-template.php`):** Se asigna a una página, el metabox aparece si la página tiene esa plantilla
- **B) ID fijo (ej: ID 2):** Hardcodear el ID de la página de inicio
- **C) Slug (`home`):** Detectar por el slug de la página

**Decisión:** Opción A (template)

**Rationale:**
- Es más robusto y portable
- Si en el futuro se cambia la página de inicio, solo hay que asignar la plantilla a otra página
- El ID fijo es frágil (puede cambiar si se borra y recrea la página)
- El slug puede cambiar si el usuario lo edita

**Consecuencias:**
- ✅ Positiva: Flexible, portable, robusto
- ⚠️ Negativa: Requiere que el usuario asigne la plantilla manualmente

**Mitigación:**
Agregar un admin notice si la página de inicio no tiene asignada la plantilla Home Template.

**Aplica a:** Todos los proyectos con página de inicio

---

## D003: WordPress Media Frame vs Input de URL

**Decisión:** Usar `wp.media` (Media Frame nativo)

**Contexto:**
El usuario necesitaba seleccionar imágenes para el Hero y otras secciones.

**Opciones consideradas:**
- **A) Media Frame nativo:** `wp.media` con selección de biblioteca, upload, crops
- **B) Input de texto para URL:** Simple pero no permite acceso a la biblioteca
- **C) Plugin de third-party:** ACF, Carbon Fields, etc.

**Decisión:** Opción A (Media Frame nativo)

**Rationale:**
- El usuario específicamente pidió el Media Frame
- Permite elegir imágenes existentes de la biblioteca
- Permite subir nuevas imágenes directamente
- Gestiona thumbnails y crops automáticamente
- Devuelve el ID del attachment para obtener la URL correcta
- 100% nativo, sin dependencias

**Consecuencias:**
- ✅ Positiva: Experiencia familiar para usuarios de WordPress
- ✅ Positiva: Integración completa con la biblioteca de medios
- ⚠️ Negativa: Requiere encolar `wp_enqueue_media()`

**Aplica a:** Todos los proyectos que necesiten selección de imágenes

---

## D004: Metabox Nativo vs ACF Pro

**Decisión:** Implementar metabox 100% nativo

**Contexto:**
Necesitábamos un panel de administración para editar meta campos. El usuario pidió explícitamente no usar ACF.

**Opciones consideradas:**
- **A) Metabox nativo:** `add_meta_box()` + campos HTML custom + JS vanilla
- **B) ACF Pro:** Plugin comercial, más rápido de implementar
- **C) Carbon Fields:** Plugin gratuito, alternativa a ACF
- **D) Meta Box:** Plugin gratuito, framework para meta boxes

**Decisión:** Opción A (nativo)

**Rationale:**
- El usuario pidió explícitamente no usar ACF
- WordPress provee todas las APIs necesarias nativamente
- Reduce dependencias y mantiene control total sobre la UI
- No hay costo de licencia
- No hay riesgo de que el plugin se descontinúe
- El código es portable y entendible

**Consecuencias:**
- ✅ Positiva: Sin dependencias, control total, sin costo
- ⚠️ Negativa: Requiere más código inicial (HTML, CSS, JS)
- ⚠️ Negativa: No tiene drag-and-drop visual como ACF

**Mitigación:**
Crear templates reutilizables para acelerar la implementación en futuros proyectos.

**Aplica a:** Todos los proyectos donde el usuario prefiera no usar ACF

---

## D005: Repeaters Nativos vs Campos Estáticos

**Decisión:** Implementar repeaters dinámicos con JavaScript vanilla

**Contexto:**
Los campos tipo lista (stats, services, steps, projects) necesitaban ser editables de forma flexible.

**Opciones consideradas:**
- **A) Repeaters dinámicos:** Botón "Añadir fila", botón "Eliminar fila", JS vanilla
- **B) Número fijo de campos:** Definir 5 campos de stats, 4 de servicios, etc.
- **C) JSON textarea:** Un textarea donde el usuario pega JSON

**Decisión:** Opción A (repeaters dinámicos)

**Rationale:**
- Permite agregar/eliminar filas sin recargar la página
- Más flexible para contenido variable
- Mejor UX que editar JSON a mano
- Los datos se serializan automáticamente en el formulario

**Consecuencias:**
- ✅ Positiva: Flexible, buena UX
- ⚠️ Negativa: Requiere JavaScript para manejar DOM
- ⚠️ Negativa: Puede haber conflicto con Gutenberg u otros plugins

**Mitigación:**
- Encolar scripts solo en la pantalla de edición de páginas
- Usar IIFE para evitar contaminación del scope global
- Re-indexar names después de eliminar filas

**Aplica a:** Todos los proyectos con listas de datos

---

## D006: Fetch Nativo vs Axios/React Query

**Decisión:** Usar `fetch` nativo con hook custom `useHomeData()`

**Contexto:**
El frontend necesitaba consumir la REST API de WordPress.

**Opciones consideradas:**
- **A) Fetch nativo:** `fetch()` + `useEffect` + `useState`
- **B) Axios:** Librería popular para HTTP requests
- **C) React Query / TanStack Query:** Manejo de estado server-side
- **D) SWR:** Alternativa a React Query

**Decisión:** Opción A (fetch nativo)

**Rationale:**
- El proyecto no tenía axios ni react-query instalados
- Agregar dependencias aumenta el bundle innecesariamente para un solo endpoint
- `fetch` + `useEffect` + `useState` es suficiente para este caso de uso
- Reduce complejidad y dependencias externas
- TypeScript proporciona tipado suficiente

**Consecuencias:**
- ✅ Positiva: Sin dependencias adicionales
- ✅ Positiva: Bundle más pequeño
- ⚠️ Negativa: No tiene caching automático
- ⚠️ Negativa: No tiene re-fetching automático

**Mitigación:**
- Dado que solo `App.tsx` usa el hook y pasa datos por props, no hay problema de múltiples requests
- Si en el futuro se necesita caching, se puede migrar a React Query fácilmente

**Aplica a:** Proyectos simples con pocos endpoints. Para proyectos complejos, considerar React Query.

---

## D007: Estructura de Meta Campos: Agrupados vs Simples

**Decisión:** Tres meta campos de tipo objeto JSON (`{PREFIX}_hero`, `{PREFIX}_rooms`, `{PREFIX}_surf_info`)

**Contexto:**
Necesitábamos decidir cómo estructurar los meta campos en la base de datos.

**Opciones consideradas:**
- **A) Campos agrupados:** 3 meta campos de tipo objeto (como hicimos)
- **B) Campos simples:** Un meta campo por cada string (ej: `{PREFIX}_hero_title`, `{PREFIX}_hero_subtitle`)
- **C) Un solo campo:** Todo en un mega-objeto `{PREFIX}_home_data`

**Decisión:** Opción A (3 campos agrupados)

**Rationale:**
- Reduce la cantidad de registros meta en la base de datos
- Agrupa lógicamente el contenido por sección
- Facilita la validación con JSON Schema anidado
- Más fácil de entender y mantener

**Consecuencias:**
- ✅ Positiva: Menos registros en DB, más organizado
- ✅ Positiva: JSON Schema anidado más limpio
- ⚠️ Negativa: Si una sección crece mucho, el objeto puede volverse grande

**Aplica a:** Todos los proyectos con múltiples secciones

---

## D008: Configuración de URL: Variable de Entorno vs Hardcode

**Decisión:** Leer `VITE_WP_API_URL` desde variables de entorno

**Contexto:**
El frontend necesitaba saber dónde está la API de WordPress.

**Opciones consideradas:**
- **A) Variable de entorno:** `VITE_WP_API_URL` en `.env`
- **B) Constante hardcodeada:** URL escrita directamente en el código
- **C) Config file:** Archivo `config.ts` con la URL

**Decisión:** Opción A (variable de entorno)

**Rationale:**
- Permite cambiar la URL de WordPress sin modificar código
- Vite expone variables `VITE_*` automáticamente
- Facilita el deploy a diferentes entornos (dev, staging, prod)
- No expone información sensible si se usa correctamente

**Consecuencias:**
- ✅ Positiva: Flexible para diferentes entornos
- ✅ Positiva: Sin cambios de código entre ambientes
- ⚠️ Negativa: Requiere que el dev sepa configurar `.env`

**Aplica a:** Todos los proyectos

---

## D009: Fallbacks al Texto Original

**Decisión:** Cada componente usa el texto estático original como valor por defecto si el campo meta no existe o está vacío.

**Contexto:**
Necesitábamos asegurar que el sitio no se vea roto si WordPress no tiene datos configurados.

**Opciones consideradas:**
- **A) Fallback al texto original:** Mostrar el texto hardcodeado si el meta está vacío
- **B) Renderizar null:** No mostrar nada si el meta está vacío
- **C) Placeholder:** Mostrar "[Contenido no configurado]"

**Decisión:** Opción A (fallback al texto original)

**Rationale:**
- Evita que el sitio se vea roto si WordPress no tiene datos
- Permite migración gradual (sección por sección)
- El usuario puede editar campos en WordPress y ver cambios inmediatamente
- Si algo falla, el sitio sigue funcionando con el diseño original

**Consecuencias:**
- ✅ Positiva: Sitio nunca se ve roto
- ✅ Positiva: Migración gradual posible
- ⚠️ Negativa: El texto original permanece en el código

**Aplica a:** Todos los proyectos

---

**Última actualización:** Mayo 2026  
**Proyecto de referencia:** theme-wordpress2 (WE Digital)
