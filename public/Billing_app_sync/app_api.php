<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
echo"Success";
}
$json_array = $_POST['json_array'];
//print_r($json_array);//exit;
/*$data=array (
  'data' => 
  array (
    0 => 
    array (
      'bill_date' => '2019-11-12',
      'cust_id' => '2',
      'cash_or_credit' => 'credit',
      'discount' => '10',
      'bill_totalamt' => '456',
      'bill_tax' => '4',
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
		{
			//$bill_no= $s['bill_no'];
			$bill_date = $s['bill_date'];
			$cust_id = $s['cust_id'];
			$cash_or_creadit = $s['cash_or_credit'];
			$discount = $s['discount'];
			$bill_totalamt = $s['bill_totalamt'];
			$bill_tax = $s['bill_tax'];
			$is_active = $s['isactive'];
			$lid = $s['lid'];
			$cid = $s['cid'];
			$emp_id = $s['emp_id'];
			$android_bill_id = $s['android_bill_id'];
			/*$Sql_Query = "insert into tbl_AddBillDetail (bill_no,bill_date,customer_name,cust_id,cash_or_creadit,discount,bill_totalamt,bill_tax,is_active,lid,cid,modify_at,is_active,lid,emp_id) values ('$bill_no','$bill_date','$cust_id','$cash_or_creadit','$discount','$city_id','$bill_totalamt','$bill_tax','$is_active','$lid','$cid','$emp_id','$is_active','$lid','$source_val','$followup_date','$sync_flag','$emp_id','$insert_date','$active_inactive_status','$cat_id','$brand_id','$cid','$lid','$sub_emp_id') ON DUPLICATE KEY UPDATE bill_no='$bill_no', bill_date='$bill_date',cust_id='$cust_id',cash_or_creadit='$cash_or_creadit',discount='$discount',bill_totalamt='$bill_totalamt',bill_tax='$bill_tax',is_active='$is_active',lid='$lid',cid='$cid',emp_id='$emp_id'";*/
$Sql_Query = "insert into bil_AddBillMaster (bill_date,cust_id,cash_or_credit,discount,bill_totalamt,bill_tax,isactive,lid,cid,emp_id,android_bill_id) values ('$bill_date','$cust_id','$cash_or_creadit','$discount','$bill_totalamt','$bill_tax','$is_active','$lid','$cid','$emp_id','$android_bill_id') ON DUPLICATE KEY UPDATE android_bill_id='$android_bill_id',bill_date='$bill_date',cust_id='$cust_id',cash_or_credit='$cash_or_creadit',discount='$discount',bill_totalamt='$bill_totalamt',bill_tax='$bill_tax',isactive='$is_active',lid='$lid',cid='$cid',emp_id='$emp_id'";
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
