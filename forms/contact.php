<?php
// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'rafabandeira@gmail.com';

if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
} else {
    die( 'Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;
$contact->to = $receiving_email_address;
$contact->from_name = isset($_POST['name']) ? $_POST['name'] : '';
$contact->from_email = isset($_POST['email']) ? $_POST['email'] : '';
$contact->subject = isset($_POST['subject']) ? $_POST['subject'] : '';

$contact->smtp = array(
    'host' => 'mail.bandeiragroup.com.br',
    'username' => 'atendimento@bandeiragroup.com.br',
    'password' => 'rafa123',
    'port' => '587'
);

if (!empty($_POST['message'])) {
    // Check for duplicate submission
    if (isset($_SESSION['form_submitted'])) {
        die('This form has already been submitted. Please wait before submitting again.');
    }
    
    $contact->add_message($_POST['name'], 'From');
    $contact->add_message($_POST['email'], 'Email');
    $contact->add_message($_POST['message'], 'Message', 10);
    
    // Mark form as submitted
    $_SESSION['form_submitted'] = true;
} else {
    die('Message field is required.');
}

if (!$contact->send()) {
    die('Email sending failed: ' . $contact->error);
} else {
    echo 'Email sent successfully!';
}

?>

