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
require_once 'Utils/mail.php';



// report all occured error messages to the screen
//ini_set('display_errors', 1);
//error_reporting(E_ALL);


// receives http get request with params: incommingWorks
// responds back with a list of new work submissions for a pre-review in JSON (Sample response is following):
//[
//    {
//        "WID": "27",
//        "Title": "Audiences",
//        "URL": "https://thearf.org/category/topics/audience-media-measurement/",
//        "DateSubmission": "2020-02-25",
//        "DateWritten": "2020-02-25",
//        "IsRetired": "no",
//        "Status": "new",
//        "AuthorName": "Brad Fay",
//        "AuthorEmail": "dparcheta@gmail.com",
//        "Tags": "Standard,Quick read,Basic,Impressions,Measurement,Ongoing,Measurement"
//    },
//  ...................................................
//]
if (isset($_GET['incommingWorks'])) {
    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');

    echo json_encode($incommingWorks);


// receives http get request with params: allWorks
// responds back with a list of all works(e.g. scored, not scored, retired, and etc) in JSON (Sample response is following):
//[
//    {
//        "WID": "1",
//        "Title": "New Metrics for New Media: Toward the Development of Web Measurement Standards",
//        "URL": "https://www.researchgate.net/publication/228606680_New_Metrics_for_New_Media_Toward_the_Development_of_Web_Measurement_Standards",
//        "DateSubmission": "2019-11-11",
//        "DateWritten": "1996-09-26",
//        "IsRetired": "no",
//        "Status": "scored",
//        "AuthorName": "TP Novak, DL Hoffman",
//        "AuthorEmail": "abca@mail.com",
//        "Tags": "Standard"
//    },
//  ...................................................
//]
} elseif (isset($_GET['allWorks'])) {
    $works = DB::select('SELECT * FROM peer_review_db.Work');
    echo json_encode($works);


// receives http post request with params: adminReview, AdminID, WorkID, DateReviewed, Decision, RejectNote,
// the data is collected and saved in db
// work status is updated to 'admitted' or 'rejected'.
} elseif (isset($_POST['adminReview'])) {
//    echo "\npostAdminReviewRequest\n";
//    var_dump($_POST);
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


    DBAdmin::updateUser($user, $_POST["oldUsername"], $_POST["oldEmail"]);
    http_response_code(200);


// receives http post request with params: deleteReviewer, RID
// deletes reviewer from the db
} elseif (isset($_POST['deleteReviewer'])) {
//    echo "\ndeleteRequest\n";

    DBAdmin::deleteReviewerByID($_POST['RID']);


    // receives http get request with params: rejectedWork
    // responds back with a list of all rejected works in json format (Sample respond is following):
//    [
//    {
//        "WID": "1",
//        "Title": "New Metrics for New Media: Toward the Development of Web Measurement Standards",
//        "URL": "https://www.researchgate.net/publication/228606680_New_Metrics_for_New_Media_Toward_the_Development_of_Web_Measurement_Standards",
//        "DateSubmission": "2019-11-11",
//        "DateWritten": "1996-09-26",
//        "IsRetired": "no",
//        "Status": "scored",
//        "AuthorName": "TP Novak, DL Hoffman",
//        "AuthorEmail": "abca@mail.com",
//        "Tags": "Standard",
//        "AdminID": "0",
//        "Admin": "Edward Snipes",
//        "DateReviewed": "2019-12-11",
//        "RejectNote": "Poor grammar"
//    }
//]

} elseif (isset($_GET['rejectedWork'])) {
    // echo "\nrejectedWorkRequest\n";

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
//        "Tags": "",
//    },
//    .................................
} elseif (isset($_GET['unassignedWorks'])) {

    $works = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="admitted";');
    echo json_encode($works);

// recieve http get request with params: reviewersToAssign
// responds back a list of reviewers along with total of their reviews for current month
// JSON:    [
//    {
//        "ReviewerID": "3",
//        "ReviewerName": "reviewer3 Name",
//        "Credential": "Academic",
//        "Role": "Reviewer",
//        "IsActive": "1",
//        "Email": "kradylov@gmail.com",
//        "WorkID": "4",
//        "AssignedThisMonth": "0",
//        "ReviewedThisMonth": "0",
//        "TotalReviews": "4"
//    },
//         .....................
//
//    ]
} elseif (isset($_GET['reviewersToAssign'])) {

    $workID = $_GET['workID'];

//    $reviewers = DB::select("SELECT * FROM peer_review_db.ReviewersToAssignView1 WHERE (AssignedThisMonth=0 OR AssignedThisMonth is NULL) AND (WorkID!=4 OR WorkID IS NULL);");
    $reviewers = DB::select('SELECT * FROM peer_review_db.ReviewersToAssignView1 WHERE WorkID!='.$workID);
//    $reviewers = DB::select("SELECT * FROM peer_review_db.ReviewsCountList");
    echo json_encode($reviewers);

// recieve http get request with params: getAssignedWorks
// responds back with a list of assigned works in JSON. Sample output is below:
//  [
//      {
//        "WID": "35",
//        "Title": "Prevalence of Articles With Honorary Authors and Ghost Authors in Peer-Reviewed Medical Journals",
//        "URL": "https://jamanetwork.com/journals/jama/article-abstract/187772",
//        "AuthorName": "Annette Flanagin, RN, MA; Lisa A. Carey, PhD;",
//        "Status": "assigned",
//        "ReviewerID": "66",
//        "ReviewerName": "Mell Gibson",
//        "Role": "Reviewer",
//        "DateAssigned": "2020-03-18",
//        "DueDate": "2020-03-23"
//    },
//    ......................
} elseif (isset($_GET['getAssignedWorks'])) {

//    $assignmentList = DB::select("SELECT WID, Title, URL, AuthorName, group_concat(ReviewerID) as ReviewerIDs, group_concat(ReviewerName) as ReviewerNames, group_concat(DueDate) as DueDate, group_concat(DateAssigned) as DateAssigned FROM peer_review_db.ReviewInProgressView
//GROUP BY WID");

    $assignmentList = DB::select("SELECT * FROM peer_review_db.ReviewInProgressView;");
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
} elseif (isset($_POST['assignReviewer'])) {
//    echo "\nassignReviewers\n";

    $adminID = $_POST['adminID'];
    $reviewerID = $_POST['reviewerID'];
    $workID = $_POST['workID'];
    $dueDate = $_POST['dueDate'];
    $dateAssigned = $_POST['dateAssigned'];
    $assignment = new Assignment($adminID, $reviewerID, $workID, $dateAssigned, $dueDate);


    // notify newly assigned reviewer about new assignment via email
    // after the assignment was successfully stored in the database
    if(DBAdmin::createNewAssignment($assignment)){
        $prsEmail = 'prs.prs2020@gmail.com';

        $query = "SELECT RName, Email FROM peer_review_db.Reviewer WHERE RID=".$reviewerID.";";
        $reviewer = DB::select($query);

        $email = new Email();
        $email->setRecepientName($reviewer[0]['RName']);
        $email->setRecepientEmail($reviewer[0]['Email']);

        $email->setSenderName('no-reply');
        $email->setSenderEmail($prsEmail);
        $email->setSubject('PRS: New Assignment');
        $email->setMessage(getNotificationForReviewerTemplate($dueDate));
        $email->setReply(0);

        sendEmail($email);

    }


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

} elseif (isset($_POST['deactivateFromAssignment'])) {

    DBAdmin::deactivateFromAssignment($_POST['ReviewerID'], $_POST['WorkID']);

} elseif (isset($_GET['getAllAdminReviews'])) {

    $workID = $_GET['WID'];

    if (isset($workID) && !empty($workID)) {

        echo json_encode(DB::select("SELECT * FROM peer_review_db.AdminReviewsView WHERE WorkID=".$workID.";"));
    } else {
        echo json_encode(DB::select("SELECT * FROM peer_review_db.AdminReviewsView"));

    }
}
elseif (isset($_POST['sendThreshold'])) {

    $threshold = $_POST['sendThreshold'];

    // UPDATE peer_review_db.Threshold SET Threshold=66 where ID=1
    $query = "UPDATE peer_review_db.Threshold SET Threshold=".$threshold." WHERE ID=1;";
    DB::execute($query);
}

elseif (isset($_GET['getThreshold'])) {

    $query = "SELECT Threshold FROM peer_review_db.Threshold;";
    $threshold = DB::select($query);

    echo json_encode($threshold);
}


?>
