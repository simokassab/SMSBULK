<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/contacts.php');
$log= new login();
$gr= new groups();
$cr= new contacts();
$res=$log->checklogin();

$cr_all=$cr->getAll($_SESSION['user_id']);

$gr_all=$gr->getAll($_SESSION['user_id']);


if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<script>
$(document).ready(function (e) {
    $('#table').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    } );
   
    $('.add_contact').on('click', function () {
       // alert($('.name_').val());
        var msisdn= $('#msisdn').val();
        var fname=$('#fname').val();
        var lname=$('#lname').val();
        var email=$('#email').val();
        var address=$('#address').val();
        var gender=$('input[name=gender]:checked').val();
        var groups=$('#groups').val();
        var userid= <?php echo $_SESSION['user_id']; ?>;
       // alert(gender);
        if (msisdn=='' && groups==''){
            $('#errorphone').css('display', 'block');
            $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errorgroups').css('display', 'block');
            $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else if (msisdn=='' && groups!=''){
            $('#errorphone').css('display', 'block');
            $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errorgroups').css('display', 'none');
        }
        else if (msisdn!='' && groups==''){
            $('#errorphone').css('display', 'none');
            $('#errorgroups').css('display', 'block');
            $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else {
            event.preventDefault();
            $.ajax({
                url: "./requests/contacts/addcontact.php",
                type: "GET",
                data: 'fname='+fname+'&lname='+lname+'&email='+email+'&address='+address+'&gender='+gender+'&groups='+groups+',&msisdn='+msisdn+'&user_id='+userid,
                success: function(data)
                {
                    console.log(data);
                // window.location.href = 'your_url';
                $.notify("New Contact has been Added.", "success");
                 window.setTimeout(function () {
                    location.reload();
                      location.href = "http://localhost/SMS/contacts.php#view";
                   }, 1000);
                },
                error: function() 
                {
                    
                } 	        
            });
        }
    });
});
</script>
<body class='bg'>
    <div id="myModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                <div class="form-group">
                    <label class="control-label col-sm-2"for="id">ID</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="fid" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name</label>
                    <div class="col-sm-10">
                    <input type="name" class="form-control" id="t">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="description">Description</label>
                    <div class="col-sm-10">
                    <textarea type="name" class="form-control" id="b"></textarea>
                    </div>
                </div>
                </form>
                        <!-- Form Delete Post -->
            <div class="deleteContent">
                Are You sure want to delete <span class="title"></span>?
                <span class="hidden id"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn actionBtn" data-dismiss="modal">
                <span id="footer_action_button" class="glyphicon"></span>
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class="glyphicon glyphicon"></span>close
                </button>
            </div>
            </div>
        </div>
    </div>
<?php include('includes/nav.php');?>
<h1 class='titlee'> Campaigns</h1><br/>
    <!-- Begin page content -->
    <div class="container-fluid" style='padding:3% !important;' >
        <div id="navbar-example">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" id='navitm' style='width:20% !important;'  >
                    <a class="nav-link active view" data-toggle="tab" href="#vieww" role="tab">Sent Campaigns</a>
                </li>
                <li class="nav-item" id='navitm' style='width:20% !important;'>
                    <a class="nav-link  new" data-toggle="tab" href="#new" role="tab">New Campaign</a>
                </li>
                <li class="nav-item" id='navitm' style='width:20% !important;'>
                    <a class="nav-link  new" data-toggle="tab" href="#sch" role="tab">Scheduled Campaigns</a>
                </li>
                <li class="nav-item" id='navitm' style='width:20% !important;'>
                    <a class="nav-link  new" data-toggle="tab" href="#draft" role="tab">Drafts</a>
                </li>
                <li class="nav-item"  id='navitm' style='width:20% !important;'>
                    <a class="nav-link upload" data-toggle="tab" href="#delet" role="tab">Deleted Campaigns</a>
                </li>
            </ul>
            <!-- Tab panes {Fade}  -->
            <div class="tab-content" id='content1'>
                <div class="tab-pane" id="new" name="new" role="tabpanel"><br/>  
                New Campaign
                </div><!-- tab pane-->
                <div class="tab-pane active" id="vieww" name='vieww' role="tabpanel">
                <br/> 
                View Sent
                </div><!-- tab pane-->
                <div class="tab-pane " id="sch" name="sch" role="tabpanel">
                    Scheduled
                </div><!-- tab pane-->
                <div class="tab-pane " id="up" name="draft" role="tabpanel">
                    Drafts
                </div><!-- tab pane-->
                <div class="tab-pane " id="up" name="delet" role="tabpanel">
                    Deleted..
                </div><!-- tab pane-->
                
            </div>
        </div>
    <div>
    <script>
    //check if its excel or not
    var _validFileExtensions = [".xls", ".xlsx"];    
        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    if (!blnValid) {
                        alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }
$( document ).ready(function() {
    $('#smartwizard').smartWizard("reset");
    $('#excel').change(function(){
        $('#formupload').submit();
    });
    $('#formupload').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'requests/contacts/upload.php',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data){
                $('#result').html("<center><h3>Loading...</h3></center>");
                $.notify("Uploading..", "info");
                window.setTimeout(function () {
                        //location.reload();
                        $('#result').html(data);
                        }, 2000);
            }
        })
    });
    $('#excel').filestyle({
				buttonName : 'btn-info',
                buttonText : 'Select Your Excel'
			});
    $(document).on('click', '.delete-modal', function() {
            
            $('#footer_action_button').text(" Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Delete Post');
            $('.id').text($(this).data('id'));
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            $('.title').html($(this).data('title'));
            $('#myModal').modal('show');
            });
           // 
            $('.modal-footer').on('click', '.delete', function(){
             //   alert($('.id').text());
                $.ajax({
                    type: 'GET',
                    url: './requests/contacts/deletecontact.php',
                    data: 'id=' +$('.id').text(),
                    success: function(data){
                        $.notify("Group has been deleted", "error");
                       window.setTimeout(function () {
                        location.reload();
                        location.href = "./contacts.php#view";
                        }, 1000); 
                        }
                });
            });
    $(".viewcontact").click(function(){ 
        $id=$(this).attr('id');
          location.href = 'editcontact.php?id='+$id;
    });
    var btnFinish = $('<button></button>').text('Upload')
                    .addClass('btn btn-info')
                    .on('click', function(){
                        if( $('#up_grp').val()==""){
                            alert("Still have an error");
                        }
                        else if($('.bootstrap-filestyle > input').val()==""){
                            alert("Still have an error.. select a file");
                        }
                    });
            var btnCancel = $('<button></button>').text('Cancel')
                            .addClass('btn btn-danger')
                            .on('click', function(){
                                $('#smartwizard').smartWizard("reset");
                                $('#up_grp').val("");
                                $('.bootstrap-filestyle > input').val("");
                            });

            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect:'fade',
                    toolbarSettings: {toolbarPosition: 'bottom',
                                      toolbarExtraButtons: [btnCancel]
                                    },
                    anchorSettings: {
                                markDoneStep: true, // add done css
                                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                            }
                 });

            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if(stepDirection === 'forward' && elmForm){
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    if(elmErr && elmErr.length > 0){
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if(stepNumber == 3){
                    $('.btn-finish').removeClass('disabled');
                }else{
                    $('.btn-finish').addClass('disabled');
                }
            });
});

  </script>
<?php //include('includes/footer.php'); ?>
