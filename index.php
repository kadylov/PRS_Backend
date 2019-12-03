<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


require_once "model/Work.php";
require_once "model/Reviewer.php";

require_once "db/DBWork.php";
require_once "db/DBReviewer.php";
require_once "db/DB.php";

//var_dump($_GET);
//var_dump($_POST);
//var_dump($_POST['workID']);
if (isset($_GET['scoredWorks'])) {

    $works = DB::select('SELECT * FROM peer_review_db.Work;');
    echo json_encode($works);

} elseif (isset($_POST['userLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

//    $result = $conn->query("SELECT * FROM peer_review_db.UsersVIew where Username='$username' and Password='$password';");
    $query="SELECT * FROM peer_review_db.UsersVIew where Username='$username' and Password='$password';";
    $user = DB::select($query);
    echo json_encode($user);
//    echo json_encode($user);

//    if (DBWork::deleteWork(new Work($workID)) == true)
//        http_response_code(202);
//    else
//        http_response_code(404);

}


#$work = new Work.class(1);
//DBWork::deleteWork($work);


// testing functionality for reviewer part
//$r = new Reviewer.class("insert", "123", "insert", "academic", 1);
//DBReviewer::selectAllReviewers();
//DBReviewer::insertReviewer($r);
//DBReviewer::deleteReviewer($r);
?>
