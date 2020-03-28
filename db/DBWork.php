<?php

require_once 'dbinfo.inc';

//require_once './model/Work.php';

class DBWork {

    //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID

    static public function selectAllWorks() {

        $works = DB::select('SELECT * FROM peer_review_db.Work;');
        return $works;

    }


    static public function insertWork(Work $newWork) {

        $title = $newWork->getTitle();
        $authorName = $newWork->getAuthorName();
        $url = $newWork->getUrl();
        $tags = $newWork->getTags();
        $dateWritten = $newWork->getDateWritten();
        $dateSubmitted = $newWork->getDateSubmitted();
        $retireFlag = $newWork->getRetireFlag();
        $status = $newWork->getStatus();
        $email = $newWork->getAuthorEmail();

        //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, TagID
        $query = "INSERT INTO peer_review_db.Work (Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tags) VALUES(?,?,?,?,?,?,?,?,?); ";

        $conn = connect();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssss", $title, $url, $dateSubmitted, $dateWritten, $retireFlag, $status, $authorName, $email, $tags);
        if (!$stmt->execute()) {
            echo json_encode($stmt->error);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

    }

    public static function findWork(Work $work) {

        $id = (int)$work.getWid();
        echo "\n findWork ID =  $id\n";
        $found = false;

        $conn = connect();
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        $result = $conn->query('SELECT * FROM peer_review_db.Work where $id ;');
        if ($result > 0) {
            $found = true;
        }
        $conn->close();

        return $found;
    }

    public static function deleteWork(Work $work) {

        $flag = true;
        $id = (int)$work->getWid();

        if ($id == null || $id == 0)
            return false;

        echo "\nDELETE id = $id \n";

        $sql = "DELETE FROM peer_review_db.Work WHERE WID='$id'";

        $conn = connect();

        // Attempt delete query execution
        if ($conn->query($sql) === true) {
            echo "Work.class was deleted successfully.";
            $flag = false;
        } else {
            echo "ERROR: Could not able to execute $sql. ".$conn->error;
        }

        $conn->close();
        return $flag;
    }


    public static function loadTags(){
        $conn = connect();

        $query = "SELECT * FROM peer_review_db.Tag;";
        $result = $conn->query($query);
        if (!$result) {
            $conn->close();
            die("\nErrormessage:".$conn->error);

        }
        elseif ($result->num_rows > 0) {

            while ($obj = $result->fetch_object()) {
                echo $obj->Title;
            }


        } else $scorecard = null;

        $conn->close();
        return $scorecard;

    }
}

?>
