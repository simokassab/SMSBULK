<?php 

    class users {

        function insert($username, $email, $password, $address, $phone, $company, $photo){
            $query = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`, `phone`, `company`, `photo`, `active`, `created_at`) 
            VALUES (NULL, '$username', '$email', '$password', '$address', '$phone', '$company', '$photo', '1', 'NOW()');";
            //echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $username, $email, $password, $address, $phone, $company, $photo){
            $sql = "UPDATE `users` SET `username` = '$username', `email` = '$email', 
                `password` = '$password', `address` = '$address', `phone` = '$phone', 
                `company` = '$company', `photo` = '$photo' WHERE `users`.`id` = ".$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $sql = "Select * FROM `users` where active=1";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        

        function getRowByID($id){
            $mysqli = getConnected();
            //echo $mysqli;
            $query = "SELECT * FROM users WHERE id = ".$id." and active=1";
           // echo $query;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_assoc($result);
            //print_r($row);
            return $row;
        }

        function deactivate ($id){
            $sql = "UPDATE `users` SET `active` = 0 WHERE `users`.`id` = ".$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }
        
    }

?>