<?php

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

/**
 * Description of Product
 */
class Product {
    
    private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function productInsert($data, $file) { //data is for most type of post, file is for the image
        
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']); //'productName is name from productadd
        $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body = mysqli_real_escape_string($this->db->link, $data['body']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        
        $permited = ['jpg', 'png', 'jpeg', 'gif'];
        $fileName = $file['image']['name'];
        $fileSize = $file['image']['size'];
        $fileTemp = $file['image']['tmp_name'];
        
        $div = explode('.', $fileName);
        $fileExt = strtolower(end($div));
        $uniqueImage = substr(md5(time()), 0, 10).'.'.$fileExt;
        $uploadedImage = "upload/".$uniqueImage;
        if ($productName == "" || $catId == "" || $brandId == "" || $body == "" ||
            $price == "" || $type == "") {
                $msg = "<span class='success'>Field must not be empty.</span>";
                return $msg;
        } else {
            move_uploaded_file($fileTemp, $uploadedImage);
            $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) "
                    . "VALUES ('$productName, $catId, $brandId, $body, $price, $uploadedImage, $type')";
            
            $insertRow = $this->db->insert($query);
             if ($insertRow) {
                $msg = "<span class='success'>Product Inserted Successfully.</span>";
                return $msg;
            } else {
                $msg = "<span class='error'>Product Not Inserted.</span>";
                return $msg;
            }
        }
    }
    
    public function getAllProducts() {
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName"
                . "FROM tbl_product"
                . "INNER JOIN tbl_category"
                . "ON tbl_product.catId = tbl_category.catId"
                . "INNER JOIN tbl_brand"
                . "ON tbl_product.brandId = tbl_brand.brandId"
                . "ORDER BY tbl_product.productId DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getProById($id) {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
}
