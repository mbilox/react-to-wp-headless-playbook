<?php
/**
 * Plugin Name: CLIENT Home Meta Fields
 * Description: Meta fields + admin panel for CLIENT home page
 * Version: 1.0.0
 * Author: AUTHOR
 * Text Domain: PREFIX
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================================
// REGISTRO DE META CAMPOS
// ============================================================

function PREFIX_register_meta_fields(): void
{
    $post_type = 'page';

    // PREFIX_hero
    register_post_meta($post_type, 'PREFIX_hero', [
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
        'sanitize_callback' => 'PREFIX_sanitize_json',
    ]);

    // PREFIX_rooms (Services)
    register_post_meta($post_type, 'PREFIX_rooms', [
        'type'         => 'object',
        'single'       => true,
        'show_in_rest' => [
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
        'sanitize_callback' => 'PREFIX_sanitize_json',
    ]);

    // PREFIX_surf_info (Process, Projects, About, Closing, Footer)
    register_post_meta($post_type, 'PREFIX_surf_info', [
        'type'         => 'object',
        'single'       => true,
        'show_in_rest' => [
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
                    'closing_headline' => ['type' => 'string'],
                    'closing_cta_text' => ['type' => 'string'],
                    'closing_cta_url'  => ['type' => 'string'],
                    'footer_tagline'   => ['type' => 'string'],
                    'footer_solutions' => [
                        'type'  => 'array',
                        'items' => ['type' => 'string'],
                    ],
                    'footer_empresa'   => [
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
                    'footer_cta_text'  => ['type' => 'string'],
                    'footer_social'    => [
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
        'sanitize_callback' => 'PREFIX_sanitize_json',
    ]);
}
add_action('init', 'PREFIX_register_meta_fields');

/**
 * Sanitiza meta valores JSON.
 */
function PREFIX_sanitize_json($value)
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
// META BOX
// ============================================================

function PREFIX_add_home_meta_box(): void
{
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') {
        return;
    }

    add_meta_box(
        'PREFIX_home_content',
        __('Contenido del Home', 'PREFIX'),
        'PREFIX_render_home_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'PREFIX_add_home_meta_box');

function PREFIX_render_home_meta_box($post): void
{
    wp_nonce_field('PREFIX_home_meta_box', 'PREFIX_home_meta_box_nonce');

    $hero = get_post_meta($post->ID, 'PREFIX_hero', true) ?: [];
    $rooms = get_post_meta($post->ID, 'PREFIX_rooms', true) ?: [];
    $surf = get_post_meta($post->ID, 'PREFIX_surf_info', true) ?: [];

    if (!is_array($hero)) $hero = [];
    if (!is_array($rooms)) $rooms = [];
    if (!is_array($surf)) $surf = [];

    ?>
    <div class="PREFIX-meta-box-wrapper">
        <!-- SECCIONES DEL METABOX -->
        <!-- Agregar aquí las secciones: Hero, Services, Stats, Process, Projects, About, Closing, Footer -->
        <!-- Ver archivo admin-metabox.css y admin-metabox.js para estilos y funcionalidad -->
    </div>
    <?php
}

// ============================================================
// GUARDADO DE DATOS
// ============================================================

function PREFIX_save_home_meta_box($post_id): void
{
    if (!isset($_POST['PREFIX_home_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['PREFIX_home_meta_box_nonce'], 'PREFIX_home_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_page', $post_id)) return;

    // Guardar PREFIX_hero
    if (isset($_POST['PREFIX_hero'])) {
        $hero = $_POST['PREFIX_hero'];
        update_post_meta($post_id, 'PREFIX_hero', [
            'label'              => sanitize_text_field($hero['label'] ?? ''),
            'headline'           => sanitize_text_field($hero['headline'] ?? ''),
            'subtitle'           => sanitize_text_field($hero['subtitle'] ?? ''),
            'cta_primary_text'   => sanitize_text_field($hero['cta_primary_text'] ?? ''),
            'cta_primary_url'    => esc_url_raw($hero['cta_primary_url'] ?? ''),
            'cta_secondary_text' => sanitize_text_field($hero['cta_secondary_text'] ?? ''),
            'cta_secondary_url'  => esc_url_raw($hero['cta_secondary_url'] ?? ''),
            'video_url'          => esc_url_raw($hero['video_url'] ?? ''),
            'image_id'           => absint($hero['image_id'] ?? 0),
        ]);
    }

    // Guardar más campos aquí...
}
add_action('save_post', 'PREFIX_save_home_meta_box');

// ============================================================
// ASSETS DEL ADMIN
// ============================================================

function PREFIX_enqueue_admin_assets($hook): void
{
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'page') return;
    
    wp_enqueue_media();
    wp_enqueue_style('PREFIX-admin-meta', plugins_url('admin-meta.css', __FILE__), [], '1.0.0');
    wp_enqueue_script('PREFIX-admin-meta', plugins_url('admin-meta.js', __FILE__), ['jquery'], '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'PREFIX_enqueue_admin_assets');

// ============================================================
// CORS
// ============================================================

function PREFIX_configure_cors(): void
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
add_action('init', 'PREFIX_configure_cors', 1);
add_action('rest_api_init', 'PREFIX_configure_cors', 1);
