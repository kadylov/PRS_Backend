<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";
require_once "model/Message.php";
require_once "model/Review.php";

require_once "db/DBReviewer.php";
require_once "db/DB.php";

require_once 'Utils/util.php';


// report all occured error messages to the screen
ini_set('display_errors', 1);
error_reporting(E_ALL);


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
        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentsView WHERE ReviewerID=$reviewerID AND CanReview=1;"));
    }

    // receives http get request with params: getScorecardForWork, WID, ReviewerID
    // responds back with the current scorecard and scores that the reviewer has been scoring but
    // did not finish, or he reviewer finished for workID
    // in json: [
//    [
//    {
//        "WorkID": "4",
//        "Title": "Can you measure the ROI of your social media marketing?",
//        "URL": "https://www.researchgate.net/publication/228237594_Can_You_Measure_the_ROI_of_Your_Social_Media_Marketing",
//        "ReviewerID": "2",
//        "canScore": "1",
//        "Scorecard": {
//            "1": "4",
//            "2": "4",
//            "3": "4",
//            "4": "4",
//            "5": "4",
//            "6": "4",
//            "7": "4",
//            "8": "4",
//            "9": "4",
//            "10": "4",
//            "11": "4",
//            "12": "4"
//        }
//    }
//]
} elseif (isset($_GET['getScorecardForWork'])) {

    $workID = $_GET["WID"];
    $reviewerID = $_GET["ReviewerID"];

    $assignment = DB::select("SELECT WID, Title, URL, ReviewerID, canScore FROM peer_review_db.ScorecardView WHERE WID=".$workID." AND ReviewerID=".$reviewerID." GROUP BY WID;");
    if (empty($assignment)) {
        return;
    }


    $response = DB::select("SELECT RubricID, Score FROM peer_review_db.ScorecardView WHERE WID=".$workID." AND ReviewerID=".$reviewerID.";");

    $rubricScore = array();

    foreach($response as $rs){
        $rubricScore[$rs['RubricID']] = $rs['Score'];
    }

    $assignment[0]['Scorecard']= $rubricScore;


    echo json_encode($assignment);

//  receives http post request with params: saveScorecard, rubricID as an array, scores as an array,reviewerID
//  receives Post
} elseif (isset($_POST['saveScorecard'])) {

    $reviewerID = $_POST['ReviewerID'];
    $workID = $_POST['WID'];

    $q1Value = $_POST['q1Value'];
    $q2Value = $_POST['q2Value'];
    $q3Value = $_POST['q3Value'];
    $q4Value = $_POST['q4Value'];
    $q5Value = $_POST['q5Value'];
    $q6Value = $_POST['q6Value'];
    $q7Value = $_POST['q7Value'];
    $q8Value = $_POST['q8Value'];
    $q9Value = $_POST['q9Value'];
    $q10Value = $_POST['q10Value'];
    $q11Value = $_POST['q11Value'];
    $q12Value = $_POST['q12Value'];
    $totalScore = $_POST['totalScore'];

    $scorecard = array(
        "WID" => $workID,
        "ReviewerID" => $reviewerID,
        "1" => $q1Value,
        "2" => $q2Value,
        "3" => $q3Value,
        "4" => $q4Value,
        "5" => $q5Value,
        "6" => $q6Value,
        "7" => $q7Value,
        "8" => $q8Value,
        "9" => $q9Value,
        "10" => $q10Value,
        "11" => $q11Value,
        "12" => $q12Value,
    );

    // if the scorecard successfully stored in the database, then update review history table
    // and update CanReview status on Assignment table
    if (DBReviewer::saveScorecard($scorecard)) {

        // current date
        $today = date("Ymd");
        DBReviewer::saveReview(new Review((int)$workID, (int)$reviewerID, $today, $totalScore, ""));

        DB::execute("UPDATE peer_review_db.Assignment SET CanReview=0 WHERE ReviewerID=$reviewerID AND WorkID=$workID");

    }


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

        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewHistoryView WHERE RID=$reviewerID;"));
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
    $WorkID = $_GET['WorkID'];
//    $RID = $_GET['RID'];
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


} elseif (isset($_GET['assignmentHistory'])) {
//    echo "\nreviewHistory\n";
    if (isset($_GET['ReviewerID'])) {
        $reviewerID = $_GET['ReviewerID'];

        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentHistView where ReviewerID=$reviewerID;"));
    }
} elseif (isset($_GET['assignedWorks'])) {
//    echo "\nreviewHistory\n";
    if (isset($_GET['ReviewerID'])) {
        $reviewerID = $_GET['ReviewerID'];
        echo json_encode(DB::select("SELECT * FROM peer_review_db.ReviewerAssignmentsView where ReviewerID=$reviewerID;"));
    }
} elseif (isset($_POST['postNewMessage'])) {
    if (isset($_POST['WorkID']) && isset($_POST['ReviewerID']) && isset($_POST['Message']) && isset($_POST['DTime'])) {

//        $wid = $_POST['WorkID'];
//        $rid = $_POST['ReviewerID'];
//        $msg = $_POST['Message'];
//        $dtime = $_POST['DTime'];


        DBReviewer::insertNewMessage(new Message($_POST['WorkID'], $_POST['ReviewerID'], $_POST['Message'], $_POST['DTime']));

    }
}

?>
