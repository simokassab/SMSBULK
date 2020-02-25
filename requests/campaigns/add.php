<?php
ob_start();
session_start();
/***********************
echo $_POST['point'];
echo $_POST['grpname'];// campname
echo $_POST['datetimepicker5']; // date
echo $_POST['camptype']; //
echo $_POST['campgroups']; // groups
echo $_POST['textarea']; //body sms
echo $_POST['point'];

****************/

header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');
include_once('../../classes/queue.php');
include_once('../../classes/contacts.php');
include_once('../../classes/credits.php');
$body='';
$camp_id=$_POST['linkcampid'];
$date=$_POST['datetimepicker5'];
// echo $date;
$status='ONGOING';
$cmp= new campaigns();
$con= new contacts();
$queue= new queue();
$credit = new credits();
$credits=$credit->getRowByUserID($_SESSION['user_id']);
// echo $credits[1];
$contacts=array();
$co=array();
$where='';
$result ='';
$body1='';
$grps=$_POST['campgroups']; //posted groups
$groups = $_POST['groups'];
$grs='';
foreach ($groups as $g){
    $grs.=$g.',';
}
//echo $grs;
$sender=$_POST['sender'];
$user_id=$_SESSION['user_id'];
if($camp_id !=''){ // advanced
    $body=$_POST['textarea1'];
    if($_POST['credits_'] > $credits[1] ){
        $result = 'NOK';
    }
    else {
        $cmp->updateStatus($camp_id, 'ONGOING');
        $cmp->updateSendingType($camp_id, $_POST['sendingtype']);
        $cmp->updateSendingDate($camp_id, $_POST['datetimepicker5']);
        $cmp->updateSender($camp_id, $sender);
        $cmp->updateCredits($camp_id, $_POST['credits_']);
        $cmp->updatePriority($camp_id, $_POST['priority']);
        $cmp->updateGroup($camp_id, $grs);
       // $credit->insertLogs($_POST['credits_'],$_SESSION['user_id']);
        //$credit->update($_POST['credits_'],$_SESSION['user_id']);
        $text = 'New campaign has been added: https://smscorp.iq.zain.com/SMS/CMS/public/campaigns/'.$camp_id.'/edit';
        $response = file_get_contents('http://localhost:8800/PhoneNumber=9647802969673&sender=smscorp&text='.urlencode($text).'&SMSCROute=SMPP%20-%20172.16.36.50:31113');
       // echo $response;
        $result='OK';
    }
}
else { // regular
    $body=$_POST['textarea'];
    if($_POST['credits_'] > $credits[1] ){
        $result = 'NOK';
    }
    else {
        if($_SESSION['filter']==0) {
            $camp_id = $cmp->insert($_POST['grpname'], $_POST['camptype'], '', $_SESSION['user_id'], $sender,
                $grs, $_POST['datetimepicker5'],$_POST['priority'] ,$_POST['credits_'] ,  $status, 0);
            $text = 'New campaign has been added: https://smscorp.iq.zain.com/SMS/CMS/public/campaigns/'.$camp_id.'/edit';
            $response = file_get_contents('http://localhost:8800/PhoneNumber=9647802969673&sender=smscorp&text='.urlencode($text).'&SMSCROute=SMPP%20-%20172.16.36.50:31113');
           // echo "1";
            //insert new campaign and get the inserted id

        }
        else {
            $camp_id = $cmp->insert($_POST['grpname'], $_POST['camptype'], '', $_SESSION['user_id'], $sender,
                $grs, $_POST['datetimepicker5'],$_POST['priority'], $_POST['credits_'], $status, 1);
            $credit->insertLogs($_POST['credits_'], $_SESSION['user_id']);
            $credit->update($_POST['credits_'], $_SESSION['user_id']);
           // echo "2";
        }
        $result = 'OK';
    }
    //
}

//if($_SESSION['filter']==1){
    if (strpos($grps, ',') !== false) {
        //$groups=split(',', $grps);
        $groups = explode(",", $grps);
    // print_r($groups);
        foreach($groups as $gr){
            $where.=" GRS_ID_FK like '%".$gr.",%' OR";

        }
        $where=preg_replace('/OR$/', '', $where);
        $where.=" )";
       // echo "where:".$where;
        $contacts=$con->getMSISDNByGRID($user_id, $where);
    }
    else {
        $where="GRS_ID_FK like '%".$grps.",%'";
       // echo "where1:".$where;
        $where.=" )";
        $contacts = $con->getMSISDNByGRID($user_id, $where);
    }
    //print_r($contacts);
    foreach($contacts as $contact){
        if($_POST['sendingtype']=="customized"){
            $body1 = str_replace('xxxxxx', $contact['TOK'], $body);
            if($_SESSION['filter']==0) {
                $queue->insert($body1, $contact['MSISDN'], $date, $user_id, $camp_id, $sender, '-1');
            }
            else {
               // echo "ddd";
                $queue->insert($body1, $contact['MSISDN'], $date, $user_id, $camp_id, $sender, '0');
            }
        }
        else {
            if($_SESSION['filter']==0) {
              //  echo "ddd";
                $queue->insert($body, $contact['MSISDN'], $date, $user_id, $camp_id, $sender, '-1');
            }
            else {
              //  echo "ddd";
                $queue->insert($body, $contact['MSISDN'], $date, $user_id, $camp_id, $sender, '0');
            }
        }
    }

echo $result;
?>