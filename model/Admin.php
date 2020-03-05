<?php


require_once 'User.php';


class Admin extends User {
    //       AID, Username, Password, AName, CredentialID, RoleId, Email

    /**
     * Reviewer.class constructor.
     * @param $username
     * @param $password
     * @param $name
     * @param $email
     * @param $credential
     * @param $roleId
     */
    public function __construct($username, $password, $name, $credential, $roleId, $email) {
        parent::__construct($username, $password, $name, $credential, $roleId, $email);
        // string $username, string $password, string $name1, int $credentialID, int $roleId, string $email) {
    }



    public function __toString() {
        try {
            return "\nAdmin\nUsername: ".(string)$this->getUsername()
                ."\nPassword: ".(string)$this->getPassword()
                ."\nName: ".(string)$this->getName()
                ."\nEmail: ".(string)$this->getEmail()
                ."\ncredentialID: ".(string)$this->getCredentialID()
                ."\nRoleID: ".(string)$this->getRoleId()."\n";
        } catch (Exception $exception) {
            return 'Error in Admin.class:toString';
        }
    }
}

?>
