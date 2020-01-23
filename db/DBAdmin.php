<?php


class DBAdmin {

    static public function createReviewer(Reviewer $newReviewer) {

        echo $newReviewer;

        $username = $newReviewer->getUsername();
        $password = $newReviewer->getPassword();
        $reviewerName = $newReviewer->getName();
        $credential = $newReviewer->getCredentialID();
        $roleType = $newReviewer->getRoleId();
        $email = $newReviewer->getEmail();

//        Username, Password, RName, CredentialID, RoleId, Email
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
        $reviewerEmail = $newReviewer->getEmail();
        $credential = $newReviewer->getCredentialID();
        $roleType = $newReviewer->getRoleId();
        $isActive = $newReviewer->getActiveFlag();

        $foundUser = DB::select("SELECT * FROM peer_review_db.Reviewer WHERE RID=$rid;");
        if ($foundUser == null) {
            die("Error in DBAdmin.class! user is not found for update");
        }

//        RID, Username, Password, RName, CredentialID, RoleId, Email, IsActive
        $conn = connect();
        $query = "UPDATE peer_review_db.Reviewer SET Username=?, Password=?, RName=?, CredentialID=?, RoleId=?, Email=?, IsActive=? WHERE RID=?;";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $conn->close();
            die($stmt->error);
        }


        $stmt->bind_param("ssssssss", $username, $password, $reviewerName, $credential, $roleType, $reviewerEmail, $isActive, $rid);
        if (!$stmt->execute()) {
            $conn->close();
            die($stmt->error);
        }

        echo "Records updated successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
    }

    public static function deleteReviewerByID($id) {

        if ($id == 0 || $id === null) {
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


    public static function getAdminReviewsByID($adminID) {
        if ($adminID == 0 || $adminID === null) {
            die("Error! admin ID cannot be zero or null");
        }

        $conn = connect();
        $result = $conn->query("SELECT * FROM peer_review_db.AdminReviews WHERE AdminID=$adminID;");

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

        // update status with a new value(e.g. admitted) in Work table
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

//        http_response_code(202);
    }


    public static function createNewAssignment(Assignment $assignment) {

        echo $assignment;
        $adminID = $assignment->getAdminID();
        $reviewerID = $assignment->getReviewerID();
        $WorkID = $assignment->getWorkID();
        $DateAssigned = $assignment->getDateAssigned();
        $DueDate = $assignment->getDueDate();

//        AdminID, ReviewerID, WorkID, DateAssigned, DueDate
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Assignment (AdminID, ReviewerID, WorkID, DateAssigned, DueDate) VALUES(?,?,?,?,?); ";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("sssss", $adminID, $reviewerID, $WorkID, $DateAssigned, $DueDate);
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
