<?php

require_once 'dbinfo.inc';

require_once 'model/Reviewer.php';


class DBReviewerUtil {

    //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID

    static public function selectAllReviewers() {

        $conn = connect();

        $result = $conn->query('SELECT * FROM peer_review_db.ReviewersView;');

        $reviewers = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($reviewers);
        mysqli_close($conn);

        return $reviewers;
    }


    static public function insertReviewer(Reviewer $newReviewer) {

        $username = $newReviewer->getUsername();
        $password = $newReviewer->getPassword();
        $reviewerName = $newReviewer->getName();
        $credential = $newReviewer->getCredential();
        $roleType = $newReviewer->getRoleId();

//        RID, Username, Password, RName, RCredential, RoleId
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Reviewer (Username, Password, RName, RCredential, RoleId) VALUES(?,?,?,?,?); ";
        if ($stmt = $conn->prepare($query)) {

            $stmt->bind_param("sssss", $username, $password, $reviewerName, $credential, $roleType);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result !== FALSE) {
                $result = $result->fetch_all(MYSQLI_ASSOC);
            }

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


    public static function deleteReviewer(Reviewer $reviewer) {
        // Attempt delete query execution
        $username = $reviewer->getUsername();
        $password = $reviewer->getPassword();
        $name = $reviewer->getName();

        $sql = "DELETE FROM peer_review_db.Reviewer WHERE Username='$username' AND Password='$password' AND RName='$name';";

        $conn = connect();
        if ($conn->query($sql) === true) {
            echo "Reviewer was deleted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. ".$conn->error;
        }

        $conn->close();
    }


}

?>
