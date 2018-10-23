<?php 
    include_once ('./config/db_connect.php');

    class campaigns {

        function insert($name, $land_id){
            $query = "INSERT INTO campaigns VALUES (NULL, '$name', '$land_id',  NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $stmt = $mysqli->prepare("DELETE FROM campaigns WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $land_id){
            $sql = ' UPDATE campaigns SET name="'.$name.'", land_id="'.$land_id.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $sql = "Select * FROM campaigns";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        

        function getRowByID($id){
            $query = "SELECT * FROM campaigns WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>