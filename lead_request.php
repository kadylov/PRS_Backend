<?php
require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";

require_once "db/DBReviewer.php";
require_once "db/DB.php";


if (isset($_GET['getScoredWorks'])) {

//    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');
//    echo json_encode($incommingWorks);
    echo "\ngetScoredWorks\n";

//    WorkID, ReviewerID, DateReviewed, Score, ReviewerComment
    $reviewsByLead = DB::select('SELECT * FROM peer_review_db.Reviews_History;');
    
    $assignedReviewers = DB::select('SELECT * FROM peer_review_db.Reviews_History;');


}
?>
