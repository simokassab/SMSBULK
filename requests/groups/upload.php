<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
include_once('../../classes/groups.php');
$cr= new contacts();
$gr= new groups();//create the group and return the id
$gr_add=$gr->insert($_POST['grpname'], "", $_SESSION['user_id']);
$result="";
    if(isset($_FILES['excel']) && $_FILES['excel']['error']==0) {
        require_once "../../PHPExcel-1.8/Classes/PHPExcel.php";
        $tmpfname = $_FILES['excel']['tmp_name'];
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();
        $errors=array();
        $good=array();
        for ($row = 2; $row <= $lastRow; $row++) {
            $msisdn=$worksheet->getCell('A'.$row)->getValue();
            $fname=$worksheet->getCell('B'.$row)->getValue();
            $lname=$worksheet->getCell('C'.$row)->getValue();
            $email=$worksheet->getCell('D'.$row)->getValue();
            $gender=$worksheet->getCell('E'.$row)->getValue();
            $address=$worksheet->getCell('F'.$row)->getValue();
            if ( filter_var($msisdn, FILTER_VALIDATE_INT) === false ) {
                $errors[].='Error in Line '.$row;
            }
            else {
                $cr_add=$cr->insert($fname, $lname, $email, $address, $gender, $gr_add.",", $msisdn, $_SESSION['user_id']);
                $good[].=$msisdn;
            }
        }
        $result.="<h3 style='text-align:center;color: green;'>".sizeof($good)." Rows have been Imported successfully</h3><br/>" ;
        $result.="<h3 style='text-align:center; color: red;'>Errors:</h3><br/><ul>" ;
        foreach($errors as $er){
            $result.="<li>".$er."</li>";
        }
        $result.="</ul>";
       // echo sizeof($good)."" ;
      //  print_r($errors);
    }
    else {
        $result= "Error Uploading... please check the support";
    }

    echo $result;
    ?>  