<?php
	include "connect_db.php";
    	$id1 = $_POST['id'];
		$name = $_POST['name'];
		$old_username = $_POST['old_username'];
		$username1 = $_POST['username'];
		$position = $_POST['position'];
		$txt_email = $_POST['txt_email'];
		if(count($_POST['media'])>0){
		  $hardware = implode(",",$_POST['media']);
		}
		if(count($_POST['report'])>0){
		  $report = implode(",",$_POST['report']);
		}

    		$sql_array2 = "SELECT cus_username FROM customer WHERE cus_username = '$username1'";
    		$query_array2 = mysqli_query($conn1,$sql_array2);
    		$array2 = mysqli_fetch_all($query_array2,MYSQLI_BOTH);
				if(count($array2) > 0 && $username1 != $old_username)
				{		
					echo "<script>window.top.window.showResult('1');</script>";
				}

				else
				{
				    $update1 = "UPDATE customer SET cus_name = '$name',cus_username = '$username1',cus_position = '$position',cus_email = '$txt_email' WHERE cus_id = '$id1'";
				    $update1_query = mysqli_query($conn1,$update1);
				    $update2 = "UPDATE customer_type SET cus_username = '$username1',cus_hardware_list = '$hardware',cus_report_list = '$report' WHERE cus_id = '$id1'";
				    $update2_query = mysqli_query($conn1,$update2);

					echo "<script>window.top.window.showResult('2');</script>";
				}
?>
<meta charset="utf-8">