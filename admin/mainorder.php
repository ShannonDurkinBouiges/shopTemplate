<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php  
    $filePath = realpath(dirname(__FILE__));
    include_once ($filePath.'/../classes/Cart.php');
    nclude_once ($filePath.'/../classes/Format.php');
    $ct = new Cart();
    $fm = new Format();
    
    if (isset($_GET['shiftid'])) {
        $id = $_GET['shiftid'];
        $price = $_GET['price'];
        $time = $_GET['time'];
        $shift = $ct->productShifted($id, $time, $price);
    }
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Customer Orders</h2>
        
        <?php
            if (isset($shift)) {
                echo $shift;
            }
        ?>
        <div class="block">        
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Customer ID</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        $ct = new Cart();
                        $fm = new Format();
                        $getOrder = $ct->getAllOrderProduct();
                        if ($getOrder) {
                            while ($result = $getOrder->fetch_assoc()) {
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $result['id']; ?></td>
                        <td><?php echo $fm->formatDate($result['date']); ?></td>
                        <td><?php echo $result['productName']; ?></td>
                        <td><?php echo $result['quantity']; ?></td>
                        <td><?php echo 'S'.$result['price']; ?></td>
                        <td><?php echo $result['cmrId']; ?></td>
                        <td><a href="customer.php?custId=<?php echo $result['cmrId']; ?>">View Address</a></td>
                        
                        <?php
                            if ($result['status'] == '0') {
                        ?>
                            <td><a href="?shiftid=<?php echo $result['cmrId']; ?>&price=<td><?php echo $result['price']; ?>
                                   &time=<td><?php echo $result['date']; ?></td></td>">Shipped</a></td>
                        <?php
                            } else {
                        ?>
                              <td><a href="?shiftid=<?php echo $result['cmrId']; ?>&price=<td><?php echo $result['price']; ?>
                                   &time=<td><?php echo $result['date']; ?></td></td>">Pending</a></td>
                        <?php
                            }
                        ?>
                        
                    </tr>
                    <?php
                        }}
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php'; ?>
