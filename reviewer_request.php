<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";
require_once "model/Message.php";

require_once "db/DBReviewer.php";
require_once "db/DB.php";

    // receives http get request with params: listAssignments, ReviewerID
    // responds back with a list of assignments for the given reviewerID
    // in json: [
//    {
//        "ReviewerID": "1",
//        "RName": "Melissa Klein",
//        "WorkID": "4",
//        "Title": "Can you measure the ROI of your social media marketing?",
//        "URL": "https://www.researchgate.net/publication/228237594_Can_You_Measure_the_ROI_of_Your_Social_Media_Marketing",
//        "DateAssigned": "2019-11-12",
//        "DueDate": "2019-11-14"
//    }
//      ........
//]
if (isset($_GET['listAssignments'])) {
//    echo "\nreviewerAssignmentRequest\n";

    if (isset($_GET['ReviewerID'])) {

        $reviewerID = $_GET['ReviewerID'];
        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentsView WHERE ReviewerID=$reviewerID;"));
    }

    // receives http get request with params: scorecard, WID, ReviewerID
    // responds back with the current scorecard and scores that the reviewer has been scoring but
    // did not finish it for workID
    // in json: [
//    {
//        "WorkID": "",
//        "Title": "",
//        "URL": "",
//        "RubricID": "",
//        "RubricText": "",
//        "Score": "",
//        "RName": "",
//        "RoleId": ""
//        "RoleName": ""
//    }
//]
} elseif (isset($_GET['scorecard'])) {
//    echo "\nscorecardRequest: ".$_GET['WID'];

    $scorecard = DBReviewer::getScorecard($_GET["WID"], $_GET["ReviewerID"]);
    echo json_encode($scorecard);

    // receives http get request with params: reviewHistory, ReviewerID
    // responds back with all reviews made by reviewerID in
    // JSON: ["WorkID": "4",
    //        "ReviewerID": "2",
    //        "RNAME": "Anton Swartz",
    //        "DateReviewed": "2019-11-11",
    //        "Score": "48",
    //        "ReviewerComment": "Reviwer2's comment text"
    //        ........
    //]
} elseif (isset($_GET['reviewHistory'])) {
//    echo "\nreviewHistory\n";
    if (isset($_GET['ReviewerID'])) {
        $reviewerID = $_GET['ReviewerID'];

       echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewHistoryView WHERE ReviewerID=2;"));
    }


    // receives http get request with params: getDiscussions, WorkID
    // responds back with all discussions made by assigned reviewers for WorkID
    // JSON : [
    //    {
    //        "WorkID": "4",
    //        "ReviewerID": "1",
    //        "ReviewerName": "Melissa Klein",
    //        "Message": "great article",
    //        "DTime": "2019-11-13 07:00:00"
    //    },
    //    {
    //        "WorkID": "4",
    //        "ReviewerID": "2",
    //        "ReviewerName": "Anton Swartz",
    //        "Message": "Yes, it is. But I found some typos",
    //        "DTime": "2019-11-13 07:01:00"
    //    },
    //        ............................
} elseif (isset($_GET['getDiscussions'])) {
//    echo "\ngetDiscussionsRequest\n";

    $WorkID = $_GET['WorkID'];
    $discussions = DB::select("SELECT * FROM peer_review_db.DiscussionView WHERE WorkID=$WorkID;");
    echo json_encode($discussions);




    // receives http post request with params: saveMessage, reviewerID, WorkID, message, and date and time
    // note that date and time format should be "YYYYMMDDhhmmss" or "YYYY-MM-DD HH:mm:SS"
    // inserts a new message to Discussion table in db
} elseif (isset($_POST['saveMessage'])) {
    echo "\nsaveDiscusionRequest\n";

    DBReviewer::insertNewMessage(new Message($_POST['$WorkID'], $_POST['$reviewerID'], $_POST['$message'], $_POST['$dateAndTime']));

} elseif (isset($_GET['getRubric'])) {

    // respond the request back with all rubric texts in json format
    echo json_encode(DBReviewer::getRubricText());
}

?>
