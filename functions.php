<?php 
require_once __DIR__ . '/functions/security.php';
require_once __DIR__ . '/functions/services/service-contact-form.php';
require_once __DIR__ . '/functions/controllers/controller-single.php';
require_once __DIR__ . '/functions/controllers/controller-contact.php';


// Setup
if ( ! function_exists( 'azietorres_setup' ) ) :
    function azietorres_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        /* Post Thumbnails */
        add_theme_support( 'post-thumbnails' );    }
endif; // azietorres_setup
add_action( 'after_setup_theme', 'azietorres_setup' );

// Título
function azietorres_wp_title( $title, $sep ) {
    global $paged, $page;
    if ( is_feed() ) { return $title; }
    $title .= get_bloginfo( 'name', 'display' );
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title = "$title $sep $site_description";
    }
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title = "$title $sep " . sprintf( __( 'Page %s', 'azietorres' ), max( $paged, $page ) );
    }
    return $title;
}
add_filter( 'wp_title', 'azietorres_wp_title', 10, 2 );


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
//Lets add Open Graph Meta Info
function insert_fb_in_head() {
global $post;
if ( !is_singular()) //if it is not a post or a page
    return;
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="' . get_the_title() . '"/>';
if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
    $default_image="https://azietorres.com.br/wp-content/themes/azietorres/assets/img/logo.png"; //replace this with a default image on your server or an image in your media library
    echo '<meta property="og:image" content="' . $default_image . '"/>';
}
else{
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
    echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
}
echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );





/////////////////////////////////////////////////////////
// Verificar atualizações do tema via servidor pessoal //
/////////////////////////////////////////////////////////
delete_site_transient('update_themes');
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
// Garantir que o código funcione em Multisite
function update_checker_multisite_network() {
    if ( is_multisite() ) {
        $sites = get_sites();
        foreach ( $sites as $site ) {
            switch_to_blog( $site->blog_id );
            // Executar o código de verificação para cada site
            $transient = get_site_transient( 'update_themes' );
            $transient = update_checker( $transient );
            set_site_transient( 'update_themes', $transient );
            restore_current_blog();
        }
    }
}
add_action( 'admin_init', 'update_checker_multisite_network' );





/////////////////////////////////////////////////////////////////
// Adiciona a base /artigos/ aos links de posts do tipo 'post'
// e cria a regra para que o WordPress entenda esses novos links.
//
// Parte 1: Modifica o link de saída para os posts padrão
function adicionar_base_artigos_para_posts( $post_link, $post ) {
    // Verifica se o objeto é um post e se o tipo é 'post' (o padrão do WP)
    if ( is_object( $post ) && $post->post_type == 'post' ) {
        // Constrói o novo link com a base /artigos/
        return home_url( '/artigos/' . $post->post_name . '/' );
    }
    // Para todos os outros tipos de post, retorna o link original sem modificação
    return $post_link;
}
add_filter( 'post_link', 'adicionar_base_artigos_para_posts', 10, 2 );
// Parte 2: Ensina o WordPress a reconhecer a nova estrutura de URL
function adicionar_rewrite_rule_artigos() {
    add_rewrite_rule(
        '^artigos/([^/]+)/?$', // A estrutura do novo URL
        'index.php?post_type=post&name=$matches[1]', // Para onde o WordPress deve apontar
        'top' // Prioridade da regra
    );
}
add_action( 'init', 'adicionar_rewrite_rule_artigos' );
// Alterar o nome do menu de Posts para Artigos
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Artigos'; // Muda o nome do menu
    $submenu['edit.php'][5][0] = 'Artigos'; // Muda o nome do submenu
    $menu[5][6] = 'dashicons-format-quote'; // Muda o ícone do menu
}
add_action('admin_menu', 'change_post_menu_label');






///////////////////////////////////////////
// Custom Post Type for Áreas de Atuação //
///////////////////////////////////////////
function create_area_atuacao_post_type() {
    $labels = array(
        'name'               => _x( 'Áreas de Atuação', 'post type general name' ),
        'singular_name'      => _x( 'Área de Atuação', 'post type singular name' ),
        'menu_name'          => _x( 'Áreas de Atuação', 'admin menu' ),
        'name_admin_bar'     => _x( 'Área de Atuação', 'add new on admin bar' ),
        'add_new'            => _x( 'Criar Nova', 'área de atuação' ),
        'add_new_item'       => __( 'Criar Nova Área de Atuação' ),
        'new_item'           => __( 'Nova Área de Atuação' ),
        'edit_item'          => __( 'Editar Área de Atuação' ),
        'view_item'          => __( 'Ver Área de Atuação' ),
        'all_items'          => __( 'Todas as Áreas de Atuação' ),
        'search_items'       => __( 'Procurar Áreas de Atuação' ),
        'parent_item_colon'  => __( 'Área de Atuação Pai:' ),
        'not_found'          => __( 'Nenhuma Área de Atuação encontrada.' ),
        'not_found_in_trash' => __( 'Nenhuma Área de Atuação encontrada no lixo.' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'area-atuacao' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' ),
        'menu_icon'          => 'dashicons-awards', // Ícone de balança
    );
    register_post_type( 'area_atuacao', $args );
}
add_action( 'init', 'create_area_atuacao_post_type' );
// Adding Custom Meta Box for Área de Atuação 
function area_atuacao_meta_box() {
    add_meta_box(
        'area_atuacao_details',
        __( 'Detalhes da Área de Atuação', 'textdomain' ),
        'area_atuacao_details_callback',
        'area_atuacao'
    );
}
add_action( 'add_meta_boxes', 'area_atuacao_meta_box' );
function area_atuacao_details_callback( $post ) {
    wp_nonce_field( 'area_atuacao_details_save', 'area_atuacao_details_nonce' );
    $summary = get_post_meta( $post->ID, '_area_atuacao_summary', true );
    $icon = get_post_meta( $post->ID, '_area_atuacao_icon', true );
    echo '<label for="area_atuacao_summary">' . __( 'Resumo', 'textdomain' ) . '</label>';
    echo '<textarea id="area_atuacao_summary" name="area_atuacao_summary" rows="4" style="width:100%;">' . esc_textarea( $summary ) . '</textarea>';
    echo '<label for="area_atuacao_icon">' . __( 'Ícone ', 'textdomain' ) . '</label> <br>';
    echo '<input type="text" id="area_atuacao_icon" name="area_atuacao_icon" value="' . esc_attr( $icon ) . '" size="25" placeholder="bi bi-briefcase" /><br>'; 
    echo '<small>Use um ícone do Bootstrap Icons. Exemplo: <code>bi-briefcase</code></small><br>';
    echo '<a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener noreferrer">Veja os ícones disponíveis</a>'; 
}
function area_atuacao_details_save( $post_id ) {
    if ( ! isset( $_POST['area_atuacao_details_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['area_atuacao_details_nonce'], 'area_atuacao_details_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['area_atuacao_summary'] ) ) {
        update_post_meta( $post_id, '_area_atuacao_summary', sanitize_textarea_field( $_POST['area_atuacao_summary'] ) );
    }
    if ( isset( $_POST['area_atuacao_icon'] ) && ! empty( $_POST['area_atuacao_icon'] ) ) {
        update_post_meta( $post_id, '_area_atuacao_icon', sanitize_text_field( $_POST['area_atuacao_icon'] ) );
    } else {
        update_post_meta( $post_id, '_area_atuacao_icon', 'bi bi-briefcase' ); // Ícone padrão
    }
}
add_action( 'save_post', 'area_atuacao_details_save' );





/////////////////////////////////
// Custom Post Type for Advogados
function create_advogado_post_type() {
    $labels = array(
        'name'               => _x( 'Advogados', 'post type general name' ),
        'singular_name'      => _x( 'Advogado', 'post type singular name' ),
        'menu_name'          => _x( 'Advogados', 'admin menu' ),
        'name_admin_bar'     => _x( 'Advogado', 'add new on admin bar' ),
        'add_new'            => _x( 'Criar Novo', 'advogado' ),
        'add_new_item'       => __( 'Criar Novo Advogado' ),
        'new_item'           => __( 'Novo Advogado' ),
        'edit_item'          => __( 'Editar Advogado' ),
        'view_item'          => __( 'Ver Advogado' ),
        'all_items'          => __( 'Todos Advogados' ),
        'search_items'       => __( 'Procurar Advogados' ),
        'parent_item_colon'  => __( 'Advogado Pai:' ),
        'not_found'          => __( 'Nenhum Advogado encontrado.' ),
        'not_found_in_trash' => __( 'Nenhum Advogado encontrado no lixo.' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'advogado' ),
        'capability_type'    => 'post', // Set capability to post
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'          => 'dashicons-groups', // Change this line to use a person icon
    );
    register_post_type( 'advogado', $args );
}
add_action( 'init', 'create_advogado_post_type' );
// Adding Custom Meta Box for Advogado's Area of Expertise
function advogado_meta_box() {
    add_meta_box(
        'advogado_expertise',
        __( 'Área de Atuação', 'textdomain' ),
        'advogado_expertise_callback',
        'advogado'
    );
}
add_action( 'add_meta_boxes', 'advogado_meta_box' );
function advogado_expertise_callback( $post ) {
    wp_nonce_field( 'advogado_expertise_save', 'advogado_expertise_nonce' );
    $value = get_post_meta( $post->ID, '_advogado_expertise', true );
    echo '<label for="advogado_expertise_field">' . __( 'Área de Atuação ', 'textdomain' ) . '</label>';
    echo '<input type="text" id="advogado_expertise_field" name="advogado_expertise_field" value="' . esc_attr( $value ) . '" size="25" />';
}
function advogado_expertise_save( $post_id ) {
    if ( ! isset( $_POST['advogado_expertise_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['advogado_expertise_nonce'], 'advogado_expertise_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['advogado_expertise_field'] ) ) {
        update_post_meta( $post_id, '_advogado_expertise', sanitize_text_field( $_POST['advogado_expertise_field'] ) );
    }
}
add_action( 'save_post', 'advogado_expertise_save' );





////////////////////////////
// Add Hero Settings Menu //
////////////////////////////
function add_hero_settings_menu() {
    add_menu_page(
        'Abertura do Site',
        'Abertura',
        'edit_pages',
        'hero-settings',
        'hero_settings_page',
        'dashicons-cover-image',
        20
    );
}
add_action('admin_menu', 'add_hero_settings_menu');
// Enqueue WordPress Media Uploader on Hero Settings page
function enqueue_hero_settings_media_uploader($hook) {
    // Aceita variações do slug do menu
    if (strpos($hook, 'hero-settings') !== false) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_hero_settings_media_uploader');
// Create Hero Settings Page
function hero_settings_page() {
    // Save settings if form is submitted
    if (isset($_POST['hero_settings_submit'])) {
        update_option('hero_background_image', esc_url_raw($_POST['hero_background_image']));
        update_option('hero_logo_image', esc_url_raw($_POST['hero_logo_image']));
    }
    // Get current values
    $background_image = get_option('hero_background_image');
    $logo_image = get_option('hero_logo_image');
    $default_bg = get_template_directory_uri() . '/assets/img/recepcao.jpeg';
    $default_logo = get_template_directory_uri() . '/assets/img/logo2.png';
    ?>
    <div class="wrap">
        <h1>Abertura do Site</h1>
        <hr>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="hero_background_image">Imagem de fundo</label></th>
                    <td>
                        <input type="hidden" id="hero_background_image" name="hero_background_image" value="<?php echo esc_attr($background_image); ?>">
                        <img id="hero_background_image_thumb" src="<?php echo esc_url($background_image ? $background_image : $default_bg); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_hero_background_image">Selecionar Imagem</button>
                        <button type="button" class="button" id="remove_hero_background_image">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="hero_logo_image">Marca</label></th>
                    <td>
                        <input type="hidden" id="hero_logo_image" name="hero_logo_image" value="<?php echo esc_attr($logo_image); ?>">
                        <img id="hero_logo_image_thumb" src="<?php echo esc_url($logo_image ? $logo_image : $default_logo); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_hero_logo_image">Selecionar marca</button>
                        <button type="button" class="button" id="remove_hero_logo_image">Remover</button>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="hero_settings_submit" class="button-primary" value="Salvar Alterações">
            </p>
        </form>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
            console.log('wp.media não carregado');
            return;
        }
        function mediaUploader(inputId, thumbId, defaultImg) {
            var frame;
            $("#upload_"+inputId).on('click', function(e){
                e.preventDefault();
                console.log('Abrindo Media Uploader para', inputId);
                if(frame){ frame.open(); return; }
                frame = wp.media({ title: 'Selecione ou envie uma imagem', button: { text: 'Usar esta imagem' }, multiple: false });
                frame.on('select', function(){
                    var attachment = frame.state().get('selection').first().toJSON();
                    $("#"+inputId).val(attachment.url);
                    $("#"+thumbId).attr('src', attachment.url);
                });
                frame.open();
            });
            $("#remove_"+inputId).on('click', function(e){
                e.preventDefault();
                console.log('Removendo imagem de', inputId);
                $("#"+inputId).val('');
                $("#"+thumbId).attr('src', defaultImg);
            });
        }
        mediaUploader('hero_background_image', 'hero_background_image_thumb', '<?php echo esc_js($default_bg); ?>');
        mediaUploader('hero_logo_image', 'hero_logo_image_thumb', '<?php echo esc_js($default_logo); ?>');
    });
    </script>
    <?php
}


//////////////////////////////////
// Add Escritório Settings Menu //
//////////////////////////////////
function add_escritorio_settings_menu() {
    add_menu_page(
        'Escritório',
        'Escritório',
        'edit_pages',
        'escritorio-settings',
        'escritorio_settings_page',
        'dashicons-admin-home',
        21
    );
}
add_action('admin_menu', 'add_escritorio_settings_menu');
// Enqueue Media Uploader for Escritório
function enqueue_escritorio_settings_media_uploader($hook) {
    if (strpos($hook, 'escritorio-settings') !== false) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_escritorio_settings_media_uploader');
// Escritório Settings Page
function escritorio_settings_page() {
    if (isset($_POST['escritorio_settings_submit'])) {
        update_option('escritorio_image', esc_url_raw($_POST['escritorio_image']));
        update_option('escritorio_title', sanitize_text_field($_POST['escritorio_title']));
        update_option('escritorio_italic', sanitize_text_field($_POST['escritorio_italic']));
        update_option('escritorio_list', sanitize_textarea_field($_POST['escritorio_list']));
        update_option('escritorio_text', sanitize_textarea_field($_POST['escritorio_text']));
    }
    $default_img = get_template_directory_uri() . '/assets/img/recepcao.jpg';
    $default_title = 'Azi & Torres Castro Habib Pinto<br>Advogados Associados';
    $default_italic = 'Atuando há quase 20 anos no mercado e pautado em valores como confiabilidade, qualidade, eficiência, ética e inovação.';
    $default_list = "Destaca-se pela seriedade;\nVasta experiência nos campos de direito público e privado;\nCélere resposta às demandas que lhe são confiadas;\nSolução dos desafios impostos por um mercado competitivo e exigente.";
    $default_text = 'Com atendimento rápido e eficiente, conta com estrutura para ampla atuação em assessoria, consultoria e contencioso. Para tanto, é composto por uma equipe jurídica qualificada e especializada e por um corpo administrativo apto a prestar serviços diferenciados que proporciona aos seus clientes uma completa experiência e assistência.';
    $image = get_option('escritorio_image', $default_img);
    $title = get_option('escritorio_title', $default_title);
    $italic = get_option('escritorio_italic', $default_italic);
    $list = get_option('escritorio_list', $default_list);
    $text = get_option('escritorio_text', $default_text);
    ?>
    <div class="wrap">
        <h1>Seção Escritório</h1>
        <hr>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="escritorio_image">Imagem do Escritório</label></th>
                    <td>
                        <input type="hidden" id="escritorio_image" name="escritorio_image" value="<?php echo esc_attr($image); ?>">
                        <img id="escritorio_image_thumb" src="<?php echo esc_url($image ? $image : $default_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_escritorio_image">Selecionar Imagem</button>
                        <button type="button" class="button" id="remove_escritorio_image">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="escritorio_title">Título</label></th>
                    <td><input type="text" id="escritorio_title" name="escritorio_title" value="<?php echo esc_attr($title); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="escritorio_italic">Texto em Itálico</label></th>
                    <td><input type="text" id="escritorio_italic" name="escritorio_italic" value="<?php echo esc_attr($italic); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="escritorio_list">Itens da Lista (1 por linha)</label></th>
                    <td><textarea id="escritorio_list" name="escritorio_list" rows="5" class="large-text"><?php echo esc_textarea($list); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="escritorio_text">Texto Final</label></th>
                    <td><textarea id="escritorio_text" name="escritorio_text" rows="5" class="large-text"><?php echo esc_textarea($text); ?></textarea></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="escritorio_settings_submit" class="button-primary" value="Salvar Alterações">
            </p>
        </form>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
            console.log('wp.media não carregado');
            return;
        }
        var frame;
        $('#upload_escritorio_image').on('click', function(e){
            e.preventDefault();
            if(frame){ frame.open(); return; }
            frame = wp.media({ title: 'Selecione ou envie uma imagem', button: { text: 'Usar esta imagem' }, multiple: false });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('#escritorio_image').val(attachment.url);
                $('#escritorio_image_thumb').attr('src', attachment.url);
            });
            frame.open();
        });
        $('#remove_escritorio_image').on('click', function(e){
            e.preventDefault();
            $('#escritorio_image').val('');
            $('#escritorio_image_thumb').attr('src', '<?php echo esc_js($default_img); ?>');
        });
    });
    </script>
    <?php
}





///////////////////////////////////////////////
// Add Visão, Valores e Missão Settings Menu //
///////////////////////////////////////////////
function add_vvm_settings_menu() {
    add_menu_page(
        'Visão, Valores e Missão',
        'Visão, Valores e Missão',
        'edit_pages',
        'vvm-settings',
        'vvm_settings_page',
        'dashicons-lightbulb',
        22
    );
}
add_action('admin_menu', 'add_vvm_settings_menu');
function enqueue_vvm_settings_media_uploader($hook) {
    if (strpos($hook, 'vvm-settings') !== false) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_vvm_settings_media_uploader');
function vvm_settings_page() {
    // Defaults from index.php
    $default_visao_img = get_template_directory_uri() . '/assets/img/visao.jpg';
    $default_visao_title = 'Nossa visão';
    $default_visao_text = 'Exceder as expectativas dos clientes, tendo como referência a atuação eficaz e de vanguarda nas demandas apresentadas, através de uma assessoria inteligente, dedicada à pacificação social.';
    $default_valores_img = get_template_directory_uri() . '/assets/img/valores.jpg';
    $default_valores_title = 'Nossos valores';
    $default_valores_list = "Ética e honestidade;\nDedicação e criatividade;\nTrabalho em equipe;\nQualidade no atendimento aos clientes;\nProfissionalismo e proatividade;\nCooperação e responsabilidade social.";
    $default_missao_img = get_template_directory_uri() . '/assets/img/missao.jpg';
    $default_missao_title = 'Nossa missão';
    $default_missao_text = 'Prestar serviços jurídicos com ética, responsabilidade e dedicação em busca de soluções inteligentes e contemporâneas para atender as complexas demandas apresentadas, com foco na solução satisfatória.';
    // Get current values
    $visao_img = get_option('vvm_visao_img', $default_visao_img);
    $visao_title = get_option('vvm_visao_title', $default_visao_title);
    $visao_text = get_option('vvm_visao_text', $default_visao_text);
    $valores_img = get_option('vvm_valores_img', $default_valores_img);
    $valores_title = get_option('vvm_valores_title', $default_valores_title);
    $valores_list = get_option('vvm_valores_list', $default_valores_list);
    $missao_img = get_option('vvm_missao_img', $default_missao_img);
    $missao_title = get_option('vvm_missao_title', $default_missao_title);
    $missao_text = get_option('vvm_missao_text', $default_missao_text);
    // Save settings
    if (isset($_POST['vvm_settings_submit'])) {
        update_option('vvm_visao_img', esc_url_raw($_POST['vvm_visao_img']));
        update_option('vvm_visao_title', sanitize_text_field($_POST['vvm_visao_title']));
        update_option('vvm_visao_text', wp_kses_post($_POST['vvm_visao_text']));
        update_option('vvm_valores_img', esc_url_raw($_POST['vvm_valores_img']));
        update_option('vvm_valores_title', sanitize_text_field($_POST['vvm_valores_title']));
        update_option('vvm_valores_list', sanitize_textarea_field($_POST['vvm_valores_list']));
        update_option('vvm_missao_img', esc_url_raw($_POST['vvm_missao_img']));
        update_option('vvm_missao_title', sanitize_text_field($_POST['vvm_missao_title']));
        update_option('vvm_missao_text', wp_kses_post($_POST['vvm_missao_text']));
        // Refresh values
        $visao_img = get_option('vvm_visao_img', $default_visao_img);
        $visao_title = get_option('vvm_visao_title', $default_visao_title);
        $visao_text = get_option('vvm_visao_text', $default_visao_text);
        $valores_img = get_option('vvm_valores_img', $default_valores_img);
        $valores_title = get_option('vvm_valores_title', $default_valores_title);
        $valores_list = get_option('vvm_valores_list', $default_valores_list);
        $missao_img = get_option('vvm_missao_img', $default_missao_img);
        $missao_title = get_option('vvm_missao_title', $default_missao_title);
        $missao_text = get_option('vvm_missao_text', $default_missao_text);
    }
    ?>
    <div class="wrap">
        <h1>Seção Visão, Valores e Missão</h1>
        <hr>
        <form method="post" action="">
            <table class="form-table">
                <tr><th colspan="2"><h2>Visão</h2></th></tr>
                <tr>
                    <th><label for="vvm_visao_img">Imagem</label></th>
                    <td>
                        <input type="hidden" id="vvm_visao_img" name="vvm_visao_img" value="<?php echo esc_attr($visao_img); ?>">
                        <img id="vvm_visao_img_thumb" src="<?php echo esc_url($visao_img ? $visao_img : $default_visao_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_vvm_visao_img">Selecionar Imagem</button>
                        <button type="button" class="button" id="remove_vvm_visao_img">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="vvm_visao_title">Título</label></th>
                    <td><input type="text" id="vvm_visao_title" name="vvm_visao_title" value="<?php echo esc_attr($visao_title); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="vvm_visao_text">Texto</label></th>
                    <td><textarea id="vvm_visao_text" name="vvm_visao_text" rows="4" class="large-text"><?php echo esc_textarea($visao_text); ?></textarea></td>
                </tr>
                <tr><th colspan="2"><h2>Valores</h2></th></tr>
                <tr>
                    <th><label for="vvm_valores_img">Imagem</label></th>
                    <td>
                        <input type="hidden" id="vvm_valores_img" name="vvm_valores_img" value="<?php echo esc_attr($valores_img); ?>">
                        <img id="vvm_valores_img_thumb" src="<?php echo esc_url($valores_img ? $valores_img : $default_valores_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_vvm_valores_img">Selecionar Imagem</button>
                        <button type="button" class="button" id="remove_vvm_valores_img">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="vvm_valores_title">Título</label></th>
                    <td><input type="text" id="vvm_valores_title" name="vvm_valores_title" value="<?php echo esc_attr($valores_title); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="vvm_valores_list">Itens da Lista (1 por linha)</label></th>
                    <td><textarea id="vvm_valores_list" name="vvm_valores_list" rows="6" class="large-text"><?php echo esc_textarea($valores_list); ?></textarea></td>
                </tr>
                <tr><th colspan="2"><h2>Missão</h2></th></tr>
                <tr>
                    <th><label for="vvm_missao_img">Imagem</label></th>
                    <td>
                        <input type="hidden" id="vvm_missao_img" name="vvm_missao_img" value="<?php echo esc_attr($missao_img); ?>">
                        <img id="vvm_missao_img_thumb" src="<?php echo esc_url($missao_img ? $missao_img : $default_missao_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button" id="upload_vvm_missao_img">Selecionar Imagem</button>
                        <button type="button" class="button" id="remove_vvm_missao_img">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th><label for="vvm_missao_title">Título</label></th>
                    <td><input type="text" id="vvm_missao_title" name="vvm_missao_title" value="<?php echo esc_attr($missao_title); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="vvm_missao_text">Texto</label></th>
                    <td><textarea id="vvm_missao_text" name="vvm_missao_text" rows="4" class="large-text"><?php echo esc_textarea($missao_text); ?></textarea></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="vvm_settings_submit" class="button-primary" value="Salvar Alterações">
            </p>
        </form>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        function mediaUploader(inputId, thumbId, defaultImg) {
            var frame;
            $("#upload_"+inputId).on('click', function(e){
                e.preventDefault();
                if(frame){ frame.open(); return; }
                frame = wp.media({ title: 'Selecione ou envie uma imagem', button: { text: 'Usar esta imagem' }, multiple: false });
                frame.on('select', function(){
                    var attachment = frame.state().get('selection').first().toJSON();
                    $("#"+inputId).val(attachment.url);
                    $("#"+thumbId).attr('src', attachment.url);
                });
                frame.open();
            });
            $("#remove_"+inputId).on('click', function(e){
                e.preventDefault();
                $("#"+inputId).val('');
                $("#"+thumbId).attr('src', defaultImg);
            });
        }
        mediaUploader('vvm_visao_img', 'vvm_visao_img_thumb', '<?php echo esc_js($default_visao_img); ?>');
        mediaUploader('vvm_valores_img', 'vvm_valores_img_thumb', '<?php echo esc_js($default_valores_img); ?>');
        mediaUploader('vvm_missao_img', 'vvm_missao_img_thumb', '<?php echo esc_js($default_missao_img); ?>');
    });
    </script>
    <?php
};





/////////////////////
//  Redes Sociais  //
/////////////////////
// Ação para adicionar a página de submenu no painel de administração
add_action('admin_menu', 'my_theme_social_media_menu');
function my_theme_social_media_menu() {
    add_menu_page(
        'Seção Redes Sociais',             // Título da página
        'Redes Sociais',                   // Título do menu
        'edit_pages',                      // Capacidade do usuário (neste caso, editor)
        'my-social-media-settings',        // Slug do menu
        'my_theme_social_media_page_html', // Função que exibe o conteúdo da página
        'dashicons-share',                 // Ícone, neste caso um ícone de "compartilhar"
        50                                 // Posição no menu, para aparecer no meio
    );
}
add_action('admin_init', 'my_theme_social_media_settings_init');
/**
 * Inicializa a API de Configurações do WordPress.
 */
function my_theme_social_media_settings_init() {
    register_setting('my-social-media-settings', 'my_social_media_options');
    // Adiciona uma seção para organizar os campos.
    add_settings_section(
        'my_social_media_section',      // ID da seção
        'Links das Redes Sociais',      // Título da seção
        'my_social_media_section_html', // Função que exibe a descrição da seção
        'my-social-media-settings'      // Slug da página
    );
    // Adiciona um campo de entrada para o X (antigo Twitter).
    add_settings_field(
        'my_social_media_field_x',      // ID do campo
        'X (antigo Twitter)',           // Título do campo
        'my_social_media_field_x_html', // Função que renderiza o campo
        'my-social-media-settings',     // Slug da página
        'my_social_media_section'       // ID da seção onde o campo será exibido
    );
    // Adiciona um campo de entrada para o Facebook.
    add_settings_field(
        'my_social_media_field_facebook', // ID do campo
        'Facebook',                       // Título do campo
        'my_social_media_field_facebook_html', // Função que renderiza o campo
        'my-social-media-settings',       // Slug da página
        'my_social_media_section'         // ID da seção onde o campo será exibido
    );
    // Adiciona um campo de entrada para o Instagram.
    add_settings_field(
        'my_social_media_field_instagram', // ID do campo
        'Instagram',                       // Título do campo
        'my_social_media_field_instagram_html', // Função que renderiza o campo
        'my-social-media-settings',        // Slug da página
        'my_social_media_section'          // ID da seção onde o campo será exibido
    );
    // Adiciona um campo de entrada para o LinkedIn.
    add_settings_field(
        'my_social_media_field_linkedin', // ID do campo
        'LinkedIn',                       // Título do campo
        'my_social_media_field_linkedin_html', // Função que renderiza o campo
        'my-social-media-settings',       // Slug da página
        'my_social_media_section'         // ID da seção onde o campo será exibido
    );
}
/**
 * Exibe a descrição da seção.
 */
function my_social_media_section_html() {
    echo '<p>Insira a URL completa (com http:// ou https://) para cada perfil de rede social.</p>';
}
/**
 * Funções de callback que renderizam cada campo de input.
 * Elas recuperam o valor salvo do banco de dados para pré-preencher o campo.
 */
function my_social_media_field_x_html() {
    $options = get_option('my_social_media_options');
    $value = isset($options['x']) ? esc_attr($options['x']) : '';
    echo '<input type="url" name="my_social_media_options[x]" value="' . $value . '" placeholder="https://x.com/nomedousuario" class="regular-text">';
}
function my_social_media_field_facebook_html() {
    $options = get_option('my_social_media_options');
    $value = isset($options['facebook']) ? esc_attr($options['facebook']) : '';
    echo '<input type="url" name="my_social_media_options[facebook]" value="' . $value . '" placeholder="https://facebook.com/nomedapagina" class="regular-text">';
}
function my_social_media_field_instagram_html() {
    $options = get_option('my_social_media_options');
    $value = isset($options['instagram']) ? esc_attr($options['instagram']) : '';
    echo '<input type="url" name="my_social_media_options[instagram]" value="' . $value . '" placeholder="https://instagram.com/nomedousuario" class="regular-text">';
}
function my_social_media_field_linkedin_html() {
    $options = get_option('my_social_media_options');
    $value = isset($options['linkedin']) ? esc_attr($options['linkedin']) : '';
    echo '<input type="url" name="my_social_media_options[linkedin]" value="' . $value . '" placeholder="https://linkedin.com/in/nomedousuario" class="regular-text">';
}
/**
 * Função principal que renderiza toda a página HTML da página de configurações.
 */
function my_theme_social_media_page_html() {
    // Checa se o usuário tem a capacidade necessária.
    if (!current_user_can('edit_pages')) {
        return;
    }
    // Save settings
    if (isset($_POST['my_social_media_options'])) {
        update_option('my_social_media_options', $_POST['my_social_media_options']);
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="" method="post">
            <?php
            // Campos de formulário padrão do WordPress, incluindo nonce para segurança.
            settings_fields('my-social-media-settings');
            // Exibe as seções e os campos registrados.
            do_settings_sections('my-social-media-settings');
            // Botão de salvar.
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
/**
 * Função para exibir os links das redes sociais no frontend.
 * Exemplo de uso: <?php my_theme_display_social_media(); ?>
 */
function my_theme_display_social_media() {
    $options = get_option('my_social_media_options');
    if (empty($options)) {
        return;
    }
    echo '<div class="social-links mt-3">';
    // X (Twitter)
    if (!empty($options['x'])) {
        echo '<a href="' . esc_url($options['x']) . '" target="_blank" rel="noopener noreferrer"><i class="bx bxl-twitter"></i></a>';
    }
    // Facebook
    if (!empty($options['facebook'])) {
        echo '<a href="' . esc_url($options['facebook']) . '" target="_blank" rel="noopener noreferrer"><i class="bx bxl-facebook"></i></a>';
    }
    // Instagram
    if (!empty($options['instagram'])) {
        echo '<a href="' . esc_url($options['instagram']) . '" target="_blank" rel="noopener noreferrer"><i class="bx bxl-instagram"></i></a>';
    }
    // LinkedIn
    if (!empty($options['linkedin'])) {
        echo '<a href="' . esc_url($options['linkedin']) . '" target="_blank" rel="noopener noreferrer"><i class="bx bxl-linkedin"></i></a>';
    }
    echo '</div>';
}




////////////////////////////////////////////////////////
// Adiciona o menu "Contato" no painel administrativo //
////////////////////////////////////////////////////////
function add_contact_settings_menu() {
    add_menu_page(
        'Contato',                      // Título da página
        'Contato',                      // Título do menu
        'edit_pages',                   // Capacidade necessária
        'contact-settings',             // Slug do menu
        'contact_settings_page',        // Função que renderiza o conteúdo da página
        'dashicons-phone',              // Ícone do menu
        50                              // Posição no menu
    );
}
add_action('admin_menu', 'add_contact_settings_menu');
// Enfileira scripts para o menu "Contato"
function enqueue_contact_settings_scripts($hook) {
    if (strpos($hook, 'contact-settings') !== false) {
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_contact_settings_scripts');
// Renderiza a página de configurações do menu "Contato"
function contact_settings_page() {
    // Salva os dados ao enviar o formulário
    if (isset($_POST['contact_settings_submit'])) {
        update_option('contact_address', sanitize_textarea_field($_POST['contact_address']));
        update_option('contact_email', sanitize_email($_POST['contact_email']));
        update_option('contact_telefax', sanitize_textarea_field($_POST['contact_telefax']));
    }
    // Valores padrão
    $default_address = 'Av. Prof. Magalhães Neto, n° 1550, Ed. Premier Tower Empresarial, Conj. salas 1106 a 1110, Pituba, Salvador/BA. CEP 41.810-012';
    $default_email = 'recepcao@azietorres.com.br';
    $default_telefax = "71 3342-1228\n71 3646-8170";
    // Recupera os valores salvos ou usa os padrões
    $address = get_option('contact_address', $default_address);
    $email = get_option('contact_email', $default_email);
    $telefax = get_option('contact_telefax', $default_telefax);
    ?>
    <div class="wrap">
        <h1>Seção de Contato</h1>
        <hr>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th><label for="contact_address">Endereço</label></th>
                    <td><textarea id="contact_address" name="contact_address" rows="4" class="large-text"><?php echo esc_textarea($address); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="contact_email">Email</label></th>
                    <td><input type="email" id="contact_email" name="contact_email" value="<?php echo esc_attr($email); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="contact_telefax">Telefax</label></th>
                    <td><textarea id="contact_telefax" name="contact_telefax" rows="2" class="large-text"><?php echo esc_textarea($telefax); ?></textarea></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="contact_settings_submit" class="button-primary" value="Salvar Alterações">
            </p>
        </form>
    </div>
    <?php
}
// Função para exibir os dados de contato no frontend
function display_contact_info() {
    $address = get_option('contact_address');
    $email = get_option('contact_email');
    $telefax = get_option('contact_telefax');
    echo '<div class="contact-info">';
        echo '<p><strong>Endereço:</strong> ' . esc_html($address) . '</p>';
        echo '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
        echo '<p><strong>Telefax:</strong> ' . nl2br(esc_html($telefax)) . '</p>';
    echo '</div>';
}





///////////////////////////////////////////////
// Paginação de artigos
///////////////////////////////////////////////
function my_custom_pagination($query = null) {
    if ($query === null) {
        global $wp_query;
        $query = $wp_query;
    }
    $big = 999999999; // an unlikely integer
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'prev_text' => '<i class="bi bi-arrow-left"></i>',
        'next_text' => '<i class="bi bi-arrow-right"></i>',
        'type' => 'list',
    ));
    if ($pagination) {
        echo '<div class="">' . $pagination . '</div>';
    }
}
///////////////////////////////////////
// Previous/next post navigation
///////////////////////////////////////
function navegacao_post() {
    // Adicionamos um container para facilitar a estilização com CSS
    echo '<div class="post-navigation">';
    the_post_navigation( array(
        'screen_reader_text' => ' ', // Garante que o título não seja exibido
        'prev_text'          => '<i class="bi bi-arrow-left"></i>',
        'next_text'          => '<i class="bi bi-arrow-right"></i>',
    ) );
    echo '</div>';
}
