<?php


require_once 'User.php';


class Reviewer extends User{
    //        RID, Username, Password, RName, RCredential, RoleId

    private $rid;
    private $name;
    private $credentialID;
    private $roleId ;

    /**
     * Reviewer constructor.
     * @param $rid
     * @param $name
     * @param $credential
     * @param $roleId
     */
    public function __construct( $username, $password, $name, $credential, $roleId) {
        parent::__construct($username, $password);
//        $this->rid = $rid;
        $this->name = $name;
        $this->credentialID = (int) $credential;
        $this->roleId = (int) $roleId;
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
        $this->roleId = $roleId;
    }


    public function __toString(){
        {
            try
            {
                return "\nReviewer\nUsername: " . (string)$this->getUsername() . "\nPassword: ". (string)$this->getUsername() . "\nName: ". (string)$this->name . "\ncredentialID: " . (string)$this->credentialID . "\nRoleID: " . (string)$this->roleId ."\n";
            }
            catch (Exception $exception)
            {
                return 'Error in Reviewer:toString';
            }
        }
    }


}

?>
