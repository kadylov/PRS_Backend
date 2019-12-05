<?php


class Scorecard {

    private $workID;
    private $title;
    private $URL;

    private $rubricText;
    private $score;

    private $reviewerID;
    private $reviewerName;
    private $roleId;
    private $roleName;
    private $canScore;

    /**
     * @return mixed
     */
    public function getWorkID() {
        return $this->workID;
    }

    /**
     * @param mixed $workID
     * @return Scorecard
     */
    public function setWorkID($workID) {

        if (empty($fromReviewerID) || !is_int($fromReviewerID)) {
            die("\nError in Scorecard.class! work id is undefined\n");
        }

        $this->workID = $workID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Scorecard
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getURL() {
        return $this->URL;
    }

    /**
     * @param mixed $URL
     * @return Scorecard
     */
    public function setURL($URL) {
        $this->URL = $URL;
        return $this;
    }

    /**
     * @return array
     */
    public function getRubricText() {
        return $this->rubricText;
    }

    /**
     * @param array $rubricText
     * @return Scorecard
     */
    public function setRubricText($rubricText) {
        $this->rubricText = $rubricText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScore():array {
        return $this->score;
    }

    /**
     * @param mixed $score
     * @return Scorecard
     */
    public function setScore($score=null) {
        $this->score = $score;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviewerID() {
        return $this->reviewerID;
    }

    /**
     * @param mixed $reviewerID
     * @return Scorecard
     */
    public function setReviewerID($reviewerID) {
        if (empty($fromReviewerID) || !is_int($fromReviewerID)) {
            die("\nError in Scorecard.class! reviewer id is undefined\n");
        }
        $this->reviewerID = $reviewerID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviewerName() {
        return $this->reviewerName;
    }

    /**
     * @param mixed reviewerName
     * @return Scorecard
     */
    public function setReviewerName($reviewerName) {
        $this->reviewerName = $reviewerName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoleId() {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     * @return Scorecard
     */
    public function setRoleId($roleId) {
        if (empty($roleId) || !is_int($roleId)) {
            die("\nError in Scorecad.class! role id is undefined\n");
        }
        $this->roleId = $roleId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoleName() {
        return $this->roleName;
    }

    /**
     * @param mixed $roleName
     * @return Scorecard
     */
    public function setRoleName($roleName) {
        $this->roleName = $roleName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCanScore() {
        return $this->canScore;
    }

    /**
     * @param mixed $canScore
     * @return Scorecard
     */
    public function setCanScore($canScore="yes") {
        $this->canScore = $canScore;
        return $this;
    }


    public function __toString() {
        return "\nScorecard\nWID: ".(string)$this->workID."\ntitle: ".(string)$this->title."\nurl: ".(string)$this->URL."\nrubrictext: ".print_r($this->rubricText,true)."\nscore: ".print_r($this->score,true)."\nreviewerId: ".(string)$this->reviewerID."\nreviwername: ".(string)$this->reviewerName."\nroleId: ".(string)$this->roleId."\nroleName: ".(string)$this->roleName."\n";

    }


}

?>
