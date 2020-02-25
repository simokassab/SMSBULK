<script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
            <script>
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split("&"),
                    sParameterName,
                    i;
                if(sPageURL==""){
                    return "null";
                }
                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split("=");
        
                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === null ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };
            $(document).ready(function (e) {
                var tokenid=getUrlParameter("t");
                //alert(tokenid);
                $("#tokenid").val(tokenid);
        
            });
        </script>
           <script   src="landingpage.js"   crossorigin="anonymous"></script>
                 <meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><style>* { box-sizing: border-box; } body {margin: 0;}@media (max-width: 667px){.c1238{padding:2%!important;max-width:97% !important;min-width:77% !important;margin-left:1%;min-height:10%!important;width:490.7815px;}}</style><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"/><link rel="stylesheet" href="../css/grapsjs.css"/><div class="jumbotron text-center"><img src="./templates/logo.png" alt="header" class="img-fluid"/></div><div class="row"><div class="col-xs-12 co"><img src="http://placehold.it/350x250/78c5d6/fff/image1.jpg" class="c1238"/></div></div><div class="container"><div class="row"><div class="col-sm-6"><div class="embed-responsive embed-responsive-16by9"><iframe src="https://www.youtube.com/embed/v64KOxKVLVg" class="embed-responsive-item"></iframe></div></div><div class="col-sm-6"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Lorem ipsum dolor sit amet, consectetur adipisicing elit...Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. </p></div></div></div><input type='hidden' id='filename' value='THLZ'><input type='hidden' id='tokenid' ><script   src="youtube.js"  crossorigin="anonymous"></script>