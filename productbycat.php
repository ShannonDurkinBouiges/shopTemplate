<?php 
    include 'inc/_header.php';
    
    if(!isset($_GET['catId']) || $_GET['catId'] == NULL) {
    echo "<script>window.location = '404.php';</script>";
} else {
    $id = $_GET['catId'];
}
?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
                    
                <?php
                   $productByCat = $pd->productByOnlyCat($id); 
                   if ($productByCat) {
                       while ($result = $productByCat->fetch_assoc()) {
                ?>    
    		<h3>Latest from <?php echo $result['catName']; ?></h3>
                <?php
                    }}
                ?>
                
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
                <?php
                   $productByCat = $pd->productByCat(); 
                   if ($productByCat) {
                       while ($result = $productByCat->fetch_assoc()) {
                ?>
				<div class="grid_1_of_4 images_1_of_4">
					<a href="preview.php?proid=<?php echo $result['productId']; ?>">
                                            <img src="admin/<?php echo $result['image']; ?>" alt="Featured Product"/>
                                        </a> 
					<h2><?php echo $result['productName']; ?></h2>
					<p><?php echo $fm->textShorten($result['body'], 60); ?></p>
					<p><span class="price">$<?php echo $result['price']; ?></span></p>
                                        <div class="button">
                                            <span>
                                                <a href="preview.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a>
                                            </span>
                                        </div>
                                </div>
                <?php
                   }} else {
                        //echo 'Products from this category are not available';
                        header("Location:404.php");
                   }
                ?>
			</div>

	
	
    </div>
 </div>
</div>

<?php
    include 'inc/_footer.php';
?>

