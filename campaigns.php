<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/contacts.php');
include_once('classes/links.php');
$log= new login();
$gr= new groups();
$link= new links();
$cr= new contacts();


$res=$log->checklogin();

$cr_all=$cr->getAll($_SESSION['user_id']);

$gr_all=$gr->getAll($_SESSION['user_id']);

//echo rand(000000,999999);

if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<script>
$(document).ready(function (e) {
    $('#table').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    });

});
</script>
<body class='bg'>
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
                <form id='campaign' name="campaign" method = "POST" enctype = "multipart/form-data"><br/>
                    <div id="result">

                    </div>
                <h4 style='text-align:center;'>Start New Campaign</h4> <br/>
                    <div id="smartwizard" style='margin:0 2% 2% 2%;'>
                        <ul>
                            <li><a href="#step-1">Step 1<br /><small>Campaign Name</small></a></li>
                            <li><a href="#step-2">Step 2<br /><small>Campaign Type</small></a></li>
                            <li><a href="#step-3" >Step 3<br /><small id="camptitle" ></small></a></li>
                            <li><a href="#step-4" >Step 4<br /><small id="campdate" >Sending Date</small></a></li>
                            <li><a href="#step-5" >Step 5<br /><small id="campdate" >Summary</small></a></li>
                        </ul>
                        <div id="list">
                            <div id="step-1"><br/>
                                <h2>Campaign Name: </h2><br/>
                                <div id="form-step-0" role="form" data-toggle="validator" >
                                    <div class="form-group">
                                        <input type="name" class="form-control" id="grpname" name='grpname' required>
                                    </div><br/>
                                </div>
                                <p id='errorname1' class="error text-center alert alert-danger" style='display:none;'></p>
                            </div>
                            <div id="step-2"><br/> 
                                <h2>Choose Type</h2><br/>
                                <section id="plans">
                                    <div class="container">
                                        <div class="row">
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <input type="hidden" id="camptype" name="camptype">
                                                <div class="panel panel-danger panel-pricing">
                                                    <div class="panel-body text-center"> <i class="fa fa-comments"></i>
                                                        <p class='headerr'>Regular SMS</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="regular" class="btn btn-lg btn-block btn-danger" style='color:white !important; font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <div class="panel panel-warning panel-pricing">
                                                    <div class="panel-body text-center"><i class="fa fa-boxes"></i>
                                                        <p>Advanced</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="advanced" class="btn btn-lg btn-block btn-warning" style='color:white !important;font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <div class="panel panel-warning panel-pricing">
                                                    <div class="panel-body text-center"><i class="fab fa-facebook"></i>
                                                        <p>Social Media</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="social" class="btn btn-lg btn-block btn-success" style='color:white !important;font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                        </div><br/><br/>
                                    </div>
                                </section>
                            </div>
                            <div id="step-3" style="text-align: center;">
                                <h2 id="camptype"></h2><br/>
                                <div id="form-step-2" role="form" data-toggle="validator">
                                    <div class="row">
                                        <div class="col col-sm-9">
                                            <div id="reg" class="reg">
                                                <div class="form-group">
                                                    <label class="control-label" for="groups" >Groups*:</label>
                                                    <select id="groups" class="form-control" multiple="multiple" name='groups' >
                                                        <?php
                                                        foreach($gr_all as $gr){
                                                            echo "<option value='".$gr['id']."'>".$gr['name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <p id='errorgroups' class="error text-center alert alert-danger" style='display:none;'></p>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function() {
                                                        $('#groups').multiselect({
                                                            enableFiltering: true,
                                                            templates: {
                                                                li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                                                                filter: '<li class="multiselect-item filter"><div class="input-group"><input class="form-control multiselect-search" type="text"></div></li>',
                                                                filterClearBtn: ''
                                                            },

                                                            onInitialized: function(select, container) {
                                                                // hide checkboxes
                                                                // container.find('input[type=checkbox]').addClass('d-none');
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <input type="hidden" id="campgroups" name="campgroups" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="regdiv">
                                        <div class="col col-sm-9">
                                            <div class="form-group">
                                                <label class="control-label" for="textarea"  role="form" data-toggle="validator">SMS Body*:</label>
                                                <textarea class="form-control" id="textarea" name="textarea" ></textarea>
                                                <div id="textarea_feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col col-sm-3">
                                            <label class="form-control-label" for="point">Points</label>
                                            <input type="text" class="form-control" style="width: 60px; margin-left: 43%;" id="point" name="point" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-sm-12" style="text-align: center;">
                                            <p id='errorname' class="error text-center alert alert-danger" style='display:none;'></p>
                                        </div>

                                    </div>

                                    <!--  Advanced Campaign -->
                                    <div id="adv" style="display: none;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12"><h3>Predefined Templates</h3></div><br/>
                                                <div class="category-filter pb-5">
                                                    <button type="button" class="btn btn-outline-primary category-button active mr-3" data-filter="all">All</button>
                                                    <?php
                                                        include_once ('classes/db_connect.php');
                                                        $mysql=getConnected();
                                                        $result = mysqli_query($mysql,
                                                            "CALL `GetCategories`") or die("Query fail: " . mysqli_error());

                                                        //loop the result set
                                                        while ($row = mysqli_fetch_array($result)){
                                                           // echo $row['name'];
                                                            echo '<button type="button" class="btn btn-outline-primary category-button mr-3" data-filter="'.$row['name'].'">'.$row['name'].'</button>';
                                                        }
                                                    ?>
                                                    <script type="text/javascript">
                                                        $('.category-filter .category-button').categoryFilter();
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row tiles">
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5 canvass" >
                                                <img src="img/templates_canvas/flexbox.PNG" class="img-fluid img-responsive" data-target="business" >
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5 canvass">
                                                <img src="https://placeimg.com/635/480/people" class="img-fluid img-responsive">
                                                <div class="usethis" style="display: none;">Hello World</div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5 canvass">
                                                <img src="https://placeimg.com/640/480/nature" class="img-fluid img-responsive">
                                                <div class="usethis" style="display: none;">Hello World</div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5 canvass">
                                                <img src="https://placeimg.com/645/480/nature" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5 canvass">
                                                <img src="https://placeimg.com/640/480/arch" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5 canvass">
                                                <img src="https://placeimg.com/635/480/nature" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5 canvass">
                                                <img src="https://placeimg.com/640/480/people" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5 canvass">
                                                <img src="./img/templates_canvas/blank.jpg" class="img-fluid img-responsive" data-target="blank">
                                            </div>
                                        </div>
                                        <script>
                                            $('.canvass').click(function() {
                                               // $('.canvass').append('test');
                                                var targett= $(this).find("img").attr('data-target');
                                               // alert(targett);
                                                var campname=$('#grpname').val();
                                                var formData =  {
                                                    'campname': campname,
                                                    'camptype': typee,
                                                    'template': targett
                                                };
                                                console.log(formData);
                                                //insert new campaign and new land page ID
                                                $.ajax({
                                                    url: "./requests/campaigns/add_advanced.php",
                                                    type: "post",
                                                    data: formData,
                                                    success: function(d) {
                                                        $.notify("You will be redirected to Page Builder", "info");
                                                        console.log(d);

                                                        window.setTimeout(function () {
                                                            location.href='vebs/editor.php?page='+targett+'&r='+d;
                                                        }, 2000);
                                                    }
                                                });


                                            });
                                        </script>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>Used Templates</h3>
                                            </div><br/>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5">
                                                <img src="https://placeimg.com/645/480/people" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5">
                                                <img src="https://placeimg.com/635/480/people" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5">
                                                <img src="https://placeimg.com/640/480/nature" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Business mb-5">
                                                <img src="https://placeimg.com/645/480/nature" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5">
                                                <img src="https://placeimg.com/640/480/arch" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5">
                                                <img src="https://placeimg.com/635/480/nature" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5">
                                                <img src="https://placeimg.com/640/480/people" class="img-fluid">
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 filter Education mb-5">
                                                <img src="https://placeimg.com/660/480/nature" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <!--  Social Campaign -->
                                    <div id="soc" style="display: none;">soc</div>
                                </div>
                            </div>
                            <div id="step-4"><br/><br>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label" for="datetimepicker5">Pick a date</label>
                                            <input type="text" class="form-control datetimepicker-input" id="datetimepicker5" name="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5"/>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {

                                                $('#datetimepicker5').datetimepicker({
                                                    minDate: new Date(),
                                                    format: 'YYYY-MM-DD HH:mm:ss',
                                                    icons: {
                                                        time: "fa fa-clock",
                                                        date: "fa fa-calendar",
                                                        up: "fa fa-arrow-up",
                                                        down: "fa fa-arrow-down"
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div id="step-5"><br/>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h2>Summary: </h2>
                                        </div>
                                        <div class="col-sm-8">
                                            Campaign Name: <span class="summary" id="scampname"></span><br/><hr/>
                                            Campaign Type: <span class="summary" id="scamptype"></span><br/><hr/>
                                            Selected Groups: <span class="summary" id="scampgroups"></span><br><hr/>
                                            SMS Body: <span class="summary" id="scampbody"></span><br/><hr/>
                                            Sending Date: <span class="summary" id="scampdate"></span><br/><hr/>
                                            Deduced Credits: <span class="summary" id="scredits"></span><br/><hr/>
                                        </div>
                                    </div><br/>
                                    <div class="row">
                                        <div class="col-sm-4">

                                        </div>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-success" id="sumitreg" style="width: 100%;">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>               
                   </form>
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

$( document ).ready(function() {
    $(window).bind('beforeunload',function(){
         //return 'are you sure you want to leave?';
        // $('#smartwizard').smartWizard("reset");
        // location.href='./campaigns.php#step-1';
    });
  //  location.href='./campaigns.php#step-1';
  //  $('#smartwizard').smartWizard("reset");
    $('#textarea').keyup(function() {
        //  alert( $('#textarea').val().length);
        var text_length = $('#textarea').val().length;
        var text = $('#textarea').val();
        if (text.match(/[\u0600-\u06FF]/)) {
            text_max = 70;
            $('#point').val('1');
            if((text_length>70) && (text_length<=140)){
                $('#point').val('2');
            }
            if((text_length>140) && (text_length<=210)){
                $('#point').val('3');
            }
            if((text_length>210) && (text_length<=280)){
                $('#point').val('4');
            }


        } else  {
            text_max = 160;
            $('#point').val('1');
            if((text_length>160) && (text_length<=320)){
                $('#point').val('2');
            }
            if((text_length>320) && (text_length<=480)){
                $('#point').val('3');
            }
            if((text_length>480) && (text_length<=640)){
                $('#point').val('4');
            }

        }
        $('#textarea_feedback').html(text_length + ' characters');
    });
    $('.panel-footer > .btn').on('click', function(event){
        event.preventDefault();
        //alert($(this).attr('id'));
        typee=$(this).attr('id');
        if(typee=='regular'){
            $('#reg').css('display', 'block');
            $('#adv').css('display', 'none');
            $('#soc').css('display', 'none');
            $('#regular').html('Selected');
            $('#advanced').html('Select');
            $('#social').html('Select');
            $('#camptype').html('Regular Campaign');
            $('#camptitle').html('Regular Campaign');
            $('#smartwizard').smartWizard("next");
            $('#camptype').val(typee);
        }
        if(typee=='advanced'){
            $('#adv').css('display', 'block');
            $('#reg').css('display', 'none');
            $('#soc').css('display', 'none');
            $('#regdiv').css('display', 'none');
            $('#advanced').html('Selected');
            $('#regular').html('Select');
            $('#social').html('Select');
            $('#camptype').html('Advanced Campaign');
            $('#camptitle').html('Advanced Campaign');
            $('#smartwizard').smartWizard("next");
            $('#camptype').val(typee);
            $('body').scrollTo('420px', 800);
        }
        if(typee=='social'){
            $('#soc').css('display', 'block');
            $('#reg').css('display', 'none');
            $('#adv').css('display', 'none');
            $('#social').html('Selected');
            $('#regular').html('Select');
            $('#advanced').html('Select');
            $('#camptype').html('Social Campaign');
            $('#camptitle').html('Social Campaign');
            $('#smartwizard').smartWizard("next");
            $('#camptype').val(typee);
        }

    });

    $('#campaign').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'requests/campaigns/add.php',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data){
                if(data==1){
                    $.notify("Campaign has been created successfully..", "success");
                }
                $('#result').html("");
               //$.notify("Uploading..", "info");
                window.setTimeout(function () {
                        location.reload();
                        $('#result').html(data);
                        }, 2000);
            }
        })
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
            theme: 'circles',
            transitionEffect:'fade',
            anchorSettings: {
                        markDoneStep: true, // add done css
                        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                    }
         });

    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
       // var elmForm = $("#form-step-" + stepNumber);
        //alert(stepNumber);
        if((stepNumber===0) && (stepDirection==='forward') ){
            if($('#grpname').val()==''){
                $('#errorname1').css('display', 'block');
                $('#errorname1').html('Please Fill the Campaign name');
                return false;
            }
            else {
                $('#errorname1').css('display', 'none');
                $('.sw-btn-next').css('display', 'none');
            }

        }
        else {
            $('.sw-btn-next').css('display', 'block');
        }
        if((stepNumber===2) && (stepDirection==='forward') ){

            if(($('#textarea').val()=='') && ($('#groups').val()=='')){

              $('#errorname').css('display', 'block');
              $('#errorname').html('Please Choose at least a group and fill the SMS Body !!');
              return false;
            }
            if(($('#textarea').val()!='') && ($('#groups').val()=='')){
                // alert($('#groups').val());
                $('#errorname').css('display', 'block');
                $('#errorname').html('Please Choose at least a group');
                return false;
            }
            if(($('#textarea').val()=='') && ($('#groups').val()!='')){
                // alert($('#groups').val());
                $('#errorname').css('display', 'block');
                $('#errorname').html('Please fill the SMS Body !!');
                return false;
            }
            if(($('#textarea').val()!='') && ($('#groups').val()!='')){
                // alert($('#groups').val());
                $('#errorname').css('display', 'none');
                $('#errorname').html('');
               // return false;
            }
            $('#campgroups').val($('#groups').val());
        }
        return true;
    });
    $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
        // Enable finish button only on last step
        //alert(stepNumber);
        if(stepNumber==4){
            $('#scampname').html($('#grpname').val());
            $('#scamptype').html(typee);
            var groups= $('#groups').find(":selected").text();;
            $('#scampgroups').html(groups);
            $('#scampbody').html($('#textarea').val());
            $('#scampdate').html($('#datetimepicker5').val());
        }

        if(stepNumber == 4){
            $('.sw-btn-next').css('display', 'none');
           // $('.sw-btn-prev').css('display', 'none');
            //$('.btn-n').removeClass('disabled');
        }
    });

    });
  </script>
<?php //include('includes/footer.php'); ?>
