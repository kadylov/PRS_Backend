<?php

abstract class User {
    private $username;
    private $password;

    /**
     * User constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void {
        $this->password = $password;
    }




    abstract public function __toString();
}

?>
