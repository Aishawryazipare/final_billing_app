<?php

include 'config.php';

 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
//echo"Success";
}
 $username = $_POST['username'];
 $password = $_POST['password'];
 //echo $username."".$password;exit;
 $Sql_Query = "select * from bil_employees where mobile_no='$username' and android_password='$password'";
 
 $result=mysqli_query($con,$Sql_Query);
 $rowcount=mysqli_num_rows($result);
 if($rowcount>0)
 { 
	while ($obj=mysqli_fetch_object($result))
	{
		$data['lid']=$obj->lid;
		$data['cid']=$obj->cid;
		$data['emp_id']=$obj->id;
	}
	$data['status']="success";
 
 }
 else{
 
 $data['status']="Fail";
 
 }
 echo json_encode($data);
 mysqli_close($con);
?>
