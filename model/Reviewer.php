<?php


require_once 'User.php';


class Reviewer extends User {
    //        RID, Username, Password, RName, RCredential, RoleId

    private $rid;
    private $name;
    private $credentialID;
    private $roleId;
    private $email;

    /**
     * Reviewer.class constructor.
     * @param $rid
     * @param $name
     * @param $credential
     * @param $roleId
     */
    public function __construct($username, $password, $name, $credential, $roleId) {
        parent::__construct($username, $password);
//        $this->rid = $rid;
        $this->name = $name;
        $this->setCredential($credential);
        $this->setRoleId($roleId);
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
     * @param mixed $credential
     */
    public function setCredential($credentialID): void {
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


    public function __toString() {
        try {
            return "\nReviewer\nUsername: ".(string)$this->getUsername()."\nPassword: ".(string)$this->getUsername()."\nName: ".(string)$this->name."\ncredentialID: ".(string)$this->credentialID."\nRoleID: ".(string)$this->roleId."\n";
        } catch (Exception $exception) {
            return 'Error in Reviewer.class:toString';
        }
    }

    public function getEmail() {
    }


}

?>
