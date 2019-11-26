<?php

//require_once 'dbinfo.inc';
require_once 'dbinfo.inc';
//require_once 'model/Reviewer.php';


class DBReviewer {

    public static function getAllAsignments() {
    }

    public static function getScorecard($workID, $reviewerID) {

        if ($workID == 0 || $workID == null || $workID == "") {
            die("\nError! Work id cannot be zero or null\n");
        }

        if ($reviewerID == 0 || $reviewerID == null || $reviewerID == "") {
            die("\nError! reviewerID id cannot be zero or null\n");
        }


        echo  "\n$workID\n";
        $conn = connect();

        $query = 'SELECT * FROM peer_review_db.ScorecardView WHERE WorkID=' . $workID .' AND ReviewerID=' .$reviewerID .';' ;
//        echo $query;
        $result = $conn->query($query);
        if (!$result) {
            die("\nErrormessage:". $conn->error);
        } elseif ($result->num_rows > 0) {
            $scorecard = $result->fetch_all(MYSQLI_ASSOC);
        }

        $conn->close();
        return $scorecard;
    }


}
?>
