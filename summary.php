<?php


require_once "header_config.php";
require_once 'Utils/util.php';
require_once 'db/dbinfo.inc';
require_once 'db/DB.php';


// report all occured error messages to the screen
//ini_set('display_errors', 1);
//error_reporting(E_ALL);


// receive generated summary from lead reviewer
// and save it in the database
if($_SERVER["REQUEST_METHOD"] == "POST"){


    $rawBody = file_get_contents("php://input"); // Read body
    $summary = array(); // Initialize default data array

    $summary = json_decode($rawBody, true); // Then decode it

    $query = "INSERT INTO peer_review_db.Review_Summary(WorkID, LeadID, WorkFinalScore, SummaryText) VALUES(?,?,?,?)";

    $conn = connect();
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $summary['WorkID'], $summary['LeadID'],$summary['WorkFinalScore'],$summary['SummaryText']);
    if (!$stmt->execute()) {
        $conn->close();
        sendHttpResponseMsg(404, 'Unable to save summary: '.$stmt->error);
    }

    // update work status to 'scored
    $query = "UPDATE peer_review_db.Work SET Status = ? WHERE (WID = ?);";
    $status = 'scored';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $status, $summary['WorkID']);
    if (!$stmt->execute()) {
        $conn->close();
        sendHttpResponseMsg(404, 'Unable to update work status: '.$stmt->error);
    }

}

?>
