<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
$log= new login();
$gr= new groups();
$res=$log->checklogin();

$gr_all=$gr->getAll($_SESSION['user_id']);


if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<script>
$(document).ready(function (e) {
    $('#table').DataTable( {
        "pagingType": "full_numbers"
    } );
    var res = $(location).attr('href').split("#");
    if(!res[1]){
        $('.view').removeClass('active');
        $('#vieww').removeClass('active');
        $('.new').addClass('active');
        $('#new').addClass('active');
    }
    else {
        //
        if(res[1]=='view'){
            $('.new').removeClass('active');
            $('#new').removeClass('active');
            $('.view').addClass('active');
            $('#vieww').addClass('active');
        }
    }
    
    $('.add_group').on('click', function () {
       // alert($('.name_').val());
        var name_= $('.name_').val();
        var desc=$('#description_').val();
        if (name_=='' && desc==''){
            $('#errorname').css('display', 'block');
            $('#errorname').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errordesc').css('display', 'block');
            $('#errordesc').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else if (name_=='' && desc!=''){
            $('#errorname').css('display', 'block');
            $('#errorname').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errordesc').css('display', 'none');
        }
        else if (name_!='' && desc==''){
            $('#errorname').css('display', 'none');
            $('#errordesc').css('display', 'block');
            $('#errordesc').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else {
            event.preventDefault();
            $.ajax({
                url: "./requests/groups/addgroup.php",
                type: "GET",
                data: 'name_='+name_+'&description_='+desc,
                success: function(data)
                {
                    console.log(data);
                // window.location.href = 'your_url';
                $.notify("New Group has been Added.", "success");
                 window.setTimeout(function () {
                    location.reload();
                      location.href = "http://localhost/SMS/groups.php#view";
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
<!-- modal -->
<div id="show" class="modal  fade " role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">ID :</label>
                        <b id="i" />
                    </div>
                    <div class="form-group">
                        <label for="">Title :</label>
                        <b id="ti"/>
                    </div>
                    <div class="form-group">
                        <label for="">Body :</label>
                        <b id="by"/>
                    </div>
                </div>
            </div>
        </div>           
</div>

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
</div>

<!-- end modal -->
<?php include('includes/nav.php');?>
<h1 style='text-align:center; color:#0580BC; font-size:80px;'> Groups</h1><br/>
    <!-- Begin page content -->
    <div class="container-fluid ">
        <div id="navbar-example">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" id='navitm' >
                    <a class="nav-link active new" data-toggle="tab" href="#new" role="tab">New Group</a>
                </li>
                <li class="nav-item" id='navitm'  >
                    <a class="nav-link view" data-toggle="tab" href="#vieww" role="tab">View/ Edit Group</a>
                </li>
                <li class="nav-item"  id='navitm' >
                    <a class="nav-link upload" data-toggle="tab" href="#up" role="tab">Upload Group</a>
                </li>
            </ul>
            <!-- Tab panes {Fade}  -->
            <div class="tab-content" id='content1'>
                <div class="tab-pane  active" id="new" name="new" role="tabpanel"><br/>  
                <form method='post' action='groups.php'>
                    <h3 style='text-align:center;'>Add Group</h3><hr/>
                   <div class='row' style='margin:0 2% 2% 2%;'>
                        <div class='col-sm-6'>
                            <div class="form-group">
                              <label class="control-label" for="title">Name :</label>
                                <input type="text" class="form-control name_" id="name_" name="name_"
                                placeholder="name" >
                                <p id='errorname' class="error text-center alert alert-danger" style='display:none;'></p>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                              <label class="control-label" for="body">description :</label>
                                <input type="text" class="form-control" id="description_" name="description_"
                                placeholder="Description" >
                                <p id='errordesc' class="error text-center alert alert-danger" style='display:none;'></p>
                            </div>
                        </div>
                    </div>
                    <div style=' margin-left: 40%;'>
                        <a class="btn btn-warning add_group" style='width:300px;' >
                        <span class="fa fa-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Save Group
                        </a><br/><br/>
                    </div>
                    </form>
                </div>
                <div class="tab-pane" id="vieww" name='vieww' role="tabpanel">
                <br/> 
                <div class='cont' >
                    <table  id='table' class="table  table-bordered hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th class="text-center">
                                    <a href='#' class='create-modal btn btn-success btn-sm'> <i class="fa fa-plus-square" style='color:white;'></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($gr_all as $gg){
                            //  echo $g['']
                        ?>
                        <tr class='group<?php echo $gg['id']; ?>'>
                            <td><?php echo $gg['name'];?></td>
                            <td><?php echo $gg['description'];?></td>
                            <td><?php echo $gg['created_at'];?></td>
                            <td class="text-center">
                                <a href="#" title='View Group' data-toggle="modal" data-target="#show" class="show-modal btn btn-info btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-eye" style='color:white;'></i>
                                </a>
                                <a href="#" title='Edit Group' class="edit-modal btn btn-warning btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-edit" style='color:white;'></i>
                                </a>
                                <a href="#" title='Delete Group'  class="delete-modal btn btn-danger btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-trash-alt" style='color:white;'></i>
                                </a>
                                <a href="contacts.php?grid=<?php echo $gg['id']; ?>" title='View Contacts' class="btn btn-primary btn-sm">
                                <i class="fa fa-user-tag" style='color:white;'></i>
                                </a>
                            
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                        </div>
                </div>
                <div class="tab-pane fade" id="up" name="up" role="tabpanel">
                </div>
            </div>
        </div>
    <div>
<?php include('includes/footer.php'); ?>
