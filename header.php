<?php require_once __DIR__ . '/functions/security.php' ?>

<!DOCTYPE html> 

<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta content="<?php get_the_title(); ?>" name="description">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" rel="stylesheet">


        <?php
        // Define a descrição com base no tipo de página
        if ( is_singular() ) {
            // Se for um post/página, use o resumo (excerpt) ou o conteúdo
            $og_description = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 50 );
        } else {
            // Se for a página inicial ou de arquivo, use a descrição do site
            $og_description = get_bloginfo( 'description' );
        }
        // Define o título com base no tipo de página
        if ( is_singular() ) {
            $og_title = get_the_title();
        } else {
            $og_title = get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
        }
        // Define a URL da página atual
        $og_url = get_permalink();
        // Define a imagem com base no tipo de página
        if ( is_singular() && has_post_thumbnail() ) {
            $og_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
        } else {
            // Imagem padrão do site caso não haja imagem destacada
            $og_image = get_template_directory_uri() . '/assets/img/favicon-azietorres-02.png';
        }
        ?>
        <!-- Open Graph Meta Tags -->
        <meta property="og:url" content="<?php echo esc_url( $og_url ); ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo esc_attr( $og_title ); ?>">
        <meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>">
        <meta property="og:image" content="<?php echo esc_url( $og_image ); ?>">
        <meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>">
        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="<?php echo parse_url(home_url(), PHP_URL_HOST); ?>">
        <meta property="twitter:url" content="<?php echo esc_url( $og_url ); ?>">
        <meta name="twitter:title" content="<?php echo esc_attr( $og_title ); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>">
        <meta name="twitter:image" content="<?php echo esc_url( $og_image ); ?>">
    </head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between"> 
        <a href="<?php echo home_url(); ?>" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="" class="img-fluid"></a>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto <?php if (is_front_page()) echo 'active'; ?>" href="<?php echo home_url('#hero'); ?>">Home</a></li>
                <li><a class="nav-link scrollto <?php if (is_page('about')) echo 'active'; ?>" href="<?php echo home_url('#about'); ?>">Escritório</a></li>
                <li><a class="nav-link scrollto <?php if(get_post_type() == 'area_atuacao'){echo 'active';}?>" href="<?php echo home_url('#atuacao'); ?>">Atuação</a></li>
                <li><a class="nav-link scrollto <?php if (is_page('team')) echo 'active'; ?>" href="<?php echo home_url('#team'); ?>">Advogados</a></li>
                <li><a class="nav-link scrollto <?php if (is_page('artigos')) echo 'active'; ?>" href="<?php echo home_url('/artigos'); ?>">Artigos</a></li>
                <li><a class="nav-link scrollto <?php if (is_page('contact')) echo 'active'; ?>" href="<?php echo home_url('#contact'); ?>">Contato</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i> 
        </nav>
    <!-- .navbar --> 

    </div>
</header>
<!-- End Header --> 