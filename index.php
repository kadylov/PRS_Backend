<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");


require_once "model/Work.php";
require_once "model/Reviewer.php";

require_once "db/DBWork.php";
require_once "db/DBReviewer.php";

//var_dump($_GET);
//var_dump($_POST);
//var_dump($_POST['workID']);
if (isset($_GET['scoredWorks'])) {
    DBWork::selectAllWorks();
} elseif (isset($_POST['userLogin'])) {
//    var_dump($_POST);
//    echo "\nuserLoginRequest\n";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connect();
    if (!$conn) {
        die("Error! cannot connect");
    }
    $result = $conn->query("SELECT * FROM peer_review_db.UsersVIew where Username='$username' and Password='$password';");


    $user = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    echo json_encode($user);


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
