<?php 
    include_once ('db_connect.php');

    class contacts {

        function insert($fname, $lname, $email, $address, $gender, $groups, $msisdn, $user_id){
            $mysqli = getConnected();
            $query = "INSERT INTO contacts_$user_id VALUES (NULL, '$fname', '$lname', '$email', '$gender', '$address', '$msisdn', '$groups', NOW(), 1)";
           // echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id, $user_id){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("UPDATE contacts_$user_id SET active=1 WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($fname, $lname, $email, $address, $gender, $groups, $msisdn, $user_id, $id){
            $mysqli = getConnected();
            $sql = ' UPDATE contacts_'.$user_id.' SET firstname="'.$fname.'", lastname="'.$lname.'", email="'.$email.'", 
            address="'.$address.'", gender="'.$gender.'", GRS_ID_FK="'.$groups.'", MSISDN="'.$msisdn.'" WHERE id='.$id;
            echo $sql;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function updateGrInContact($gr_id, $user_id, $id){
            $mysqli = getConnected();
            if($gr_id==""){
                $sql = ' UPDATE contacts_'.$user_id.' SET active=0 WHERE id='.$id;
            }
            else {
                $sql = ' UPDATE contacts_'.$user_id.' SET  GRS_ID_FK="'.$gr_id.'" WHERE id='.$id;
            }
           // echo $sql."<br/>";
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll($userid){
            $mysqli = getConnected();
            $sql = "Select * FROM `contacts_$userid` where active=1";
           // echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);
            if($Rslt) {
                $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
                return $rows;
            }
            else {
                return "";
            }
            
        }
        
        function getRowByGRID($gr_id, $userid){
            $mysqli = getConnected();
            $query = "SELECT * FROM contacts_$userid WHERE GRS_ID_FK LIKE '%".$gr_id.",%'  and active=1";
            //echo $query;
            $Rslt = mysqli_query($mysqli,$query);

            $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
            return $rows;
            return $row;
        }

        function getRowByID($id, $userid){
            $mysqli = getConnected();
            $query = "SELECT * FROM contacts_$userid WHERE id = ".$id." and active=1";
            $result = mysqli_query($mysqli, $query);
            $row=mysqli_fetch_assoc($result);
            return $row;
        }

        function getRowByUserID($user_id){
            $query = "SELECT * FROM groups WHERE US_ID_FK = ".$user_id." and active=1";
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>