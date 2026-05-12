<?php
/**
 * Plugin Name: WE Theme Home Meta Fields
 * Description: Registra meta campos personalizados para la página de inicio con esquema JSON estricto, exposición REST API y panel de administración nativo.
 * Version: 2.0.0
 * Author: WE Digital
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================================
// REGISTRO DE META CAMPOS
// ============================================================

function wetheme_register_home_meta_fields(): void
{
    $post_type = 'page';

    // wetheme_hero
    register_post_meta($post_type, 'wetheme_hero', [
        'type'              => 'object',
        'single'            => true,
        'show_in_rest'      => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'label'             => ['type' => 'string'],
                    'headline'          => ['type' => 'string'],
                    'subtitle'          => ['type' => 'string'],
                    'cta_primary_text'  => ['type' => 'string'],
                    'cta_primary_url'   => ['type' => 'string'],
                    'cta_secondary_text'=> ['type' => 'string'],
                    'cta_secondary_url' => ['type' => 'string'],
                    'video_url'         => ['type' => 'string'],
                    'image_id'          => ['type' => 'integer'],
                ],
                'additionalProperties' => true,
            ],
        ],
        'sanitize_callback' => 'wetheme_sanitize_json_meta',
    ]);

    // wetheme_rooms
    register_post_meta($post_type, 'wetheme_rooms', [
        'type'              => 'object',
        'single'            => true,
        'show_in_rest'      => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'section_label' => ['type' => 'string'],
                    'section_title' => ['type' => 'string'],
                    'services'      => [
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
                ],
                'additionalProperties' => true,
            ],
        ],
        'sanitize_callback' => 'wetheme_sanitize_json_meta',
    ]);

    // wetheme_surf_info
    register_post_meta($post_type, 'wetheme_surf_info', [
        'type'              => 'object',
        'single'            => true,
        'show_in_rest'      => [
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'process_label'  => ['type' => 'string'],
                    'process_title'  => ['type' => 'string'],
                    'steps'          => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'number'      => ['type' => 'string'],
                                'title'       => ['type' => 'string'],
                                'description' => ['type' => 'string'],
                            ],
                            'additionalProperties' => true,
                        ],
                    ],
                    'projects_label' => ['type' => 'string'],
                    'projects_title' => ['type' => 'string'],
                    'projects'       => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'client'      => ['type' => 'string'],
                                'stat'        => ['type' => 'string'],
                                'statLabel'   => ['type' => 'string'],
                                'description' => ['type' => 'string'],
                                'subStat'     => ['type' => 'string'],
                                'services'    => [
                                    'type'  => 'array',
                                    'items' => ['type' => 'string'],
                                ],
                            ],
                            'additionalProperties' => true,
                        ],
                    ],
                    'about_label'       => ['type' => 'string'],
                    'about_title'       => ['type' => 'string'],
                    'about_paragraphs'  => [
                        'type'  => 'array',
                        'items' => ['type' => 'string'],
                    ],
                    'stats'             => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'value'  => ['type' => 'integer'],
                                'prefix' => ['type' => 'string'],
                                'suffix' => ['type' => 'string'],
                                'label'  => ['type' => 'string'],
                            ],
                            'additionalProperties' => true,
                        ],
                    ],
                    'closing_headline'  => ['type' => 'string'],
                    'closing_cta_text'  => ['type' => 'string'],
                    'closing_cta_url'   => ['type' => 'string'],
                    'footer_tagline'    => ['type' => 'string'],
                    'footer_solutions'  => [
                        'type'  => 'array',
                        'items' => ['type' => 'string'],
                    ],
                    'footer_empresa'    => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'label' => ['type' => 'string'],
                                'href'  => ['type' => 'string'],
                            ],
                            'additionalProperties' => true,
                        ],
                    ],
                    'footer_cta_text'   => ['type' => 'string'],
                    'footer_social'     => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'label' => ['type' => 'string'],
                                'url'   => ['type' => 'string'],
                            ],
                            'additionalProperties' => true,
                        ],
                    ],
                ],
                'additionalProperties' => true,
            ],
        ],
        'sanitize_callback' => 'wetheme_sanitize_json_meta',
    ]);
}
add_action('init', 'wetheme_register_home_meta_fields');

/**
 * Sanitiza meta valores JSON.
 */
function wetheme_sanitize_json_meta($value)
{
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
    }
    return $value;
}

// ============================================================
// META BOX DE ADMINISTRACIÓN
// ============================================================

/**
 * Agrega el metabox "Contenido del Home" al editor de páginas.
 */
function wetheme_add_home_meta_box(): void
{
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') {
        return;
    }

    add_meta_box(
        'wetheme_home_content',
        __('Contenido del Home', 'wetheme'),
        'wetheme_render_home_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'wetheme_add_home_meta_box');

/**
 * Renderiza el contenido del metabox.
 */
function wetheme_render_home_meta_box($post): void
{
    wp_nonce_field('wetheme_home_meta_box', 'wetheme_home_meta_box_nonce');

    $hero = get_post_meta($post->ID, 'wetheme_hero', true) ?: [];
    $rooms = get_post_meta($post->ID, 'wetheme_rooms', true) ?: [];
    $surf = get_post_meta($post->ID, 'wetheme_surf_info', true) ?: [];

    // Asegurar que sean arrays
    if (!is_array($hero)) $hero = [];
    if (!is_array($rooms)) $rooms = [];
    if (!is_array($surf)) $surf = [];

    ?>
    <div class="wetheme-meta-box-wrapper">
        <!-- Sección: Hero -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Hero</h3>
            <div class="wetheme-field">
                <label>Label:</label>
                <input type="text" name="wetheme_hero[label]" value="<?php echo esc_attr($hero['label'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Headline:</label>
                <input type="text" name="wetheme_hero[headline]" value="<?php echo esc_attr($hero['headline'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Subtitle:</label>
                <input type="text" name="wetheme_hero[subtitle]" value="<?php echo esc_attr($hero['subtitle'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA Primario (Texto):</label>
                <input type="text" name="wetheme_hero[cta_primary_text]" value="<?php echo esc_attr($hero['cta_primary_text'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA Primario (URL):</label>
                <input type="text" name="wetheme_hero[cta_primary_url]" value="<?php echo esc_attr($hero['cta_primary_url'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA Secundario (Texto):</label>
                <input type="text" name="wetheme_hero[cta_secondary_text]" value="<?php echo esc_attr($hero['cta_secondary_text'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA Secundario (URL):</label>
                <input type="text" name="wetheme_hero[cta_secondary_url]" value="<?php echo esc_attr($hero['cta_secondary_url'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Video URL:</label>
                <input type="text" name="wetheme_hero[video_url]" value="<?php echo esc_attr($hero['video_url'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Imagen del Hero:</label>
                <div class="wetheme-image-upload">
                    <input type="hidden" name="wetheme_hero[image_id]" id="hero-image-id" value="<?php echo esc_attr($hero['image_id'] ?? ''); ?>" />
                    <div id="hero-image-preview" class="wetheme-image-preview">
                        <?php if (!empty($hero['image_id'])): ?>
                            <?php echo wp_get_attachment_image($hero['image_id'], 'thumbnail'); ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button" id="hero-select-image">Seleccionar Imagen</button>
                    <button type="button" class="button" id="hero-remove-image" style="<?php echo empty($hero['image_id']) ? 'display:none;' : ''; ?>">Eliminar Imagen</button>
                </div>
            </div>
        </div>

        <!-- Sección: Services -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Services</h3>
            <div class="wetheme-field">
                <label>Label de Sección:</label>
                <input type="text" name="wetheme_rooms[section_label]" value="<?php echo esc_attr($rooms['section_label'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Título de Sección:</label>
                <input type="text" name="wetheme_rooms[section_title]" value="<?php echo esc_attr($rooms['section_title'] ?? ''); ?>" />
            </div>

            <div class="wetheme-repeater" data-repeater="services">
                <h4>Servicios</h4>
                <div class="wetheme-repeater-items" id="services-container">
                    <?php
                    $services = $rooms['services'] ?? [];
                    foreach ($services as $index => $service):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field">
                            <label>Título:</label>
                            <input type="text" name="wetheme_rooms[services][<?php echo $index; ?>][title]" value="<?php echo esc_attr($service['title'] ?? ''); ?>" />
                        </div>
                        <div class="wetheme-field">
                            <label>Descripción:</label>
                            <textarea name="wetheme_rooms[services][<?php echo $index; ?>][description]" rows="3"><?php echo esc_textarea($service['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="wetheme-field">
                            <label>Ícono:</label>
                            <select name="wetheme_rooms[services][<?php echo $index; ?>][icon]">
                                <option value="branding" <?php selected(($service['icon'] ?? ''), 'branding'); ?>>Branding</option>
                                <option value="platforms" <?php selected(($service['icon'] ?? ''), 'platforms'); ?>>Plataformas</option>
                                <option value="growth" <?php selected(($service['icon'] ?? ''), 'growth'); ?>>Growth</option>
                                <option value="ai" <?php selected(($service['icon'] ?? ''), 'ai'); ?>>IA</option>
                            </select>
                        </div>
                        <div class="wetheme-field">
                            <label>Items (uno por línea):</label>
                            <textarea name="wetheme_rooms[services][<?php echo $index; ?>][items]" rows="4"><?php 
                                if (!empty($service['items']) && is_array($service['items'])) {
                                    echo esc_textarea(implode("\n", $service['items']));
                                }
                            ?></textarea>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar Servicio</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="services">Añadir Servicio</button>
            </div>
        </div>

        <!-- Sección: Stats -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Estadísticas (Stats)</h3>
            <div class="wetheme-repeater" data-repeater="stats">
                <div class="wetheme-repeater-items" id="stats-container">
                    <?php
                    $stats = $surf['stats'] ?? [];
                    foreach ($stats as $index => $stat):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field-row">
                            <div class="wetheme-field">
                                <label>Prefijo:</label>
                                <input type="text" name="wetheme_surf_info[stats][<?php echo $index; ?>][prefix]" value="<?php echo esc_attr($stat['prefix'] ?? ''); ?>" class="small" />
                            </div>
                            <div class="wetheme-field">
                                <label>Valor:</label>
                                <input type="number" name="wetheme_surf_info[stats][<?php echo $index; ?>][value]" value="<?php echo esc_attr($stat['value'] ?? ''); ?>" class="small" />
                            </div>
                            <div class="wetheme-field">
                                <label>Sufijo:</label>
                                <input type="text" name="wetheme_surf_info[stats][<?php echo $index; ?>][suffix]" value="<?php echo esc_attr($stat['suffix'] ?? ''); ?>" class="small" />
                            </div>
                        </div>
                        <div class="wetheme-field">
                            <label>Label:</label>
                            <input type="text" name="wetheme_surf_info[stats][<?php echo $index; ?>][label]" value="<?php echo esc_attr($stat['label'] ?? ''); ?>" />
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar Stat</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="stats">Añadir Stat</button>
            </div>
        </div>

        <!-- Sección: Process -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Proceso</h3>
            <div class="wetheme-field">
                <label>Label de Sección:</label>
                <input type="text" name="wetheme_surf_info[process_label]" value="<?php echo esc_attr($surf['process_label'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Título de Sección:</label>
                <input type="text" name="wetheme_surf_info[process_title]" value="<?php echo esc_attr($surf['process_title'] ?? ''); ?>" />
            </div>

            <div class="wetheme-repeater" data-repeater="steps">
                <h4>Pasos</h4>
                <div class="wetheme-repeater-items" id="steps-container">
                    <?php
                    $steps = $surf['steps'] ?? [];
                    foreach ($steps as $index => $step):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field">
                            <label>Número:</label>
                            <input type="text" name="wetheme_surf_info[steps][<?php echo $index; ?>][number]" value="<?php echo esc_attr($step['number'] ?? ''); ?>" class="small" />
                        </div>
                        <div class="wetheme-field">
                            <label>Título:</label>
                            <input type="text" name="wetheme_surf_info[steps][<?php echo $index; ?>][title]" value="<?php echo esc_attr($step['title'] ?? ''); ?>" />
                        </div>
                        <div class="wetheme-field">
                            <label>Descripción:</label>
                            <textarea name="wetheme_surf_info[steps][<?php echo $index; ?>][description]" rows="3"><?php echo esc_textarea($step['description'] ?? ''); ?></textarea>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar Paso</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="steps">Añadir Paso</button>
            </div>
        </div>

        <!-- Sección: Projects -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Proyectos</h3>
            <div class="wetheme-field">
                <label>Label de Sección:</label>
                <input type="text" name="wetheme_surf_info[projects_label]" value="<?php echo esc_attr($surf['projects_label'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Título de Sección:</label>
                <input type="text" name="wetheme_surf_info[projects_title]" value="<?php echo esc_attr($surf['projects_title'] ?? ''); ?>" />
            </div>

            <div class="wetheme-repeater" data-repeater="projects">
                <h4>Proyectos</h4>
                <div class="wetheme-repeater-items" id="projects-container">
                    <?php
                    $projects = $surf['projects'] ?? [];
                    foreach ($projects as $index => $project):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field">
                            <label>Cliente:</label>
                            <input type="text" name="wetheme_surf_info[projects][<?php echo $index; ?>][client]" value="<?php echo esc_attr($project['client'] ?? ''); ?>" />
                        </div>
                        <div class="wetheme-field-row">
                            <div class="wetheme-field">
                                <label>Stat:</label>
                                <input type="text" name="wetheme_surf_info[projects][<?php echo $index; ?>][stat]" value="<?php echo esc_attr($project['stat'] ?? ''); ?>" class="small" />
                            </div>
                            <div class="wetheme-field">
                                <label>Stat Label:</label>
                                <input type="text" name="wetheme_surf_info[projects][<?php echo $index; ?>][statLabel]" value="<?php echo esc_attr($project['statLabel'] ?? ''); ?>" />
                            </div>
                        </div>
                        <div class="wetheme-field">
                            <label>Descripción:</label>
                            <textarea name="wetheme_surf_info[projects][<?php echo $index; ?>][description]" rows="3"><?php echo esc_textarea($project['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="wetheme-field">
                            <label>Sub-stat:</label>
                            <input type="text" name="wetheme_surf_info[projects][<?php echo $index; ?>][subStat]" value="<?php echo esc_attr($project['subStat'] ?? ''); ?>" />
                        </div>
                        <div class="wetheme-field">
                            <label>Servicios (uno por línea):</label>
                            <textarea name="wetheme_surf_info[projects][<?php echo $index; ?>][services]" rows="3"><?php 
                                if (!empty($project['services']) && is_array($project['services'])) {
                                    echo esc_textarea(implode("\n", $project['services']));
                                }
                            ?></textarea>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar Proyecto</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="projects">Añadir Proyecto</button>
            </div>
        </div>

        <!-- Sección: About -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Nosotros (About)</h3>
            <div class="wetheme-field">
                <label>Label de Sección:</label>
                <input type="text" name="wetheme_surf_info[about_label]" value="<?php echo esc_attr($surf['about_label'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>Título de Sección:</label>
                <input type="text" name="wetheme_surf_info[about_title]" value="<?php echo esc_attr($surf['about_title'] ?? ''); ?>" />
            </div>

            <div class="wetheme-repeater" data-repeater="about_paragraphs">
                <h4>Párrafos</h4>
                <div class="wetheme-repeater-items" id="paragraphs-container">
                    <?php
                    $paragraphs = $surf['about_paragraphs'] ?? [];
                    foreach ($paragraphs as $index => $paragraph):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field">
                            <textarea name="wetheme_surf_info[about_paragraphs][<?php echo $index; ?>]" rows="4"><?php echo esc_textarea($paragraph); ?></textarea>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar Párrafo</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="paragraphs">Añadir Párrafo</button>
            </div>
        </div>

        <!-- Sección: Closing -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Closing</h3>
            <div class="wetheme-field">
                <label>Headline:</label>
                <textarea name="wetheme_surf_info[closing_headline]" rows="3"><?php echo esc_textarea($surf['closing_headline'] ?? ''); ?></textarea>
            </div>
            <div class="wetheme-field">
                <label>CTA Texto:</label>
                <input type="text" name="wetheme_surf_info[closing_cta_text]" value="<?php echo esc_attr($surf['closing_cta_text'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA URL:</label>
                <input type="text" name="wetheme_surf_info[closing_cta_url]" value="<?php echo esc_attr($surf['closing_cta_url'] ?? ''); ?>" />
            </div>
        </div>

        <!-- Sección: Footer -->
        <div class="wetheme-section">
            <h3 class="wetheme-section-title">Footer</h3>
            <div class="wetheme-field">
                <label>Tagline:</label>
                <input type="text" name="wetheme_surf_info[footer_tagline]" value="<?php echo esc_attr($surf['footer_tagline'] ?? ''); ?>" />
            </div>
            <div class="wetheme-field">
                <label>CTA Texto:</label>
                <input type="text" name="wetheme_surf_info[footer_cta_text]" value="<?php echo esc_attr($surf['footer_cta_text'] ?? ''); ?>" />
            </div>

            <div class="wetheme-repeater" data-repeater="footer_solutions">
                <h4>Soluciones</h4>
                <div class="wetheme-repeater-items" id="footer-solutions-container">
                    <?php
                    $solutions = $surf['footer_solutions'] ?? [];
                    foreach ($solutions as $index => $solution):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field">
                            <input type="text" name="wetheme_surf_info[footer_solutions][<?php echo $index; ?>]" value="<?php echo esc_attr($solution); ?>" />
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="footer_solutions">Añadir Solución</button>
            </div>

            <div class="wetheme-repeater" data-repeater="footer_empresa">
                <h4>Empresa (Enlaces)</h4>
                <div class="wetheme-repeater-items" id="footer-empresa-container">
                    <?php
                    $empresa = $surf['footer_empresa'] ?? [];
                    foreach ($empresa as $index => $item):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field-row">
                            <div class="wetheme-field">
                                <label>Label:</label>
                                <input type="text" name="wetheme_surf_info[footer_empresa][<?php echo $index; ?>][label]" value="<?php echo esc_attr($item['label'] ?? ''); ?>" />
                            </div>
                            <div class="wetheme-field">
                                <label>URL:</label>
                                <input type="text" name="wetheme_surf_info[footer_empresa][<?php echo $index; ?>][href]" value="<?php echo esc_attr($item['href'] ?? ''); ?>" />
                            </div>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="footer_empresa">Añadir Enlace</button>
            </div>

            <div class="wetheme-repeater" data-repeater="footer_social">
                <h4>Redes Sociales</h4>
                <div class="wetheme-repeater-items" id="footer-social-container">
                    <?php
                    $social = $surf['footer_social'] ?? [];
                    foreach ($social as $index => $item):
                    ?>
                    <div class="wetheme-repeater-item" data-index="<?php echo $index; ?>">
                        <div class="wetheme-field-row">
                            <div class="wetheme-field">
                                <label>Label:</label>
                                <input type="text" name="wetheme_surf_info[footer_social][<?php echo $index; ?>][label]" value="<?php echo esc_attr($item['label'] ?? ''); ?>" />
                            </div>
                            <div class="wetheme-field">
                                <label>URL:</label>
                                <input type="text" name="wetheme_surf_info[footer_social][<?php echo $index; ?>][url]" value="<?php echo esc_attr($item['url'] ?? ''); ?>" />
                            </div>
                        </div>
                        <button type="button" class="button wetheme-remove-item">Eliminar</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button wetheme-add-item" data-template="footer_social">Añadir Red Social</button>
            </div>
        </div>
    </div>

    <script type="text/template" id="template-services">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field">
            <label>Título:</label>
            <input type="text" name="wetheme_rooms[services][{index}][title]" value="" />
        </div>
        <div class="wetheme-field">
            <label>Descripción:</label>
            <textarea name="wetheme_rooms[services][{index}][description]" rows="3"></textarea>
        </div>
        <div class="wetheme-field">
            <label>Ícono:</label>
            <select name="wetheme_rooms[services][{index}][icon]">
                <option value="branding">Branding</option>
                <option value="platforms">Plataformas</option>
                <option value="growth">Growth</option>
                <option value="ai">IA</option>
            </select>
        </div>
        <div class="wetheme-field">
            <label>Items (uno por línea):</label>
            <textarea name="wetheme_rooms[services][{index}][items]" rows="4"></textarea>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar Servicio</button>
    </div>
    </script>

    <script type="text/template" id="template-stats">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field-row">
            <div class="wetheme-field">
                <label>Prefijo:</label>
                <input type="text" name="wetheme_surf_info[stats][{index}][prefix]" value="" class="small" />
            </div>
            <div class="wetheme-field">
                <label>Valor:</label>
                <input type="number" name="wetheme_surf_info[stats][{index}][value]" value="" class="small" />
            </div>
            <div class="wetheme-field">
                <label>Sufijo:</label>
                <input type="text" name="wetheme_surf_info[stats][{index}][suffix]" value="" class="small" />
            </div>
        </div>
        <div class="wetheme-field">
            <label>Label:</label>
            <input type="text" name="wetheme_surf_info[stats][{index}][label]" value="" />
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar Stat</button>
    </div>
    </script>

    <script type="text/template" id="template-steps">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field">
            <label>Número:</label>
            <input type="text" name="wetheme_surf_info[steps][{index}][number]" value="" class="small" />
        </div>
        <div class="wetheme-field">
            <label>Título:</label>
            <input type="text" name="wetheme_surf_info[steps][{index}][title]" value="" />
        </div>
        <div class="wetheme-field">
            <label>Descripción:</label>
            <textarea name="wetheme_surf_info[steps][{index}][description]" rows="3"></textarea>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar Paso</button>
    </div>
    </script>

    <script type="text/template" id="template-projects">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field">
            <label>Cliente:</label>
            <input type="text" name="wetheme_surf_info[projects][{index}][client]" value="" />
        </div>
        <div class="wetheme-field-row">
            <div class="wetheme-field">
                <label>Stat:</label>
                <input type="text" name="wetheme_surf_info[projects][{index}][stat]" value="" class="small" />
            </div>
            <div class="wetheme-field">
                <label>Stat Label:</label>
                <input type="text" name="wetheme_surf_info[projects][{index}][statLabel]" value="" />
            </div>
        </div>
        <div class="wetheme-field">
            <label>Descripción:</label>
            <textarea name="wetheme_surf_info[projects][{index}][description]" rows="3"></textarea>
        </div>
        <div class="wetheme-field">
            <label>Sub-stat:</label>
            <input type="text" name="wetheme_surf_info[projects][{index}][subStat]" value="" />
        </div>
        <div class="wetheme-field">
            <label>Servicios (uno por línea):</label>
            <textarea name="wetheme_surf_info[projects][{index}][services]" rows="3"></textarea>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar Proyecto</button>
    </div>
    </script>

    <script type="text/template" id="template-paragraphs">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field">
            <textarea name="wetheme_surf_info[about_paragraphs][{index}]" rows="4"></textarea>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar Párrafo</button>
    </div>
    </script>

    <script type="text/template" id="template-footer_solutions">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field">
            <input type="text" name="wetheme_surf_info[footer_solutions][{index}]" value="" />
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar</button>
    </div>
    </script>

    <script type="text/template" id="template-footer_empresa">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field-row">
            <div class="wetheme-field">
                <label>Label:</label>
                <input type="text" name="wetheme_surf_info[footer_empresa][{index}][label]" value="" />
            </div>
            <div class="wetheme-field">
                <label>URL:</label>
                <input type="text" name="wetheme_surf_info[footer_empresa][{index}][href]" value="" />
            </div>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar</button>
    </div>
    </script>

    <script type="text/template" id="template-footer_social">
    <div class="wetheme-repeater-item" data-index="{index}">
        <div class="wetheme-field-row">
            <div class="wetheme-field">
                <label>Label:</label>
                <input type="text" name="wetheme_surf_info[footer_social][{index}][label]" value="" />
            </div>
            <div class="wetheme-field">
                <label>URL:</label>
                <input type="text" name="wetheme_surf_info[footer_social][{index}][url]" value="" />
            </div>
        </div>
        <button type="button" class="button wetheme-remove-item">Eliminar</button>
    </div>
    </script>
    <?php
}

// ============================================================
// GUARDADO DE DATOS
// ============================================================

/**
 * Guarda los datos del metabox.
 */
function wetheme_save_home_meta_box($post_id): void
{
    // Verificar nonce
    if (!isset($_POST['wetheme_home_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['wetheme_home_meta_box_nonce'], 'wetheme_home_meta_box')) {
        return;
    }

    // Verificar autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verificar permisos
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Guardar Hero
    if (isset($_POST['wetheme_hero'])) {
        $hero = $_POST['wetheme_hero'];
        $hero_sanitized = [
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
        update_post_meta($post_id, 'wetheme_hero', $hero_sanitized);
    }

    // Guardar Rooms (Services)
    if (isset($_POST['wetheme_rooms'])) {
        $rooms = $_POST['wetheme_rooms'];
        $rooms_sanitized = [
            'section_label' => sanitize_text_field($rooms['section_label'] ?? ''),
            'section_title' => sanitize_text_field($rooms['section_title'] ?? ''),
        ];

        if (!empty($rooms['services']) && is_array($rooms['services'])) {
            foreach ($rooms['services'] as $index => $service) {
                $rooms_sanitized['services'][] = [
                    'title'       => sanitize_text_field($service['title'] ?? ''),
                    'description' => sanitize_textarea_field($service['description'] ?? ''),
                    'icon'        => sanitize_text_field($service['icon'] ?? ''),
                    'items'       => !empty($service['items']) ? array_map('sanitize_text_field', explode("\n", $service['items'])) : [],
                ];
            }
        }

        update_post_meta($post_id, 'wetheme_rooms', $rooms_sanitized);
    }

    // Guardar Surf Info
    if (isset($_POST['wetheme_surf_info'])) {
        $surf = $_POST['wetheme_surf_info'];
        $surf_sanitized = [
            'process_label'    => sanitize_text_field($surf['process_label'] ?? ''),
            'process_title'    => sanitize_text_field($surf['process_title'] ?? ''),
            'projects_label'   => sanitize_text_field($surf['projects_label'] ?? ''),
            'projects_title'   => sanitize_text_field($surf['projects_title'] ?? ''),
            'about_label'      => sanitize_text_field($surf['about_label'] ?? ''),
            'about_title'      => sanitize_text_field($surf['about_title'] ?? ''),
            'closing_headline' => sanitize_textarea_field($surf['closing_headline'] ?? ''),
            'closing_cta_text' => sanitize_text_field($surf['closing_cta_text'] ?? ''),
            'closing_cta_url'  => esc_url_raw($surf['closing_cta_url'] ?? ''),
            'footer_tagline'   => sanitize_text_field($surf['footer_tagline'] ?? ''),
            'footer_cta_text'  => sanitize_text_field($surf['footer_cta_text'] ?? ''),
        ];

        // Steps
        if (!empty($surf['steps']) && is_array($surf['steps'])) {
            foreach ($surf['steps'] as $step) {
                $surf_sanitized['steps'][] = [
                    'number'      => sanitize_text_field($step['number'] ?? ''),
                    'title'       => sanitize_text_field($step['title'] ?? ''),
                    'description' => sanitize_textarea_field($step['description'] ?? ''),
                ];
            }
        }

        // Projects
        if (!empty($surf['projects']) && is_array($surf['projects'])) {
            foreach ($surf['projects'] as $project) {
                $surf_sanitized['projects'][] = [
                    'client'      => sanitize_text_field($project['client'] ?? ''),
                    'stat'        => sanitize_text_field($project['stat'] ?? ''),
                    'statLabel'   => sanitize_text_field($project['statLabel'] ?? ''),
                    'description' => sanitize_textarea_field($project['description'] ?? ''),
                    'subStat'     => sanitize_text_field($project['subStat'] ?? ''),
                    'services'    => !empty($project['services']) ? array_map('sanitize_text_field', explode("\n", $project['services'])) : [],
                ];
            }
        }

        // Stats
        if (!empty($surf['stats']) && is_array($surf['stats'])) {
            foreach ($surf['stats'] as $stat) {
                $surf_sanitized['stats'][] = [
                    'value'  => absint($stat['value'] ?? 0),
                    'prefix' => sanitize_text_field($stat['prefix'] ?? ''),
                    'suffix' => sanitize_text_field($stat['suffix'] ?? ''),
                    'label'  => sanitize_text_field($stat['label'] ?? ''),
                ];
            }
        }

        // About paragraphs
        if (!empty($surf['about_paragraphs']) && is_array($surf['about_paragraphs'])) {
            $surf_sanitized['about_paragraphs'] = array_map('sanitize_textarea_field', $surf['about_paragraphs']);
        }

        // Footer solutions
        if (!empty($surf['footer_solutions']) && is_array($surf['footer_solutions'])) {
            $surf_sanitized['footer_solutions'] = array_map('sanitize_text_field', $surf['footer_solutions']);
        }

        // Footer empresa
        if (!empty($surf['footer_empresa']) && is_array($surf['footer_empresa'])) {
            foreach ($surf['footer_empresa'] as $item) {
                $surf_sanitized['footer_empresa'][] = [
                    'label' => sanitize_text_field($item['label'] ?? ''),
                    'href'  => esc_url_raw($item['href'] ?? ''),
                ];
            }
        }

        // Footer social
        if (!empty($surf['footer_social']) && is_array($surf['footer_social'])) {
            foreach ($surf['footer_social'] as $item) {
                $surf_sanitized['footer_social'][] = [
                    'label' => sanitize_text_field($item['label'] ?? ''),
                    'url'   => esc_url_raw($item['url'] ?? ''),
                ];
            }
        }

        update_post_meta($post_id, 'wetheme_surf_info', $surf_sanitized);
    }
}
add_action('save_post', 'wetheme_save_home_meta_box');

// ============================================================
// ASSETS DEL ADMIN
// ============================================================

/**
 * Encola scripts y estilos del metabox.
 */
function wetheme_enqueue_admin_assets($hook): void
{
    if ($hook !== 'post.php' && $hook !== 'post-new.php') {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('wetheme-admin-meta', plugins_url('admin-home-meta.css', __FILE__), [], '1.0.0');
    wp_enqueue_script('wetheme-admin-meta', plugins_url('admin-home-meta.js', __FILE__), ['jquery'], '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'wetheme_enqueue_admin_assets');

// ============================================================
// CSS DEL METABOX
// ============================================================

add_action('admin_head', function () {
    ?>
    <style>
    .wetheme-meta-box-wrapper {
        padding: 15px;
    }
    .wetheme-section {
        margin-bottom: 25px;
        padding: 15px;
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
    }
    .wetheme-section-title {
        margin: 0 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #ffc932;
        color: #333;
        font-size: 16px;
        font-weight: 600;
    }
    .wetheme-field {
        margin-bottom: 12px;
    }
    .wetheme-field label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    .wetheme-field input[type="text"],
    .wetheme-field input[type="number"],
    .wetheme-field textarea,
    .wetheme-field select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .wetheme-field input.small {
        width: 120px;
    }
    .wetheme-field-row {
        display: flex;
        gap: 15px;
        margin-bottom: 12px;
    }
    .wetheme-field-row .wetheme-field {
        flex: 1;
        margin-bottom: 0;
    }
    .wetheme-repeater {
        margin-top: 15px;
        padding: 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .wetheme-repeater h4 {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #666;
    }
    .wetheme-repeater-item {
        padding: 12px;
        margin-bottom: 10px;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 3px;
        position: relative;
    }
    .wetheme-remove-item {
        margin-top: 8px !important;
        color: #d63638 !important;
        border-color: #d63638 !important;
    }
    .wetheme-add-item {
        margin-top: 10px !important;
        background: #2271b1 !important;
        color: #fff !important;
        border-color: #2271b1 !important;
    }
    .wetheme-image-upload {
        margin-top: 8px;
    }
    .wetheme-image-preview {
        margin-bottom: 8px;
    }
    .wetheme-image-preview img {
        max-width: 200px;
        height: auto;
        border-radius: 3px;
    }
    </style>
    <?php
});

// ============================================================
// JAVASCRIPT DEL METABOX
// ============================================================

add_action('admin_footer', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') {
        return;
    }
    ?>
    <script>
    (function($) {
        'use strict';

        // Media Frame para Hero
        var heroFrame;
        $(document).on('click', '#hero-select-image', function(e) {
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
                $('#hero-image-id').val(attachment.id);
                $('#hero-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '" alt="" />');
                $('#hero-remove-image').show();
            });
            
            heroFrame.open();
        });
        
        $(document).on('click', '#hero-remove-image', function(e) {
            e.preventDefault();
            $('#hero-image-id').val('');
            $('#hero-image-preview').html('');
            $(this).hide();
        });

        // Repeaters
        function reindexItems(container) {
            container.find('.wetheme-repeater-item').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('input, textarea, select').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        // Reemplazar índice en el name
                        var newName = name.replace(/\[\d+\]/g, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
        }

        $(document).on('click', '.wetheme-add-item', function() {
            var $btn = $(this);
            var template = $btn.data('template');
            var $container = $btn.siblings('.wetheme-repeater-items');
            var index = $container.find('.wetheme-repeater-item').length;
            
            var html = $('#template-' + template).html();
            html = html.replace(/{index}/g, index);
            
            $container.append(html);
        });

        $(document).on('click', '.wetheme-remove-item', function() {
            var $item = $(this).closest('.wetheme-repeater-item');
            var $container = $item.closest('.wetheme-repeater-items');
            $item.remove();
            reindexItems($container);
        });

    })(jQuery);
    </script>
    <?php
});

// ============================================================
// CORS
// ============================================================

function wetheme_configure_cors(): void
{
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
add_action('init', 'wetheme_configure_cors', 1);
add_action('rest_api_init', 'wetheme_configure_cors', 1);
