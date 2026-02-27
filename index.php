<?php
/**
 * Main Template File
 * Used to display the front page of the theme.
 */

require_once __DIR__ . '/functions/security.php';

get_header();

// Process contact form response if any
$post_response = apply_filters('send_contact_form', false);
?>

<main id="main">

  <?php
  // Hero Section
  get_template_part('template-parts/section', 'hero');

  // About Section
  get_template_part('template-parts/section', 'about');

  // About Boxes Section (Mission, Vision, Values)
  get_template_part('template-parts/section', 'about-boxes');

  // Areas of Expertise Section
  get_template_part('template-parts/section', 'atuacao');

  // Team Section
  get_template_part('template-parts/section', 'team');

  // Contact Section
  get_template_part('template-parts/section', 'contact', array('post_response' => $post_response));
  ?>

</main><!-- End #main -->

<?php get_footer(); ?>