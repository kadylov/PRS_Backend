<?php


class Review {

    private $workID;
    private $reviewerID;
    private $dateReviewed;
    private $score;
    private $reviewerComment;

    /**
     * Review constructor.
     * @param $workID
     * @param $reviewerID
     * @param $dateReviewed
     * @param $score
     * @param $reviewerComment
     */
    public function __construct($workID, $reviewerID, $dateReviewed, $score, $reviewerComment = "") {
        $this->setWorkID($workID);
        $this->setReviewerID($reviewerID);
        $this->setDateReviewed($dateReviewed);
        $this->setScore($score);
        $this->reviewerComment = $reviewerComment;
    }


    /**
     * @return mixed
     */
    public function getWorkID() {
        return $this->workID;
    }

    /**
     * @param mixed $workID
     * @return Review
     */
    public function setWorkID($workID) {
        if (empty($workID) || !is_int($workID)) {
            die("\nError in Review.class! work id is undefined\n");
        }

        $this->workID = $workID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviewerID() {
        return $this->reviewerID;
    }

    /**
     * @param mixed $reviewer
     * @return Review
     */
    public function setReviewerID($reviewerID) {
        if (empty($reviewerID) || !is_int($reviewerID)) {
            die("\nError in Review.class! reviewer id is undefined\n");
        }
        $this->reviewerID = $reviewerID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateReviewed() {
        return $this->dateReviewed;
    }

    /**
     * @param mixed $dateReviewed
     * @return Review
     */
    public function setDateReviewed($dateReviewed = "00000000") {
        $this->dateReviewed = $dateReviewed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScore() {
        return $this->score;
    }

    /**
     * @param mixed $score
     * @return Review
     */
    public function setScore($score) {
        if (empty($score)) {
            die("\nError in Review.class! score number is undefined\n");
        }

        $this->score = $score;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviewerComment() {
        return $this->reviewerComment;
    }

    /**
     * @param mixed $reviewerComment
     * @return Review
     */
    public function setReviewerComment($reviewerComment) {
        $this->reviewerComment = $reviewerComment;
        return $this;
    }


}

?>
