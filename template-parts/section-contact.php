<?php
/**
 * Template part for displaying the contact section
 */
$contact_endereco = get_option('contact_endereco', "Av. Prof. Magalhães Neto, n° 1550, Ed. Premier Tower Empresarial, Conj. salas 1106 a 1110, Pituba, Salvador/BA. CEP 41.810-012");
$contact_email = get_option('contact_email', "recepcao@azietorres.com.br");
$contact_tel = get_option('contact_telefax', "71 3342-1228\n71 3646-8170");

// $args['post_response'] is passed via get_template_part() in WP 5.5+
$post_response = isset($args['post_response']) ? $args['post_response'] : null;
?>
<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        <div class=" section-title">
            <h2>Contato</h2>
            <p>Entre em contato</p>
        </div>
        <?php if ($post_response): ?>
            <div class="alert alert-<?php echo $post_response->status ?>">
                <?php echo $post_response->message ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
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
                            <p>
                                <?php echo esc_html($contact_endereco); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box mt-4"> <i class="bx bx-envelope"></i>
                            <h3>Email</h3>
                            <p>
                                <?php echo esc_html($contact_email); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box mt-4"> <i class="bx bx-phone-call"></i>
                            <h3>Telefax</h3>
                            <?php
                            $telefones = esc_html($contact_tel);
                            foreach (explode("\n", $telefones) as $item) {
                                $item = trim($item);
                                if ($item) {
                                    echo '<p> ' . esc_html($item) . '</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" class="email-form">
                    <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input class="form-control" type="text" name="field_name" id="field-name"
                                placeholder="Seu nome" required />
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input class="form-control" type="email" name="field_email" id="field-email"
                                placeholder="Seu email" required />
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" name="field_subject" id="field-subject" placeholder="Assunto"
                            class="form-control [ input-text ] contact-form__list-item__input" />
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="field_message" id="field-message" rows="5"
                            placeholder="Mensagem" required></textarea>
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