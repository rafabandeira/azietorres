<?php
/**
 * Admin Settings Pages
 */

// Menus
add_action('admin_menu', 'azietorres_admin_menus');
function azietorres_admin_menus()
{
    // Hero
    add_menu_page('Abertura do Site', 'Abertura', 'edit_pages', 'hero-settings', 'hero_settings_page', 'dashicons-cover-image', 20);
    // Escritório
    add_menu_page('Escritório', 'Escritório', 'edit_pages', 'escritorio-settings', 'escritorio_settings_page', 'dashicons-admin-home', 21);
    // VVM
    add_menu_page('Visão, Valores e Missão', 'VVM', 'edit_pages', 'vvm-settings', 'vvm_settings_page', 'dashicons-lightbulb', 22);
    // Redes Sociais
    add_menu_page('Redes Sociais', 'Redes Sociais', 'edit_pages', 'my-social-media-settings', 'my_theme_social_media_page_html', 'dashicons-share', 50);
    // Contato
    add_menu_page('Contato', 'Contato', 'edit_pages', 'contact-settings', 'contact_settings_page', 'dashicons-phone', 51);
}

// Media Uploaer Enqueue
add_action('admin_enqueue_scripts', 'azietorres_admin_scripts');
function azietorres_admin_scripts($hook)
{
    $pages = array('hero-settings', 'escritorio-settings', 'vvm-settings', 'contact-settings');
    $is_our_page = false;
    foreach ($pages as $page) {
        if (strpos($hook, $page) !== false) {
            $is_our_page = true;
            break;
        }
    }
    if ($is_our_page) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}

// Hero Settings
function hero_settings_page()
{
    if (isset($_POST['hero_settings_submit'])) {
        if (!isset($_POST['hero_settings_nonce']) || !wp_verify_nonce($_POST['hero_settings_nonce'], 'hero_settings_save'))
            wp_die('Security Error');
        update_option('hero_background_image', esc_url_raw($_POST['hero_background_image']));
        update_option('hero_logo_image', esc_url_raw($_POST['hero_logo_image']));
    }
    $background_image = get_option('hero_background_image');
    $logo_image = get_option('hero_logo_image');
    $default_bg = get_template_directory_uri() . '/assets/img/recepcao.jpeg';
    $default_logo = get_template_directory_uri() . '/assets/img/logo2.png';
    ?>
    <div class="wrap">
        <h1>Abertura do Site</h1>
        <form method="post" action="">
            <?php wp_nonce_field('hero_settings_save', 'hero_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th>Imagem de fundo</th>
                    <td>
                        <input type="hidden" id="hero_background_image" name="hero_background_image"
                            value="<?php echo esc_attr($background_image); ?>">
                        <img id="hero_background_image_thumb"
                            src="<?php echo esc_url($background_image ? $background_image : $default_bg); ?>"
                            style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="hero_background_image"
                            data-thumb="hero_background_image_thumb">Selecionar Imagem</button>
                        <button type="button" class="button button-remove" data-input="hero_background_image"
                            data-thumb="hero_background_image_thumb"
                            data-default="<?php echo esc_attr($default_bg); ?>">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th>Marca</th>
                    <td>
                        <input type="hidden" id="hero_logo_image" name="hero_logo_image"
                            value="<?php echo esc_attr($logo_image); ?>">
                        <img id="hero_logo_image_thumb"
                            src="<?php echo esc_url($logo_image ? $logo_image : $default_logo); ?>"
                            style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="hero_logo_image"
                            data-thumb="hero_logo_image_thumb">Selecionar marca</button>
                        <button type="button" class="button button-remove" data-input="hero_logo_image"
                            data-thumb="hero_logo_image_thumb"
                            data-default="<?php echo esc_attr($default_logo); ?>">Remover</button>
                    </td>
                </tr>
            </table>
            <?php submit_button('Salvar Alterações', 'primary', 'hero_settings_submit'); ?>
        </form>
    </div>
    <?php azietorres_admin_inline_script();
}

// Escritório Settings
function escritorio_settings_page()
{
    if (isset($_POST['escritorio_settings_submit'])) {
        if (!isset($_POST['escritorio_settings_nonce']) || !wp_verify_nonce($_POST['escritorio_settings_nonce'], 'escritorio_settings_save'))
            wp_die('Security Error');
        update_option('escritorio_image', esc_url_raw($_POST['escritorio_image']));
        update_option('escritorio_title', wp_kses_post($_POST['escritorio_title']));
        update_option('escritorio_italic', sanitize_text_field($_POST['escritorio_italic']));
        update_option('escritorio_list', sanitize_textarea_field($_POST['escritorio_list']));
        update_option('escritorio_text', wp_kses_post($_POST['escritorio_text']));
    }
    $default_img = get_template_directory_uri() . '/assets/img/recepcao.jpg';
    $image = get_option('escritorio_image', $default_img);
    $title = get_option('escritorio_title', 'Azi & Torres Castro Habib Pinto<br>Advogados Associados');
    $italic = get_option('escritorio_italic');
    $list = get_option('escritorio_list');
    $text = get_option('escritorio_text');
    ?>
    <div class="wrap">
        <h1>Seção Escritório</h1>
        <form method="post" action="">
            <?php wp_nonce_field('escritorio_settings_save', 'escritorio_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th>Imagem</th>
                    <td>
                        <input type="hidden" id="escritorio_image" name="escritorio_image"
                            value="<?php echo esc_attr($image); ?>">
                        <img id="escritorio_image_thumb" src="<?php echo esc_url($image ? $image : $default_img); ?>"
                            style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="escritorio_image"
                            data-thumb="escritorio_image_thumb">Selecionar Imagem</button>
                        <button type="button" class="button button-remove" data-input="escritorio_image"
                            data-thumb="escritorio_image_thumb"
                            data-default="<?php echo esc_attr($default_img); ?>">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th>Título</th>
                    <td><input type="text" name="escritorio_title" value="<?php echo esc_attr($title); ?>"
                            class="large-text"></td>
                </tr>
                <tr>
                    <th>Texto em Itálico</th>
                    <td><input type="text" name="escritorio_italic" value="<?php echo esc_attr($italic); ?>"
                            class="large-text"></td>
                </tr>
                <tr>
                    <th>Itens da Lista (1 por linha)</th>
                    <td><textarea name="escritorio_list" rows="5"
                            class="large-text"><?php echo esc_textarea($list); ?></textarea></td>
                </tr>
                <tr>
                    <th>Texto Final</th>
                    <td><textarea name="escritorio_text" rows="5"
                            class="large-text"><?php echo esc_textarea($text); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button('Salvar Alterações', 'primary', 'escritorio_settings_submit'); ?>
        </form>
    </div>
    <?php azietorres_admin_inline_script();
}

// VVM Settings
function vvm_settings_page()
{
    if (isset($_POST['vvm_settings_submit'])) {
        if (!isset($_POST['vvm_settings_nonce']) || !wp_verify_nonce($_POST['vvm_settings_nonce'], 'vvm_settings_save'))
            wp_die('Security Error');
        update_option('vvm_visao_img', esc_url_raw($_POST['vvm_visao_img']));
        update_option('vvm_visao_title', sanitize_text_field($_POST['vvm_visao_title']));
        update_option('vvm_visao_text', wp_kses_post($_POST['vvm_visao_text']));
        update_option('vvm_valores_img', esc_url_raw($_POST['vvm_valores_img']));
        update_option('vvm_valores_title', sanitize_text_field($_POST['vvm_valores_title']));
        update_option('vvm_valores_list', sanitize_textarea_field($_POST['vvm_valores_list']));
        update_option('vvm_missao_img', esc_url_raw($_POST['vvm_missao_img']));
        update_option('vvm_missao_title', sanitize_text_field($_POST['vvm_missao_title']));
        update_option('vvm_missao_text', wp_kses_post($_POST['vvm_missao_text']));
    }

    // Default Images
    $default_visao_img = get_template_directory_uri() . '/assets/img/visao.jpg';
    $default_valores_img = get_template_directory_uri() . '/assets/img/valores.jpg';
    $default_missao_img = get_template_directory_uri() . '/assets/img/missao.jpg';

    // Get Options
    $visao_img = get_option('vvm_visao_img', $default_visao_img);
    $visao_title = get_option('vvm_visao_title', 'Nossa visão');
    $visao_text = get_option('vvm_visao_text', 'Exceder as expectativas dos clientes...');

    $valores_img = get_option('vvm_valores_img', $default_valores_img);
    $valores_title = get_option('vvm_valores_title', 'Nossos valores');
    $valores_list = get_option('vvm_valores_list', "Ética e honestidade;\nDedicação e criatividade;\nTrabalho em equipe;\nQualidade no atendimento aos clientes;\nProfissionalismo e proatividade;\nCooperação e responsabilidade social.");

    $missao_img = get_option('vvm_missao_img', $default_missao_img);
    $missao_title = get_option('vvm_missao_title', 'Nossa missão');
    $missao_text = get_option('vvm_missao_text', 'Prestar serviços jurídicos com ética...');

    ?>
    <div class="wrap">
        <h1>Visão, Valores e Missão</h1>
        <form method="post" action="">
            <?php wp_nonce_field('vvm_settings_save', 'vvm_settings_nonce'); ?>

            <h2 class="title">Visão</h2>
            <table class="form-table">
                <tr>
                    <th>Imagem da Visão</th>
                    <td>
                        <input type="hidden" id="vvm_visao_img" name="vvm_visao_img" value="<?php echo esc_attr($visao_img); ?>">
                        <img id="vvm_visao_img_thumb" src="<?php echo esc_url($visao_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="vvm_visao_img" data-thumb="vvm_visao_img_thumb">Selecionar Imagem</button>
                        <button type="button" class="button button-remove" data-input="vvm_visao_img" data-thumb="vvm_visao_img_thumb" data-default="<?php echo esc_attr($default_visao_img); ?>">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th>Título da Visão</th>
                    <td><input type="text" name="vvm_visao_title" value="<?php echo esc_attr($visao_title); ?>" class="large-text"></td>
                </tr>
                <tr>
                    <th>Texto da Visão</th>
                    <td><textarea name="vvm_visao_text" rows="4" class="large-text"><?php echo esc_textarea($visao_text); ?></textarea></td>
                </tr>
            </table>

            <hr>
            <h2 class="title">Valores</h2>
            <table class="form-table">
                <tr>
                    <th>Imagem dos Valores</th>
                    <td>
                        <input type="hidden" id="vvm_valores_img" name="vvm_valores_img" value="<?php echo esc_attr($valores_img); ?>">
                        <img id="vvm_valores_img_thumb" src="<?php echo esc_url($valores_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="vvm_valores_img" data-thumb="vvm_valores_img_thumb">Selecionar Imagem</button>
                        <button type="button" class="button button-remove" data-input="vvm_valores_img" data-thumb="vvm_valores_img_thumb" data-default="<?php echo esc_attr($default_valores_img); ?>">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th>Título dos Valores</th>
                    <td><input type="text" name="vvm_valores_title" value="<?php echo esc_attr($valores_title); ?>" class="large-text"></td>
                </tr>
                <tr>
                    <th>Lista de Valores (1 por linha)</th>
                    <td><textarea name="vvm_valores_list" rows="6" class="large-text"><?php echo esc_textarea($valores_list); ?></textarea></td>
                </tr>
            </table>

            <hr>
            <h2 class="title">Missão</h2>
            <table class="form-table">
                <tr>
                    <th>Imagem da Missão</th>
                    <td>
                        <input type="hidden" id="vvm_missao_img" name="vvm_missao_img" value="<?php echo esc_attr($missao_img); ?>">
                        <img id="vvm_missao_img_thumb" src="<?php echo esc_url($missao_img); ?>" style="max-width:150px;display:block;margin-bottom:10px;" />
                        <button type="button" class="button button-upload" data-input="vvm_missao_img" data-thumb="vvm_missao_img_thumb">Selecionar Imagem</button>
                        <button type="button" class="button button-remove" data-input="vvm_missao_img" data-thumb="vvm_missao_img_thumb" data-default="<?php echo esc_attr($default_missao_img); ?>">Remover</button>
                    </td>
                </tr>
                <tr>
                    <th>Título da Missão</th>
                    <td><input type="text" name="vvm_missao_title" value="<?php echo esc_attr($missao_title); ?>" class="large-text"></td>
                </tr>
                <tr>
                    <th>Texto da Missão</th>
                    <td><textarea name="vvm_missao_text" rows="4" class="large-text"><?php echo esc_textarea($missao_text); ?></textarea></td>
                </tr>
            </table>

            <?php submit_button('Salvar Alterações', 'primary', 'vvm_settings_submit'); ?>
        </form>
    </div>
    <?php azietorres_admin_inline_script();
}

// Common script for media uploader
function azietorres_admin_inline_script()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var frame;
            $('.button-upload').on('click', function (e) {
                e.preventDefault();
                var btn = $(this);
                var input = $('#' + btn.data('input'));
                var thumb = $('#' + btn.data('thumb'));
                if (frame) { frame.open(); return; }
                frame = wp.media({ title: 'Selecionar Imagem', button: { text: 'Usar' }, multiple: false });
                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    input.val(attachment.url);
                    thumb.attr('src', attachment.url);
                });
                frame.open();
            });
            $('.button-remove').on('click', function (e) {
                e.preventDefault();
                var btn = $(this);
                $('#' + btn.data('input')).val('');
                $('#' + btn.data('thumb')).attr('src', btn.data('default'));
            });
        });
    </script>
    <?php
}

// Social Media Page (Settings API example)
function my_theme_social_media_page_html()
{
    if (isset($_POST['my_social_media_options_nonce'])) {
        if (wp_verify_nonce($_POST['my_social_media_options_nonce'], 'my_social_media_options_action')) {
            $options = array();
            if (isset($_POST['my_social_media_options'])) {
                foreach ($_POST['my_social_media_options'] as $key => $val) {
                    $options[$key] = esc_url_raw($val);
                }
            }
            update_option('my_social_media_options', $options);
        }
    }
    ?>
    <div class="wrap">
        <h1>Configurações de Redes Sociais</h1>
        <form method="post" action="">
            <?php wp_nonce_field('my_social_media_options_action', 'my_social_media_options_nonce'); ?>
            <?php
            $options = get_option('my_social_media_options');
            $platforms = array('x' => 'X (Twitter)', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn');
            ?>
            <table class="form-table">
                <?php foreach ($platforms as $slug => $name): ?>
                    <tr>
                        <th>
                            <?php echo $name; ?>
                        </th>
                        <td><input type="url" name="my_social_media_options[<?php echo $slug; ?>]"
                                value="<?php echo esc_attr($options[$slug] ?? ''); ?>" class="large-text"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Contact Settings
function contact_settings_page()
{
    if (isset($_POST['contact_settings_submit'])) {
        if (wp_verify_nonce($_POST['contact_settings_nonce'], 'contact_settings_save')) {
            update_option('contact_address', sanitize_textarea_field($_POST['contact_address']));
            update_option('contact_email', sanitize_email($_POST['contact_email']));
            update_option('contact_telefax', sanitize_textarea_field($_POST['contact_telefax']));
        }
    }
    $address = get_option('contact_address');
    $email = get_option('contact_email');
    $telefax = get_option('contact_telefax');
    ?>
    <div class="wrap">
        <h1>Configurações de Contato</h1>
        <form method="post" action="">
            <?php wp_nonce_field('contact_settings_save', 'contact_settings_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th>Endereço</th>
                    <td><textarea name="contact_address" rows="3"
                            class="large-text"><?php echo esc_textarea($address); ?></textarea></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><input type="email" name="contact_email" value="<?php echo esc_attr($email); ?>"
                            class="regular-text"></td>
                </tr>
                <tr>
                    <th>Telefax</th>
                    <td><textarea name="contact_telefax" rows="2"
                            class="large-text"><?php echo esc_textarea($telefax); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button('Salvar Alterações', 'primary', 'contact_settings_submit'); ?>
        </form>
    </div>
    <?php
}
