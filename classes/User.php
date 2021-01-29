<?php
    $filePath = realpath(dirname(__FILE__));
    include_once ($filePath.'/../lib/Database.php');
    include_once ($filePath.'/../heelpers/Format.php');

/**
 * Description of User
 */
class User {
    
    private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function customerRegistration($data) {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $address = mysqli_real_escape_string($this->db->link, $data['productName']);
        $city = mysqli_real_escape_string($this->db->link, $data['city']);
        $country = mysqli_real_escape_string($this->db->link, $data['country']);
        $zip = mysqli_real_escape_string($this->db->link, $data['zip']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $pass = mysqli_real_escape_string($this->db->link, md5($data['pass']));
        
         if ($name == "" || $address == "" || $city == "" || $country == "" ||
                $zip == "" || $phone == "" || $email == "" || $pass == "") {
                    $msg = "<span class='success'>Field cannot be empty.</span>";
                    return $msg;
        } 
        $mailQuery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
        $mailCheck = $this->db->select($mailCheck);
        if ($mailCheck != false) {
            $msg = "<span class='success'>Email already exist.</span>";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, pass) "
                    . "VALUES ('$name', '$address', '$city', '$country', '$zip', '$phone', '$email', '$pass')";

            $insertRow = $this->db->insert($query);
            if ($insertRow) {
                $msg = "<span class='success'>Customer profile created.</span>";
                return $msg;
            } else {
                $msg = "<span class='error'>Error: Customer profile not created.</span>";
                return $msg;
            }
        }
    }
    
    public function customerLogin($data) {
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $pass = mysqli_real_escape_string($this->db->link, md5($data['pass']));
        
        if ($email == "" || $pass == "") {
            $msg = "<span class='success'>Field cannot be empty.</span>";
            return $msg;
        }
        
        $query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass= '$pass'";
        $result = $this->db->select($query);
        if ($result != false) {
            $value = $result->fetch_assoc();
            Session::set("cusLogin", true);
            Session::set("cmrId", $value['id']);
            Session::set("cmrName", $value['name']);
            header("Location:order.php");
        } else {
            $msg = "<span class='success'>Email or Password is incorrect.</span>";
            return $msg;
        }
    }
}
