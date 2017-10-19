<?php
	include "connect_db.php";
	$id = $_GET['id'];
	$status = $_GET['status'];

	if($status == '0'){
		$update = "UPDATE customer SET cus_status = '1' WHERE cus_id = '$id'";
		$query = mysqli_query($conn1,$update);
		echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_user.php?page=user_detail\">"; 
	}
	else if($status == '1'){
		$update = "UPDATE customer SET cus_status = '0' WHERE cus_id = '$id'";
		$query = mysqli_query($conn1,$update);
		echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_user.php?page=user_detail\">"; 
	}

	else if($status == 'time_drop'){
		$delete_time = "DELETE FROM log_schedule";
		$query = mysqli_query($conn,$delete_time);
		echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_control_sc.php?page=control_sc_schedule\">"; 
	}

	else if($status == 'clear_bin'){
		$delete_time = "DELETE FROM bookbin_now";
		$query = mysqli_query($conn,$delete_time);
		echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_control_bd.php?page=control_bd_checkBin\">"; 
	}
	
?>