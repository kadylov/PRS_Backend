<?php


require_once "header_config.php";
require_once 'Utils/util.php';
require_once 'db/dbinfo.inc';
require_once 'db/DB.php';


// report all occured error messages to the screen
//ini_set('display_errors', 1);
//error_reporting(E_ALL);


// this php script is responsible for collecting and submitting all reviewers scorecards for each reviewed works
// it is used for generating review summary

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $status = 'scored';

    if ($_GET['getReviewersScorecard']) {

        $query = "SELECT WID, Title, URL, Status, AuthorName FROM peer_review_db.ScorecardView WHERE Status='scored' GROUP BY WID";


        // modify query if the work status was passed from client side
        // this statement is true if the http request coming form lead reviewer summary page
        if (isset($_GET['Status']) && !empty($_GET['Status']) && isset($_GET['WID']) && !empty($_GET['WID'])) {
            $status = $_GET['Status'];
            $query = "SELECT WID, Title, URL, Status, AuthorName FROM peer_review_db.ScorecardView WHERE Status='".$status."' GROUP BY WID";

        }

        else if (isset($_GET['WID']) && !empty($_GET['WID'])) {

            $query = "SELECT WID, Title, URL, Status, AuthorName FROM peer_review_db.ScorecardView WHERE WID =".$_GET['WID']." GROUP BY WID";
        }

        $scorecards = array();


        // get all Works
        $conn = connect();
        $result = $conn->query($query);


        if ($result->num_rows > 0) {

            // loop through each work and collect reviewers info and their scores from their scorecards
            while ($work = $result->fetch_assoc()) {

                $work['Scorecards'] = array();

                // get group of reviewers for the work
                $query2 = "SELECT ReviewerID, ReviewerName, Credential, RoleId, RoleType, IsActive, canScore FROM peer_review_db.ScorecardView where WID=".$work['WID']." group by ReviewerID;";
                $reviewers = $conn->query($query2);
                if ($reviewers->num_rows > 0) {

                    // loop through each reviewer and get his/her scores for the scorecard
                    while ($reviewer = $reviewers->fetch_assoc()) {
//                        $rubricQuery = "SELECT RubricID, RubricText, Score FROM peer_review_db.ScorecardView where WID=".$work['WID']." and ReviewerID=".$reviewer['ReviewerID'].";";
                        $rubricQuery = "SELECT RubricID, Score FROM peer_review_db.ScorecardView where WID=".$work['WID']." and ReviewerID=".$reviewer['ReviewerID'].";";


                        $result2 = $conn->query($rubricQuery);
                        if ($result2->num_rows > 0) {
                            $scorecard = $result2->fetch_all(MYSQLI_ASSOC);
                        }

                        $reviewer['Scores'] = $scorecard;

                        array_push($work['Scorecards'], $reviewer);
                    }

                    array_push($scorecards, $work);

                }
            }
        }
        $conn->close();
        echo json_encode($scorecards);

    }

}


?>
