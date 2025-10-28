<?php 
require_once __DIR__ . '/functions/security.php';
require_once __DIR__ . '/functions/services/service-contact-form.php';
require_once __DIR__ . '/functions/controllers/controller-single.php';
require_once __DIR__ . '/functions/controllers/controller-contact.php';
require_once __DIR__ . '/functions/enqueue-assets.php'; // <<< ADICIONADO


// Setup
if ( ! function_exists( 'azietorres_setup' ) ) :
    function azietorres_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        /* Post Thumbnails */
        add_theme_support( 'post-thumbnails' );
        /* Title Tag */
        add_theme_support( 'title-tag' );

        /* Nav Menus */ // <<< ADICIONADO
        register_nav_menus( array(
            'primary' => esc_html__( 'Menu Principal', 'azietorres' ),
        ) );
    }
endif; // azietorres_setup
add_action( 'after_setup_theme', 'azietorres_setup' );

// Remove Menu´s
function remove_menus() {
    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php?post_type=page');
    if (!current_user_can('administrator')) {
        remove_menu_page('tools.php');
    }
}
add_action('admin_menu', 'remove_menus');

// Remove dashboard widgets for all user levels
function remove_dashboard_widgets() {
    remove_meta_box('dashboard_activity', 'dashboard', 'side');
    remove_meta_box('dashboard_right_now', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'side');
    remove_meta_box('dashboard_plugins', 'dashboard', 'side');
    remove_meta_box('dashboard_site_health', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

// Resumo
function custom_excerpt($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;
    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

// <<< FUNÇÃO 'insert_fb_in_head' REMOVIDA DAQUI >>>
// (A funcionalidade foi movida para o header.php, que está mais completa
// e evita a duplicação de meta tags.)


/////////////////////////////////////////////////////////
// Verificar atualizações do tema via servidor pessoal //
/////////////////////////////////////////////////////////
function update_checker( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }
    // URL do JSON de atualizações
    $remote_json = 'https://raw.githubusercontent.com/rafabandeira/azietorres/refs/heads/main/azietorres.json';
    // Buscar dados do JSON
    $response = wp_remote_get( $remote_json, array(
        'timeout' => 10,
        'headers' => array( 'Accept' => 'application/json' )
    ) );
    // Se houver erro, retorne o transient original
    if ( is_wp_error( $response ) ) {
        return $transient;
    }
    // Verifica se a resposta é válida
    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return $transient;
    }
    // Decodificar JSON
    $remote_data = json_decode( wp_remote_retrieve_body( $response ) );
    // Verificar se a decodificação foi bem-sucedida e se os campos necessários estão presentes
    if ( json_last_error() !== JSON_ERROR_NONE || ! isset( $remote_data->version, $remote_data->details_url, $remote_data->download_url ) ) {
        return $transient; // Retornar o transient original se houver erro na decodificação ou campos ausentes
    }
    // Identificar slug e versão do tema
    $theme_slug = get_template(); // Slug do tema (nome da pasta)
    $current_version = wp_get_theme( $theme_slug )->get( 'Version' );
    // Comparar versões
    if ( version_compare( $current_version, $remote_data->version, '<' ) ) {
        $transient->response[ $theme_slug ] = array(
            'theme'        => $theme_slug,
            'new_version'  => $remote_data->version,
            'details_url'  => esc_url( $remote_data->details_url ),
            'package'      => esc_url( $remote_data->download_url ),
        );
    }
    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'update_checker' );

// (O restante do functions.php permanece igual...)
// ... (CPTs, Metaboxes, Páginas de Opções, etc.)