<?php

include '../lib/Session.php';
Session::checkLogin();

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

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
            $query = "SELECT * FROM tbl_admin WHERE adminUser='$adminUser' AND adminPass='$adminPass'";
            $result = $this->db->select($query);
            if ($result != false) {
                $value = $result->fetch_assoc();
                Session::set("adminLogin", true);
                Session::set("adminId", $value['adminId']);
                Session::set("adminUser", $value['adminUser']);
                Session::set("adminName", $value['adminName']);
                header("Location:dashboard.php");
            } else {
                $loginmsg = "username or password is incorrect";
                return $loginmsg;
            }
        }
    }
}
