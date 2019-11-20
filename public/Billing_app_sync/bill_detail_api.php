<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
echo"Success";
}
$json_array = $_POST['json_array'];
//print_r($json_array);exit;
/*$data=array (
  'data' => 
  array (
    0 => 
    array (
      'item_name' => 'dosa',
      'item_qty' => '2',
      'item_rate' => '4',
      'item_totalrate' => '10',
      'created_at_TIMESTAMP' => '2019-10-24 19:11:09',
      'updated_at_TIMESTAMP' => '2019-10-24 19:11:09',
      'isactive' => '0',
      'cid' => '2',
      'lid' => '0',
      'emp_id' => '4'
    )
  ),
);*/
$data=json_decode($json_array, true); 
//print_r($data); //exit;
foreach($data as $s)
{
	foreach($s as $key=>$value)
	{		$bill_no=$s['bill_no'];
			$item_name= $s['item_name'];
			$item_qty = $s['item_qty'];
			$item_rate = $s['item_rate'];
			$item_totalrate = $s['item_totalrate'];
			$is_active = $s['isactive'];
			$lid = $s['lid'];
			$cid = $s['cid'];
			$emp_id = $s['emp_id'];
			$android_bill_id = $s['android_bill_id'];
		
$Sql_Query = "insert into bil_addbilldetail (bill_no,item_name,item_qty,item_rate,item_totalrate,isactive,lid,cid,emp_id,android_bill_id) values ('$bill_no','$item_name','$item_qty','$item_rate','$item_totalrate','$is_active','$lid','$cid','$emp_id','$android_bill_id') ON DUPLICATE KEY UPDATE android_bill_id='$android_bill_id',bill_no='$bill_no',item_name='$item_name',item_qty='$item_qty',item_rate='$item_rate',item_totalrate='$item_totalrate',isactive='$is_active',lid='$lid',cid='$cid',emp_id='$emp_id'";
//echo $Sql_Query;
//$insert_result= mysqli_query($con,$Sql_Query);
//echo $insert_result;			
	}
	if(mysqli_query($con,$Sql_Query)){
 
	//echo 'Data Inserted Successfully';
 
 }
 else{
 echo 'Try Again';
 
 }	
echo 'Data Synced Successfully';
}
?>
