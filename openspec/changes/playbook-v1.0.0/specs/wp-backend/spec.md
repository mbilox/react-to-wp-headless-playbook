## ADDED Requirements

### Requirement: Mu-plugin funcional
El sistema SHALL crear un mu-plugin que registre meta campos, exponga REST API, e implemente un metabox admin nativo.

#### Scenario: Registro de meta campos
- **WHEN** se ejecuta la fase 3
- **THEN** el mu-plugin MUST registrar 3 meta campos (`{PREFIX}_hero`, `{PREFIX}_rooms`, `{PREFIX}_surf_info`) usando `register_post_meta()`
- **AND** cada campo MUST tener `show_in_rest => true` con JSON Schema estricto

#### Scenario: Plantilla Home Template
- **WHEN** se configura WordPress
- **THEN** el sistema MUST crear `home-template.php` en el tema activo
- **AND** asignarla a la página de inicio

#### Scenario: Metabox nativo
- **WHEN** se edita la página con Home Template
- **THEN** el metabox "Contenido del Home" MUST aparecer debajo del editor
- **AND** MUST tener campos por sección con inputs, textareas, selects

#### Scenario: WordPress Media Frame
- **WHEN** el usuario necesita seleccionar una imagen
- **THEN** el sistema MUST integrar `wp.media` (Media Frame nativo)
- **AND** guardar el `attachment_id` (no la URL)

#### Scenario: Repeaters dinámicos
- **WHEN** el usuario necesita agregar filas a una lista (servicios, pasos, etc.)
- **THEN** el sistema MUST permitir añadir/eliminar filas sin recargar
- **AND** re-indexar los `name` de los inputs después de eliminar

#### Scenario: Sanitización completa
- **WHEN** se guarda la página
- **THEN** el sistema MUST sanitizar todos los campos:
  - Texto simple: `sanitize_text_field()`
  - Texto multilínea: `sanitize_textarea_field()`
  - URL: `esc_url_raw()`
  - Número: `absint()`
  - Array: `array_map('sanitize_text_field', ...)`

#### Scenario: CORS para desarrollo
- **WHEN** el frontend en desarrollo hace peticiones a WordPress
- **THEN** el sistema MUST permitir origen `http://localhost:5173` (puerto de Vite)
- **AND** responder a preflight OPTIONS con status 200

## Validation Rules

- [ ] Meta campos registrados con `register_post_meta`
- [ ] JSON Schema definido para cada campo con `additionalProperties: true`
- [ ] `show_in_rest => true` configurado
- [ ] Plantilla `home-template.php` creada y asignada
- [ ] Metabox aparece en página con Home Template
- [ ] Media Frame funciona para selección de imágenes
- [ ] Repeaters permiten añadir/eliminar filas
- [ ] `save_post` con sanitización completa
- [ ] Headers CORS configurados para desarrollo
- [ ] REST API devuelve meta campos correctamente

## Templates

- **Archivo:** `TEMPLATES/mu-plugin-template.php`
- **Plantilla:** `TEMPLATES/home-template.php`
- **CSS metabox:** `TEMPLATES/admin-metabox.css`
- **JS metabox:** `TEMPLATES/admin-metabox.js`
- **Ejemplo completo:** Ver `STARTERS/wp-mu-plugin/wetheme-home-meta.php`