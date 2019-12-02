<?php

//        AdminID, ReviewerID, WorkID, DateAssigned, DueDate
class Assignment {

    private $adminID;
    private $reviewerIDs;
    private $workID;
    private $dateAssigned;
    private $dueDate;

    /**
     * Assignment constructor.
     * @param $adminID
     * @param reviewerIDs
     * @param $workID
     * @param $dateAssigned
     * @param $dueDate
     */
    public function __construct($adminID, $reviewerID, $workID, $dateAssigned = "000000", $dueDate = "000000") {
        $this->setAdminID($adminID);
        $this->setReviewerID(reviewerID);
        $this->setWorkID($workID);
        $this->dateAssigned = $dateAssigned;
        $this->dueDate = $dueDate;
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
    public function setAdminID($adminID): void {
        if ($adminID == 0 || $adminID == '') {
            die("\nError! reviewer id cannot be zero or empty\n");
        }
        $this->adminID = $adminID;
    }

    /**
     * @return mixed
     */
    public function getReviewerID() {
        return $this->reviewerIDs;
    }

    /**
     * @param mixed reviewerIDs
     */
    public function setReviewerID($reviewerID): void {
        if ($reviewerID == 0 || $reviewerID == '') {
            die("\nError! reviewerID cannot be zero or empty\n");
        }
        $this->$reviewerID = $reviewerID;
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
    public function setWorkID($workID): void {
        if ($workID == 0 || $workID == '') {
            die("\nError! work id cannot be zero or empty\n");
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
    public function setDateAssigned($dateAssigned): void {
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
    public function setDueDate($dueDate): void {
        $this->dueDate = $dueDate;
    }


    public function __toString() {
        return "\nAssignment:\n adminID: $this->adminID \nReviewerID: $this->reviewerIDs\n workID: $this->workID\n dateAssigned: $this->dateAssigned\n Due date: $this->dueDate\n";
    }
}

?>
