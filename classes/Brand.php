<?php

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

/**
 * Description of Brand
 */
class Brand {
    
     private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function brandInsert($brandName) {
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        if (empty($brandName)) {
            $msg = "Brand must be filled out";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_brand(brandName) VALUES ('$brandName')"; //values is from catadd.php
            $brandInsert = $this->db->insert($query);
            if ($brandInsert) {
                $msg = "<span class='success'>Brand Inserted Successfully.</span>";
                return $msg;
            } else {
                $msg = "<span class='error'>Brand Not Inserted.</span>";
                return $msg;
            }
        }
    }
    
    public function getAllBrand() {
        $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getBrandById($id) {
        $query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function brandUpdate($brandName, $id) {
       $brandName = $this->fm->validation($brandName);
       $brandName = mysqli_real_escape_string($this->db->link, $brandName);
       $brandName = mysqli_real_escape_string($this->db->link, $id);
       if (empty($brandName)) {
           $msg = "<span class='error'>BrandField Must Not Be Empty.</span>";
           return $msg;
       } else {
           $query = "UPDATE tbl_brand "
                   . "SET brandName = '$brandName'"
                   . "WHERE brandId = '$id'";
           $updateRow = $this->db->update($query);
           if ($updateRow) {
               $msg = "<span class='success'>Brand Updated Successfully.</span>";
               return $msg;
           } else {
               $msg = "<span class='error'>Brand Not Updated.</span>";
               return $msg;
           }
       }
    }
    
    public function delBrandById($id) {
        $query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
        $delData = $this->db->delete($query);
        if($delData) {
           $msg = "<span class='success'>Brand Deleted Successfully.</span>";
           return $msg; 
        } else {
            $msg = "<span class='error'>Brand Not Deleted.</span>";
            return $msg;
        }
    }
}