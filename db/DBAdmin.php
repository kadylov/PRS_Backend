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
//            echo $stmt->error;
            sendHttpResponseMsg(404, 'Unable to create a user');
            $flag = false;
        }

        sendHttpResponseMsg(202, 'New user has been created successfully.');

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
            sendHttpResponseMsg(404, 'Error, credential or roleId cannot be zero');

        }

        //AID, Username, Password, AName, CredentialID, RoleId, Email
        $query = "INSERT INTO peer_review_db.Admin (Username, Password, AName, CredentialID, RoleId, Email) VALUES(?,?,?,?,?,?); ";
        $conn = connect();
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssssss", $username, $password, $name, $credential, $roleType, $email);
        if (!$stmt->execute()) {
            // close statement
            $stmt->close();

            // close connection
            $conn->close();
            sendHttpResponseMsg(404, 'Unable to create an admin');
        }

        sendHttpResponseMsg(202, 'Admin has been created successfully.');

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
            sendHttpResponseMsg(404, 'User was not found for update');
        }

        $conn = connect();
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $conn->close();

            sendHttpResponseMsg(404, 'Unable to update user');
//            responseWithError("$stmt->error", 406);

        }

        $stmt->bind_param("ssssssss", $username, $password, $reviewerName, $credential, $roleType, $reviewerEmail, $isActive, $rid);
        if (!$stmt->execute()) {
            $conn->close();
            sendHttpResponseMsg(404, 'Invalid sql query');
//            responseWithError("$stmt->error", 406);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
    }

    public static function deleteReviewerByID($id) {

        if ($id == 0 || $id === null) {
            sendHttpResponseMsg(404, 'Reviewer ID cannot be zero');

        }

        $sql = "DELETE FROM peer_review_db.Reviewer WHERE RID=$id";

        $conn = connect();
        if ($conn->query($sql) === true) {
            sendHttpResponseMsg(200, 'Reviewer.class was deleted successfully.');

        } else {
            sendHttpResponseMsg(404, 'ERROR: Could not able to execute $sql. ".$conn->error');

        }

        $conn->close();
    }


    public static function getAdminReviewsByID($adminID) {
        if ($adminID == 0 || $adminID === null) {
            sendHttpResponseMsg(404, 'Error! admin ID cannot be zero or null');
        }

        $conn = connect();
        $result = $conn->query("SELECT * FROM peer_review_db.AdminReviews WHERE AdminID=$adminID;");

        $reviews = array();
        if (!$result) {
            sendHttpResponseMsg(404, 'Error'. $conn->error);

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
        // save admin's prereview in the db
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
        }


        // update status of the work with a new value(e.g. admitted) in Work table
        $query = "UPDATE peer_review_db.Work SET Status=? WHERE WID=?;";
        if (!$stmt = $conn->prepare($query)) {
            http_response_code(400);
            echo json_encode(array("message" => "$conn->error"));
//            die($conn->error);
        }

        $stmt->bind_param("ss", $decision, $workID);
        if (!$stmt->execute()) {
            sendHttpResponseMsg(404, 'Error'. $stmt->error);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

    }


    // store new reviewer assignment to the database
    public static function createNewAssignment(Assignment $assignment) {

        $adminID = $assignment->getAdminID();
        $reviewerID = $assignment->getReviewerID();
        $workID = $assignment->getWorkID();
        $dateAssigned = $assignment->getDateAssigned();
        $dueDate = $assignment->getDueDate();
        $canReviewStatus = $assignment->getCanReview();

//        AdminID, ReviewerID, WorkID, DateAssigned, DueDate
        $conn = connect();
        $query = "INSERT INTO peer_review_db.Assignment (AdminID, ReviewerID, WorkID, DateAssigned, DueDate, CanReview) VALUES(?,?,?,?,?,?); ";
        $stmt = $conn->prepare($query);


        $stmt->bind_param("ssssss", $adminID, $reviewerID, $workID, $dateAssigned, $dueDate, $canReviewStatus);
        if (!$stmt->execute()) {
            sendHttpResponseMsg(404, 'Error'. $stmt->error);
        }

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        return true;
    }

    // deactivate reviewer whose review was over due
    public static function deactivateFromAssignment($reviewerID, $workID) {
        if ($reviewerID === null) {
            sendHttpResponseMsg(404, 'Error! Reviewer.class ID cannot be null');
        }

        if ($workID === null) {
            sendHttpResponseMsg(404, 'Error! Reviewer.class ID cannot be null');
        }

        $sql = "UPDATE  peer_review_db.Assignment SET CanReview=0 WHERE ReviewerID=$reviewerID AND WorkID=$workID";
        $conn = connect();

        if ($conn->query($sql) === true) {
            sendHttpResponseMsg(200, 'Reviewer has been successfully removed from the assignment');

        } else {
            sendHttpResponseMsg(404,"ERROR: Could not able to execute".$sql." ".$conn->error);
        }

        $conn->close();
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
//            printf("Size %d \n", $size);

            for ($index = 0; $index < $size; ++$index) {
                printf("%s \n", $list[$index]);
            }

            $result->close();
        }

        $conn->close();
        echo json_encode($works);
    }

    static function getUnassignedWorks(){
        $unasignedWorks = array();
        // get all Works
        $query = "SELECT WID, Title, URL, AuthorName, Status FROM peer_review_db.ReviewInProgressView GROUP BY WID";
        $conn = connect();
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($work = $result->fetch_assoc()) {
                $query2 = "SELECT ReviewerID, ReviewerName, Role, DateAssigned, DueDate FROM peer_review_db.ReviewInProgressView WHERE WID=".$work['WID'].";";
                $result2 = $conn->query($query2);
                if ($result2->num_rows > 0) {
                    $reviewers = $result2->fetch_all();
                    $work['Reviewers'] = $reviewers;
//                $works['Reviewers']=$reviewers;
                    array_push($unasignedWorks, $work);
                }
            }
        }
        else{

        }
        $conn->close();


//    $works = DB::select($query);
        echo json_encode($unasignedWorks);
    }
}

?>
