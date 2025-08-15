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

        <!-- Open Graph Meta Tags -->
        <meta property="og:url" content="<?php get_permalink(); ?>">
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>">
        <meta property="og:description" content="<?php custom_excerpt(150); ?>">
        <meta property="og:image" content="<?php echo get_the_post_thumbnail_url($post->ID); ?>">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="<?php echo parse_url(home_url(), PHP_URL_HOST); ?>">
        <meta property="twitter:url" content="<?php get_permalink(); ?>">
        <meta name="twitter:title" content="<?php wp_title( '|', true, 'right' ); ?>">
        <meta name="twitter:description" content="<?php custom_excerpt(150); ?>">
        <meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url($post->ID); ?>">
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