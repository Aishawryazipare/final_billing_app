<?php 


	//$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
    if (isset($_POST)) {
        
		//print_r($_POST);
		$mobileno=$_POST["mobile_no"];
		$password=$_POST["password"];
		$token=$_POST["token"];
		$conn = mysqli_connect("localhost","ipinguser","iPing@321","billing_app");
		if($conn === false){
			die("ERROR: Could not connect. " . mysqli_connect_error());
		}
		
		$sql = "UPDATE bil_employees SET token='".$token."' WHERE mobile_no='".$mobileno."' AND android_password='".$password."'";

		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		
		mysqli_close($conn);		
    }
 ?>