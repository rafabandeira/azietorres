<?php require_once __DIR__ . '/functions/security.php' ?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo esc_attr(get_bloginfo('description')); ?>" name="description">

    <?php wp_head(); ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="<?php echo home_url(); ?>" class="logo"><img
                    src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="" class="img-fluid"></a>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto <?php if (is_front_page())
                        echo 'active'; ?>" href="<?php echo home_url('#hero'); ?>">Home</a></li>
                    <li><a class="nav-link scrollto <?php if (is_page('about'))
                        echo 'active'; ?>" href="<?php echo home_url('#about'); ?>">Escritório</a></li>
                    <?php if (tem_area_atuacao_posts()): ?>
                        <li><a class="nav-link scrollto <?php if (is_singular('area_atuacao')) {
                            echo 'active';
                        } ?>" href="<?php echo home_url('/#atuacao'); ?>">Atuação</a></li>
                    <?php endif; ?>
                    <?php if (tem_advogado_posts()): ?>
                        <li><a class="nav-link scrollto <?php if (is_page('team'))
                            echo 'active'; ?>" href="<?php echo home_url('#team'); ?>">Advogados</a></li>
                    <?php endif; ?>
                    <?php if (tem_artigos_posts()): ?>
                        <li><a class="nav-link scrollto <?php if (is_page('artigos'))
                            echo 'active'; ?>" href="<?php echo home_url('/artigos'); ?>">Artigos</a></li>
                    <?php endif; ?>
                    <li><a class="nav-link scrollto <?php if (is_page('contact'))
                        echo 'active'; ?>" href="<?php echo home_url('#contact'); ?>">Contato</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->