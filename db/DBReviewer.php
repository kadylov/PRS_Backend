<?php

require_once 'dbinfo.inc';

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

        $conn = connect();

        $scorecard = new Scorecard();

        $query = "SELECT * FROM peer_review_db.ScorecardView WHERE WorkID=$workID AND ReviewerID=$reviewerID;";
        $result = $conn->query($query);
        if (!$result)
            die("\nErrormessage:".$conn->error);

        elseif ($result->num_rows > 0) {
            $result = $result->fetch_all(MYSQLI_ASSOC);
            echo "\nCurrent Scorecard\n";

            $result = $result->fetch_array();

            $scorecard->setRubricText($result["RubricText"]);
            $scorecard->setScore(array($result['Score']));
            $scorecard->setCanScore($result['canScore']);
            $scorecard->setWorkID($result['WorkID']);
            $scorecard->setTitle($result['Title']);
            $scorecard->setURL($result['URL']);
            $scorecard->setReviewerID($result['ReviewerID']);
            $scorecard->setReviewerName($result['RName']);
            $scorecard->setRoleId($result['RoleId']);
            $scorecard->setRoleName($result['RoleName']);

            $result->free();

        }
        $conn->close();
        return $scorecard;

    }

    public static function getRubricText() {
        echo "\nNew Scorecard\n";
        $conn = connect();
        $result = $conn->query("SELECT * FROM peer_review_db.Rubric;");
        if (!$result)
            die("\nErrormessage:".$conn->error);

        while ($row = $result->fetch_assoc()) {
            $rubricText[] = $row["RubricID"].". ".$row["Text"];
        }

        $result->free();
        $conn->close();
        return $rubricText;


//        printf("\n%s\n", json_encode("rubric", $scorecard->getRubricText()));
//        $scorecard->setRubricText($rubricText);
    }

    // return all reviewer's reviews as an array
    public static function getReviewHistory($reviewerID) {
        $conn = connect();

        if ($reviewerID == 0 || $reviewerID == null || $reviewerID == "") {
            die("\nError! reviewerID id cannot be zero or null\n");
        }
//        WorkID, ReviewerID, DateReviewed, Score, ReviewerComment
        $query = "SELECT * FROM peer_review_db.Reviews_History WHERE ReviewerID=$reviewerID;";
        $result = $conn->query($query);

        if (!$result)
            die("\nErrormessage:".$conn->error);

        $reviewHistory = array();
        if ($result->num_rows > 0) {
            $reviewHistory = $result->fetch_all(MYSQLI_ASSOC);
        }

        $conn->close();
        return $reviewHistory;
    }

    public static function getDiscussionHistory($WorkID) {
        $conn = connect();

        if ($WorkID == 0 || $WorkID == null || $WorkID == "") {
            die("\nError! reviewerID id cannot be zero or null\n");
        }

        $query = "SELECT * FROM peer_review_db.DiscussionView WHERE WorkID=$WorkID;";
        $result = $conn->query($query);
        if (!$result)
            die("\nErrormessage:".$conn->error);

        $discussion = array();
        if ($result->num_rows > 0) {
            $discussion = $result->fetch_all(MYSQLI_ASSOC);
        }

        $conn->close();
        return $discussion;
    }
}

?>
