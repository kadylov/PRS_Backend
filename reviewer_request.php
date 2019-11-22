<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


require_once "model/Reviewer.php";

require_once "db/DBReviewerUtil.php";


if ($_GET['reviewerList']) {
    DBWorkUtil::selectAllReviewers();

} elseif ($_POST['deleteReviewer']) {

}elseif ($_POST['updateReviewer']) {

}

DBReviewerUtil::selectAllReviewers();

// testing functionality for reviewer part
//$r = new Reviewer("insert", "123", "insert", "academic", 1);
//DBReviewerUtil::selectAllReviewers();
//DBReviewerUtil::insertReviewer($r);
//DBReviewerUtil::deleteReviewer($r);

?>
