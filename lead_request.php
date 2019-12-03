<?php
require_once "header_config.php";

require_once "model/Reviewer.php";
require_once "model/Scorecard.php";

require_once "db/DBReviewer.php";
require_once "db/DB.php";


if (isset($_GET['getScoredWorks'])) {

//    $incommingWorks = DB::select('SELECT * FROM peer_review_db.Work WHERE Status="new";');
//    echo json_encode($incommingWorks);
    echo "\npostAdminReviewRequest\n";

} elseif (isset($_POST['adminReview'])) {
    echo "\npostAdminReviewRequest\n";
}
//$adminReview = new AdminReview($_POST['AdminID'], $_POST['WorkID'], $_POST['DateReviewed'], $_POST['Decision'], $_POST['RejectNote']);
//DBAdmin::preReview($adminReview);

?>
