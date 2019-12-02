<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/AdminReview.php";

require_once "db/DBReviewer.php";
require_once "db/DBAdmin.php";
require_once "db/DBReviewer.php";
require_once "db/DB.php";



if (isset($_GET['incommingWorks'])) {
    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');
    echo json_encode($incommingWorks);

} elseif (isset($_POST['adminReview'])) {
    echo "\npostAdminReviewRequest\n";

    $ar = new AdminReview($_POST['AdminID'], $_POST['WorkID'], $_POST['DateReviewed'], $_POST['Decision'], $_POST['RejectNote']);
    DBAdmin::preReview($ar);

} elseif (isset($_GET['reviewerList'])) {
    echo "\nreviewerListRequest\n";

    $reviewers = DB::select('SELECT * FROM peer_review_db.ReviewersListView;');
    echo json_encode($reviewers);

} elseif (isset($_POST['createReviewer'])) {

    echo "\ncreateReviewer\n";
    DBAdmin::createReviewer(new Reviewer($_POST["Username"], $_POST["Password"], $_POST["RName"], $_POST["CredentialID"], $_POST["RoleId"]));

//    if (DBWork::deleteWork(new Work.class($workID)) == true)
//        http_response_code(202);
//    else
//        http_response_code(404);

} elseif (isset($_POST['updateReviewer'])) {
    echo "\nupdateReviewerRequest\n";
    $r = new Reviewer($_POST["Username"], $_POST["Password"], $_POST["RName"], $_POST["CredentialID"], $_POST["RoleId"]);
    $r->setRid($_POST["RID"]);
    DBAdmin::updateReviewer($r);

    // receive reviewer id, pass it to delete function that deletes the reviewer from db table
} elseif (isset($_POST['deleteReviewer'])) {

    echo "\ndeleteRequest\n";

    DBAdmin::deleteReviewerByID($_POST["RID"]);

    // receives rejectedWork command as http get parameter
    // responds back with all rejected works in json format
} elseif (isset($_GET['rejectedWork'])) {
    echo "\nrejectedWorkRequest\n";

    $works = DB::select('SELECT * FROM peer_review_db.RejectedWorkView;');
    echo json_encode($works);

    // responds back with all admin's pre review history in json format
    // receives adminID as a parameter from http get request
} elseif (isset($_GET['adminReviews'])) {
    echo "\nadminReviewsRequest\n";

    // TODO
    $reviews = DBAdmin::getAdminReviewsByID($_GET['adminID']);
    echo json_encode($reviews);

    // responds back with all unassigned works in json format
} elseif (isset($_GET['unassignedWorks'])) {
//    echo "\nunassignedWorksRequest\n";

    $works = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="admitted";');
    echo json_encode($works);

    // recieve http get request with params: reviewersToAssign
    // responds back a list of reviewers along with total of their reviews for current month
} elseif (isset($_GET['reviewersToAssign'])) {
//    echo "\nreviewHistoryRequest\n";

    $reviewers = DB::select("SELECT * FROM peer_review_db.ReviewsCountList");
    echo json_encode($reviewers);

    // recieve http get request with params: getAssignedWorks
    // responds back with a list of assigned works
} elseif (isset($_GET['getAssignedWorks'])) {
    echo "\ngetAssignedWorks\n";

    $assignmentList = DB::select("SELECT * FROM peer_review_db.Assignment;");
    echo json_encode($assignmentList);

    // receives http get request with param getAssignedReviewers and WorkID
    // respond back with list of assigned reviewers per workid in json format
} elseif (isset($_GET['getAssignedReviewers'])) {
    echo "\ngetAssignedReviewers\n";

    if (isset($_GET['WorkID']))
        $WorkID = $_GET['WorkID'];

    $query = "SELECT * FROM peer_review_db.ReviewersListView
                    where RID in (select Assignment.ReviewerID from peer_review_db.Assignment where WorkID='$WorkID')";

    $reviewers = DB::select($query);
    echo json_encode($reviewers);

    // receives http post request with params: newAssignment, adminID, reviewerID, workID, dueDate, dateAssigned
    // store assignment data in the db
} elseif (isset($_POST['newAssignment'])) {
    echo "\nassignReviewers\n";

    $reviewerID = $_POST['reviewerID'];
    $workID = $_POST['workID'];
    $adminID = $_POST['adminID'];
    $adminID = $_POST['dueDate'];
    $adminID = $_POST['dateAssigned'];
    $assignment = new Assignment($adminID, $reviewerID, $workID);
    DBAdmin::newAssignment($adminID, $reviewerID, $workID);

} elseif (isset($_POST['getDisscussion'])) {
    $workID = $_POST['workID'];
    if ($workID=='' || $workID==null)
        die("Error! work id cannot be zero or null");


}
//
//$incommingWorks = DBAdmin::selectAllIncommingWorks();
//echo json_encode($incommingWorks);

//$rw = new Reviewer.class("qqqqq", "qqqq", "qqqqqq", 1, 2);
//$rw->setRid(23);
//DBAdmin::updateReviewer($rw);
?>
