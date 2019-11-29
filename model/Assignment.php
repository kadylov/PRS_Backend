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
    public function __construct($adminID, $reviewerIDs, $workID, $dateAssigned, $dueDate) {
        $this->adminID = $adminID;
        $this->reviewerIDs = reviewerIDs;
        $this->workID = $workID;
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
    public function setReviewerID($reviewerIDs): void {
        $this->reviewerIDs = reviewerIDs;
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
