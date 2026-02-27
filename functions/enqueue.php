<?php
/**
 * Enqueue scripts and styles
 */
function azietorres_scripts()
{
    // Google Fonts
    wp_enqueue_style('azietorres-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i', array(), null);

    // Vendor CSS
    wp_enqueue_style('aos', get_template_directory_uri() . '/assets/vendor/aos/aos.css', array(), '2.3.1');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), '5.1.3');
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/assets/vendor/bootstrap-icons/bootstrap-icons.css', array(), '1.8.1');
    wp_enqueue_style('boxicons', get_template_directory_uri() . '/assets/vendor/boxicons/css/boxicons.min.css', array(), '2.1.2');
    wp_enqueue_style('glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/css/glightbox.min.css', array(), '3.1.0');
    wp_enqueue_style('remixicon', 'https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css', array(), '2.5.0');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css', array(), '8.1.1');

    // Main CSS
    wp_enqueue_style('azietorres-style', get_template_directory_uri() . '/assets/css/style.css', array(), wp_get_theme()->get('Version'));

    // Vendor JS
    wp_enqueue_script('aos', get_template_directory_uri() . '/assets/vendor/aos/aos.js', array(), '2.3.1', true);
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array(), '5.1.3', true);
    wp_enqueue_script('glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/js/glightbox.min.js', array(), '3.1.0', true);
    wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/vendor/isotope-layout/isotope.pkgd.min.js', array(), '3.0.6', true);
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array(), '8.1.1', true);

    // Main JS
    wp_enqueue_script('azietorres-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Theme Custom Init
    wp_enqueue_script('azietorres-theme-init', get_template_directory_uri() . '/assets/js/theme-init.js', array('swiper'), wp_get_theme()->get('Version'), true);

    wp_localize_script('azietorres-theme-init', 'themeData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'newsletter_nonce' => wp_create_nonce('newsletter-nonce'),
    ));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'azietorres_scripts');
