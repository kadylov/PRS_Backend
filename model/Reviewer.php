<?php


require_once 'User.php';


class Reviewer extends User {
    //        RID, Username, Password, RName, RCredential, RoleId

    private $isActive;

    /**
     * Reviewer.class constructor.
     * @param $username
     * @param $password
     * @param $name
     * @param $credential
     * @param $roleId
     * @param $email
     */
    public function __construct($username, $password, $name, $credential, $roleId, $email) {
        parent::__construct($username, $password, $name, $credential, $roleId, $email);
//        $this->rid = $rid;
        $this->isActive = 1;
    }

    public function __toString() {
        try {
            return "\nReviewer\nUsername: ".(string)$this->getUsername()
                ."\nPassword: ".(string)$this->getPassword()
                ."\nName: ".(string)$this->getName()
                ."\nEmail: ".(string)$this->getEmail()
                ."\ncredentialID: ".(string)$this->getCredentialID()
                ."\nRoleID: ".(string)$this->getRoleId()."\n";
        } catch (Exception $exception) {
            return 'Error in Reviewer.class:toString';
        }
    }

    public function getActiveFlag() {
        return $this->isActive;
    }

    /**
     * @param int $isActive
     * @return Reviewer
     */
    public function setIsActive(int $isActive): Reviewer {
        $this->isActive = $isActive;
    }
}

?>
