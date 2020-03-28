<?php

require_once './Utils/util.php';


class DBAdmin {

    static public function createUser(User $user) {
        $flag = true;
        $username = $user->getUsername();
        $password = $user->getPassword();
        $reviewerName = $user->getName();
        $credential = $user->getCredentialID();
        $roleType = $user->getRoleId();
        $email = $user->getEmail();
        $activeFlag = $user->getActiveFlag();

        if ($roleType == 3) {
            $query = "INSERT INTO peer_review_db.Admin (Username, Password, AName, CredentialID, RoleId, Email, IsActive) VALUES(?,?,?,?,?,?,?); ";

        } else {
            $query = "INSERT INTO peer_review_db.Reviewer (Username, Password, RName, CredentialID, RoleId, Email, IsActive) VALUES(?,?,?,?,?,?,?); ";

        }


//        RID, Username, Password, RName, CredentialID, RoleId, Email, IsActive
        $conn = connect();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $username, $password, $reviewerName, $credential, $roleType, $email, $activeFlag);
        if (!$stmt->execute()) {
            echo $stmt->error;
            $flag = false;
        }

//        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
        return $flag;
    }

    static public function createAdmin(Admin $newAdmin) {

        $username = $newAdmin->getUsername();
        $password = $newAdmin->getPassword();
        $name = $newAdmin->getName();
        $credential = $newAdmin->getCredentialID();
        $roleType = $newAdmin->getRoleId();
        $email = $newAdmin->getEmail();

        if ($credential == 0 || $roleType == 0) {
            die("\nError, credential or roleId cannot be zero\n");
        }

        //AID, Username, Password, AName, CredentialID, RoleId, Email
        $query = "INSERT INTO peer_review_db.Admin (Username, Password, AName, CredentialID, RoleId, Email) VALUES(?,?,?,?,?,?); ";
        $conn = connect();
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssssss", $username, $password, $name, $credential, $roleType, $email);
        if (!$stmt->execute()) {
            die($stmt->error);
        }

        echo "Records inserted successfully.";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
    }


    static public function updateUser(User $user, $oldUsername, $oldEmail) {
        $rid = $user->getRid();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $reviewerName = $user->getName();
        $reviewerEmail = $user->getEmail();
        $credential = $user->getCredentialID();
        $roleType = $user->getRoleId();
        $isActive = $user->getActiveFlag();

        $foundReviewer = DB::select("SELECT * FROM peer_review_db.Reviewer WHERE RID=$rid AND Username='$oldUsername' AND Email='$oldEmail'");

        $foundAdmin = DB::select("SELECT * FROM peer_review_db.Admin WHERE AID=3 AND Username='$oldUsername' AND Email='$oldEmail'");

        if ($foundReviewer != null) {
            $query = "UPDATE peer_review_db.Reviewer SET Username=?, Password=?, RName=?, CredentialID=?, RoleId=?, Email=?, IsActive=? WHERE RID=?;";
        } else if ($foundAdmin != null) {
            $query = "UPDATE peer_review_db.Admin SET Username=?, Password=?, AName=?, CredentialID=?, RoleId=?, Email=?, IsActive=? WHERE AID=?;";
        } else {
            responseWithError("User was not found for update", 406);
        }

        $conn = connect();
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $conn->close();
            responseWithError("$stmt->error", 406);

        }

        $stmt->bind_param("ssssssss", $username, $password, $reviewerName, $credential, $roleType, $reviewerEmail, $isActive, $rid);
        if (!$stmt->execute()) {
            $conn->close();
            responseWithError("$stmt->error", 406);
        }

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
            json_encode("Reviewer.class was deleted successfully.");
        } else {
            http_response_code(409);
            json_encode("ERROR: Could not able to execute $sql. ".$conn->error);

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
        $adminId = $adminReview->getAdminID();
        $workID = $adminReview->getWorkID();
        $dateReviewed = $adminReview->getDateReviewed();
        $decision = $adminReview->getDecision();
        $rejectedNote = $adminReview->getRejectNote();


        // check whether the work has already been pre-reviewed in the database or not
        // return an error message if the work with given workId is in the admin review database
        $review = DB::select('SELECT * FROM peer_review_db.Admin_Review WHERE WorkID='.$workID);
        if ($review != null) {
            responseWithError("Work with id= ".$workID." was already reviewed. You cannot preview the same work twice!!!");

        }
        //    dbAdmin_Review columns: AdminID, WorkID, DateReviewed, Decision, RejectNote
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Admin_Review (AdminID, WorkID, DateReviewed, Decision, RejectNote) VALUES(?,?,?,?,?); ";

        if (!$stmt = $conn->prepare($query)) {
            responseWithError("$conn->error");
            return;
        }

        $stmt->bind_param("sssss", $adminId, $workID, $dateReviewed, $decision, $rejectedNote);
        if (!$stmt->execute()) {
            responseWithError("$stmt->error");

            return;
//            die($stmt->error);
        }
//        echo "Records inserted successfully.";

        // update status with a new value(e.g. admitted) in Work table
        $query = "UPDATE peer_review_db.Work SET Status=? WHERE WID=?;";
        if (!$stmt = $conn->prepare($query)) {
            http_response_code(400);
            echo json_encode(array("message" => "$conn->error"));
//            die($conn->error);
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

    public static function deactivateUserById(int $id, int $roleId, int $activeStatus) {
        if ($id === null) {
            die("\nError! Reviewer.class ID cannot be null\n");
        }

        $sql = "UPDATE  peer_review_db.Reviewer SET isActive=$activeStatus WHERE RID=$id";
        $conn = connect();

        if ($roleId === 3) {    // admin id is 3
            this.$sql = "UPDATE  peer_review_db.Admin SET isActive=$activeStatus WHERE AID=$id";
        }

        if ($conn->query($sql) === true) {
            json_encode(array("message" => "Reviewer.class was deleted successfully."));
            http_response_code(200);

        } else {
            responseWithError("ERROR: Could not able to execute".$sql." ".$conn->error);
        }

        $conn->close();
    }

    public static function getReviewInProgress() {
        $conn = connect();

        $query = "SELECT * FROM peer_review_db.ReviewInProgressView;";
        $result = $conn->query($query);
        if (!$result) {
            $conn->close();
            responseWithError("Errormessage:".$conn->error);

        } elseif ($result->num_rows > 0) {

            $workID = 0;
            $isNewRow = false;
            $reviewers = array();
            $works[] = array();
            $list = array();

            while ($row = $result->fetch_array(MYSQLI_BOTH)) {
                $list[] = $row;
            }

            $size = sizeof($list);
            printf("Size %d \n", $size);

            for ($index = 0; $index < $size; ++$index) {
                                printf("%s \n", $list[$index]);
            }

//            while ($obj = $result->fetch_object()) {

//                $title = $obj->Title;
//                $URL = $obj->URL;
//                $AuthorName = $obj->AuthorName;
//                $DateAssigned = $obj->DateAssigned;
//                $DueDate = $obj->DueDate;
//                printf("%s \n", $obj->ReviewerName);
//
//                if ($workID !== $obj->WID) {
//                    $isNewRow = true;
//                    $workID = $obj->WID;
//
////                    $works[] = array(
////                        'WID' => $wid,
////                        'Title' => $title,
////                        'URL' => $URL,
////                        'AuthorName' => $AuthorName,
////                        'DateAssigned' => $DateAssigned,
////                        'DueDate' => $DueDate,
////                        'Reviewers' => $reviewers
////                    );
//                    $works[] = array(
//                        'WID' => $obj->WID,
//                        'Title' => $obj->Title,
//                        'URL' => $obj->URL,
//                        'AuthorName' => $obj->AuthorName,
//                        'DateAssigned' => $obj->DateAssigned,
//                        'DueDate' => $obj->DueDate,
//                        'Reviewers' => $reviewers
//                    );
//                    $reviewers = array();
//
//                    $works[] = array(
//                        'WID' => $obj->WID,
//                        'Title' => $obj->Title,
//                        'URL' => $obj->URL,
//                        'AuthorName' => $obj->AuthorName,
//                        'DateAssigned' => $obj->DateAssigned,
//                        'DueDate' => $obj->DueDate,
//                        'Reviewers' => $reviewers
//                    );
//
//
//                } else {
//                    $reviewers[] = array(
//                        'ReviewerID' => $obj->ReviewerID,
//                        'ReviewerName' => $obj->ReviewerName,
//                    );
//                }

//            }
            $result->close();
        }

        $conn->close();
        echo json_encode($works);

    }

}

?>
