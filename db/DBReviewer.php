<?php

require_once 'dbinfo.inc';

class DBReviewer {

    public static function getScorecard($workID, $reviewerID) {
        if ($workID == 0 || $workID == null || $workID == "") {
            die("\nError! Work id cannot be zero or null\n");
        }

        if ($reviewerID == 0 || $reviewerID == null || $reviewerID == "") {
            die("\nError! reviewerID id cannot be zero or null\n");
        }

        $conn = connect();

        $scorecard = null;

//        $query = "SELECT * FROM peer_review_db.ScorecardView WHERE WorkID='$workID' AND ReviewerID='$reviewerID';";
        $query = "SELECT * FROM peer_review_db.ScorecardView WHERE WorkID=$workID AND ReviewerID=$reviewerID;";
        $result = $conn->query($query);
        if (!$result) {
            $conn->close();
            die("\nErrormessage:".$conn->error);

        }
        elseif ($result->num_rows > 0) {
//            $result = $result->fetch_all(MYSQLI_ASSOC);
//            $result = $result->fetch_array(MYSQLI_ASSOC);

            $scorecard = new Scorecard();
            $rubric = [];
            $scores = [];

//            WorkID, Title, URL, RubricID, RubricText, Score, ReviewerID, ReviewerName, RoleId, RoleName
            $obj = $result->fetch_object();
            $scorecard->setWorkID((int)$workID);
            $scorecard->setTitle($obj->Title);
            $scorecard->setURL($obj->URL);
            $scorecard->setReviewerID((int)$reviewerID);
            $scorecard->setReviewerName($obj->ReviewerName);
            $scorecard->setRoleId((int)$obj->RoleId);
            $scorecard->setRoleName($obj->RoleName);
            $rubric["$obj->RubricID"] = $obj->RubricText;
            $scores["$obj->RubricID"] = $obj->Score;
            $scorecard->setCanScore("$obj->CanScore");

//            echo $scorecard;


            while ($obj = $result->fetch_object()) {
                $rubric["$obj->RubricID"] = $obj->RubricText;
                $scores["$obj->RubricID"] = $obj->Score;
            }

            $scorecard->setRubric($rubric);
            $scorecard->setScore($scores);
//            echo $scorecard."\n";
//            var_dump($scorecard);
//            echo $rubric;

        } else $scorecard = null;

        $conn->close();
        return $scorecard;

    }

    public static function getRubricText() {
        echo "\nNew Scorecard\n";
        $conn = connect();
        $result = $conn->query("SELECT * FROM peer_review_db.Rubric;");
        if (!$result){
            $conn->close();
            die("\nErrormessage:".$conn->error);

        }

        while ($row = $result->fetch_assoc()) {
            $rubricText[] = $row["RubricID"].". ".$row["Text"];
        }

        $result->free();
        $conn->close();
        return $rubricText;


//        printf("\n%s\n", json_encode("rubric", $scorecard->getRubricText()));
//        $scorecard->setRubricText($rubricText);
    }

//    // return all reviewer's reviews as an array
//    public static function getReviewHistory($reviewerID) {
//        $conn = connect();
//
//        if ($reviewerID == 0 || $reviewerID == null || $reviewerID == "") {
//            die("\nError! reviewerID id cannot be zero or null\n");
//        }
////        WorkID, ReviewerID, DateReviewed, Score, ReviewerComment
//        $query = "SELECT * FROM peer_review_db.Reviews_History WHERE ReviewerID=$reviewerID;";
//        $result = $conn->query($query);
//
//        if (!$result)
//            die("\nErrormessage:".$conn->error);
//
//        $reviewHistory = array();
//        if ($result->num_rows > 0) {
//            $reviewHistory = $result->fetch_all(MYSQLI_ASSOC);
//        }
//
//        $conn->close();
//        return $reviewHistory;
//    }

//    public static function getDiscussionHistory($WorkID) {
//        $conn = connect();
//
//        if ($WorkID == 0 || $WorkID == null || $WorkID == "") {
//            die("\nError! WorkID id cannot be zero or null\n");
//        }
//
//        $query = "SELECT * FROM peer_review_db.DiscussionView WHERE WorkID=$WorkID;";
//        echo $query;
//        $result = $conn->query($query);
//        if (!$result)
//            die("\nErrormessage:".$conn->error);
//
//        $discussion = array();
//        if ($result->num_rows > 0) {
//            $discussion = $result->fetch_all(MYSQLI_ASSOC);
//        }
//
//        $conn->close();
//        return $discussion;
//    }


    public static function insertNewMessage(Message $msg) {

        $conn = connect();
        $query = "INSERT INTO peer_review_db.Discussion (WorkID, ReviewerID, Message, DTime) VALUES(?,?,?,?); ";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssss", $msg->getWorkID(), $msg->getReviewerID(), $msg->getMessage(), $msg->getDateAndTime());
        if (!$stmt->execute()) {
            $conn->close();
            die($stmt->error);
        }

        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

//        http_response_code(202);

    }

    public static function saveScores(Scorecard $scorecard) {
        $conn = connect();

        $rubrics = $scorecard->getRubric();
        $scores = $scorecard->getScore();
        $workID = $scorecard->getWorkID();
        $canScore = $scorecard->getCanScore();
        $reviewerID = $scorecard->getReviewerID();


        //        WorkID, RubricID, Score, ReviewerID, canScore
        $query = "INSERT INTO peer_review_db.Scorecard (WorkID, RubricID, Score, ReviewerID, canScore) VALUES(?,?,?,?,?); ";
        $stmt = $conn->prepare($query);
        for ($i = 0; $i < count($rubrics); $i++) {
            $rubID = (int)$rubrics[$i];
            $scoreID = (int)$scores[$i];
            $stmt->bind_param("sssss", $workID, $rubID, $scoreID, $reviewerID, $canScore);

            if (!$stmt->execute()) {
                $conn->close();
                die($stmt->error);
            }

        }


        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();


    }



    public static function saveReview(Review $review) {
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Reviews_History (WorkID, ReviewerID, DateReviewed, Score,ReviewerComment) VALUES(?,?,?,?,?); ";
        $stmt = $conn->prepare($query);


        echo "\nAAAAAA\n".$review->getReviewerID();

        $stmt->bind_param("sssss",$review->getWorkID(), $review->getReviewerID(),$review->getDateReviewed(),$review->getScore(),$review->getReviewerComment());
        if (!$stmt->execute()) {
            $conn->close();
            die($stmt->error);
        }

        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

//        http_response_code(202);
    }

}

?>
