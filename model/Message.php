<?php


require_once './Utils/util.php';


class Message {

    private $workID;
    private $fromReviewerID;
    private $message;
    private $dateAndTime;

    /**
     * Discussion constructor.
     * @param $workID
     * @param $fromReviewerID
     * @param $message
     * @param $dateAndTime
     */
    public function __construct($workID = NULL, $fromReviewerID = NULL, $message = "", $dateAndTime = "") {
        $this->setWorkID($workID);
        $this->setReviewerID($fromReviewerID);
        $this->message = $message;
        $this->dateAndTime = $dateAndTime;
    }

    /**
     * @return mixed
     */
    public function getWorkID() {
        return $this->workID;
    }

    /**
     * @param mixed $workID
     * @return Message
     */
    public function setWorkID($workID) {
        if (!validatesAsInt($workID)) {
            responseWithError("Error in Discussion.class! work id is undefined");
        }
        $this->workID = $workID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReviewerID() {
        return $this->fromReviewerID;
    }

    /**
     * @param mixed $fromReviewerID
     * @return Message
     */
    public function setReviewerID($fromReviewerID) {
        if (!validatesAsInt($fromReviewerID)) {
            responseWithError("Error in Discussion.class! reviewer id is undefined");
        }
        $this->fromReviewerID = $fromReviewerID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param mixed $Message
     * @return Message
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateAndTime() {
        return $this->dateAndTime;
    }

    /**
     * @param mixed $dateAndTime
     * @return Message
     */
    public function setDateAndTime($dateAndTime) {
        $this->dateAndTime = $dateAndTime;
        return $this;
    }

    public function __toString() {
        // TODO: Implement __toString() method.
        return "";
    }


}
