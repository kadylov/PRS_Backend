<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


require_once "model/Work.php";
require_once "model/Reviewer.php";

require_once "db/DBWorkUtil.php";
require_once "db/DBReviewerUtil.php";


if ($_GET['scoredWorks']) {
    DBWorkUtil::selectAllWorks();
}
elseif ($_POST['deleteWork']) {

}elseif ($_POST['updateWork']) {

}


#$work = new Work(1);
//DBWorkUtil::deleteWork($work);


// testing functionality for reviewer part
//$r = new Reviewer("insert", "123", "insert", "academic", 1);
//DBReviewerUtil::selectAllReviewers();
//DBReviewerUtil::insertReviewer($r);
//DBReviewerUtil::deleteReviewer($r);

?>