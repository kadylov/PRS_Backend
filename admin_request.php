<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");

require_once "model/Reviewer.php";
require_once "db/DBReviewerUtil.php";
require_once "db/DBAdmin.php";
require_once "db/DBReviewerUtil.php";

if ($_GET['incommingWorks']) {
    $incommingWorks = DBAdmin::selectAllIncommingWorks();
    echo json_encode($incommingWorks);

} elseif ($_GET['reviewerList']) {
    $reviewers = DBAdmin::selectAllReviewers();
    echo json_encode($reviewers);

} elseif ($_POST['createReviewer']) {

    echo "\ncreateReviewer\n";
    DBAdmin::createReviewer(new Reviewer($_POST["Username"], $_POST["Password"], $_POST["RName"], $_POST["CredentialID"], $_POST["RoleId"]));

//    if (DBWorkUtil::deleteWork(new Work($workID)) == true)
//        http_response_code(202);
//    else
//        http_response_code(404);

} elseif ($_POST['updateReviewer']) {
    echo "\nupdateReviewerRequest\n";
    $r = new Reviewer($_POST["Username"], $_POST["Password"], $_POST["RName"], $_POST["CredentialID"], $_POST["RoleId"]);
    $r->setRid($_POST["RID"]);
    DBAdmin::updateReviewer($r);

} elseif ($_POST['deleteReviewer']) {

    echo "\ndeleteRequestRequest\n";

    DBAdmin::deleteReviewerByID($_POST["RID"]);
}

//$incommingWorks = DBAdmin::selectAllIncommingWorks();
//$aaa= json_encode($incommingWorks);

//$rw = new Reviewer("qqqqq", "qqqq", "qqqqqq", 1, 2);
//$rw->setRid(23);
//DBAdmin::updateReviewer($rw);

?>
