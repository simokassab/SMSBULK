<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');
include_once('../../classes/land_page.php');
include_once('../../classes/links.php');
$cmp= new campaigns();
$land_page = new land_page();

$link= new links();
$template=$_POST['template'];
$host= $_SERVER['SERVER_NAME'].'/SMS/vebs/editor.php';
$status='progress';
$camp_id = $cmp->insert($_POST['campname'], $_POST['camptype'], 0,  $status);
$land_page_id = $land_page->insert('', '', '', '', 0, $_SESSION['user_id']);
$parameters='campid='.$camp_id."&landid=".$land_page_id;
$shortlinkid = $link->insert($host, $parameters);
echo $link->getLinkByID($shortlinkid);

?>