# Checklist — Fase 3: WordPress Backend

> **Objetivo:** Construir el backend de WordPress con meta campos, metabox y REST API.
> **Tiempo estimado:** 4-6 horas

---

## Setup Inicial

- [ ] Tema activo de WordPress identificado
- [ ] Ruta del tema guardada en memoria
- [ ] Página de inicio identificada (slug e ID)

## Plantilla

- [ ] `home-template.php` creado en el tema activo
- [ ] Template Name definido: "Home Template"
- [ ] Template Post Type: page
- [ ] Plantilla asignada a la página de inicio

## Mu-Plugin

- [ ] Archivo creado en `wp-content/mu-plugins/{PREFIX}-home-meta.php`
- [ ] Header de plugin con nombre, descripción, versión, autor
- [ ] `if (!defined('ABSPATH')) exit;` presente

## Meta Campos

- [ ] `register_post_meta()` implementado para post type `page`
- [ ] 3 meta campos registrados: `{PREFIX}_hero`, `{PREFIX}_rooms`, `{PREFIX}_surf_info`
- [ ] `show_in_rest => true` configurado en cada campo
- [ ] `single => true` configurado
- [ ] JSON Schema definido para cada campo con propiedades anidadas
- [ ] `additionalProperties => true` en objetos de nivel superior
- [ ] `sanitize_callback` con `json_decode` para arrays/objetos

## Metabox Admin

- [ ] `add_meta_box()` implementado con ID `{PREFIX}_home_content`
- [ ] Título: "Contenido del Home"
- [ ] Contexto: `normal`, prioridad: `high`
- [ ] `wp_nonce_field()` presente
- [ ] Campos por sección: text, textarea, number, url

## Media Frame

- [ ] WordPress Media Frame integrado para selección de imágenes
- [ ] `wp_enqueue_media()` encolado en `admin_enqueue_scripts`
- [ ] Botón "Seleccionar Imagen" funcional
- [ ] Preview de imagen mostrado después de seleccionar
- [ ] `attachment_id` guardado (no URL)

## Repeaters

- [ ] Repeaters dinámicos implementados con JS vanilla
- [ ] Botón "Añadir fila" funcional
- [ ] Botón "Eliminar fila" funcional
- [ ] Re-indexación de `name` después de eliminar
- [ ] Template HTML en `<script type="text/template">`

## Sanitización

- [ ] `save_post` hooked con `add_action('save_post', ...)`
- [ ] Nonce verificado con `wp_verify_nonce()`
- [ ] Autosave verificado con `DOING_AUTOSAVE`
- [ ] Permisos verificados con `current_user_can('edit_page', $post_id)`
- [ ] Texto simple: `sanitize_text_field()`
- [ ] Texto multilínea: `sanitize_textarea_field()`
- [ ] URL: `esc_url_raw()`
- [ ] Número: `absint()` o `intval()`
- [ ] Array de strings: `array_map('sanitize_text_field', ...)`

## CORS

- [ ] Headers CORS configurados para desarrollo
- [ ] Origen `http://localhost:5173` permitido
- [ ] Preflight OPTIONS responde con status 200
- [ ] Headers: Access-Control-Allow-Origin, Methods, Headers, Credentials

## Assets Admin

- [ ] `admin_enqueue_scripts` hooked
- [ ] CSS del metabox encolado
- [ ] JS del metabox encolado
- [ ] Scripts solo en pantalla de edición de páginas
- [ ] `get_current_screen()->id === 'page'` verificado

## Datos Iniciales

- [ ] Datos iniciales poblados desde contenido estático del React
- [ ] Hero: label, headline, subtitle, CTAs, video_url
- [ ] Services: section_label, section_title, array de servicios
- [ ] Surf Info: process, projects, about, stats, closing, footer

## Verificación

- [ ] REST API devuelve meta campos correctamente
- [ ] `curl http://localhost:8882/wp-json/wp/v2/pages?slug={SLUG}` funciona
- [ ] Respuesta JSON incluye campo `meta` con estructura correcta
- [ ] No hay errores PHP (habilitar `WP_DEBUG` si es necesario)