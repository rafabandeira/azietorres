<?php
/**
 * Custom Post Types and Meta Boxes
 */

// Áreas de Atuação
function create_area_atuacao_post_type()
{
    $labels = array(
        'name' => 'Áreas de Atuação',
        'singular_name' => 'Área de Atuação',
        'menu_name' => 'Áreas de Atuação',
        'add_new' => 'Criar Nova',
        'add_new_item' => 'Criar Nova Área de Atuação',
        'edit_item' => 'Editar Área de Atuação',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'area-atuacao'),
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-awards',
    );
    register_post_type('area_atuacao', $args);
}
add_action('init', 'create_area_atuacao_post_type');

function area_atuacao_meta_box()
{
    add_meta_box('area_atuacao_details', 'Detalhes da Área de Atuação', 'area_atuacao_details_callback', 'area_atuacao');
}
add_action('add_meta_boxes', 'area_atuacao_meta_box');

function area_atuacao_details_callback($post)
{
    wp_nonce_field('area_atuacao_details_save', 'area_atuacao_details_nonce');
    $summary = get_post_meta($post->ID, '_area_atuacao_summary', true);
    $icon = get_post_meta($post->ID, '_area_atuacao_icon', true);
    ?>
    <p>
        <label for="area_atuacao_summary">Resumo</label><br>
        <textarea id="area_atuacao_summary" name="area_atuacao_summary" rows="4"
            style="width:100%;"><?php echo esc_textarea($summary); ?></textarea>
    </p>
    <p>
        <label for="area_atuacao_icon">Ícone</label><br>
        <input type="text" id="area_atuacao_icon" name="area_atuacao_icon" value="<?php echo esc_attr($icon); ?>" size="25"
            placeholder="bi bi-briefcase" /><br>
        <small>Use um ícone do Bootstrap Icons. Exemplo: <code>bi-briefcase</code></small>
    </p>
    <?php
}

function area_atuacao_details_save($post_id)
{
    if (!isset($_POST['area_atuacao_details_nonce']) || !wp_verify_nonce($_POST['area_atuacao_details_nonce'], 'area_atuacao_details_save'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (isset($_POST['area_atuacao_summary'])) {
        update_post_meta($post_id, '_area_atuacao_summary', sanitize_textarea_field($_POST['area_atuacao_summary']));
    }
    if (isset($_POST['area_atuacao_icon'])) {
        $icon = !empty($_POST['area_atuacao_icon']) ? sanitize_text_field($_POST['area_atuacao_icon']) : 'bi bi-briefcase';
        update_post_meta($post_id, '_area_atuacao_icon', $icon);
    }
}
add_action('save_post', 'area_atuacao_details_save');

// Advogados
function create_advogado_post_type()
{
    $labels = array(
        'name' => 'Advogados',
        'singular_name' => 'Advogado',
        'menu_name' => 'Advogados',
        'add_new' => 'Criar Novo',
        'add_new_item' => 'Criar Novo Advogado',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'advogado'),
        'supports' => array('title', 'thumbnail', 'sticky'),
        'menu_icon' => 'dashicons-businessman',
    );
    register_post_type('advogado', $args);
}
add_action('init', 'create_advogado_post_type');

function advogado_meta_box()
{
    add_meta_box('advogado_expertise', 'Área de Atuação', 'advogado_expertise_callback', 'advogado');
}
add_action('add_meta_boxes', 'advogado_meta_box');

function advogado_expertise_callback($post)
{
    wp_nonce_field('advogado_expertise_save', 'advogado_expertise_nonce');
    $value = get_post_meta($post->ID, '_advogado_expertise', true);
    ?>
    <p>
        <label for="advogado_expertise_field">Especialidade/Cargo</label><br>
        <input type="text" id="advogado_expertise_field" name="advogado_expertise_field"
            value="<?php echo esc_attr($value); ?>" class="large-text" />
    </p>
    <?php
}

function advogado_expertise_save($post_id)
{
    if (!isset($_POST['advogado_expertise_nonce']) || !wp_verify_nonce($_POST['advogado_expertise_nonce'], 'advogado_expertise_save'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (isset($_POST['advogado_expertise_field'])) {
        update_post_meta($post_id, '_advogado_expertise', sanitize_text_field($_POST['advogado_expertise_field']));
    }
}
add_action('save_post', 'advogado_expertise_save');
