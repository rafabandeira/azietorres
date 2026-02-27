<?php
/**
 * Template part for displaying the about section
 */
$escritorio_img = get_option('escritorio_image');
$escritorio_img = $escritorio_img ? $escritorio_img : get_template_directory_uri() . '/assets/img/recepcao.jpg';
$escritorio_title = get_option('escritorio_title', 'Azi & Torres Castro Habib Pinto<br>Advogados Associados');
$escritorio_italic = get_option('escritorio_italic', 'Atuando há quase 20 anos no mercado e pautado em valores como confiabilidade, qualidade, eficiência, ética e inovação.');
$escritorio_list = get_option('escritorio_list', "Destaca-se pela seriedade;\nVasta experiência nos campos de direito público e privado;\nCélere resposta às demandas que lhe são confiadas;\nSolução dos desafios impostos por um mercado competitivo e exigente.");
$escritorio_text = get_option('escritorio_text', 'Com atendimento rápido e eficiente, conta com estrutura para ampla atuação em assessoria, consultoria e contencioso. Para tanto, é composto por uma equipe jurídica qualificada e especializada e por um corpo administrativo apto a prestar serviços diferenciados que proporciona aos seus clientes uma completa experiênciam e assistência.');
?>
<!-- ======= About Section ======= -->
<section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="row ">
            <div class="col-lg-6 p-3" data-aos="zoom-in" data-aos-delay="100">
                <img src="<?php echo esc_url($escritorio_img); ?>" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 p-5 content">
                <h3>
                    <?php echo wp_kses_post($escritorio_title); ?>
                </h3>
                <p class="fst-italic">
                    <?php echo esc_html($escritorio_italic); ?>
                </p>
                <ul>
                    <?php foreach (explode("\n", $escritorio_list) as $item) {
                        $item = trim($item);
                        if ($item) {
                            echo '<li><i class="bx bx-check-double"></i> ' . esc_html($item) . '</li>';
                        }
                    } ?>
                </ul>
                <p>
                    <?php echo wp_kses_post($escritorio_text); ?>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->