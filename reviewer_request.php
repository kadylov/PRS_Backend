<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";
require_once "model/Message.php";
require_once "model/Review.php";

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
//    Array{
//        "WorkID": 4,
//    "Title": "Can you measure the ROI of your social media marketing?",
//    "URL": "https://www.researchgate.net/publication/228237594_Can_You_Measure_the_ROI_of_Your_Social_Media_Marketing",
//    "ReviewerID": 1,
//    "ReviewerName": "Melissa Klein",
//    "RoleId": 1,
//    "RoleName": 1,
//    "Rubric": {
//            "1": "Goal Setting and Measurement are Fundamental to Communication\nand Public Relations",
//        "2": "Measuring Communication Outcomes is Recommended Versus Only\nMeasuring Outputs",
//        "3": "The Effect on Organizational Performance Can and Should Be\nMeasured Where Possible",
//        "4": "Measurement and Evaluation Require Both Qualitative and\nQuantitative Methods",
//        "5": "AVEs are not the Value of Communications",
//        "6": "Social Media Can and Should be Measured Consistently with Other\nMedia Channels",
//        "7": "Measurement and Evaluation Should be Transparent, Consistent and\nValid"
//    },
//    "Scores": {
//            "1": "4",
//        "2": "4",
//        "3": "4",
//        "4": "4",
//        "5": "4",
//        "6": "4",
//        "7": "4"
//    },
//    "CanScore": "0"
//}
}
elseif (isset($_GET['getScorecardForWork'])) {
//    echo "\nscorecardRequest: ".$_GET['WID'];

    // gets current scorecard of the reviewerID
    // if the scorecard is not found, returns rubric for scoring work
    $scorecard = DBReviewer::getScorecard($_GET["WID"], $_GET["ReviewerID"]);
    if ($scorecard != null)
        echo json_encode($scorecard);
    else
        echo json_encode(DBReviewer::getRubricText());


//  receives http post request with params: saveScorecard, rubricID as an array, scores as an array,reviewerID
//  receives Post
} elseif (isset($_POST['saveScorecard'])) {

    $rubricIDs_array = $_POST['rubricID'];
    $scores_array = $_POST['scores'];
    $workID = $_POST['workID'];
    $reviewerID = $_POST['reviewerID'];

    $scorecard = new Scorecard();
    $scorecard->setRubric($rubricIDs_array);
    $scorecard->setScore($scores_array);
    $scorecard->setWorkID((int)$workID);
    $scorecard->setReviewerID((int)$reviewerID);

    DBReviewer::saveScores($scorecard);


//     receives http get request with params: reviewHistory, ReviewerID
//     responds back with all reviews made by reviewerID in
//     JSON: ["WorkID": "4",
//            "ReviewerID": "2",
//            "RNAME": "Anton Swartz",
//            "DateReviewed": "2019-11-11",
//            "Score": "48",
//            "ReviewerComment": "Reviwer2's comment text"
//            ........
//    ]
} elseif (isset($_GET['reviewHistory'])) {
//    echo "\nreviewHistory\n";
    if (isset($_GET['ReviewerID'])) {
        $reviewerID = $_GET['ReviewerID'];

        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewHistoryView WHERE ReviewerID=$reviewerID;"));
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


//  receives http post request with params: saveMessage, WorkID, ReviewerID, DateReviewed, Score, ReviewerComment
//  note that date and time format should be "YYYYMMDD" or "YYYY-MM-DD"
//  saves reviewer's review in the db
} elseif (isset($_POST['saveReview'])) {

    echo "\nSave request\n";
    $workID = $_POST['WorkID'];
    $reviewerID = $_POST['ReviewerID'];
    $dateReviewed = $_POST['DateReviewed'];
    $score = $_POST['Score'];
    $reviewerComment = $_POST['ReviewerComment'];

    DBReviewer::saveReview(new Review((int)$workID, (int)$reviewerID, $dateReviewed, $score, $reviewerComment));
}



?>
