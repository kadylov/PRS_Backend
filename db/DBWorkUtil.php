<?php

require_once 'dbinfo.inc';

require_once 'model/Work.php';


class DBWorkUtil {

    //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID

    static public function selectAllWorks() {

        $conn = connect();

        $result = $conn->query('SELECT * FROM peer_review_db.Work;');

        $works = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($works);
        mysqli_close($conn);

        return $works;

    }


    static public function insertWork(Work $newWork) {

        $title = $newWork->getTitle();
        $authorName = $newWork->AuthorName();
        $url = $newWork->getUrl();
        $tags = $newWork->getTags();
        $dateWritten = $newWork->getDateWritten();
        $dateSubmitted = $newWork->getDateSubmitted();
        $retireFlag = $newWork->getRetireFlag();
        $status = $newWork->getStatus();

        $conn = connect();
        //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID, Score
        $query = "INSERT INTO peer_review_db.Work (Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, Score) VALUES(?,?,?,?,?,?,?,?,?,?); ";
        if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("ssssssss", $title, $authorName, $url, $tags, $dateWritten, $dateSubmitted, $retireFlag, $status);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result !== FALSE)
                $result = $result->fetch_all(MYSQLI_ASSOC);

            echo "Records inserted successfully.";
        } else {
            echo "ERROR: Could not prepare query: $query. ".$conn->error;
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
        return $result;

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
            echo "Work was deleted successfully.";
            $flag = false;
        } else {
            echo "ERROR: Could not able to execute $sql. ".$conn->error;
        }

        $conn->close();
        return $flag;
    }


}

?>
