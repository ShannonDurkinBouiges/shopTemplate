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
    .tblone{widtch: 550px; margin: 0 auto; border: 2px solid #ddd;}
    .tblone tr td{text-align: justify;}
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            
            <?php
                $id = Session::get('cmrId');
                $getData = $cmr->getCustomerData($id); //$id is var from above
                if ($getData) {
                    while ($result = $getData->fetch_assoc()) {
            ?>
            <table class="tblone">
                <tr>
                    <td colspan="3"><h2>Your Profile Details</h2></td>
                </tr>
                <tr>
                    <td width="20%">Name</td>
                    <td width="5%"> : </td>
                    <td><?php echo $result['name']; ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td> : </td>
                    <td><?php echo $result['phone']; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> : </td>
                    <td><?php echo $result['email']; ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td> : </td>
                    <td><?php echo $result['address']; ?></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td> : </td>
                    <td><?php echo $result['city']; ?></td>
                </tr>
                <tr>
                    <td>Zipcode</td>
                    <td> : </td>
                    <td><?php echo $result['zip']; ?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td> : </td>
                    <td><?php echo $result['country']; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><a href="editprofile.php">Update Details</a></td>
                </tr>
            </table>
            <?php
                }}
            ?>
            
        </div>
    </div>
</div>

<?php
    include 'inc/_footer.php';
?>



