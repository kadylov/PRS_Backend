<?php


class DBAdmin {

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
    public static function preReview(AdminReview $adminReview) {
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
//        echo "Records inserted successfully.";


        $query = "UPDATE peer_review_db.Work SET Status=? WHERE WID=?;";
        if (!$stmt = $conn->prepare($query)) {
            die($conn->error);
        }

        $stmt->bind_param("ss", $decision, $workID);
        if (!$stmt->execute()) {
            die($stmt->error);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

//        echo "Records updated successfully.";

        http_response_code(202);
    }

    public static function getAllMessages($workID){
        if($workID==0 || $workID=="" || $workID==null)
            die("Error! work id cannot be zero or null");



    }

    public static function newAssignment(Assignment $assignment) {

        $adminID = $assignment->getAdminID();
        $reviewerID = $assignment->getReviewerID();
        $DateAssigned = $assignment->getDateAssigned();
        $DueDate = $assignment->getDueDate();

//        AdminID, ReviewerID, WorkID, DateAssigned, DueDate
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Assignment (AdminID, ReviewerID, WorkID, DateAssigned, DueDate) VALUES(?,?,?,?); ";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssss", $adminID, $reviewerID, $WorkID, $DateAssigned, $DueDate);
        if (!$stmt->execute()) {
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
