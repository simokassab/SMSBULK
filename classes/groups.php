<?php 
    include_once ('db_connect.php');

    class groups {

        function insert($name, $description, $user_id){
            $query = "INSERT INTO groups VALUES (NULL, '$name', '$description', '$user_id', NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $stmt = $mysqli->prepare("DELETE FROM groups WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $description, $user_id){
            $sql = ' UPDATE groups SET name="'.$name.'", description="'.$description.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $mysqli = getConnected();
            $sql = "Select * FROM `groups`";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
            return $rows;
        }
        

        function getRowByID($id){
            $query = "SELECT * FROM groups WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getRowByUserID($user_id){
            $query = "SELECT * FROM groups WHERE US_ID_FK = ".$user_id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>