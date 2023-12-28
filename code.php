<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debugging
    // $mail->isSMTP();
    // $mail->Host = 'localhost'; // Your SMTP host
    // $mail->SMTPAuth = true;
    // $mail->Username = 'root'; // Your SMTP username
    // $mail->Password = ''; // Your SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    // $mail->Port = 80; // TCP port to connect to

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debugging
    $mail->isSMTP();
    $mail->Host = 'localhost'; // Your SMTP host (or use '127.0.0.1')
    $mail->SMTPAuth = false; // No authentication is required for the local SMTP server
    $mail->SMTPAutoTLS = false;
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = ''; // No encryption is needed for a local connection
    $mail->Port = 25; // Default SMTP port for unencrypted connections


    //Recipients
    $mail->setFrom('isihakakyomuhendo1@gmail.com', 'Your Name');
    $mail->addAddress('kyomuhendoisihaka1@gmail.com', 'Recipient Name');

    //Content
    $mail->isHTML(false);
    $mail->Subject = 'Subject Here';
    $mail->Body = 'Message body here';

    $mail->send();
    echo 'Message has been sent successfully.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>