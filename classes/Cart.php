<?php
    $filePath = realpath(dirname(__FILE__));
    include_once ($filePath.'/../lib/Database.php');
    include_once ($filePath.'/../heelpers/Format.php');

/**
 * Description of Cart
 */
class Cart {
    
    private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function addToCart($quantity, $id) {
        $quantity = $this->fm->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $productId = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();
        
        $sQuery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($sQuery)->fetch_assoc();   
        
        $productName = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];
        
        $cQuery = "SELECT * FROM tbl_cart WHERE $productId = '$productId' AND sId = '$sId'";
        $getPro = $this->db->select($cQuery);
        if ($getPro) {
            $msg = "Product Already Added";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_product(sId, productId, productName, price, quantity, image) "
                        . "VALUES ('$sId', '$productId', '$productName', '$quantity', '$uploadedImage', '$image')";

                $insertRow = $this->db->insert($query);
                if ($insertRow) {
                    header("Location::cart.php");
                } else {
                    header("Location:404.php");
                }
        }
    }
    
    public function getCartProduct() {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE $sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function updateCartQuantity($cartId, $quantity) {
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        
        $query = "UPDATE tbl_cart "
                   . "SET quantity = '$quantity'"
                   . "WHERE cartId = '$cartId'";
           $updateRow = $this->db->update($query);
           if ($updateRow) {
               header("Location:cart.php");
           } else {
               $msg = "<span class='error'>Quantity Not Updated.</span>";
               return $msg;
           }
    }
    
    public function delProductByCart($delId) {
        $delId = mysqli_real_escape_string($this->db->link, $delId);
        $query = "DELETE FROM tbl_cart WHERE cartId = '$delId'";
        $delData = $this->db->delete($query);
        if($delData) {
           echo "<script>window.location = 'cart.php'; </script>";
        } else {
            $msg = "<span class='error'>Product Not Deleted.</span>";
            return $msg;
        }
    }
    
    public function checkCartTable() {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function delCustomerCart() {
        $cId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->delete($query);
    }
}
