<?php


require_once 'User.php';


class Reviewer extends User{
    //        RID, Username, Password, RName, RCredential, RoleId

    private $rid;
    private $name;
    private $credential;
    private $roleId;

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
        $this->credential = $credential;
        $this->roleId = $roleId;
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
    public function getCredential() {
        return $this->credential;
    }

    /**
     * @param mixed $credential
     */
    public function setCredential($credential): void {
        $this->credential = $credential;
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


    public function toString(){
//        $desc = $this->$this->getName()
    }


}

?>
