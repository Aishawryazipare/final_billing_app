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
	$sql="SELECT * FROM bil_addcustomer WHERE sync_flag=0 AND cid=$cid LIMIT $Firstlimit, $Secondlimit";
}else{
	$sql="SELECT * FROM bil_addcustomer WHERE sync_flag=0 AND cid=$cid AND lid=$lid LIMIT $Firstlimit, $Secondlimit";
}

$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['cust_id']=$obj->cust_id;
		$flag['cust_CompanyName']=$obj->cust_CompanyName;
		$flag['cust_name']=$obj->cust_name;
		$flag['address']=$obj->address;
		$flag['mobile_no']=$obj->mobile_no;
		$flag['email_id']=$obj->email_id;
		$flag['cust_companyId_or_GST']=$obj->cust_companyId_or_GST;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		$flag['is_active']=$obj->is_active;
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