<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/AdminReview.php";

require_once "db/DBReviewer.php";
require_once "db/DBAdmin.php";
require_once "db/DBReviewer.php";

if (isset($_GET['incommingWorks'])) {
    $incommingWorks = DBAdmin::getAllIncommingWorks();
    echo json_encode($incommingWorks);

} elseif (isset($_POST['adminReview'])) {
    echo "\npostAdminReviewRequest\n";

//    dbAdmin_Review columns: AdminID, WorkID, DateReviewed, Decision, RejectNote
//    $ar = new AdminReview($_POST("AdminID"), $_POST("WorkID"), $_POST("DateReviewed"), $_POST("Decision"), $_POST("RejectNote"));
//    echo "\npostAdminReviewRequest\n";

    $ar = new AdminReview(1, 4, "20191212", "accepted", "");
    DBAdmin::updateReview($ar);

} elseif (isset($_GET['reviewerList'])) {
    echo "\nreviewerListRequest\n";

    $reviewers = DBAdmin::getAllReviewers();
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

    // responds back with all rejected works in json format
} elseif (isset($_GET['rejectedWork'])) {
    echo "\nrejectedWorkRequest\n";

    $works = DBAdmin::getRejectedWorks();
    echo json_encode($works);

    // responds back with all admin's pre review history in json format
} elseif (isset($_GET['adminReviews'])) {
    echo "\nrejectedWorkRequest\n";

    $works = DBAdmin::getAdminReviews($_GET['adminID']);
    echo json_encode($works);

  // responds back with all unassigned works in json format
} elseif (isset($_GET['unassignedWorks'])) {
    echo "\nunassignedWorksRequest\n";

    $works = DBAdmin::getUnassignedWorks();
    echo json_encode($works);
}

//
//$incommingWorks = DBAdmin::selectAllIncommingWorks();
//echo json_encode($incommingWorks);

//$rw = new Reviewer.class("qqqqq", "qqqq", "qqqqqq", 1, 2);
//$rw->setRid(23);
//DBAdmin::updateReviewer($rw);


?>
