<?php
/**
 * AJAX Handlers
 */

add_action('wp_ajax_subscribe_newsletter', 'handle_newsletter_subscription');
add_action('wp_ajax_nopriv_subscribe_newsletter', 'handle_newsletter_subscription');

function handle_newsletter_subscription()
{
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'newsletter-nonce')) {
        wp_send_json_error(array('message' => 'Erro de segurança.'));
    }

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'E-mail inválido.'));
    }

    $to = get_option('admin_email');
    $subject = 'Nova Inscrição na Newsletter: ' . $email;
    $message = '<p>Nova inscrição: <strong>' . $email . '</strong></p>';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json_success(array('message' => 'Inscrição realizada com sucesso!'));
    } else {
        wp_send_json_error(array('message' => 'Erro ao processar.'));
    }
}
