<?php
/**
 * Template part for displaying the about boxes (Vision, Mission, Values)
 */
$vvm_visao_img = get_option('vvm_visao_img');
$vvm_visao_img = $vvm_visao_img ? $vvm_visao_img : get_template_directory_uri() . '/assets/img/visao.jpg';
$vvm_visao_title = get_option('vvm_visao_title', 'Nossa visão');
$vvm_visao_text = get_option('vvm_visao_text', 'Exceder as expectativas dos clientes, tendo como referência a atuação eficaz e de vanguarda nas demandas apresentadas, através de uma assessoria inteligente, dedicada à pacificação social.');

$vvm_valores_img = get_option('vvm_valores_img');
$vvm_valores_img = $vvm_valores_img ? $vvm_valores_img : get_template_directory_uri() . '/assets/img/valores.jpg';
$vvm_valores_title = get_option('vvm_valores_title', 'Nossos valores');

$vvm_missao_img = get_option('vvm_missao_img');
$vvm_missao_img = $vvm_missao_img ? $vvm_missao_img : get_template_directory_uri() . '/assets/img/missao.jpg';
$vvm_missao_title = get_option('vvm_missao_title', 'Nossa missão');
$vvm_missao_text = get_option('vvm_missao_text', 'Prestar serviços jurídicos com ética, responsabilidade e dedicação em busca de soluções inteligentes e contemporâneas para atender as complexas demandas apresentadas, com foco na solução satisfatória.');
?>
<!-- ======= About Boxes Section ======= -->
<section id="about-boxes" class="about-boxes">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="card"> <img src="<?php echo esc_url($vvm_visao_img); ?>" class="card-img-top" alt="...">
                    <div class="card-icon"> <i class="ri-eye-line"></i> </div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">
                                <?php echo esc_html($vvm_visao_title); ?>
                            </a></h5>
                        <p class="card-text">
                            <?php echo wp_kses_post($vvm_visao_text); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                <div class="card"> <img src="<?php echo esc_url($vvm_valores_img); ?>" class="card-img-top" alt="...">
                    <div class="card-icon"> <i class="ri-shield-star-line"></i> </div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="">
                                <?php echo esc_html($vvm_valores_title); ?>
                            </a></h5>
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
                        <h5 class="card-title"><a href="">
                                <?php echo esc_html($vvm_missao_title); ?>
                            </a></h5>
                        <p class="card-text">
                            <?php echo wp_kses_post($vvm_missao_text); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Boxes Section -->