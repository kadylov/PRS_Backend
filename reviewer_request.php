<?php

require_once "header_config.php";

require_once "model/Reviewer.php";

require_once "db/DBReviewer.php";


if (isset($_GET['reviewerAssignment'])) {
    echo "\nreviewerAssignmentRequest\n";

    $incommingWorks = DBReviewer::getAllAsignments();
    echo json_encode($incommingWorks);

} elseif (isset($_GET['scorecard'])) {
    $ww = $_GET["WID"];
    echo "\nscorecardRequest: $ww \n";

    $reviewers = DBReviewer::getScorecard($_GET["WID"], $_GET["ReviewerID"]);
    echo json_encode($reviewers);

} elseif (isset($_GET['reviewHistory'])) {

    echo "\ncreateReviewer\n";
    DBReviewer::getReviewHistory();
//    if (DBWork::deleteWork(new Work.class($workID)) == true)
//        http_response_code(202);
//    else
//        http_response_code(404);

} elseif (isset($_GET['getDiscussions'])) {
    echo "\ngetDiscussionsRequest\n";


} elseif (isset($_POST['saveDiscusion'])) {

    echo "\nsaveDiscusionRequest\n";

    DBAdmin::DBReviewer($_POST["RID"]);
}
9
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

?>
