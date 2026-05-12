# Fase 3: WordPress Backend

> **Tiempo estimado:** 4-6 horas  
> **Entregable:** Mu-plugin funcional + metabox admin + plantilla asignada

---

## Objetivo

Crear todo el backend de WordPress: meta campos, metabox visual, sanitización, y exposición REST API.

---

## 3.1 Identificar tema activo

```bash
ls wp-content/themes/
```

**Nota:** Guardar esta ruta en memoria persistente. Se va a usar muchas veces.

## 3.2 Crear plantilla `home-template.php`

Crear archivo en el tema activo:

```php
<?php
/**
 * Template Name: Home Template
 * Template Post Type: page
 */

get_header();
?>

<div style="max-width: 800px; margin: 50px auto; padding: 40px; text-align: center;">
    <h1>{CLIENT} — Home</h1>
    <p>Esta página sirve como fuente de datos para el sitio React.</p>
    <p>Para editar el contenido, usá el metabox "Contenido del Home" en el editor.</p>
</div>

<?php get_footer(); ?>
```

## 3.3 Asignar plantilla a página de inicio

Opción A: Script PHP temporal (recomendado para automatización)

```php
<?php
// Ejecutar via: http://localhost/wp-content/mu-plugins/assign-template.php?run=1
require_once __DIR__ . '/../../wp-load.php';
if (!isset($_GET['run'])) return;

$page_id = 2; // ID de la página de inicio
update_post_meta($page_id, '_wp_page_template', 'home-template.php');

// Auto-eliminar
unlink(__FILE__);
```

Opción B: Manualmente desde el admin de WordPress

## 3.4 Crear mu-plugin base

Crear archivo: `wp-content/mu-plugins/{PREFIX}-home-meta.php`

### Estructura básica

```php
<?php
/**
 * Plugin Name: {CLIENT} Home Meta Fields
 * Description: Meta fields + admin panel for {CLIENT} home page
 * Version: 1.0.0
 * Author: {TU_NOMBRE}
 */

if (!defined('ABSPATH')) exit;

// ============================================================
// REGISTRO DE META CAMPOS
// ============================================================

function {PREFIX}_register_meta_fields(): void {
    $post_type = 'page';
    
    // {PREFIX}_hero
    register_post_meta($post_type, '{PREFIX}_hero', [
        'type'         => 'object',
        'single'       => true,
        'show_in_rest' => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'label'              => ['type' => 'string'],
                    'headline'           => ['type' => 'string'],
                    'subtitle'           => ['type' => 'string'],
                    'cta_primary_text'   => ['type' => 'string'],
                    'cta_primary_url'    => ['type' => 'string'],
                    'cta_secondary_text' => ['type' => 'string'],
                    'cta_secondary_url'  => ['type' => 'string'],
                    'video_url'          => ['type' => 'string'],
                    'image_id'           => ['type' => 'integer'],
                ],
                'additionalProperties' => true,
            ],
        ],
        'sanitize_callback' => '{PREFIX}_sanitize_json',
    ]);
    
    // Más meta campos aquí...
}
add_action('init', '{PREFIX}_register_meta_fields');

function {PREFIX}_sanitize_json($value) {
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
    }
    return $value;
}
```

**Nota importante:** `additionalProperties => true` permite extender el schema sin romper compatibilidad.

### JSON Schema para meta campos complejos

**Array de objetos (ej: services):**
```php
'services' => [
    'type'  => 'array',
    'items' => [
        'type'       => 'object',
        'properties' => [
            'title'       => ['type' => 'string'],
            'description' => ['type' => 'string'],
            'items'       => [
                'type'  => 'array',
                'items' => ['type' => 'string'],
            ],
            'icon'        => ['type' => 'string'],
        ],
        'additionalProperties' => true,
    ],
],
```

## 3.5 Implementar metabox nativo

```php
// ============================================================
// META BOX
// ============================================================

function {PREFIX}_add_home_meta_box(): void {
    add_meta_box(
        '{PREFIX}_home_content',
        __('Contenido del Home', '{PREFIX}'),
        '{PREFIX}_render_home_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', '{PREFIX}_add_home_meta_box');

function {PREFIX}_render_home_meta_box($post): void {
    wp_nonce_field('{PREFIX}_home_meta_box', '{PREFIX}_home_meta_box_nonce');
    
    $hero = get_post_meta($post->ID, '{PREFIX}_hero', true) ?: [];
    // ... más campos
    
    ?>
    <!-- HTML del metabox -->
    <div class="{PREFIX}-meta-box">
        <!-- Sección Hero -->
        <div class="{PREFIX}-section">
            <h3>Hero</h3>
            <label>Label:</label>
            <input type="text" name="{PREFIX}_hero[label]" 
                   value="<?php echo esc_attr($hero['label'] ?? ''); ?>" />
            <!-- Más campos... -->
        </div>
    </div>
    <?php
}
```

## 3.6 WordPress Media Frame

Implementar selección de imágenes nativa:

```html
<div class="{PREFIX}-image-upload">
    <input type="hidden" name="{PREFIX}_hero[image_id]" id="hero-image-id" 
           value="<?php echo esc_attr($hero['image_id'] ?? ''); ?>" />
    
    <div id="hero-image-preview">
        <?php if (!empty($hero['image_id'])): ?
            <?php echo wp_get_attachment_image($hero['image_id'], 'thumbnail'); ?
        <?php endif; ?
    </div>
    
    <button type="button" class="button" id="hero-select-image">
        Seleccionar Imagen
    </button>
    <button type="button" class="button" id="hero-remove-image"
            style="<?php echo empty($hero['image_id']) ? 'display:none;' : ''; ?>">
        Eliminar Imagen
    </button>
</div>
```

JavaScript para Media Frame:

```javascript
var heroFrame;
jQuery(document).on('click', '#hero-select-image', function(e) {
    e.preventDefault();
    
    if (heroFrame) {
        heroFrame.open();
        return;
    }
    
    heroFrame = wp.media({
        title: 'Seleccionar imagen del Hero',
        button: { text: 'Usar esta imagen' },
        multiple: false,
        library: { type: 'image' }
    });
    
    heroFrame.on('select', function() {
        var attachment = heroFrame.state().get('selection').first().toJSON();
        jQuery('#hero-image-id').val(attachment.id);
        jQuery('#hero-image-preview').html(
            '<img src="' + attachment.sizes.thumbnail.url + '" alt="" />'
        );
        jQuery('#hero-remove-image').show();
    });
    
    heroFrame.open();
});
```

**Importante:** Encolar `wp_enqueue_media()` antes del script del metabox.

## 3.7 Repeaters dinámicos con JS

Template HTML para una fila de repeater:

```html
<script type="text/template" id="template-services">
<div class="{PREFIX}-repeater-item" data-index="{index}">
    <input type="text" name="{PREFIX}_rooms[services][{index}][title]" />
    <textarea name="{PREFIX}_rooms[services][{index}][description]"></textarea>
    <button type="button" class="button {PREFIX}-remove-item">
        Eliminar
    </button>
</div>
</script>
```

JavaScript para manejar repeaters:

```javascript
jQuery(document).on('click', '.{PREFIX}-add-item', function() {
    var template = jQuery(this).data('template');
    var container = jQuery(this).siblings('.{PREFIX}-repeater-items');
    var index = container.find('.{PREFIX}-repeater-item').length;
    
    var html = jQuery('#template-' + template).html();
    html = html.replace(/{index}/g, index);
    container.append(html);
});

jQuery(document).on('click', '.{PREFIX}-remove-item', function() {
    var item = jQuery(this).closest('.{PREFIX}-repeater-item');
    var container = item.closest('.{PREFIX}-repeater-items');
    item.remove();
    reindexItems(container);
});

function reindexItems(container) {
    container.find('.{PREFIX}-repeater-item').each(function(index) {
        jQuery(this).attr('data-index', index);
        jQuery(this).find('input, textarea, select').each(function() {
            var name = jQuery(this).attr('name');
            if (name) {
                jQuery(this).attr('name', 
                    name.replace(/\[\d+\]/g, '[' + index + ']')
                );
            }
        });
    });
}
```

## 3.8 Sanitización en save_post

```php
function {PREFIX}_save_home_meta_box($post_id): void {
    // Verificar nonce
    if (!isset($_POST['{PREFIX}_home_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['{PREFIX}_home_meta_box_nonce'], '{PREFIX}_home_meta_box')) {
        return;
    }
    
    // Verificar autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    // Verificar permisos
    if (!current_user_can('edit_page', $post_id)) return;
    
    // Guardar Hero
    if (isset($_POST['{PREFIX}_hero'])) {
        $hero = $_POST['{PREFIX}_hero'];
        $sanitized = [
            'label'              => sanitize_text_field($hero['label'] ?? ''),
            'headline'           => sanitize_text_field($hero['headline'] ?? ''),
            'subtitle'           => sanitize_text_field($hero['subtitle'] ?? ''),
            'cta_primary_text'   => sanitize_text_field($hero['cta_primary_text'] ?? ''),
            'cta_primary_url'    => esc_url_raw($hero['cta_primary_url'] ?? ''),
            'cta_secondary_text' => sanitize_text_field($hero['cta_secondary_text'] ?? ''),
            'cta_secondary_url'  => esc_url_raw($hero['cta_secondary_url'] ?? ''),
            'video_url'          => esc_url_raw($hero['video_url'] ?? ''),
            'image_id'           => absint($hero['image_id'] ?? 0),
        ];
        update_post_meta($post_id, '{PREFIX}_hero', $sanitized);
    }
    
    // Más campos...
}
add_action('save_post', '{PREFIX}_save_home_meta_box');
```

### Tabla de sanitización

| Tipo de dato | Función de sanitización | Uso |
|--------------|------------------------|-----|
| Texto simple | `sanitize_text_field()` | Títulos, labels, nombres |
| Texto multilínea | `sanitize_textarea_field()` | Descripciones, párrafos |
| URL | `esc_url_raw()` | Links, videos, imágenes |
| Número entero | `absint()` | IDs, valores de stats |
| HTML básico | `wp_kses_post()` | Contenido con formato (opcional) |
| Array de strings | `array_map('sanitize_text_field', ...)` | Listas simples |

## 3.9 CORS para desarrollo

```php
function {PREFIX}_configure_cors(): void {
    $allowed_origins = [
        'http://localhost:5173',
        'https://localhost:5173',
        'http://127.0.0.1:5173',
        'https://127.0.0.1:5173',
    ];
    
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    if (in_array($origin, $allowed_origins, true)) {
        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-WP-Nonce');
        header('Access-Control-Allow-Credentials: true');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit;
    }
}
add_action('init', '{PREFIX}_configure_cors', 1);
add_action('rest_api_init', '{PREFIX}_configure_cors', 1);
```

## 3.10 Encolar assets del admin

```php
function {PREFIX}_enqueue_admin_assets($hook): void {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') return;
    
    wp_enqueue_media();
    wp_enqueue_style('{PREFIX}-admin-meta', plugins_url('admin-meta.css', __FILE__), [], '1.0.0');
    wp_enqueue_script('{PREFIX}-admin-meta', plugins_url('admin-meta.js', __FILE__), ['jquery'], '1.0.0', true);
}
add_action('admin_enqueue_scripts', '{PREFIX}_enqueue_admin_assets');
```

---

## Checklist Fase 3

- [ ] Tema activo identificado
- [ ] `home-template.php` creado
- [ ] Plantilla asignada a página de inicio
- [ ] Mu-plugin creado en `wp-content/mu-plugins/`
- [ ] Meta campos registrados con `register_post_meta`
- [ ] JSON Schema definido para cada campo
- [ ] `show_in_rest => true` configurado
- [ ] Metabox "Contenido del Home" implementado
- [ ] WordPress Media Frame integrado
- [ ] Repeaters dinámicos funcionando
- [ ] `save_post` con sanitización completa
- [ ] CORS configurado para desarrollo
- [ ] Assets encolados en el admin
- [ ] CSS básico para el metabox
- [ ] Datos iniciales poblados
- [ ] REST API devuelve datos correctos

---

## Errores comunes

**Error:** Meta campos no aparecen en REST API
- **Causa:** Olvidar `show_in_rest => true`
- **Solución:** Agregar `show_in_rest` con schema en `register_post_meta`

**Error:** Media Frame no abre
- **Causa:** No encolar `wp_enqueue_media()`
- **Solución:** Llamar `wp_enqueue_media()` en `admin_enqueue_scripts`

**Error:** Datos se guardan como string en vez de array
- **Causa:** JSON no se decodifica al leer
- **Solución:** Usar `sanitize_callback` con `json_decode`

**Error:** CORS bloquea peticiones del frontend
- **Causa:** WordPress no acepta origen del dev server
- **Solución:** Headers CORS en el mu-plugin

---

## Verificación

```bash
# Verificar que los meta campos están en la REST API
curl http://localhost:8882/wp-json/wp/v2/pages/2 | jq '.meta'

# Debería mostrar:
# {
#   "{PREFIX}_hero": { ... },
#   "{PREFIX}_rooms": { ... },
#   "{PREFIX}_surf_info": { ... }
# }
```
