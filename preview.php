<?php 
    include 'inc/_header.php';
?>

<?php

if(isset($_GET['proid'])) {
    $id = $_GET['proid'];
}

?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        
        $addCart = $ct->addToCart($quantity, $id);
    }
        
    $cmrId = Session::get("cmrId");
     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
         $productId = $_POST['productId'];
         $insertCompare = $pd->insertCompareData($productId, $cmrId);
     }
?>

 <div class="main">
    <div class="content">
    	<div class="section group">
				<div class="cont-desc span_1_of_2">
                                    <?php
                                        $getPd = $pd->getSingleProduct($id);
                                        if ($getPd) {
                                            while ($result = $getPd->fetch_assoc()) {
                                    ?>
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image']; ?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
                                    <h2><?php echo $result['productName']; ?></h2>
					<p><?php echo $fm->textShorten($result['body'], 200); ?></p>					
					<div class="price">
						<p>Price: <span>$ <?php echo $result['price']; ?></span></p>
						<p>Category: <span><?php echo $result['catName']; ?></span></p>
						<p>Brand:<span><?php echo $result['brandName']; ?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number" class="buyfield" name="quantity" value="1"/> //quantity is from cart table in db
						<input type="submit" class="buysubmit" name="submit" value="Add to Cart"/>
					</form>				
				</div>
                        <span style="color: red; font-size: 18px;">
                            <?php
                                if (isset($addCart)) {
                                    echo $addCart;
                                }
                            ?>
                        </span>
                            
                        <?php
                            if (isset($insertCompare)) {
                                echo $insertCompare;
                            }
                        ?>
                        
                        <div class="add-cart">
                            <form action="" method="POST">
                                <input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/> 
                                <input type="submit" class="buysubmit" name="compare" value="Compare"/>
                            </form>
                        </div>
                                        
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
                        <p><?php echo $result['body']; ?></p>
	    </div>
            <?php
                }}
            ?>
	</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
                                        <?php
                                            $getCat = $cat->getAllCat();
                                            if ($getCat) {
                                                while ($result = $getCat->fetch_assoc()) {
                                        ?>
                                            <li><a href="productbycat.php?catId=<?php echo $result['catId']; ?>">
                                                <?php echo $result['catName']; ?></a>
                                            </li>
                                        <?php 
                                            }}
                                        ?>
    				</ul>
    	
 				</div>
 		</div>
 	</div>
	</div>

<?php
    include 'inc/_footer.php';
?>
