<?php
ob_start();
session_start();
include_once('../../classes/groups.php');
$gr= new groups();
if(isset($_GET['id'])) {
    $gr_add=$gr->delete($_GET['id']);
   // echo $gr_add;
}

?>