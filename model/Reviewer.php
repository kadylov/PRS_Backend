<?php


require_once 'User.php';


class Reviewer extends User {
    //        RID, Username, Password, RName, RCredential, RoleId

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
        // string $username, string $password, string $name1, int $credentialID, int $roleId, string $email) {
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


}

?>
