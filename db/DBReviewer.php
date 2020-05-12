<?php

require_once 'dbinfo.inc';

require_once './Utils/util.php';


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
        $query = "SELECT RubricID, Score FROM peer_review_db.ScorecardView WHERE WorkID=$workID AND ReviewerID=$reviewerID;";
        $result = $conn->query($query);
        if (!$result) {
            $conn->close();
            die("\nErrormessage:".$conn->error);

        } elseif ($result->num_rows > 0) {
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

            if (!empty($obj->RubricID)) {
                $rubric["$obj->RubricID"] = $obj->RubricText;
                $scores["$obj->RubricID"] = $obj->Score;
                $scorecard->setCanScore("$obj->CanScore");
            }

            while ($obj = $result->fetch_object()) {

                if (!empty($obj->RubricID)) {
                    $rubric["$obj->RubricID"] = $obj->RubricText;
                    $scores["$obj->RubricID"] = $obj->Score;
                }


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
        if (!$result) {
            $conn->close();
            die("\nErrormessage:".$conn->error);

        }

        while ($row = $result->fetch_assoc()) {
            $rubricText[] = $row["RubricID"].". ".$row["Text"];
        }

        $result->free();
        $conn->close();
        return $rubricText;


    }



    public static function insertNewMessage(Message $msg) {


        $wid = $msg->getWorkID();
        $rid = $msg->getReviewerID();
        $message = $msg->getMessage();
        $dtime = $msg->getDateAndTime();

        $conn = connect();
        $query = "INSERT INTO peer_review_db.Discussion (WorkID, ReviewerID, Message, DTime) VALUES(?,?,?,?); ";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("ssss", $wid, $rid, $message, $dtime);
        if (!$stmt->execute()) {
            $conn->close();
            responseWithError($stmt->error);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();


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

//        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();


    }

    public static function saveScorecard($scorecard) {

        $conn = connect();
        $workID = $scorecard['WID'];
        $reviewerID = $scorecard['ReviewerID'];
        $canScore = 0;

        //        WorkID, RubricID, Score, ReviewerID, canScore
        $query = "INSERT INTO peer_review_db.Scorecard (WorkID, RubricID, Score, ReviewerID, canScore)"
            ." VALUES(?,?,?,?,?); ";

        $stmt = $conn->prepare($query);

        for ($rubricID = 1; $rubricID <= 12; $rubricID++) {
            $score = (int)$scorecard["$rubricID"];
            $stmt->bind_param("sssss", $workID, $rubricID, $score, $reviewerID, $canScore);

            if (!$stmt->execute()) {
                $conn->close();
                sendHttpResponseMsg(404, 'Unable to save the scorecard: '.$stmt->error);
            }
        }


        sendHttpResponseMsg(200, 'Scorecard sucessfully saved.');
        // close statement
        $stmt->close();

        // close connection
        $conn->close();
        return true;
    }


    // add reviewer review to review history
    public static function saveReview(Review $review) {

        $workID = $review->getWorkID();
        $reviewerID = $review->getReviewerID();
        $dateReviewed = $review->getDateReviewed();
        $score = $review->getScore();
        $reviewComment = $review->getReviewerComment();

        $conn = connect();
        $query = "INSERT INTO peer_review_db.Reviews_History (WorkID, ReviewerID, DateReviewed, Score,ReviewerComment) VALUES(?,?,?,?,?); ";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("sssss", $workID, $reviewerID, $dateReviewed, $score, $reviewComment);
        if (!$stmt->execute()) {
            $conn->close();
            sendHttpResponseMsg(404, 'Unable to save the scorecard: '.$stmt->error);
        }

//        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
    }

}

?>
