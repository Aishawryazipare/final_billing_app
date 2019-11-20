<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Firstlimit=$_POST['firstlimt'];
$Secondlimit=$_POST['secondlimit'];
$lid=$_POST['lid'];
$cid=$_POST['cid'];
$empid=$_POST['empid'];
if($lid == 'null'){
	$sql="SELECT * FROM bil_additems WHERE sync_flag=0 AND cid=$cid LIMIT $Firstlimit, $Secondlimit";
}else{
	$sql="SELECT * FROM bil_additems WHERE sync_flag=0 AND cid=$cid AND lid=$lid LIMIT $Firstlimit, $Secondlimit";
}
$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['item_id']=$obj->item_id;
		$flag['item_name']=$obj->item_name;
		$flag['item_rate']=$obj->item_rate;
		$flag['item_dis']=$obj->item_dis;
		$flag['item_disrate']=$obj->item_disrate;
		$flag['item_tax']=$obj->item_tax;
		$flag['item_taxvalue']=$obj->item_taxvalue;
		$flag['item_final_rate']=$obj->item_final_rate;
		$flag['item_category']=$obj->item_category;
		$flag['item_units']=$obj->item_units;
		$flag['item_stock']=$obj->item_stock;
		$flag['item_barcode']=$obj->item_barcode;
		$flag['item_hsncode']=$obj->item_hsncode;
		$flag['is_active']=$obj->is_active;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
		$flag['sub_emp_id']=$obj->sub_emp_id;
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