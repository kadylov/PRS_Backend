<?php

require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/AdminReview.php";
require_once "model/Assignment.php";
require_once "model/Admin.php";

require_once "db/DBReviewer.php";
require_once "db/DBAdmin.php";
require_once "db/DBReviewer.php";
require_once "db/DB.php";


// receives http get request with params: incommingWorks
// responds back with a list of new work submissions for a pre-review in JSON:
// [
//    {
//        "ReviewerID": "1",
//        "RName": "Melissa Klein",
//        "WorkID": "4",
//        "Title": "Can you measure the ROI of your social media marketing?",
//        "URL": "https://www.researchgate.net/publication/228237594_Can_You_Measure_the_ROI_of_Your_Social_Media_Marketing",
//        "DateAssigned": "2019-11-12",
//        "DueDate": "2019-11-14"
//    }
//      ........
//]
if (isset($_GET['incommingWorks'])) {
    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');
    echo json_encode($incommingWorks);


// receives http post request with params: adminReview, AdminID, WorkID, DateReviewed, Decision, RejectNote,
// the data is collected and saved in db
// work status is updated to 'admitted'.
} elseif (isset($_POST['adminReview'])) {
    echo "\npostAdminReviewRequest\n";

    $adminReview = new AdminReview($_POST['AdminID'], $_POST['WorkID'], $_POST['DateReviewed'], $_POST['Decision'], $_POST['RejectNote']);
    DBAdmin::preReview($adminReview);


// receives http get request with params: reviewerList
// responds back with a list of all reviewers in JSON:
// [
//    {
//        "RID": "1",
//        "Username": "reviewer1",
//        "Password": "1234",
//        "Fullname": "Melissa Klein",
//        "Credential": "Academic",
//        "RoleType": "Reviewer",
//        "IsActive": "1
//    },
//    ...........................
} elseif (isset($_GET['reviewerList'])) {
    echo "\nreviewerListRequest\n";

    $reviewers = DB::select('SELECT * FROM peer_review_db.ReviewersListView;');
    echo json_encode($reviewers);


// receives http post request with params: createReviewer, Username, Password, RName, CredentialID, RoleId
// creates a new reviewer in the db
} elseif (isset($_POST['createUser'])) {

    $roleId = (int)$_POST["RoleId"];

    $user = null;

    if ($roleId === 3) { // role is admin?
        //    $username, $password, $name, $credential, $roleId, $email) {
        $user = new Admin($_POST["Username"], $_POST["Password"], $_POST["Name"], (int)$_POST["CredentialID"], (int)$_POST["RoleId"], $_POST["Email"]);

    } else {
        $user = new Reviewer($_POST["Username"], $_POST["Password"], $_POST["Name"], (int)$_POST["CredentialID"], (int)$_POST["RoleId"], $_POST["Email"]);
    }


    if (DBAdmin::createUser($user)) {
        http_response_code(200);
    } else
        http_response_code(409);


// receives http post request with params: updateReviewer, Username, Password, RName, Email, CredentialID, RoleId
// the data is collected, proccessed, and updated in the db
} elseif (isset($_POST['updateUser'])) {
    //$username, $password, $name, $credential, $roleId, $email) {
//    $r = new Reviewer($_POST["Username"], $_POST["Password"], $_POST["RName"], (int)$_POST["CredentialID"], (int)$_POST["RoleId"], $_POST["Email"]);
    $roleId = (int)$_POST["RoleId"];

    $user = null;

    if ($roleId === 3) { // role is admin?
        $user = new Admin($_POST["Username"], $_POST["Password"], $_POST["Name"], (int)$_POST["CredentialID"], (int)$_POST["RoleId"], $_POST["Email"]);
    } else {
        $user = new Reviewer($_POST["Username"], $_POST["Password"], $_POST["Name"], (int)$_POST["CredentialID"], (int)$_POST["RoleId"], $_POST["Email"]);
    }

    $user->setRid((int)$_POST["ID"]);


    DBAdmin::updateUser($user, $_POST["oldUsername"],$_POST["oldEmail"]);
    http_response_code(200);


// receives http post request with params: deleteReviewer, RID
// deletes reviewer from the db
} elseif (isset($_POST['deleteReviewer'])) {
//    echo "\ndeleteRequest\n";

    DBAdmin::deleteReviewerByID($_POST['RID']);


    // receives http get request with params: rejectedWork
    // responds back with a list of all rejected works in json format

} elseif (isset($_GET['rejectedWork'])) {
    echo "\nrejectedWorkRequest\n";

    $works = DB::select('SELECT * FROM peer_review_db.RejectedWorkView;');
    echo json_encode($works);


// receives http get request with params: adminReviews, adminID
// responds back with all admin's pre review history in JSON:
// [
//    {
//        "AdminID": "1",
//        "WorkID": "1",
//        "Title": "New Metrics for New Media: Toward the Development of Web Measurement Standards",
//        "DateReviewed": "2019-12-11",
//        "Decision": "rejeted",
//        "RejectNote": "Poor grammar"
//    },
//    .................................
} elseif (isset($_GET['getAdminReviews'])) {
    echo "\nadminReviewsRequest\n";

    $reviews = DBAdmin::getAdminReviewsByID($_GET['adminID']);
    echo json_encode($reviews);


// receives htt get request with params: unassignedWorks
// responds back with all works whose status='admitted' in JSON:
// [
//    {
//        "WID": "",
//        "Title": "",
//        "URL": "",
//        "DateSubmission": "",
//        "DateWritten": "",
//        "IsRetired": "",
//        "Status": "",
//        "Title": "",
//        "AuthorName": "",
//        "AuthorEmail": "",
//        "TagID": "",
//    },
//    .................................
} elseif (isset($_GET['unassignedWorks'])) {
//    echo "\nunassignedWorksRequest\n";

    $works = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="admitted";');
    echo json_encode($works);

// recieve http get request with params: reviewersToAssign
// responds back a list of reviewers along with total of their reviews for current month
// JSON:    [
//    {
//        "ReviewerID": "1",
//        "ReviewerName": "Melissa Klein",
//        "ReviewedThisMonth": "4"
//    },
//         .....................
} elseif (isset($_GET['reviewersToAssign'])) {
//    echo "\nreviewHistoryRequest\n";

    $reviewers = DB::select("SELECT * FROM peer_review_db.ReviewsCountList");
    echo json_encode($reviewers);

// recieve http get request with params: getAssignedWorks
// responds back with a list of assigned works in JSON:
//  [
//    {
//        "AdminID": "1",
//        "ReviewerID": "1",
//        "WorkID": "4",
//        "DateAssigned": "2019-11-12",
//        "DueDate": "2019-11-14"
//    },
//    ......................
} elseif (isset($_GET['getAssignedWorks'])) {
    echo "\ngetAssignedWorks\n";

    $assignmentList = DB::select("SELECT * FROM peer_review_db.Assignment;");
    echo json_encode($assignmentList);

// receives http get request with param getAssignedReviewers, WorkID
// respond back with a list of assigned reviewers for WorkID in JSON:
//    [
//    {
//        "RID": "1",
//        "Username": "reviewer1",
//        "Password": "1234",
//        "Fullname": "Melissa Klein",
//        "Credential": "Academic",
//        "RoleType": "Reviewer"
//    },
} elseif (isset($_GET['getAssignedReviewers'])) {
    echo "\ngetAssignedReviewers\n";

    if (isset($_GET['WorkID']))
        $WorkID = $_GET['WorkID'];

    $query = "SELECT * FROM peer_review_db.ReviewersListView
                    where RID in (select Assignment.ReviewerID from peer_review_db.Assignment where WorkID='$WorkID')";

    $reviewers = DB::select($query);
    echo json_encode($reviewers);

// receives http post request with params: newAssignment, adminID, reviewerID, workID, dueDate, dateAssigned
// creates a new assignment object and passes it to the function createNewAssignment. This function inserts the new
// assignment into table named 'Assignment'
// Note that dueDate and dateAssignment should be in YYYYMMDD format
} elseif (isset($_POST['assignReviewers'])) {
    echo "\nassignReviewers\n";

    $adminID = $_POST['adminID'];
    $reviewerID = $_POST['reviewerID'];
    $workID = $_POST['workID'];
    $dueDate = $_POST['dueDate'];
    $dateAssigned = $_POST['dateAssigned'];
//    var_dump($reviewerID);
    $assignment = new Assignment((int)$adminID, (int)$reviewerID, (int)$workID, $dateAssigned, $dueDate);
    DBAdmin::createNewAssignment($assignment);

} elseif (isset($_GET['getUsers'])) {
//    echo "\ngetUsers\n";

    $users = DB::select("SELECT * FROM peer_review_db.UsersView;");

    echo json_encode($users);

} elseif (isset($_GET['getUserById'])) {
//    echo "\ngetUsers\n";

    $id = $_GET['getUserById'];
    $user = DB::select("SELECT * FROM peer_review_db.UsersView WHERE id = $id;");
    echo json_encode($user);

} elseif (isset($_GET['getRolesCredential'])) {

    // get a list of roles and credentials
    $roleList = DB::select("SELECT * FROM peer_review_db.Role;");
    $credentialList = DB::select("SELECT * FROM peer_review_db.ReviewerCredential;");

    $roleCredential = array("roles" => $roleList, "credentials" => $credentialList);

    echo json_encode($roleCredential);

} elseif (isset($_POST['deactivateUser'])) {
//    echo "\ngetUsers\n";

    DBAdmin::deactivateUserById($_POST['id'], $_POST['roleId'], $_POST['activeStatus']);

}


?>
