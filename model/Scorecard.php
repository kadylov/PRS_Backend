<?php


class Scorecard implements JsonSerializable {

    private $workID;
    private $title;
    private $URL;

    private $score = [];
    private $rubric = [];

    private $reviewerID;
    private $reviewerName;
    private $roleId;
    private $roleName;
    private $canScore;

    /**
     * Scorecard constructor.
     */
    public function __construct() {
        $this->reviewerName = "";
        $this->roleName = "";
        $this->canScore = 1;
    }


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

        if (empty($workID) || !is_int($workID)) {
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
     * @param array $rubricText
     * @return Scorecard
     */
    public function addRubricText($rubricText) {
        $this->rubricText = $rubricText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScore(): array {
        return $this->score;
    }

    /**
     * @param mixed $score
     * @return Scorecard
     */
    public function setScore($score) {
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
    public function setReviewerID($fromReviewerID) {
        if (empty($fromReviewerID) || !is_int($fromReviewerID)) {
            die("\nError in Scorecard.class! reviewer id is undefined\n");
        }
        $this->reviewerID = $fromReviewerID;
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
    public function setCanScore($canScore = 0) {
        $this->canScore = $canScore;
        return $this;
    }


    public function __toString() {
        return "\nScorecard\nWID: ".(string)$this->workID."\ntitle: ".(string)$this->title."\nurl: ".(string)$this->URL."\nRubric: ".print_r($this->rubric, true)."\nscore: ".print_r($this->score, true)."\nreviewerId: ".(string)$this->reviewerID."\nreviwername: ".(string)$this->reviewerName."\nroleId: ".(string)$this->roleId."\nroleName: ".(string)$this->roleName."\n";

    }

    /**
     * @return array
     */
    public function getRubric(): array {
        return $this->rubric;
    }

    /**
     * @param array $rubric
     */
    public function setRubric(array $rubric): void {
        $this->rubric = $rubric;
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize() {
        //            , , , Score, , , RoleId, RoleName

        return [
            "WorkID" => $this->workID,
            "Title" => $this->title,
            "URL" => $this->URL,
            "ReviewerID" => $this->reviewerID,
            "ReviewerName" => $this->reviewerName,
            "RoleId" => $this->roleId,
            "RoleName" => $this->roleId,
            "Rubric" => $this->rubric,
            "Scores" => $this->score,
            "CanScore" => $this->canScore];

    }
}

?>
