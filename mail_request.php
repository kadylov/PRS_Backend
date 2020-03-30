<?php

require_once "header_config.php";

require_once "model/Work.php";
require_once "model/Email.php";

require_once "db/DB.php";
require_once "db/DBWork.php";

require_once 'Utils/mail.php';


if (isset($_POST['contactMessage'])) {

    $admin = DB::select('SELECT AName, Email FROM peer_review_db.Admin WHERE AID=0;');
    if (isset($admin[0]['AName']) && isset($admin[0]['Email'])) {
//        echo "AAA";

        $email = new Email();
        $email->setRecepientName($admin[0]['AName']);
        $email->setRecepientEmail($admin[0]['Email']);
        $email->setSenderName($_POST['senderName']);
        $email->setSenderEmail($_POST['senderEmail']);
        $email->setSubject($_POST['subject']);
        $email->setMessage($_POST['message']);

        sendEmail($email, true);
    }





    /*
     *
     *
     * */


}


?>
