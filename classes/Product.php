<?php
    $filePath = realpath(dirname(__FILE__));
    include_once ($filePath.'/../lib/Database.php');
    include_once ($filePath.'/../heelpers/Format.php');

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
        $uniqueImage = substr(md5(time()), 0, 10) . '.' . $fileExt;
        $uploadedImage = "upload/" . $uniqueImage;
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

    public function productUpdate($data, $file, $id) {

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
        $uniqueImage = substr(md5(time()), 0, 10) . '.' . $fileExt;
        $uploadedImage = "upload/" . $uniqueImage;
        if ($productName == "" || $catId == "" || $brandId == "" || $body == "" ||
                $price == "" || $type == "") {
            $msg = "<span class='success'>Field must not be empty.</span>";
            return $msg;
        } else {
            if (!empty($fileName)) {
                if ($fileSize > 1054589) {
                    echo "<span class='error'>Image size must be less than 1MB.</span>";
                } elseif (in_array($fileExt, $permited === false)) {
                    echo "<span class='error'>You can only upload" . implode(',', $permited) . ".</span>";
                } else {
                    move_uploaded_file($fileTemp, $uploadedImage);
                    $query = "UPDATE tbl_product
                              SET 
                              productName = '$productName',
                              catId = '$catId',
                              brandId = '$brandId',
                              body = '$body',
                              price = '$price',
                              image = '$uploadedImage',
                              type = '$type'
                              WHERE productId = '$id'";
                                
                    $updatedRow = $this->db->update($query);
                    if ($updatedRow) {
                        $msg = "<span class='success'>Product Updated Successfully.</span>";
                        return $msg;
                    } else {
                        $msg = "<span class='error'>Product Not Updated.</span>";
                        return $msg;
                    }
                }
            } else {
                $query = "UPDATE tbl_product
                              SET 
                              productName = '$productName',
                              catId = '$catId',
                              brandId = '$brandId',
                              body = '$body',
                              price = '$price',
                              image = '$uploadedImage',
                              type = '$type'
                              WHERE productId = '$id'";
                                
                    $updatedRow = $this->db->update($query);
                    if ($updatedRow) {
                        $msg = "<span class='success'>Product Updated Successfully.</span>";
                        return $msg;
                    }
            }
        }
    }
    
    public function delProById($id) {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $getData = $this->db->select($query);
        if ($getData) {
            while ($delImg = $getData->fetch_assoc()) {
                $delLink = $delImg['image'];
                unlink($delLink);
            }
        }
        $delQuery = "DELETE FROM tbl_product WHERE productId = '$id' ";
        $delData = $this->db->delete($delQuery);
        if($delData) {
           $msg = "<span class='success'>Product Deleted Successfully.</span>";
           return $msg; 
        } else {
            $msg = "<span class='error'>Product Not Deleted.</span>";
            return $msg;
        }
    } 
    
    public function getFeaturedProduct() {
        $query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getNewProduct() {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function getSingleProduct($id) {
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName"
                . "FROM tbl_product"
                . "INNER JOIN tbl_category"
                . "ON tbl_product.catId = tbl_category.catId"
                . "INNER JOIN tbl_brand"
                . "ON tbl_product.brandId = tbl_brand.brandId"
                . "AND tbl_product.productId = '$id'"
                . "ORDER BY tbl_product.productId DESC";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function latestFromAcer() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function latestFromZara() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function latestFromPolo() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '6' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function latestFromSamsung() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function productByCat($id) {
        $catId = mysqli_real_escape_string($this->db->link, $id);
        $query = "SELECT * FROM tbl_product WHERE catId = '$catId'";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function productByOnlyCat($id) {
        $query = "SELECT * FROM tbl_category WHERE catId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
}
    