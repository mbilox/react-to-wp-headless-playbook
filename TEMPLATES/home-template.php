<?php
/**
 * Template Name: Home Template
 * Template Post Type: page
 * 
 * Plantilla para la página de inicio.
 * Esta plantilla activa el metabox en el editor de WordPress.
 */

get_header();

// Este template no renderiza contenido visual propio
// El frontend es manejado completamente por la aplicación React
// Los datos se consumen via REST API

if (!defined('REST_REQUEST') && !wp_is_json_request()) :
?>

<div style="max-width: 800px; margin: 50px auto; padding: 40px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; text-align: center;">
    <h1 style="color: #333; margin-bottom: 20px;">CLIENT — Home</h1>
    <p style="color: #666; font-size: 18px; line-height: 1.6; margin-bottom: 30px;">
        Esta página sirve como fuente de datos para el sitio React.
        <br>
        El contenido visual se renderiza en la aplicación frontend.
    </p>
    <p style="color: #999; font-size: 14px;">
        Para editar el contenido, usá el metabox "Contenido del Home" en el editor.
    </p>
</div>

<?php
endif;

get_footer();
