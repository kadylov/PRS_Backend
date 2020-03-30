<?php
require_once "header_config.php";

require_once "model/Work.php";
require_once "model/Email.php";

require_once "db/DB.php";
require_once "db/DBWork.php";

require_once 'Utils/mail.php';


if (isset($_POST['postNewWork'])) {

    $authorEmail = $_POST['email'];
    $authorName = $_POST['author'];

    $work = new Work(
        $_POST['title'],
        $_POST['author'],
        $_POST['url'],
        $_POST['selectedTags'],
        $_POST['dateWritten'],
        $_POST['dateSubmitted']);
    $work->setAuthorEmail($_POST['email']);


    if (DBWork::insertWork($work)) {

        // send email confirmation to author
        sendConfirmation($authorName, $authorEmail);

        // fetch admin name and email address
        $admin = DB::select('SELECT AName, Email FROM peer_review_db.Admin WHERE AID=0;');
        if (isset($admin[0]['AName']) && isset($admin[0]['Email'])) {
            $email = new Email();
            $email->setRecepientName($admin[0]['AName']);
            $email->setRecepientEmail($admin[0]['Email']);
            $email->setSenderName('PRS no-reply');
            $email->setSenderEmail('prs.prs2020@gmail.com');
            $email->setSubject('New Work Submission');
            $email->setMessage('New work has been submitted.');
            sendEmail($email);
        }
    } else {
        sendHttpResponseMsg(404, 'Error! Your Work submission has not saved. Please contact a system admin.');
    }


} elseif (isset($_GET['getAllTags'])) {

    $tags = DB::select('SELECT * FROM peer_review_db.Tag;');
    echo json_encode($tags);

//    DBWork::loadTags();

}

?>
