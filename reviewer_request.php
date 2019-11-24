<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


require_once "model/Reviewer.php";

require_once "db/DBReviewerUtil.php";



//echo json_encode(DBReviewerUtil::selectAllReviewers());

// testing functionality for reviewer part
//$r = new Reviewer("insert111", "123", "insert", "1", 1);
//echo $r;
//DBReviewerUtil::selectAllReviewers();
//DBReviewerUtil::createReviewer($r);
//DBReviewerUtil::deleteReviewer($r);

?>
