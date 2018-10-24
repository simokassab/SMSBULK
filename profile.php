<?php
ob_start(); 
session_start();
include('includes/header.php'); ?>
<body>
<?php 
    include('includes/nav.php'); 
    include_once('classes/users.php');
    include_once('classes/login.php');
    $id = $_SESSION['user_id'];
    //echo $id;
    $log= new login();
    $user= new users();
    $logged=$log->checklogin();
    if(!$logged)
        header("Location: login.php");
    $row=$user->getRowByID($id);

    ?>
<h1 style='text-align:center; color:#0580BC; font-size:80px;'> Profile</h1><br/>
<div class="container">
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
            <div id="body-overlay"><div><img src="./img/loading.gif" width="64px" height="64px"/></div></div>
                <div class="bgColor">
                    <form id="uploadForm" action="requests/uploadimage.php" method="post">
                        <div id="targetOuter" >
                            <div id="targetLayer"></div>
                            <img src="./img/photo.png"  class="icon-choose-image" />
                            <div class="icon-choose-image" >

                            <input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
                            </div>
                        </div>
                        <div>
                        <input type="submit" value="Upload Photo" class="btnSubmit" />
                    </form>
            </div>
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <form class="form-horizontal" role="form" action='requests/updateprofile.php' method='POST' enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name='username' value='<?php echo $row['username']; ?>'>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password"  id='password' value='<?php echo $row['password']; ?>' disabled>
            <a href='changepassword.php' class='changepass'>Change Password </a>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" rows="5" id="address" name='address'><?php echo $row['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name='phone'  value='<?php echo $row['phone']; ?>'>
        </div>
        <div class="form-group">
            <label for="company">Company:</label>
            <input type="text" class="form-control" id="company" name='company' value='<?php echo $row['company']; ?>'>
        </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="button" class="btn btn-primary" value="Save">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>

</div>
<script>
function showPreview(objFileInput) {
    if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
            
           $("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="image--profile" />');
			$("#targetLayer").css('opacity','0.7');
			$(".icon-choose-image").css('opacity','0.5');
        }
		fileReader.readAsDataURL(objFileInput.files[0]);
    }
}

$(document).ready(function (e) {
    $("#targetLayer").html(' <img class="image--profile" src="<?php echo $row['photo']; ?>" width="200px" height="200px"  />');
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "requests/uploadimage.php",
			type: "POST",
			data:  new FormData(this),
			beforeSend: function(){$("#body-overlay").show();},
			contentType: false,
    	    processData:false,
			success: function(data)
		    {
			$("#targetLayer").html(data);
			$("#targetLayer").css('opacity','1');
			setInterval(function() {$("#body-overlay").hide(); },500);
			},
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});
</script>