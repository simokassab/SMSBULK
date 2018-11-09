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
    $body=$_POST['textarea'];
    $date=$_POST['datetimepicker5'];
   // echo $date;
    $status='online';
    $cmp= new campaigns();
    $con= new contacts();
    $queue= new queue();
    $contacts=array();
    $result=0;
    //$groups=array();
    $camp_id = $cmp->insert($_POST['grpname'], $_POST['camptype'], 0, $status); //insert new campaign and get the inserted id
    //echo
    $grps=$_POST['campgroups']; //posted groups
    $user_id=$_SESSION['user_id'];

    if (strpos($grps, ',') !== false) {
        $groups=split(',', $grps);
        foreach($groups as $gr){
            //$contacts. = $con->getRowByGRID($gr, $user_id);
            array_push($contacts, $con->getRowByGRID($gr, $user_id));
        }
    }
    else {
       $contacts = $con->getRowByGRID($grps, $user_id);
    }

    if(count($contacts[0])==1){
        foreach($contacts as $contact){
            // print_r($contact);
            foreach ($contact as $c ){
               //  echo "<br/>".$c['MSISDN']."<br>";
                $queue->insert($body, $c['MSISDN'], $date, $user_id, $camp_id );
                $result=1;
            }
            //
        }
    }
    else {
        foreach($contacts as $contact){
           // echo $contact['MSISDN']."<br>";
            $queue->insert($body, $contact['MSISDN'], $date, $user_id, $camp_id );
            $result=1;
        }       //
    }

    echo $result;

?>