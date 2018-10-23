<?php 
include_once ('DB.php');

//function mysqli_(){
   // $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
   // return $mysqli;
//}
function getConnected() {

    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if($mysqli->connect_error) 
      die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
 
    return $mysqli;
 }

?>