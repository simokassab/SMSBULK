<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
$log= new login();
$gr= new groups();
$res=$log->checklogin();

$gr_all=$gr->getAll();
//print_r($gr_all);
//f//oreach($gr_all as $g){
   // echo $g[0];
//}

if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
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
   <div id='create' class="modal fade" role="dialog">
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type="button" class='close' data-dismiss='modal'>&times;</button>
                        <h4 class='modal-title'>Add Group</h4>        
                    </div>
                    <div class='modal-body'>
                        <form class="form-horizontal" role="form">
                            <div class="form-group row add">
                              <label class="control-label col-sm-2" for="title">Name :</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_" name="name_"
                                placeholder="name" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-2" for="body">description :</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"
                                placeholder="Your Body Here" required>
                                <p class="error text-center alert alert-danger hidden"></p>
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning add_group" type="submit" >
                          <span class="glyphicon glyphicon-plus"></span>Save Group
                        </button>
                        <button class="btn btn-warning" type="button" data-dismiss="modal">
                          <span class="glyphicon glyphicon-remobe"></span>Close
                        </button>
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
                    <a class="nav-link active" data-toggle="tab" href="#attributes" role="tab">New Group</a>
                </li>
                <li class="nav-item" id='navitm'  >
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">View/ Edit Group</a>
                </li>
                <li class="nav-item"  id='navitm' >
                    <a class="nav-link" data-toggle="tab" href="#experience" role="tab">Upload Group</a>
                </li>
            </ul>
            <!-- Tab panes {Fade}  -->
            <div class="tab-content" id='content1'>
                <div class="tab-pane  active" id="attributes" name="attributes" role="tabpanel">  
                    
                </div>
                <div class="tab-pane fade " id="profile" role="tabpanel">
                <br/> 
                    <table class='table table-bordered' id='table' style='width:98%;margin-left: 1%; text-align:center;'>
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
                <div class="tab-pane fade" id="experience" name="experience" role="tabpanel">
                </div>
            </div>
        </div>
    <div>
<?php include('includes/footer.php'); ?>
