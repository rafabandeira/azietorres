<?php
/**
 * Template part for displaying the hero section
 */
$hero_bg = get_option('hero_background_image');
$hero_logo = get_option('hero_logo_image');
$default_bg = get_template_directory_uri() . '/assets/img/recepcao.jpeg';
$default_logo = get_template_directory_uri() . '/assets/img/logo2.png';
?>
<!-- ======= Hero Section ======= -->
<section id="hero"
  style="background: url('<?php echo esc_url($hero_bg ? $hero_bg : $default_bg); ?>') center center/cover no-repeat;">
  <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
    <img src="<?php echo esc_url($hero_logo ? $hero_logo : $default_logo); ?>" alt="" class="img-fluid">
  </div>
</section>
<!-- End Hero -->
