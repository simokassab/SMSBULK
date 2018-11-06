<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 11/6/2018
 * Time: 3:36 PM
 */
include_once ('db_connect.php');

    class queue {

        function insert($body, $msisdn, $date, $user_id, $camp_id ){
            $mysqli = getConnected();
            $query = "INSERT INTO queue VALUES (NULL, '$body', '$msisdn', '$date', '$user_id', '$camp_id', NOW() , 'GO')";
           //  echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }
    }
?>