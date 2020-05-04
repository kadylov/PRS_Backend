<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");

require_once 'db/dbinfo.inc';

require_once "model/Work.php";
require_once "model/Reviewer.php";

require_once "db/DBWork.php";
require_once "db/DBReviewer.php";
require_once "db/DB.php";

// report all occured error messages to the screen
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['scoredWorks'])) {

    $works = DB::select('SELECT * FROM peer_review_db.ScoredWorksView;');
    echo json_encode($works);

} elseif (isset($_POST['userLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

//    $result = $conn->query("SELECT * FROM peer_review_db.UsersVIew where Username='$username' and Password='$password';");
    $query = "SELECT * FROM peer_review_db.UsersView where Username='$username' and Password='$password';";
    $user = DB::select($query);

    if ($user != null) {
        $user[0]['username']="";
        $user[0]['password']="";
        echo json_encode($user);
    } else
        http_response_code(404);
} 

?>
