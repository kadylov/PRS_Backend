<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";

require_once "db/DBReviewer.php";


if (isset($_GET['reviewerAssignment'])) {
    echo "\nreviewerAssignmentRequest\n";

    $assignedWorks = DBReviewer::getAllAsignments();
    echo json_encode($assignedWorks);

} elseif (isset($_GET['scorecard'])) {
//    echo "\nscorecardRequest: ".$_GET['WID'];

    $scorecard = DBReviewer::getScorecard($_GET["WID"], $_GET["ReviewerID"]);
    echo json_encode($scorecard);

} elseif (isset($_GET['reviewHistory'])) {

//    echo "\nreviewHistory\n";
    echo json_encode(DBReviewer::getReviewHistory($_GET["ReviewerID"]));

//    if (DBWork::deleteWork(new Work.class($workID)) == true)
//        http_response_code(202);
//    else
//        http_response_code(404);

} elseif (isset($_GET['getDiscussions'])) {
    echo "\ngetDiscussionsRequest\n";

    json_encode(DBReviewer::getDiscussionHistory($_GET["WorkID"]));


} elseif (isset($_POST['saveDiscusion'])) {

    echo "\nsaveDiscusionRequest\n";

    DBReviewer($_POST["RID"]);
}

elseif (isset($_GET['getRubric'])) {

    // respond the request back with all rurbric texts in json format
    echo json_encode(DBReviewer::getRubricText());
}

//$incommingWorks = DBAdmin::selectAllIncommingWorks();
//$aaa= json_encode($incommingWorks);

//$rw = new Reviewer.class("qqqqq", "qqqq", "qqqqqq", 1, 2);
//$rw->setRid(23);
//DBAdmin::updateReviewer($rw);


//echo json_encode(DBReviewer::selectAllReviewers());

// testing functionality for reviewer part
//$r = new Reviewer.class("insert111", "123", "insert", "1", 1);
//echo $r;
//DBReviewer::selectAllReviewers();
//DBReviewer::createReviewer($r);
//DBReviewer::deleteReviewer($r);


//$scorecard = DBReviewer::getScorecard(4, 1);
//echo json_encode($scorecard);

//$rb=DBReviewer::getRubricText();
//print_r($rb);

?>
