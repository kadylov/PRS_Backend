<?php

require_once './Utils/util.php';


//        AdminID, ReviewerID, WorkID, DateAssigned, DueDate
class Assignment {

    private $adminID;
    private $reviewerID;
    private $workID;
    private $dateAssigned;
    private $dueDate;
    private $canReview;

    /**
     * Assignment constructor.
     * @param $adminID
     * @param $reviewerID
     * @param $workID
     * @param $dateAssigned
     * @param $dueDate
     */

    public function __construct($adminID = NULL, $reviewerID = NULL, $workID = NULL, $dateAssigned = "000000", $dueDate = "000000") {
        echo $adminID;
        $this->setAdminID($adminID);
        $this->setReviewerID($reviewerID);
        $this->setWorkID($workID);
        $this->dateAssigned = $dateAssigned;
        $this->dueDate = $dueDate;
        $this->canReview = 1;
    }

    /**
     * @return mixed
     */
    public function getAdminID() {
        return $this->adminID;
    }

    /**
     * @param mixed $adminID
     */
    public function setAdminID($adminID) {
        if (!validatesAsInt($adminID)) {
            responseWithError("adminID is undefined");
            return;
        }

        $this->adminID = $adminID;
    }

    /**
     * @return mixed
     */
    public function getReviewerID() {
        return $this->reviewerID;
    }

    /**
     * @param mixed reviewerIDs
     */
    public function setReviewerID($reviewerID) {

        if (!validatesAsInt($reviewerID) && $reviewerID == 0) {
            responseWithError("reviewerID is undefined");
            return;
        }

        $this->reviewerID = $reviewerID;
    }

    /**
     * @return mixed
     */
    public function getWorkID() {
        return $this->workID;
    }

    /**
     * @param mixed $workID
     */
    public function setWorkID($workID) {

        if (!validatesAsInt($workID) && $workID == 0) {
            responseWithError("workID is undefined");
            return;
        }

        $this->workID = $workID;
    }

    /**
     * @return mixed
     */
    public function getDateAssigned() {
        return $this->dateAssigned;
    }

    /**
     * @param mixed $dateAssigned
     */
    public function setDateAssigned($dateAssigned) {
        $this->dateAssigned = $dateAssigned;
    }

    /**
     * @return mixed
     */
    public function getDueDate() {
        return $this->dueDate;
    }

    /**
     * @param mixed $dueDate
     */
    public function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
    }

    /**
     * @return mixed
     */
    public function getCanReview() {
        return $this->canReview;
    }

    /**
     * @param mixed $dueDate
     */
    public function setCanReview($canReview) {
        $this->canReview = $canReview;
    }


    public function __toString() {
        return "\nAssignment:\n adminID: $this->adminID \nReviewerID: $this->reviewerID\n workID: $this->workID\n dateAssigned: $this->dateAssigned\n Due date: $this->dueDate\n";
    }

}

?>
