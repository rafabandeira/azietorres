<?php
/**
 * Template Name: Artigos
 */

get_header(); ?>

<!-- Page Title -->
<div class="page-title dark-background" data-aos="fade" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/artigos-1.jpg);">
    <div class="container position-relative">
        <h1><?php echo strtoupper(get_the_title()); ?></h1>
        <p>Confira nossos artigos e publicações.</p>
    </div>
</div><!-- End Page Title -->

<!-- ======= Artigos Section ======= -->
<section id="artigos" class="artigos section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Artigos</h2>
            <p>Confira nossos artigos e publicações.</p>
        </div>
        <div class="row">
            <?php
            // Query para buscar os artigos
            $args = array(
                'post_type' => 'post', // Ou 'artigos' se for um Custom Post Type
                'posts_per_page' => 9, // Número de artigos por página
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // Paginação
                'orderby' => 'date',
                'order' => 'DESC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="col-lg-4 col-md-6 gb-5"> 
                <div class="article-box mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="article-img">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-image" style="overflow: hidden; border-radius: 5px; height: 200px; display: flex; justify-content: center; align-items: center;">
                                    <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid rounded" alt="<?php the_title(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            <?php else : ?>
                                <div class="featured-image" style="overflow: hidden; border-radius: 5px; height: 200px; display: flex; justify-content: center; align-items: center;">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/artigos.jpg" class="img-fluid rounded " alt="Imagem padrão">
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="article-content my-3">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="small"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more">Leia mais</a>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Nenhum artigo encontrado.</p>';
            endif;
            ?>
        </div>

        <!-- Paginação -->
        <div class="container" data-aos="fade-up" data-aos-delay="200">
            <div class="row">
                <div class="position-relative">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <?php my_custom_pagination($query); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Paginação -->

    </div>
</section>
<!-- End Artigos Section -->

<?php get_footer(); ?>