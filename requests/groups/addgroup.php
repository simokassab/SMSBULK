<?php
ob_start();
session_start();
include_once('../../classes/groups.php');
$gr= new groups();
if((isset($_GET['name_'])) && (isset($_GET['description_']))) {
    $gr_add=$gr->insert($_GET['name_'], $_GET['description_'], $_SESSION['user_id']);
    echo $gr_add;
}

?>