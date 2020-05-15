<?php
require_once "header_config.php";
require_once "db/DB.php";
require_once 'Utils/util.php';
require_once 'Utils/mail.php';


// this php file is responsible to receive a group of assigned reviewers for incoming work

// responsible for receiving a list of reviewers in json
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$contentType = explode(';', $_SERVER['CONTENT_TYPE']);


$rawBody = file_get_contents("php://input"); // Read body
$data = array(); // Initialize default data array

$data = json_decode($rawBody, true); // Then decode it


$adminID = $data['AdminID'];
$workID = $data['WorkID'];
$adminID = $data['AdminID'];
$reviewers = $data['ReviewersAndDueDate'];
$canReview = 1;

$a = "";

// set timezone to Denver and get current date
date_default_timezone_set("America/Denver");
$currentDate =  date("Ymd");


$conn = connect();


$query = "INSERT IGNORE INTO peer_review_db.Assignment (AdminID, ReviewerID, WorkID, DateAssigned, DueDate, CanReview) VALUES(?,?,?,?,?,?); ";
$stmt = $conn->prepare($query);

foreach ($reviewers as $reviewer) {
//AdminID, ReviewerID, WorkID, DateAssigned, DueDate, CanReview

    $stmt->bind_param("ssssss", $adminID, $reviewer["ReviewerID"], $workID, $currentDate, $reviewer["DueDate"], $canReview);
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

// notify assigned reviewers via email
$query = "SELECT r.RName, r.Email, a.DueDate, a.WorkID FROM peer_review_db.Reviewer r, peer_review_db.Assignment a WHERE r.RID=a.ReviewerID AND a.WorkID=$workID;";

$result = $conn->query($query);
if (!$result)
    sendHttpResponseMsg(404, "\nError message:".$conn->error);

elseif ($result->num_rows > 0) {

    $prsEmail = 'prs.prs2020@gmail.com';

    while ($reviewer = $result->fetch_assoc()) {

        // RName, Email, DueDate, WorkID
        $email = new Email();
        $email->setRecepientName($reviewer['RName']);
        $email->setRecepientEmail($reviewer['Email']);

        $email->setSenderName('no-reply');
        $email->setSenderEmail($prsEmail);
        $email->setSubject('PRS: New Assignment');
        $email->setMessage(getNotificationForReviewerTemplate($reviewer['DueDate']));
        $email->setReply(0);

        sendEmail($email);


    }

}

$conn->close();
return $result;


/*
 * private $recepientName;
    private $recepientEmail;
    private $senderName;
    private $senderEmail;
    private $subject;
    private $message;
 *
 *
 * */

sendHttpResponseMsg(200, 'Assignment has been saved successfully.');


?>



