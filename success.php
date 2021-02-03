<?php

    include 'inc/_header.php';
    
    $login = Session::get("cusLogin");
    if ($login == false) {
        header("Location: login.php");
    }
?>

<style>
    .payment{width: 500px;min-height:200px;text-align: center;border: 1px solid #ddd;margin: 0 auto; padding:50px; } 
    .payment h2{border-bottom: 2px solid #ddd;margin-bottom: 40px;padding-bottom: 10px;} 
    .payment p{line-height: 25px;} 
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            
            <div class="payment">
                <h2>Success</h2>
                <p>Your order has been successful.  Below are your order details: <a href="order.php"></a> Click here to see details</p>
            </div>
            
        </div>
    </div>
</div>

<?php
    include 'inc/_footer.php';
?>



