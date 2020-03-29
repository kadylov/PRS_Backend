<?php

//Import PHPMailer classes into the global namespace
require './phpmailer/PHPMailer/src/PHPMailer.php';
require './phpmailer/PHPMailer/src/SMTP.php';
require './phpmailer/PHPMailer/src/Exception.php';

require './model/Email.php';


$host = 'smtp.gmail.com';
$username = 'prs.prs2020@gmail.com';
$password = 'Senior2020';


function sanitize_email($email) {
    $field = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}


function sendConfirmation($email) {

    $adminEmail = 'prs.prs2020@gmail.com';

//    $email->getRecepientName();
//    $email->getRecepientEmail();
//    $email->getSenderName();
//    $email->getSenderEmail();
//    $email->getSubject();
//    $email->getMessage();

    $mail = new PHPMailer;
    $mail->isSMTP();

    global $host;
    global $username;
    global $password;

    echo $username;

    $mail->Host = $host;
    $mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    $mail->Username = $username;
    $mail->Password = $password;
    $mail->setFrom($adminEmail);
    $mail->addAddress($email->getRecepientEmail(), $email->getRecepientName());
    $mail->Subject = 'Work Submission Confirmation';
    $mail->Body = '
   <b>Dear Valued Author</b>,
        <p>Thank you for using The Peer Review System to submit a work review request.</p>
        <p>Your work submission has been received and will soon be proceeded.</p>';

    $mail->AltBody = 'Your work submission has been received and will soon be proceeded.';

//send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: '.$mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }

}


function sendEmail($to, $subject, $message) {

    $adminEmail = 'prs.prs2020@gmail.com';

    $mail = new PHPMailer;
    $mail->isSMTP();

    global $host;
    global $username;
    global $password;

    echo $username;

    $mail->Host = $host;
    $mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    $mail->Username = $username;
    $mail->Password = $password;
    $mail->setFrom('farsh01@list.ru', 'Nikolai Solovey');
    $mail->addReplyTo('farsh01@list.ru', 'Kim Chi');
    $mail->addAddress($adminEmail);
    $mail->Subject = 'PHPMailer GMail SMTP test';
    $mail->Body = '<h1>Header</h1> <p>THis is the test message</p>';
    $mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: '.$mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }

}

?>
