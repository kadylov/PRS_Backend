<?php

require_once "header_config.php";

require_once "model/Work.php";
require_once "db/DB.php";
require_once "db/DBWork.php";


if (isset($_POST['postNewWork'])) {
    $work = new Work(
        $_POST['title'],
        $_POST['author'],
        $_POST['url'],
        $_POST['selectedTags'],
        $_POST['dateWritten'],
        $_POST['dateSubmitted']);
    $work->setAuthorEmail($_POST['email']);


//     public function __construct($title="", $authorName="", $url="", $tags="", $dateWritten="", $dateSubmitted="", $retireFlag="no", $status="new")
    DBWork::insertWork($work);
} elseif (isset($_GET['getAllTags'])) {

    $tags = DB::select('SELECT * FROM peer_review_db.Tag;');
    echo json_encode($tags);

//    DBWork::loadTags();

}

?>
