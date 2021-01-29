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
                <h2><span>Order Page</span> Not Found</h2>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>

<?php
    include 'inc/_footer.php';
?>

