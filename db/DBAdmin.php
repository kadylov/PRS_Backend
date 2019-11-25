<?php


class DBAdmin {
    static public function getAllIncommingWorks() {

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

    static public function getRejectedWorks() {

        $conn = connect();
        $result = $conn->query('SELECT * FROM peer_review_db.RejectedWorkView;');

        $works = "";
        if ($result) {
            if ($result->num_rows > 0) {
                $works = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
        $conn->close();
        return $works;

    }

    static public function getUnassignedWorks() {

        $conn = connect();
        $result = $conn->query('SELECT * FROM peer_review_db.Work WHERE Status="admitted";');

        $works = "";
        if ($result) {
            if ($result->num_rows > 0) {
                $works = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
        $conn->close();
        return $works;

    }

    //WID, Title, URL, DateSubmission, DateWritten, IsRetired, Status, AuthorName, AuthorEmail, Tag, RSID

    static public function getAllReviewers() {

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
        $roleType = $newReviewer->getRoleId();

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
        $roleType = $newReviewer->getRoleId();

        if ($rid == 0 || $credential == 0 || $roleType == 0) {
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
            echo "Reviewer.class was deleted successfully.";
        } else {
            die("ERROR: Could not able to execute $sql. ".$conn->error);
        }

        $conn->close();
    }

    public static function deleteReviewerByID($id) {

        if ($id == 0) {
            die("\nError! Reviewer.class ID cannot be zero\n");
        }

        $sql = "DELETE FROM peer_review_db.Reviewer WHERE RID=$id";

        $conn = connect();
        if ($conn->query($sql) === true) {
            echo "Reviewer.class was deleted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. ".$conn->error;
        }

        $conn->close();
    }

    public static function getAdminReviewsByID($adminId) {
        if ($adminId == 0 || $adminId == null) {
            die("Error! ID cannot be zero or null");
        }

        $conn = connect();
        $result = $conn->query('SELECT * FROM peer_review_db.Work WHERE Status="new";');

        $reviews = array();
        if (!$result) {
            printf("Errormessage: %s\n", $conn->error);
        } elseif ($result->num_rows > 0) {
            $reviews = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            printf("\nNo reviews by the selected admin: \n");
        }
        return $reviews;
    }

    // stores admin's pre-review in the table Admin_Review
    public static function updateReview(AdminReview $adminReview) {
        echo "\n$adminReview\n";

        $adminId = $adminReview->getAdminID();
        $workID = $adminReview->getWorkID();
        $dateReviewed = $adminReview->getDateReviewed();
        $decision = $adminReview->getDecision();
        $rejectedNote = $adminReview->getRejectNote();

        if ($adminId == 0 || $workID == 0) {
            die("\nError! adminid or workid cannot be zero\n");
        }

        //    dbAdmin_Review columns: AdminID, WorkID, DateReviewed, Decision, RejectNote
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Admin_Review (AdminID, WorkID, DateReviewed, Decision, RejectNote) VALUES(?,?,?,?,?); ";

        if (!$stmt = $conn->prepare($query)) {
            die($conn->error);
        }

        $stmt->bind_param("sssss", $adminId, $workID, $dateReviewed, $decision, $rejectedNote);
        if (!$stmt->execute()) {
            die($stmt->error);
        }
        echo "Records inserted successfully.";


        $query = "UPDATE peer_review_db.Work SET Status=? WHERE WID=?;";
        if (!$stmt = $conn->prepare($query)) {
            die($conn->error);
        }

        $stmt->bind_param("ss", $decision, $workID);
        if (!$stmt->execute()) {
            die($stmt->error);
        }

        echo "Records updated successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();


    }


}

?>
