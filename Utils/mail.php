<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Import PHPMailer classes into the global namespace
require_once "./phpmailer/PHPMailer.php";
require_once "./phpmailer/SMTP.php";
require_once "./phpmailer/Exception.php";

require_once './model/Email.php';

require_once 'util.php';


$host = 'smtp.gmail.com';
$username = 'prs.prs2020@gmail.com';
$password = 'Senior2020';


function sendConfirmation($authorName, $authorEmail) {

    $prsEmail = 'prs.prs2020@gmail.com';

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

    $mail->Host = $host;
    $mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    $mail->Username = $username;
    $mail->Password = $password;
    $mail->setFrom($prsEmail, 'Peer Review System', false);
    $mail->addAddress($authorEmail, $authorName);
    $mail->Subject = 'Work Submission Confirmation';
    $mail->Body = getAuthorConfirmTemplate();
    $mail->AltBody = 'Your work submission has been received and will soon be processed.';

//send the message, check for errors
    if (!$mail->send()) {
        sendHttpResponseMsg(404, 'Mailer Error: '.$mail->ErrorInfo);
    }

}


function sendEmail(Email $email, $repply = false) {

    $mail = new PHPMailer;
    $mail->isSMTP();

    global $host;
    global $username;
    global $password;
    $mail->Host = $host;
    $mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    $mail->Username = $username;
    $mail->Password = $password;
    $mail->setFrom($email->getSenderEmail(), $email->getSenderName());
    if ($email->canReply()=='1') {
        $mail->addReplyTo($email->getSenderEmail(), $email->getSenderName());
    }
    $mail->addAddress($email->getRecepientEmail(), $email->getRecepientName());
    $mail->Subject = $email->getSubject();
    $mail->Body = $email->getMessage();
    $mail->AltBody = $email->getMessage();


    if (!$mail->send()) {
        sendHttpResponseMsg(404, 'Mailer Error: '.$mail->ErrorInfo);
    }

}

function getAuthorConfirmTemplate() {
    return '<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        body {
            text-align: left;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #464646;
            line-height: 1.5em;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .mt-5 {
            margin-top: 5px;
        }

    </style>

</head>
<body>

<div class="container">
    <div class="mt-5">

        <p>Dear Valued Author,</p>
        <p>Thank you for using The Peer Review System to submit a work review request.</p>
        <p> Your work submission has been received and will soon be processed.</p>

    </div>
</div>

</body>
</html>
';
}

?>
