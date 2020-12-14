<?php

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

/**
 * Description of Category
 */
class Category {
    
     private $db;
    private $fm;
    
    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }
    
    public function catInsert($catName) {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        if (empty($catName)) {
            $msg = "Category must be filled out";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_category(catName) VALUES ('$catName')"; //values is from catadd.php
            $catInsert = $this->db->insert($query);
            if ($catInsert) {
                $msg = "<span class='success'>Category Inserted Successfully.</span>";
                return $msg;
            } else {
                $msg = "<span class='error'>Category Not Inserted.</span>";
                return $msg;
            }
        }
    }
    
    public function getAllCat() {
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getCatById($id) {
        $query = "SELECT * FROM tbl_category WHERE catId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function catUpdate($catName, $id) {
       $catName = $this->fm->validation($catName);
       $catName = mysqli_real_escape_string($this->db->link, $catName);
       $catName = mysqli_real_escape_string($this->db->link, $id);
       if (empty($catName)) {
           $msg = "<span class='error'>Category Field Must Not Be Empty.</span>";
           return $msg;
       } else {
           $query = "UPDATE tbl_category "
                   . "SET catName = '$catName'"
                   . "WHERE catId = '$id'";
           $updateRow = $this->db->update($query);
           if ($updateRow) {
               $msg = "<span class='success'>Category Updated Successfully.</span>";
               return $msg;
           } else {
               $msg = "<span class='error'>Category Not Updated.</span>";
               return $msg;
           }
       }
    }
    
    public function delCatById($id) {
        $query = "DELETE FROM tbl_category WHERE catId = '$id'";
        $delData = $this->db->delete($query);
        if($delData) {
           $msg = "<span class='success'>Category Deleted Successfully.</span>";
           return $msg; 
        } else {
            $msg = "<span class='error'>Category Not Deleted.</span>";
            return $msg;
        }
    }
}
