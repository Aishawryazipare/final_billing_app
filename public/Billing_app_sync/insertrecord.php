<?php
include 'config.php';
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
echo"Success";
}
$company_name = $_POST['reg_companyname'];
$person_name = $_POST['reg_personname'];
$reg_mobileno = $_POST['reg_mobileno'];
$reg_emailid = $_POST['reg_emailid'];
$reg_address = $_POST['reg_address'];
$reg_username = $_POST['reg_username'];
$android_password = $_POST['reg_password'];
$reg_dealercode = $_POST['reg_dealercode'];
$reg_location = $_POST['reg_location'];
$Sql_Query = "insert into bil_registration (reg_companyname,reg_personname,reg_mobileno,reg_emailid,reg_address,reg_username,android_password,reg_dealercode,location) values ('$company_name','$person_name','$reg_mobileno','$reg_emailid','$reg_address','$reg_username','$android_password','$reg_dealercode','$reg_location')";
 
 if(mysqli_query($con,$Sql_Query)){
 
 echo 'Data Inserted Successfully';
 
 }
 else{
 
 echo 'Try Again';
 
 }
 mysqli_close($con);
?>
