<?php
require_once "header_config.php";

require_once "model/Work.php";
require_once "model/Email.php";

require_once "db/DB.php";
require_once "db/DBWork.php";

require_once 'Utils/mail.php';
require_once 'Utils/util.php';


// receive author submission and then store it to the database
// then notify admins of the system about incoming work
if (isset($_POST['postNewWork'])) {

    $authorEmail = $_POST['email'];
    $authorName = $_POST['author'];

    $work = new Work(
        $_POST['title'],
        $_POST['author'],
        $_POST['url'],
        $_POST['selectedTags'],
        $_POST['dateWritten'],
        $_POST['dateSubmitted']);
    $work->setAuthorEmail($_POST['email']);


    if (DBWork::insertWork($work)) {

        // send email confirmation to author
        sendConfirmation($authorName, $authorEmail);

        // fetch admin name and email address
        $admin = DB::select('SELECT AName, Email FROM peer_review_db.Admin WHERE AID=0;');
        if (isset($admin[0]['AName']) && isset($admin[0]['Email'])) {
            $email = new Email();
            $email->setRecepientName($admin[0]['AName']);
            $email->setRecepientEmail($admin[0]['Email']);
            $email->setSenderName('PRS no-reply');
            $email->setSenderEmail('prs.prs2020@gmail.com');
            $email->setSubject('New Work Submission');
            $email->setMessage('New work has been submitted.');
            sendEmail($email);
        }
    } else {
        sendHttpResponseMsg(404, 'Error! Your Work submission has not saved. Please contact a system admin.');
    }

// receives request to submit tags from the database
} elseif (isset($_GET['getAllTags'])) {

    $tags = DB::select('SELECT * FROM peer_review_db.Tag;');
    echo json_encode($tags);

// receives request to submit all incoming works for admin pre review
} else if (isset($_GET['incommingWorks'])) {
    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');

    echo json_encode($incommingWorks);

// receive request to submit all works for public view
} else if (isset($_GET['getWorksForPublic'])) {

    $works = DB::select('SELECT * FROM peer_review_db.ScoredWorksView WHERE Publish=1');
    echo json_encode($works);

// receive request to submit all works from the database
// except incoming works. This request comes from admin side when admin clicks on "All Works" tab on the left menu
} else if (isset($_GET['getAllWorks'])) {

    $works = DB::select("SELECT * FROM peer_review_db.Work where Status != 'new';");
    echo json_encode($works);

// receives request to update work's publish flag in the database.
// The request comes from admin side when admin slides one of the sliders in "All Works" page
} else if (isset($_POST['publishWork'])) {

    $wid = $_POST['WID'];
    $status = $_POST['Publish'];

    DBWork::publishWork($wid, $status);


// get admin request to update work status after admin makes a final decision on the completed review page in Angular
} else if (isset($_POST['updateWorkStatus'])) {

    $wid = $_POST['WID'];
    $status = $_POST['Status'];

    DBWork::updateWorkStatus($wid, $status);

    if ($status == 'completed' || $status == 'rejected') {
        sendWorkSummary($wid);
    }


}

// email the summary to the author
// it is called when the server receives "updateWorkStatus" request
function sendWorkSummary($wid) {
    $query = "SELECT * FROM peer_review_db.SummaryView where WorkID=".$wid.";";

    $conn = connect();

    // WorkID, Title, AuthorName, AuthorEmail, Status, WorkFinalScore, SummaryText
    $result = $conn->query($query);
    if (!$result)
        sendHttpResponseMsg(404, "\nError in getting author email:".$conn->error);

    elseif ($result->num_rows > 0) {

        $prsEmail = 'prs.prs2020@gmail.com';

        $summary = $result->fetch_assoc();

        // RName, Email, DueDate, WorkID
        $email = new Email();
        $email->setRecepientName('Author');
        $email->setRecepientEmail($summary['AuthorEmail']);

        $email->setSenderName('no-reply');
        $email->setSenderEmail($prsEmail);
        $email->setSubject('PRS: Work Summary');
        $email->setMessage(getWorkSummaryTemplate($summary));
        $email->setReply(0);

        sendEmail($email);


    }



    $conn->close();

}

?>
