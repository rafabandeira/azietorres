<?php get_header(); ?>

<!-- Page Title -->
<div class="page-title dark-background" data-aos="fade" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/recepcao.jpeg);">
    <div class="container position-relative">
        <h1><?php the_title(); ?></h1>
    </div>
</div><!-- End Page Title -->

<!-- Portfolio Details Section -->
<section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image mb-5" style="overflow: hidden; border-radius: 5px; height: 400px; display: flex; justify-content: center; align-items: center;">
                            <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt="<?php the_title(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php endif; ?>
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_content(); ?></p>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Portfolio Details Section -->

<!-- Navigation Section -->
<section class="section">
    <div class="container" data-aos="fade-up" data-aos-delay="200">
        <div class="row">
            <div class="position-relative">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <?php navegacao_post(); ?>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Navigation Section -->

<?php get_footer(); ?>