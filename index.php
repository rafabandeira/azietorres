<?php 
  require_once __DIR__ . '/functions/security.php';
  get_header(); 
  $post_response = apply_filters( 'send_contact_form', false );
?> 

<!-- ======= Hero Section ======= --> 
<?php
    $hero_bg = get_option('hero_background_image');
    $hero_logo = get_option('hero_logo_image');
    $default_bg = get_template_directory_uri() . '/assets/img/recepcao.jpeg';
    $default_logo = get_template_directory_uri() . '/assets/img/logo2.png';
?>
<section id="hero" style="background: url('<?php echo esc_url($hero_bg ? $hero_bg : $default_bg); ?>') center center/cover no-repeat;"> 
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <img src="<?php echo esc_url($hero_logo ? $hero_logo : $default_logo); ?>" alt="" class="img-fluid">
    </div>
</section>
<!-- End Hero -->

<main id="main"> 
  
    <!-- ======= About Section ======= -->
    <?php
    $escritorio_img = get_option('escritorio_image');
    $escritorio_img = $escritorio_img ? $escritorio_img : get_template_directory_uri() . '/assets/img/recepcao.jpg';
    $escritorio_title = get_option('escritorio_title', 'Azi & Torres Castro Habib Pinto<br>Advogados Associados');
    $escritorio_italic = get_option('escritorio_italic', 'Atuando há quase 20 anos no mercado e pautado em valores como confiabilidade, qualidade, eficiência, ética e inovação.');
    $escritorio_list = get_option('escritorio_list', "Destaca-se pela seriedade;\nVasta experiência nos campos de direito público e privado;\nCélere resposta às demandas que lhe são confiadas;\nSolução dos desafios impostos por um mercado competitivo e exigente.");
    $escritorio_text = get_option('escritorio_text', 'Com atendimento rápido e eficiente, conta com estrutura para ampla atuação em assessoria, consultoria e contencioso. Para tanto, é composto por uma equipe jurídica qualificada e especializada e por um corpo administrativo apto a prestar serviços diferenciados que proporciona aos seus clientes uma completa experiência e assistência.');
    ?>
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="row ">
                <div class="col-lg-6 p-3" data-aos="zoom-in" data-aos-delay="100"> 
                    <img src="<?php echo esc_url($escritorio_img); ?>" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 p-5 content">
                    <h3><?php echo $escritorio_title; ?></h3>
                    <p class="fst-italic"> <?php echo $escritorio_italic; ?> </p>
                    <ul>
                        <?php foreach (explode("\n", $escritorio_list) as $item) {
                            $item = trim($item);
                            if ($item) {
                                echo '<li><i class="bx bx-check-double"></i> ' . esc_html($item) . '</li>';
                            }
                        } ?>
                    </ul>
                    <p> <?php echo $escritorio_text; ?> </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section --> 
  
    <!-- ======= About Boxes Section ======= -->
    <?php
    $vvm_visao_img = get_option('vvm_visao_img');
    $vvm_visao_img = $vvm_visao_img ? $vvm_visao_img : get_template_directory_uri() . '/assets/img/visao.jpg';
    $vvm_visao_title = get_option('vvm_visao_title', 'Nossa visão');
    $vvm_visao_text = get_option('vvm_visao_text', 'Exceder as expectativas dos clientes, tendo como referência a atuação eficaz e de vanguarda nas demandas apresentadas, através de uma assessoria inteligente, dedicada à pacificação social.');

    $vvm_valores_img = get_option('vvm_valores_img');
    $vvm_valores_img = $vvm_valores_img ? $vvm_valores_img : get_template_directory_uri() . '/assets/img/valores.jpg';
    $vvm_valores_title = get_option('vvm_valores_title', 'Nossos valores');
    $vvm_valores_text = get_option('vvm_valores_text', '<i class="bx bx-check-double"></i> Ética e honestidade;<br>
        <i class="bx bx-check-double"></i> Dedicação e criatividade;<br>
        <i class="bx bx-check-double"></i> Trabalho em equipe;<br>
        <i class="bx bx-check-double"></i> Qualidade no atendimento aos clientes;<br>
        <i class="bx bx-check-double"></i> Profissionalismo e proatividade;<br>
        <i class="bx bx-check-double"></i> Cooperação e responsabilidade social.');

    $vvm_missao_img = get_option('vvm_missao_img');
    $vvm_missao_img = $vvm_missao_img ? $vvm_missao_img : get_template_directory_uri() . '/assets/img/missao.jpg';
    $vvm_missao_title = get_option('vvm_missao_title', 'Nossa missão');
    $vvm_missao_text = get_option('vvm_missao_text', 'Prestar serviços jurídicos com ética, responsabilidade e dedicação em busca de soluções inteligentes e contemporâneas para atender as complexas demandas apresentadas, com foco na solução satisfatória.');
    ?>
    <section id="about-boxes" class="about-boxes">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="card"> <img src="<?php echo esc_url($vvm_visao_img); ?>" class="card-img-top" alt="...">
              <div class="card-icon"> <i class="ri-eye-line"></i> </div>
              <div class="card-body">
                <h5 class="card-title"><a href=""><?php echo esc_html($vvm_visao_title); ?></a></h5>
                <p class="card-text"><?php echo $vvm_visao_text; ?></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="card"> <img src="<?php echo esc_url($vvm_valores_img); ?>" class="card-img-top" alt="...">
              <div class="card-icon"> <i class="ri-shield-star-line"></i> </div>
              <div class="card-body">
                <h5 class="card-title"><a href=""><?php echo esc_html($vvm_valores_title); ?></a></h5>
                <ul class="card-text">
                  <?php 
                  $valores_list = get_option('vvm_valores_list', "Ética e honestidade;\nDedicação e criatividade;\nTrabalho em equipe;\nQualidade no atendimento aos clientes;\nProfissionalismo e proatividade;\nCooperação e responsabilidade social.");
                  foreach (explode("\n", $valores_list) as $item) {
                    $item = trim($item);
                    if ($item) {
                      echo '<li><i class="bx bx-check-double"></i> ' . esc_html($item) . '</li>';
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="card"> <img src="<?php echo esc_url($vvm_missao_img); ?>" class="card-img-top" alt="...">
              <div class="card-icon"> <i class="ri-auction-line"></i> </div>
              <div class="card-body">
                <h5 class="card-title"><a href=""><?php echo esc_html($vvm_missao_title); ?></a></h5>
                <p class="card-text"><?php echo $vvm_missao_text; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      </section>
    <!-- End About Boxes Section --> 
  
  
<!-- ======= Services Section ======= -->
<section id="atuacao" class="services section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Atuação</h2>
            <p>Áreas de atuação</p>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="200">
            <?php
            // Query para buscar as Áreas de Atuação
            $args = array(
                'post_type' => 'area_atuacao',
                'posts_per_page' => -1, // Busca todas as áreas de atuação
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    // Recupera os dados personalizados
                    $icon = get_post_meta(get_the_ID(), '_area_atuacao_icon', true);
                    $summary = get_post_meta(get_the_ID(), '_area_atuacao_summary', true);
            ?>
                    <div class="col-md-6 mt-4 mt-md-0">
                        <div class="icon-box">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <p><?php echo esc_html($summary); ?></p>
                        </div>
                    </div>
            <?php
                endwhile; wp_reset_postdata();
            else :
                echo '<p>Nenhuma área de atuação encontrada.</p>';
            endif;
            ?>
        </div>
    </div>
</section>
<!-- End Services Section -->
  
<!-- ======= Team Section ======= -->
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
                    // Query para buscar os advogados
                    $args = array(
                        'post_type' => 'advogado',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $photo = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $expertise = get_post_meta(get_the_ID(), '_advogado_expertise', true);
                    ?>
                    <div class="swiper-slide">
                        <div class="member" data-aos="fade-up">
                            <div class="pic">
                                <img src="<?php echo esc_url($photo ? $photo : get_template_directory_uri() . '/assets/img/team/default.jpg'); ?>" class="img-fluid featured-image-fix" alt="<?php the_title(); ?>">
                            </div>
                            <div class="member-info">
                                <h4><?php the_title(); ?></h4>
                                <span><?php echo esc_html($expertise); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                        endwhile; wp_reset_postdata();
                    else :
                        echo '<p>Nenhum advogado encontrado.</p>';
                    endif;
                    ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
              var swiper = new Swiper(".mySwiper", {
                  slidesPerView: 4,
                  spaceBetween: 30,
                  navigation: {
                      nextEl: ".swiper-button-next",
                      prevEl: ".swiper-button-prev",
                  },
                  pagination: {
                      el: ".swiper-pagination",
                      clickable: true,
                  },
                  loop: true, // Adiciona o loop infinito
                  autoplay: { // Configura o autoplay
                      delay: 2500, // Tempo em milissegundos entre as transições
                      disableOnInteraction: false, // Continua a reprodução automática mesmo após o usuário interagir
                  },
                  breakpoints: {
                      320: {
                          slidesPerView: 1
                      },
                      768: {
                          slidesPerView: 2
                      },
                      1024: {
                          slidesPerView: 4
                      }
                  }
              });
          });
      </script>
    </div>
</section>
<!-- End Team Section -->
  
  <!-- ======= Contact Section ======= -->
  <?php
    $contact_endereco = get_option('contact_endereco', "Av. Prof. Magalhães Neto, n° 1550, Ed. Premier Tower Empresarial, Conj. salas 1106 a 1110, Pituba, Salvador/BA. CEP 41.810-012");
    $contact_email = get_option('contact_email', "recepcao@azietorres.com.br");
    $contact_tel = get_option('contact_telefax', "71 3342-1228\n71 3646-8170");
  ?>
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
      <div class=" section-title">
        <h2>Contato</h2>
        <p>Entre em contato</p>
      </div>
<?php if( $post_response ) : ?>
  <div class="alert alert-<?php echo $post_response->status ?>">
    <?php echo $post_response->message ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.location.hash = '#contact';
        });
    </script>
  </div>
<?php endif ?>
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-md-12">
              <div class="info-box"> 
                <i class="bx bx-map"></i>
                <h3>Endereço</h3>
                <p><?php echo esc_html($contact_endereco); ?></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box mt-4"> <i class="bx bx-envelope"></i>
                <h3>Email</h3>
                <p><?php echo esc_html($contact_email); ?></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-box mt-4"> <i class="bx bx-phone-call"></i>
                <h3>Telefax</h3>
                <?php 
                    $telefones = esc_html($contact_tel);
                    foreach (explode("\n", $telefones) as $item) {
                        $item = trim($item);
                        if ($item) { echo '<p> ' . esc_html($item) . '</p>'; }
                    }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" class="email-form">
                <div class="row">
                  <div class="col-md-6 form-group">
                      <input class="form-control" type="text" name="field_name" id="field-name" placeholder="Seu nome" required />
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                      <input class="form-control" type="email" name="field_email" id="field-email" placeholder="Seu email" required />
                  </div>
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="field_subject" id="field-subject" placeholder="Assunto" class="form-control [ input-text ] contact-form__list-item__input" />
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control" name="field_message" id="field-message" rows="5" placeholder="Mensagem" required></textarea>
                </div>
                <div class="text-center my-3">
                    <button type="submit">Enviar mensagem</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </section>
  <!-- End Contact Section --> 
  
</main>
<!-- End #main --> 


<?php get_footer(); ?>

