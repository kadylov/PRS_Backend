<?php
require_once "header_config.php";
require_once "db/DB.php";
require_once 'Utils/util.php';


// responsible for receiving a list of reviewers in json
ini_set('display_errors', 1);
error_reporting(E_ALL);

$contentType = explode(';', $_SERVER['CONTENT_TYPE']);


$rawBody = file_get_contents("php://input"); // Read body
$data = array(); // Initialize default data array

$data = json_decode($rawBody, true); // Then decode it


$adminID = $data['AdminID'];
$workID = $data['WorkID'];
$adminID = $data['AdminID'];
$reviewers = $data['Reviewers'];
$canReview = 1;

$a = "";



$conn = connect();
$query = "INSERT IGNORE INTO peer_review_db.Assignment (AdminID, ReviewerID, WorkID, DateAssigned, DueDate, CanReview) VALUES(?,?,?,?,?,?); ";
$stmt = $conn->prepare($query);

foreach ($reviewers as $reviewer) {
//AdminID, ReviewerID, WorkID, DateAssigned, DueDate, CanReview

    $stmt->bind_param("ssssss", $adminID, $reviewer["ReviewerID"], $workID, $reviewer["DueDate"], $reviewer["DueDate"], $canReview);
    if (!$stmt->execute()) {
        sendHttpResponseMsg(404, 'Unable to save an assignment: '.$stmt->error);
    }
}

// update work status to 'assigned'
$decision = "assigned";
$query = "UPDATE peer_review_db.Work SET Status=? WHERE WID=?;";
if (!$stmt = $conn->prepare($query)) {
    sendHttpResponseMsg(404, 'Unable to prepare query for work status: '.$stmt->error);
}

$stmt->bind_param("ss", $decision, $workID);
if (!$stmt->execute()) {
    sendHttpResponseMsg(404, 'Unable to update work status: '.$stmt->error);
}


sendHttpResponseMsg(200, 'Assignment has been saved successfully.');




?>



