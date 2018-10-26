<?php
ob_start();
session_start();
include_once('classes/login.php');
$log= new login();
$res=$log->checklogin();





if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>

<?php include('includes/nav.php');?>
    <!-- Begin page content -->
    <div class="container-fluid ">
        <h1> hello </h1>
    </div>
    
</div><!-- for wrapper -->
<?php include('includes/footer.php'); ?>
