<!doctype>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
var _validFileExtensions = [".xls", ".xlsx", ".csv"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
</script>
</head>
<body>
<div class="container">
<?php
if(isset($_FILES['excel']) && $_FILES['excel']['error']==0) {
		require_once "../Classes/PHPExcel.php";
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
               // echo "Your variable is not an integer";
                $errors[].='Error in Line '.$row;
            }
            else {
                $good[].=$msisdn;
            }
        }
        print_r($good);
        print_r($errors);
}
?>
<div class="container">
<form action = "" method = "POST" enctype = "multipart/form-data">
         <input type = "file" name = "excel" onchange="ValidateSingleInput(this)" />
         <input type = "submit"/>
</form>
</div>
</div>

</body>
</html>