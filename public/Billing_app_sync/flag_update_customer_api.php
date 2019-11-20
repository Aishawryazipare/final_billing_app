<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$cat_id = $_POST['cust_id'];
$arr[]=json_decode($cat_id,true);
$response=array();
$j=0;
foreach($arr as $row){
	foreach($row as $val){
		$sql = "UPDATE bil_addcustomer SET sync_flag=1 WHERE cust_id=".$val;

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
	echo "Error in Updating Categories";
}else{ 
	echo "Customers Updated Succesfully"; 
} 

mysqli_close($con);
?>