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


//    DBWork::insertWork($work);


    $email = new Email();
    $email->setRecepientName();
    $email->setRecepientEmail();
    $email->setSenderName();
    $email->setSenderEmail();
    $email->setSubject();
    $email->setMessage();

    sendConfirmation($email);

} elseif (isset($_GET['getAllTags'])) {

    $tags = DB::select('SELECT * FROM peer_review_db.Tag;');
    echo json_encode($tags);

//    DBWork::loadTags();

}

?>
