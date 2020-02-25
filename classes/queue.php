<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 11/6/2018
 * Time: 3:36 PM
 */
include_once ('db_connect.php');

    class queue {

        function insert($body, $msisdn, $date, $user_id, $camp_id, $sender_id, $status ){
            $mysqli = getConnected();
            $query = "INSERT INTO queue VALUES (NULL, '$body', '$msisdn', '$date', '$user_id', '$camp_id','$sender_id', '$status',  NOW(), 1, '', '' )";
           //  echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function getSingleRowByCampID($camp_id)
        {
            $mysqli = getConnected();
            $query = "SELECT * FROM queue WHERE CAMP_ID_FK=" . $camp_id.' and active=1';
           // echo $query;
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_assoc($result);
            return $row;
        }

        function getSingleRowByCampIdSendType($camp_id, $sendtype)
        {
            $mysqli = getConnected();
            $query = "SELECT * FROM queue WHERE CAMP_ID_FK=" . $camp_id." and body LIKE '%$sendtype%' and active=1";
            // echo $query;
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_assoc($result);
            return $row;
        }

        function getRowByCampID($camp_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT * FROM queue WHERE CAMP_ID_FK=" . $camp_id.' and active=1';
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function deleteByCampID($camp_id){
            $mysqli = getConnected();
            $sql = 'update queue set active=0 where CAMP_ID_FK='.$camp_id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }


    }
?>