<?php
/**
 * Template part for displaying the team section
 */
$args = array(
    'post_type' => 'advogado',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);
$query = new WP_Query($args);

if ($query->have_posts()): ?>
    <!-- ======= Advogados Section ======= -->
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Equipe</h2>
                <p>Sócios e Advogados</p>
            </div>
            <div class="row">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        while ($query->have_posts()):
                            $query->the_post();
                            $photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $expertise = get_post_meta(get_the_ID(), '_advogado_expertise', true);
                            ?>
                            <div class="swiper-slide">
                                <div class="member" data-aos="fade-up">
                                    <div class="pic">
                                        <img src="<?php echo esc_url($photo ? $photo : get_template_directory_uri() . '/assets/img/team/default.jpg'); ?>"
                                            class="img-fluid featured-image-fix" alt="<?php the_title(); ?>">
                                    </div>
                                    <div class="member-info">
                                        <h4>
                                            <?php the_title(); ?>
                                        </h4>
                                        <span>
                                            <?php echo esc_html($expertise); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= Fim de Advogados Section ======= -->
<?php endif; ?>