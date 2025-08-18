<?php require_once __DIR__ . '/functions/security.php' ?>

<!-- ======= Footer ======= -->
  <?php
    $contact_endereco = get_option('contact_endereco', "Av. Prof. Magalhães Neto, n° 1550, Ed. Premier Tower Empresarial, Conj. salas 1106 a 1110, Pituba, Salvador/BA. CEP 41.810-012");
    $contact_email = get_option('contact_email', "recepcao@azietorres.com.br");
    $contact_tel = get_option('contact_telefax', "71 3342-1228\n71 3646-8170");
  ?>

<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="footer-info">
            <h3><?php bloginfo('nome'); ?><br><?php bloginfo('description'); ?></h3>
            <p><?php echo esc_html($contact_endereco); ?><br>
                <br>
                <strong>Telefone:</strong> 
                  <?php 
                    $items = explode("\n", $contact_tel);
                    $first = true; // Flag to check if it's the first item
                    foreach ($items as $item) {
                        $item = trim($item);
                        if ($item) { 
                            if (!$first) {
                                echo ' • '; // Add separator only after the first item
                            }
                            echo esc_html($item);
                            $first = false; // Set flag to false after the first item
                        }
                    }
                  ?>
                <br>
                <strong>Email:</strong> <?php echo esc_html($contact_email); ?><br>
            </p>
            <div class="social-links mt-3"> 
                <?php my_theme_display_social_media(); ?> 
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Menu</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="/#hero">Home</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="/#about">Escritório</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="/#atuacao">Atuação</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="/#team">Advogados</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="/artigos">Artigos</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Áreas de atuação</h4>
          <?php
            // Query para buscar as Áreas de Atuação
            $args = array(
                'post_type' => 'area_atuacao',
                'posts_per_page' => -1, // Busca todas as áreas de atuação
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            ?>
            <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            </ul>
            <?php
                endwhile; wp_reset_postdata();
            else :
                echo '<p>Nenhuma área de atuação encontrada.</p>';
            endif;
            ?>





        </div>
        <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Newsletter</h4>
            <p>Assine nossa lista de transmissão</p>
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <input type="email" name="email">
                <input type="submit" value="Assinar">
            </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
        <div class="copyright"> Copyright &copy; <strong><span><?php bloginfo('nome'); ?> – <?php bloginfo('description'); ?></span></strong>. Todos os direitos reservados </div>
        <div class="credits"> Desenvolvido pela <a href="https://bandeiragroup.com.br/">BandeiraGroup Design & Web</a> </div>
  </div>
</footer>
<!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> 

<!-- Vendor JS Files --> 

<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/aos/aos.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/glightbox/js/glightbox.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/swiper/swiper-bundle.min.js"></script> 

<!-- Template Main JS File --> 

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>
</body>
</html>