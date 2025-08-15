<?php
require_once __DIR__ . '/../security.php';

class Service_Contact_Form {
    public function send_contact_form() {
        if( !isset( $_POST[ 'field_name' ] ) ) {
            return false;
        }

        $all_fields = $this->get_fields();
        $are_all_fields_ok = $this->are_all_fields_ok( $all_fields );

        if( ! $are_all_fields_ok ) {
            return $this->get_status_message( 'error' );
        }

        if( $this->is_spam() ) {
            return $this->get_status_message( 'error_sent' );
        }

        if( ! $this->message_sent( $all_fields ) ) {
            return $this->get_status_message( 'error_sent' );
        }

        return $this->get_status_message( 'success' );
    }

    private function get_fields() {
        $fields = array(
            'name' => array(
                'value' => sanitize_text_field( $_POST[ 'field_name' ] ),
                'is_required' => true
            ),
            'email' => array(
                'value' => sanitize_email( $_POST[ 'field_email' ] ),
                'is_required' => true
            ),
            'subject' => array(
                'value' => sanitize_text_field( $_POST[ 'field_subject' ] ),
                'is_required' => false
            ),
            'message' => array(
                'value' => wp_kses( $_POST[ 'field_message' ], 'br' ),
                'is_required' => true
            )
        );

        return $fields;
    }

    private function are_all_fields_ok( $fields ) {
        foreach( $fields as $field ) {
            if( $this->is_field_required_empty( $field ) ) {
                return false;
            }
        }
        return true;
    }

    private function is_field_required_empty( $field ) {
        return $field[ 'is_required' ] && empty( $field[ 'value' ] );
    }

    private function is_spam() {
        if( $this->has_malicious_content() ||
            $this->has_more_than_three_links() ||
            $this->spam_field_is_filled()
        ) {
            return true;
        }

        return false;
    }

    private function has_malicious_content() {
        return preg_match( '/bcc:|cc:|multipart|\[url|\[link|Content-Type:/i', implode( $_POST ) );
    }

    private function has_more_than_three_links() {
        return preg_match_all( '/<a|http:/i', implode( $_POST ) ) > 3;
    }

    private function spam_field_is_filled() {
        return !empty( $_POST[ 'field_mail' ] );
    }

    private function get_status_message( $status = 'success' ) {
        $message = array(
            'success' => $this->get_status_message_success(),
            'error' => $this->get_status_message_error(),
            'error_sent' => $this->get_status_message_error_sent()
        );
        return (object) $message[ $status ];
    }

    private function get_status_message_success() {
        return array(
            'message' => 'Mensagem enviada com sucesso!',
            'status' => 'success'
        );
    }

    private function get_status_message_error() {
        return array(
            'message' => 'Preencha todos os campos!',
            'status' => 'error'
        );
    }

    private function get_status_message_error_sent() {
        return array(
            'message' => 'Erro ao enviar mensagem. Tente novamente mais tarde.',
            'status' => 'error'
        );
    }


    private function message_sent( $fields ) {
        $to = get_option( 'admin_email' ); // E-mail de administração do WordPress
        $subject = 'E-mail do site ' . html_entity_decode( get_bloginfo('name') ) . ' - ' . $fields['subject']['value'];
        $message = $this->message_to_sent( $fields );
        $headers = array(
            'From: ' . html_entity_decode( get_bloginfo('name') ) . '<' . get_option('admin_email') . '>', 
            'Reply-To: ' . $fields['email']['value'], 
            'Content-Type: text/html; charset=UTF-8'
        );
        $attachments = '';
        return wp_mail( $to, $subject, $message, $headers, $attachments );
    }

    private function message_to_sent( $fields ) {
        $message = sprintf( '<h2>De: %s', $fields[ 'name' ][ 'value' ] );
        $message .= sprintf( '<br> %s</h2><br>', $fields[ 'email' ][ 'value' ] );
        $message .= sprintf( '<p>%s</p>', $fields[ 'message' ][ 'value' ] );

        return $message;
    }
}
