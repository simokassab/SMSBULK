<body class='bg'>
<div class="wrapper">
        <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header"><a href='index.php'>
            <img src='img/logo@4x.png' class='img-responsive' style='width:80%;'></a>
        </div>
        <ul class="list-unstyled components">
            <li class='hov' id='grp'>
                <a href="groups.php" >
                <i class="fas fa-users" style='font-size:30px;' ></i>
                    Groups
                </a>
            </li>
                <li class='hov' id='cont'>
                <a href="contacts.php">
                    <i class="fas fa-user-circle " style='font-size:30px;' ></i>
                    Contacts
                </a>
            </li>
            <li class='hov' id='camp'>
                <a href="campaigns.php"  >
                    <i class="fas fa-bullhorn " style='font-size:30px;' ></i>
                    Campaigns
                </a>
            </li>
            <li class='hov'>
                <a href="reports.php" id='rep' >
                    <i class="fas fa-chart-line " style='font-size:30px;' ></i>
                    Reports
                </a>
            </li>   
        </ul> 
        <div class='foot small'>Powered By:
            <img src='img/homelogo.png' style='width:100px;'></img>
        </div>
    </nav>
    
    <!-- Page Content Holder -->
    <div id="content">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span></span>
            </button>
            <ul id="nav">
            <li><a href="#"><img src='<?php echo $_SESSION['photo'] ?>' class='img-responsive image--cover'><br/>Me&nbsp;<i class="fas fa-sort-down"></i></a>
                <ul class='submen' id='subb'>  
                <li><a href="profile.php">Profile</a></li>
                <li><a href="changepassword.php"  >Change Password</a></li>
                <li><a href="#" id='logout' >Logout</a></li>
                </ul>
            </li>

        </ul><br/><br/>
    <hr/>
<script>
$(document).ready(function () {
    $('#nav > li').on('click', function () {
       // alert('dsda');
       $('.image--cover').css('border', '3px solid #0580BC');
        $('#subb').slideToggle( "fast", function(){
            $('.image--cover').css('border', 'none');
        });
     });
        var res = $(location).attr('href');

        if(res.indexOf("groups") >= 0){
            console.log('groups');
            $('#grp').addClass('active');
            $(document).prop('title', 'Groups');
        }
        else if (res.indexOf("contact") >= 0) {
            console.log('contact');
            $('#cont').addClass('active');
            $(document).prop('title', 'Contacts');
        }
        else if (res.indexOf("campaign") >= 0) {
            console.log('camp');
            $('#camp').addClass('active');
            $(document).prop('title', 'Campaigns');
        }
        else if (res.indexOf("report") >= 0) {
            $('#rep').addClass('active');
            $(document).prop('title', 'Reports');

        }
    $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
    
            
            $('#logout').on('click', function () {
                event.preventDefault();
                $.notify("You will be logged out ..", "info");
                window.setTimeout(function () {
                    location.href = "requests/logout.php";
                }, 1500);
            });
            $("[rel='tooltip']").tooltip();
        });
</script>