<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$newaray2=array();
if($count=mysqli_num_rows(mysqli_query($con,"SELECT * FROM bil_inventory WHERE sync_flag=0"))>5){
	$flag1["count"]="More";
	array_push($newaray2,$flag1);
}else{
	$flag1["count"]="Less";
	array_push($newaray2,$flag1);
}
$json_arr=array();
$json_arr["tbl_setting"]=$newaray2;

$sql="SELECT * FROM bil_inventory WHERE sync_flag=0 LIMIT 5";
$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['inventoryid']=$obj->inventoryid;
		$flag['inventorysupid']=$obj->inventorysupid;
		$flag['inventoryitemid']=$obj->inventoryitemid;
		$flag['inventoryitemquantity']=$obj->inventoryitemquantity;
		$flag['inventorystatus']=$obj->inventorystatus;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		$flag['isactive']=$obj->isactive;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
		$flag['sync_flag']=$obj->sync_flag;
		array_push($new_arr,$flag);
    }
  // Free result set
  mysqli_free_result($result);
}
$json_arr["data"]=$new_arr;

echo json_encode($json_arr);
mysqli_close($con);
?>