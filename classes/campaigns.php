<?php
    include_once ('db_connect.php');

    class campaigns
    {

        function insert($name, $type, $sendingtype,  $user_id, $sender_id, $grs_id, $sending_date, $priority, $credits, $status, $filter)
        {
            $mysqli = getConnected();
            $query = "INSERT INTO campaigns VALUES (NULL, '$name', '$type', '$sendingtype',  '$user_id', '$sender_id', '$grs_id', '$sending_date', '$priority', '$credits',  NOW(), 1, '$status', $filter)";
            //echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }


        function delete($id)
        {
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("UPDATE  campaigns set active=0 WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
        }

        function update($id, $name, $land_id)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET name="' . $name . '", land_id="' . $land_id . '" WHERE id=' . $id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateStatus($id, $status)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET status="' . $status . '" WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateGroup($id, $grs_id)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET GRS_ID_FK="' . $grs_id . '" WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateSendingType($id, $send)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET sendingtype="' . $send . '" WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateSendingDate($id, $date)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET sending_date="' . $date . '" WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateCredits($id, $credits)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET credits=' . $credits . ' WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updateSender($id, $sender)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET SENDER_FK_ID=' . $sender . ' WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function updatePriority($id, $priority){
            $mysqli = getConnected();
            $sql = ' UPDATE campaigns SET priority=' . $priority . ' WHERE id=' . $id.' and active=1';
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getAll()
        {
            $mysqli = getConnected();
            $sql = "Select * FROM campaigns where active=1";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getAllSocial($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, campaigns.status as CMP_STATUS, campaigns.created_at FROM campaigns
                    where campaigns.active=1 and campaigns.type='social' and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }
        function getAllview($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, campaigns.status as CMP_STATUS, campaigns.approved as approved, campaigns.created_at, 
                    SUBSTRING_INDEX(body, '?', 1) as body, 
                    queue.date, sender.name as S_NAME FROM campaigns 
                    LEFT JOIN queue ON campaigns.id=queue.CAMP_ID_FK INNER JOIN sender ON campaigns.SENDER_FK_ID=sender.id where campaigns.active=1 and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getScheduledview($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, 
            campaigns.status as CMP_STATUS, campaigns.created_at, SUBSTRING_INDEX(body, '?', 1) as body, queue.date, sender.name as S_NAME
            FROM campaigns LEFT JOIN queue  ON campaigns.id=queue.CAMP_ID_FK INNER JOIN sender ON campaigns.SENDER_FK_ID=sender.id 
            where campaigns.sending_date> NOW() and campaigns.active=1 and campaigns.approved=1 and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getPendingCampaign($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, 
            campaigns.status as CMP_STATUS, campaigns.created_at, SUBSTRING_INDEX(body, '?', 1) as body, queue.date,  sender.name as S_NAME
            FROM campaigns LEFT JOIN queue  ON campaigns.id=queue.CAMP_ID_FK INNER JOIN sender ON campaigns.SENDER_FK_ID=sender.id 
            where (campaigns.status='ONGOING' or campaigns.status='SOCIAL')  and campaigns.active=1 and campaigns.approved=0 and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getSentview($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, 
            campaigns.status as CMP_STATUS, campaigns.created_at, SUBSTRING_INDEX(body, '?', 1) as body, queue.date,  sender.name as S_NAME
            FROM campaigns LEFT JOIN queue  ON campaigns.id=queue.CAMP_ID_FK INNER JOIN sender ON campaigns.SENDER_FK_ID=sender.id 
            where (campaigns.status='SENT' or campaigns.status='SOCIAL')  and campaigns.active=1 and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getDeletedCampaigns($user_id)
        {
            $mysqli = getConnected();
            $sql = "SELECT DISTINCT campaigns.name, campaigns.id, campaigns.type, 
            campaigns.status as CMP_STATUS, campaigns.created_at, SUBSTRING_INDEX(body, '?', 1) as body, queue.date,  sender.name as S_NAME
            FROM campaigns LEFT JOIN queue  ON campaigns.id=queue.CAMP_ID_FK INNER JOIN sender ON campaigns.SENDER_FK_ID=sender.id 
            where campaigns.active=0  and campaigns.US_ID_FK=$user_id";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getRowByID($id)
        {
            $mysqli = getConnected();
            $query = "SELECT * FROM campaigns WHERE id = " . $id;
            //echo $query;
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_row($result);
            return $row;
        }

        function getCountCampaigns($user_id)
        {
            $mysqli = getConnected();
            $query = "select count(id) as NB, type from campaigns WHERE campaigns.active=1 and US_ID_FK=$user_id group by type";
            //echo $query;
            $Rslt = mysqli_query($mysqli, $query);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            }

        }
    }

?>