<?php

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

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
}
