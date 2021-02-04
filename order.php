<?php
    include 'inc/_header.php';
    
    $login = Session::get("cusLogin");
    if ($login == false) {
        header("Location: login.php");
    }
?>

<style>
    .notFound h2{font-size: 80px; line-height: 130px; text-align: center;}
    .notFound h2 span{display: block; color: red; font-size: 150px;}
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="notFound">
                <h2><span>Your Order Details</span></h2>
                <table class="tblone">
                    <tr>
                        <th>Sl</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    $cmrId = Session::get("cmrId");
                    $getOrder = $ct->getOrderProduct();  //$ct is in _header
                    if ($getOrder) {
                        $i = 0;
                        while ($result = $getOrder->fetch_assoc()) {
                            $i++;
                            ?>

                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $result['productName']; ?></td>
                                <td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
                                <td><?php echo $result['quantity']; ?></td>
                                <td>$
                                    <?php
                                    $total = $result['price'] * $result['quantity'];
                                    echo $total;
                                    ?>
                                </td>
                                <td><?php echo $fm->formatDate($result['date']); ?></td>
                                <td>
                                    <?php
                                        if ($result['status'] == '0') {
                                            echo 'Shipped';
                                        } else {
                                            echo 'Pending';
                                        }
                                    ?>
                                </td>
                                
                                <?php
                                    if ($result['status'] == '1') {
                                ?>
                                    <td><a onclick="return confirm('Are you sure you want to delete this item?');" 
                                           href="">X</a></td>
                                <?php } else { ?>
                                           <td>N/A</td>     
                                <?php } ?>
                            </tr>

                            <?php
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>

<?php
    include 'inc/_footer.php';
?>

