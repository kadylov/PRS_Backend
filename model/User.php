<?php

abstract class User {
    private $username;
    private $password;
    private $rid;
    private $name;
    private $credentialID;
    private $roleId;
    private $email;

    /**
     * User constructor.  Username, Password, RName, RCredential, RoleId
     * @param $username
     * @param $password
     * @param $name
     * @param $credentialID
     * @param $roleId
     * @param $email
     */
    public function __construct(string $username, string $password, string $name1, int $credentialID, int $roleId, string $email) {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name1;
        $this->setCredentialID($credentialID);
        $this->setRoleId($roleId);
        $this->email = $email;

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

    /**
     * @return mixed
     */
    public function getRid() {
        return $this->rid;
    }

    /**
     * @param mixed $rid
     */
    public function setRid($rid): void {
        if (empty($rid) || !is_int($rid)) {
            die("\nError in Reviewer.class! rid is undefined\n");
        }
        $this->rid = $rid;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCredentialID() {
        return $this->credentialID;
    }

    /**
     * @param mixed $credentialID
     */
    public function setCredentialID($credentialID): void {
        if (empty($credentialID) || !is_int($credentialID)) {
            die("\nError in Reviewer.class! credentialID is undefined\n");
        }
        $this->credentialID = $credentialID;
    }

    /**
     * @return mixed
     */
    public function getRoleId() {
        return $this->roleId;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId): void {
        if (empty($roleId) || !is_int($roleId)) {
            die("\nError in Reviewer.class! roleId is undefined\n");
        }
        $this->roleId = $roleId;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void {
        $this->email = $email;
    }


    abstract public function __toString();
}

?>
