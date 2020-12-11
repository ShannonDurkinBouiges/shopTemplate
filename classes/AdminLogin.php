<?php

include '../lib/Session.php';
include '../lib/Database.php';
include '../helpers/Format.php';

/**
 * Description of AdminLogin
 */
class AdminLogin {
    
    private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function adminLogin($adminUser, $adminPass) {
        $adminUser = $this->fm->validation($adminUser);
        $adminPass = $this->fm->validation($adminPass);
        
        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser); //no longer use mysqli_real_escape_string
        $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);
        
        if (empty($adminUser) || empty($adminPass)) {
            $loginmsg = "User name or Password must not be empty";
            return $loginmsg;
        } else {
            $query = "";
        }
    }
}
