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
}
