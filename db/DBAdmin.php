<?php


class DBAdmin {
    static public function selectAllIncommingWorks() {

        $conn = connect();
        $reviewers = array();

        $result = $conn->query('SELECT * FROM peer_review_db.Work WHERE Status="new";');
        if (!$result) {
            printf("Errormessage: %s\n", $conn->error);
        } elseif ($result->num_rows > 0) {
            $reviewers = $result->fetch_all(MYSQLI_ASSOC);
        }


        $conn->close();
        return $reviewers;

    }

    //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID

    static public function selectAllReviewers() {

        $conn = connect();

        $result = $conn->query('SELECT * FROM peer_review_db.ReviewersListView;');
        $reviewers = array();
        if ($result->num_rows > 0) {
            $reviewers = $result->fetch_all(MYSQLI_ASSOC);
        }


        mysqli_close($conn);
        return $reviewers;

    }

    static public function createReviewer(Reviewer $newReviewer) {

        echo $newReviewer;

        $username = $newReviewer->getUsername();
        $password = $newReviewer->getPassword();
        $reviewerName = $newReviewer->getName();
        $credential = $newReviewer->getCredentialID();
        $roleType =  $newReviewer->getRoleId();

        if ($credential == 0 || $roleType == 0) {
            die("\nError, credential or roleId cannot be zero\n");
        }

//        RID, Username, Password, RName, RCredential, RoleId
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Reviewer (Username, Password, RName, CredentialID, RoleId) VALUES(?,?,?,?,?); ";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("sssss", $username, $password, $reviewerName, $credential, $roleType);
        if (!$stmt->execute()) {
            die($stmt->error);
        }

        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
    }

    static public function updateReviewer(Reviewer $newReviewer) {

        echo $newReviewer;

        $rid = $newReviewer->getRid();
        $username = $newReviewer->getUsername();
        $password = $newReviewer->getPassword();
        $reviewerName = $newReviewer->getName();
        $credential = $newReviewer->getCredentialID();
        $roleType =  $newReviewer->getRoleId();

        if ($rid==0 || $credential == 0 || $roleType == 0) {
            die("\nError! id or credential or roleId cannot be zero\n");
        }

//        RID, Username, Password, RName, RCredential, RoleId
        $conn = connect();
        $query = "UPDATE peer_review_db.Reviewer SET Username=?, Password=?, RName=?, CredentialID=?, RoleId=? WHERE RID=?;";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die($stmt->error);
        }


        $stmt->bind_param("ssssss", $username, $password, $reviewerName, $credential, $roleType, $rid);
        if (!$stmt->execute()) {
            die($stmt->error);
        }

        echo "Records deleted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
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
            die("ERROR: Could not able to execute $sql. ".$conn->error);
        }

        $conn->close();
    }

    public static function deleteReviewerByID($id) {

        if ($id == 0) {
            die("\nError! Reviewer ID cannot be zero\n");
        }

        $sql = "DELETE FROM peer_review_db.Reviewer WHERE RID=$id";

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
