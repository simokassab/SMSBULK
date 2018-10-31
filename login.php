<?php 
ob_start();
session_start();
include_once('classes/login.php');
$log= new login();
$res=$log->checklogin();

if($res)
    header("Location: index.php");

include('includes/header.php');

?>
<div class='container-fluid'>

    <div class='row'>
        <div class='col-sm-6 back' style=''>
            <img src='img/bg1.png' class="resp" >
        </div>
        <div class='col-sm-6'>
            <div class='login'>
            <h2 style='text-align:center; margin-left:5%; color:#595959;'>Welcome back! Please login to your account. </h2>
            <?php
                    $res='';
                    if (isset($_GET['action'])) {
                        if($_GET['action']=='b')
                            $res='Bad Password, Please try again.. :(';
                        else 
                            $res='User Not Found..';
                        ?>
                        <div class="form-group">
                            <div class="alert alert-danger" style='margin-left:5%; text-align:center;'>
                                <span class="glyphicon glyphicon-info-sign" ></span> <?php echo $res; ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <form class="form-style-8" method='post' action='./requests/login.php'>
                    
                    <input type="email" name="email" placeholder="Email"  class="form-control" /><br/>
                    <input type="password" name='pass' id="inputPassword" class="form-control" placeholder="Password" required>
                    <div class='row' style='margin-top:40px;'>
                        <div class='col-md-6'>
                            <input type="checkbox" id="box-1">
                            <label for="box-1">Remember me</label>
                        </div>
                        <div class='col-md-6 for' >
                            <a href='#' class='forget'>Forget Password</a>
                        </div>
                    </div>
                    <div class='row' style='margin-top:40px;'>
                        <div class='col-md-6' style='text-align:center;'>
                             <button class="btn btn-lg btnlogin" type="submit" name='btn-login'>Log in</button>
                        </div>
                        <div class='col-md-6' style='text-align:center;'>
                             <button class=" btnsign " type="submit" name='btn-login'>Sign Up</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>