<?php 
?>
<body class='bg'>
<div class="wrapper">
        <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header"><a href='index.php'>
            <img src='img/logo@4x.png' style='width:99%;'></a>
        </div>
        <ul class="list-unstyled components">
            <li class='active'>
                <a href="groups.php">
                <i class="fas fa-users" style='font-size:30px;' ></i>
                    Groups
                </a>
                <li class='hov'>
                <a href="contacts.php">
                    <i class="fas fa-user-circle " style='font-size:30px;' ></i>
                    Contacts
                </a>
            </li>
            <li class='hov'>
                <a href="campaigns.php">
                    <i class="fas fa-bullhorn " style='font-size:30px;' ></i>
                    Campaigns
                </a>
            </li>
            <li class='hov'>
                <a href="reports.php">
                    <i class="fas fa-chart-line " style='font-size:30px;' ></i>
                    Reports
                </a>
            </li>
            </li>
                
        </ul>
        
    </nav>
    
    <!-- Page Content Holder -->
    <div id="content">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fas fa-align-left"></i>
                <span></span>
            </button>
        <ul id="nav">
            <li><a href="#"><img src='<?php echo $_SESSION['photo'] ?>' class='image--cover'><i class="fas fa-chevron-down"></i></a>
                <ul class='submen'>  
                <li><a href="profile.php">Profile</a></li>
                <li><a href="changepassword.php"  >Change Password</a></li>
                <li><a href="#" id='logout' >Logout</a></li>
                </ul>
            </li>

        </ul><br/><br/>
    <hr/>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
            $('#nav > li').each(function(){
                var t = null;
                var li = $(this);
                li.hover(function(){
                    t = setTimeout(function(){
                        li.find("ul").slideDown(300);
                        t = null;
                    }, 300);
                }, function(){
                    if (t){
                        clearTimeout(t);
                        t = null;
                    }
                    else
                        li.find("ul").slideUp(200);
                });
            });
            $('#logout').on('click', function () {
                event.preventDefault();
                $.notify("You will be logged out ..", "info");
                window.setTimeout(function () {
                    location.href = "requests/logout.php";
                }, 1500);
            });
            $("[rel='tooltip']").tooltip();

            $(document).on('click','.create-modal', function() {
                $('#create').modal('show');
                $('.form-horizontal').show();
                $('.modal-title').text('Add Group');
            });
            $(".add_group").click(function() {
                $.ajax({
                type: 'POST',
                url: 'addGroup',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'name': $('input[name=name_]').val(),
                    'description': $('input[name=description]').val()
                },
                success: function(data){
                    if ((data.errors)) {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                    $('.error').text(data.errors.description);
                    } else {
                    $('.error').remove();
                    $('#table').append("<tr class='group" + data.id + "'>"+
                    "<td >" + data.name + "</td>"+
                    "<td>" + data.description + "</td>"+
                    "<td>" + data.created_at + "</td>"+
                    "<td>" + data.active + "</td>"+
                    "<td class='text-center'><button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + 
                    "' data-title='" + data.name + "' data-body='" + data.description + 
                    "'><span class='glyphicon glyphicon-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + 
                    "' data-title='" + data.name + "' data-body='" + data.description + "'><span class='glyphicon glyphicon-trash'></span></button>"+
                    "<a href='#' title='View Contacts' class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-tag' ></i> </td></tr>");
                    }
                },
                });
                $('#name').val('');
                $('#description').val('');
                //$('#create').hide();
            });

            // function Edit POST
            $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text(" Update Post");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Post Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#fid').val($(this).data('id'));
            $('#t').val($(this).data('title'));
            $('#b').val($(this).data('body'));
            $('#myModal').modal('show');
            });

            $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'POST',
                url: 'editGroup',
                data: {
            '_token': $('input[name=_token]').val(),
            'id': $("#fid").val(),
            'name': $('#t').val(),
            'description': $('#b').val()
                },
            success: function(data) {
                $('.group' + data.id).replaceWith(" "+
                "<tr class='group" + data.id + "'>"+
                "<td>" + data.name + "</td>"+
                "<td>" + data.description + "</td>"+
                "<td>" + data.created_at + "</td>"+
                "<td>" + data.active + "</td>"+
            "<td class='text-center'><button class='show-modal btn btn-info btn-sm'  data-id='" + data.id + "' data-title='" + data.name + 
            "' data-body='" + data.description + "'><i class='fa fa-eye'></i></button>&nbsp;<button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-title='" + data.name + 
            "' data-body='" + data.description + "'><span class='glyphicon glyphicon-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + 
            data.id + "' data-title='" + data.name + "' data-body='" + data.description + "'><span class='glyphicon glyphicon-trash'></span></button>"+
            "<a href='#' title='View Contacts' class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-tag' ></i> </td></tr>");
                }
            });
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

            $('.modal-footer').on('click', '.delete', function(){
            $.ajax({
                type: 'POST',
                url: 'deleteGroup',
                data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.id').text()
                },
                success: function(data){
                $('.group' + $('.id').text()).remove();
                }
            });
            });

            // Show function
            $(document).on('click', '.show-modal', function() {
            $('#show').modal('show');
            $('.modal-title').text('');
            $('#i').text($(this).data('id'));
            $('#ti').text($(this).data('title'));
            $('#by').text($(this).data('body'));
           
            });
        });
    </script>