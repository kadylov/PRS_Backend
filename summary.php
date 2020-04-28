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

    echo json_encode(DB::select("SELECT * FROM peer_review_db.ScorecardView;"));


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



function getUnassignedWorks(){
    $unasignedWorks = array();
    // get all Works
    $query = "SELECT WID, Title, URL, AuthorName, Status FROM peer_review_db.ReviewInProgressView GROUP BY WID";
    $conn = connect();
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($work = $result->fetch_assoc()) {
            $query2 = "SELECT ReviewerID, ReviewerName, Role, DateAssigned, DueDate FROM peer_review_db.ReviewInProgressView WHERE WID=".$work['WID'].";";
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                $reviewers = $result2->fetch_all();
                $work['Reviewers'] = $reviewers;
//                $works['Reviewers']=$reviewers;
                array_push($unasignedWorks, $work);
            }
        }
    }
    else{

    }
    $conn->close();


//    $works = DB::select($query);
    echo json_encode($unasignedWorks);
}




?>
