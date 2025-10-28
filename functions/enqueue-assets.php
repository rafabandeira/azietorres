<?php
/**
 * Enfileira scripts e estilos do tema.
 *
 * @package azietorres
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Acesso direto bloqueado.
}

/**
 * Enfileira os assets do frontend.
 */
function azietorres_enqueue_assets() {
    
    // 1. FONTES
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i',
        array(),
        null 
    );

    // 2. CSS DE VENDEDORES (VENDOR)
    $theme_uri = get_template_directory_uri();
    
    wp_enqueue_style(
        'aos',
        $theme_uri . '/assets/vendor/aos/aos.css',
        array(),
        '2.3.4'
    );
    wp_enqueue_style(
        'bootstrap',
        $theme_uri . '/assets/vendor/bootstrap/css/bootstrap.min.css',
        array(),
        '5.1.3' // Use a versão correta
    );
    wp_enqueue_style(
        'bootstrap-icons',
        $theme_uri . '/assets/vendor/bootstrap-icons/bootstrap-icons.css',
        array(),
        '1.8.1' // Use a versão correta
    );
    wp_enqueue_style(
        'boxicons',
        $theme_uri . '/assets/vendor/boxicons/css/boxicons.min.css',
        array(),
        '2.1.1' // Use a versão correta
    );
    wp_enqueue_style(
        'glightbox',
        $theme_uri . '/assets/vendor/glightbox/css/glightbox.min.css',
        array(),
        '3.2.0' // Use a versão correta
    );
    wp_enqueue_style(
        'remixicon',
        'https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css', // CDN Externo
        array(),
        '2.5.0'
    );
    wp_enqueue_style(
        'swiper',
        $theme_uri . '/assets/vendor/swiper/swiper-bundle.min.css',
        array(),
        '8.0.0' // Use a versão correta
    );

    // 3. CSS PRINCIPAL DO TEMA
    wp_enqueue_style(
        'azietorres-style',
        get_stylesheet_uri(),
        array( 'bootstrap' ), // Depende do Bootstrap
        wp_get_theme()->get( 'Version' )
    );

    // 4. SCRIPTS DE VENDEDORES (VENDOR)
    // Carregados no footer (último parâmetro 'true')
    wp_enqueue_script(
        'aos-js',
        $theme_uri . '/assets/vendor/aos/aos.js',
        array(),
        '2.3.4',
        true
    );
    wp_enqueue_script(
        'bootstrap-bundle',
        $theme_uri . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        array(),
        '5.1.3',
        true
    );
    wp_enqueue_script(
        'glightbox-js',
        $theme_uri . '/assets/vendor/glightbox/js/glightbox.min.js',
        array(),
        '3.2.0',
        true
    );
    wp_enqueue_script(
        'swiper-js',
        $theme_uri . '/assets/vendor/swiper/swiper-bundle.min.js',
        array(),
        '8.0.0',
        true
    );

    // 5. SCRIPT PRINCIPAL DO TEMA
    // (Assumindo que assets/js/main.js existe e contém a inicialização do Swiper, etc.)
    wp_enqueue_script(
        'azietorres-main',
        $theme_uri . '/assets/js/main.js',
        array( 'jquery', 'bootstrap-bundle', 'swiper-js', 'glightbox-js', 'aos-js' ), // Dependências
        wp_get_theme()->get( 'Version' ),
        true
    );

}
add_action( 'wp_enqueue_scripts', 'azietorres_enqueue_assets' );