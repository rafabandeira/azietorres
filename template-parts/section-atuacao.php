<?php
/**
 * Template part for displaying the areas of expertise section
 */
$args = array(
    'post_type' => 'area_atuacao',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);
$query_atuacao = new WP_Query($args);

if ($query_atuacao->have_posts()):
    ?>
    <!-- ======= Áreas de Atuação Section ======= -->
    <section id="atuacao" class="services section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Atuação</h2>
                <p>Áreas de atuação</p>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <?php
                while ($query_atuacao->have_posts()):
                    $query_atuacao->the_post();
                    $icon = get_post_meta(get_the_ID(), '_area_atuacao_icon', true);
                    $summary = get_post_meta(get_the_ID(), '_area_atuacao_summary', true);
                    ?>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="icon-box">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                            <h4><a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a></h4>
                            <p>
                                <?php echo esc_html($summary); ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <!-- ======= Fim de Áreas de Atuação Section ======= -->
    <?php
    wp_reset_postdata();
endif;
?>