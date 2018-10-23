<?php 
    include_once ('./config/db_connect.php');

    class images {

        function insert($name, $path){
            $query = "INSERT INTO images VALUES (NULL, '$name', '$path', NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $stmt = $mysqli->prepare("DELETE FROM images WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $path){
            $sql = ' UPDATE images SET name="'.$name.'", $path="'.$path.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $sql = "Select * FROM `images`";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        
        function getRowByID($id){
            $query = "SELECT * FROM images WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getRowByName($name){
            $query = "SELECT * FROM images WHERE name ='".$id."'";
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>