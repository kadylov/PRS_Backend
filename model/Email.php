<?php

class Email{

    private $recepientName;
    private $recepientEmail;
    private $senderName;
    private $senderEmail;
    private $subject;
    private $message;





    /**
     * @return mixed
     */
    public function getRecepientName() {
        return $this->recepientName;
    }

    /**
     * @param mixed $recepientName
     */
    public function setRecepientName($recepientName) {
        $this->recepientName = $recepientName;
    }

    /**
     * @return mixed
     */
    public function getRecepientEmail() {
        return $this->recepientEmail;
    }

    /**
     * @param mixed $recepientEmail
     */
    public function setRecepientEmail($recepientEmail) {
        $this->recepientEmail = $recepientEmail;
    }

    /**
     * @return mixed
     */
    public function getSenderName() {
        return $this->senderName;
    }

    /**
     * @param mixed $senderName
     */
    public function setSenderName($senderName) {
        $this->senderName = $senderName;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail() {
        return $this->senderEmail;
    }

    /**
     * @param mixed $senderEmail
     */
    public function setSenderEmail($senderEmail) {
        $this->senderEmail = $senderEmail;
    }

    /**
     * @return mixed
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }




}



?>
