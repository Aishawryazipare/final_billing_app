<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$unit_id = $_POST['Unit_Id'];
$arr[]=json_decode($unit_id,true);
$response=array();
$j=0;
foreach($arr as $row){
	foreach($row as $val){
		$sql = "UPDATE bil_addiunits SET sync_flag=1 WHERE Unit_Id=".$val;

		if (mysqli_query($con, $sql)) {
			$response[$j]="Updated";
		}else {
			$response[$j]="Error";
		}
		$j++;
	}
}
if(in_array("Error", $response,true)) 
{ 
	echo "Error in Updating Units";
}else{ 
	echo "Unit Updated Succesfully"; 
} 

mysqli_close($con);
?>