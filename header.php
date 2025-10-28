<?php require_once __DIR__ . '/functions/security.php' ?>

<!DOCTYPE html> 

<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        
        <?php
        // Define a descrição com base no tipo de página
        if ( is_singular() ) {
            // Se for um post/página, use o resumo (excerpt) ou o conteúdo
            $page_description = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 50 );
            $page_title = get_the_title();
            $og_type = 'article';
        } else {
            // Se for a página inicial ou de arquivo, use a descrição do site
            $page_description = get_bloginfo( 'description' );
            $page_title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
            $og_type = 'website';
        }
        
        // Define a URL da página atual
        $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Define a imagem com base no tipo de página
        if ( is_singular() && has_post_thumbnail() ) {
            $page_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        } else {
            // Imagem padrão do site caso não haja imagem destacada
            $page_image = get_template_directory_uri() . '/assets/img/favicon-azietorres-02.png';
        }
        ?>
        
        <meta name="description" content="<?php echo esc_attr( $page_description ); ?>">

        <meta property="og:url" content="<?php echo esc_url( $page_url ); ?>">
        <meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>">
        <meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>">
        <meta property="og:description" content="<?php echo esc_attr( $page_description ); ?>">
        <meta property="og:image" content="<?php echo esc_url( $page_image ); ?>">
        <meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="<?php echo parse_url(home_url(), PHP_URL_HOST); ?>">
        <meta property="twitter:url" content="<?php echo esc_url( $page_url ); ?>">
        <meta name="twitter:title" content="<?php echo esc_attr( $page_title ); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr( $page_description ); ?>">
        <meta name="twitter:image" content="<?php echo esc_url( $page_image ); ?>">

        <?php 
        // ADICIONADO: Hook wp_head()
        // Essencial para plugins, 'title-tag' e scripts enfileirados.
        wp_head(); 
        ?>
    </head>

<body>

<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between"> 
        <a href="<?php echo home_url(); ?>" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="" class="img-fluid"></a>
        
        <nav id="navbar" class="navbar">
            <?php
            // CORREÇÃO: Substituído menu hardcoded por wp_nav_menu()
            // Requer registro em functions.php (adicionado na Etapa 2)
            // e criação do menu 'Menu Principal' no Admin WP.
            wp_nav_menu( array(
                'theme_location'  => 'primary',
                'container'       => false, // Remove a div container
                'menu_class'      => '', // Remove classes padrão do WP
                'items_wrap'      => '<ul>%3$s</ul>', // Mantém a estrutura <ul>
                'fallback_cb'     => false, // Não exibe nada se o menu não existir
                'depth'           => 1, // Apenas links de nível superior
            ) );
            ?>
            <i class="bi bi-list mobile-nav-toggle"></i> 
        </nav>
    </div>
</header>