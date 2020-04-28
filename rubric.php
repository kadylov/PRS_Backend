<?php


require_once "header_config.php";
require_once 'Utils/util.php';
require_once 'db/dbinfo.inc';
require_once 'db/DB.php';


// report all occured error messages to the screen
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    echo json_encode(DB::select("SELECT * FROM peer_review_db.Rubric;"));


} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $rawBody = file_get_contents("php://input"); // Read body
    $data = array(); // Initialize default data array

    $data = json_decode($rawBody, true); // Then decode it


    $query = "UPDATE peer_review_db.Rubric SET Text = ? WHERE (RubricID = ?);";


    $conn = connect();
    $stmt = $conn->prepare($query);

    foreach ($data as $rubric) {
        $stmt->bind_param("ss", $rubric['Text'], $rubric['RubricID']);
        if (!$stmt->execute()) {
            $conn->close();
            sendHttpResponseMsg(404, 'Unable to save an assignment: '.$stmt->error);
        }
    }

    $conn->close();
    sendHttpResponseMsg(200, 'Rubric for a Scorecard has been updated succesfully.');
}

?>
