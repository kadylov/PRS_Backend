<?php


class AdminReview {
    private $adminID;
    private $workID;
    private $dateReviewed;
    private $decision;
    private $rejectNote;

    /**
     * AdminReview constructor.
     * @param $adminID
     * @param $workID
     * @param $dateReviewed
     * @param $decision
     * @param $rejectNote
     */
    public function __construct($adminID, $workID, $dateReviewed, $decision = "", $rejectNote = "") {
        $this->adminID = $adminID;
        $this->workID = $workID;
        $this->dateReviewed = $dateReviewed;
        $this->decision = $decision;
        $this->rejectNote = $rejectNote;
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
    public function getDateReviewed() {
        return $this->dateReviewed;
    }

    /**
     * @param mixed $dateReviewed
     */
    public function setDateReviewed($dateReviewed): void {
        $this->dateReviewed = $dateReviewed;
    }

    /**
     * @return mixed
     */
    public function getDecision() {
        return $this->decision;
    }

    /**
     * @param mixed $decision
     */
    public function setDecision($decision): void {
        $this->decision = $decision;
    }

    /**
     * @return mixed
     */
    public function getRejectNote() {
        return $this->rejectNote;
    }

    /**
     * @param mixed $rejectNote
     */
    public function setRejectNote($rejectNote): void {
        $this->rejectNote = $rejectNote;
    }


    public function __toString() {
        {
            try {
                return "\nAdmin Review\nAdminID: ".(string)$this->adminID."\nWorkID: ".(string)$this->workID."\nDateReviewed: ".(string)$this->dateReviewed."\nDecision: ".(string)$this->decision."\nRejectNote: ".(string)$this->rejectNote."\n";
            } catch (Exception $exception) {
                return 'Error in Reviewer.class:toString';
            }
        }

    }
}

?>
