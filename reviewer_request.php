<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";

require_once "db/DBReviewer.php";
require_once "db/DB.php";

if (isset($_GET['listAssignments'])) {
//    echo "\nreviewerAssignmentRequest\n";

    if (isset($_GET['ReviewerID'])) {

        $reviewerID = $_GET['ReviewerID'];
        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentsView WHERE ReviewerID=$reviewerID;"));
    }


} elseif (isset($_GET['scorecard'])) {
//    echo "\nscorecardRequest: ".$_GET['WID'];

    $scorecard = DBReviewer::getScorecard($_GET["WID"], $_GET["ReviewerID"]);
    echo json_encode($scorecard);

} elseif (isset($_GET['reviewHistory'])) {
//    echo "\nreviewHistory\n";
    echo json_encode(DBReviewer::getReviewHistory($_GET["ReviewerID"]));

} elseif (isset($_GET['getDiscussions'])) {
    echo "\ngetDiscussionsRequest\n";

    json_encode(DBReviewer::getDiscussionHistory($_GET["WorkID"]));

} elseif (isset($_POST['saveDiscusion'])) {

    echo "\nsaveDiscusionRequest\n";

    DBReviewer($_POST["RID"]);
} elseif (isset($_GET['getRubric'])) {

    // respond the request back with all rubric texts in json format
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

//echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentsView WHERE ReviewerID=1"));


?>
