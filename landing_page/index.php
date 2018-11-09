<?php
ob_start();
session_start();
include_once ('../classes/land_page.php');
include_once ('../classes/campaigns.php');
include_once ('../classes/links.php');

$links=new links();
$camp= new campaigns();
$land = new land_page();

$campid=mysql_real_escape_string($_POST['campid']);
$htmlcode=$_POST['htmlcode'];
$landid=mysql_real_escape_string($_POST['landid']);
$name='asd';
//$link = 'http://localhost/SMS/c/asd.php';
$expiry_date='2019-01-20';
$published=1;
$parameters='campid='.$campid.'&landid='.$landid;
$host= $_SERVER['SERVER_NAME'].'/SMS/';


$linkid=$links->insertName($host, $parameters);
$shortlink=$links->getLinkByID($linkid);
$name=$shortlink;//landing page name

$land-> update($name, $htmlcode, $_SERVER['SERVER_NAME'].'/SMS/c/'.$name.'.php', $expiry_date, $published, $landid);

$myfile = fopen("../c/".$name.'.php', "w") or die("Unable to open file!");

fwrite($myfile, $htmlcode);
fclose($myfile);


?>

