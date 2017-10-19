<?php
	include "connect_db.php";
		$name = $_POST['name'];
		$user = $_POST['user'];
    	$pass_m = md5($_POST['pass']);
		$position = $_POST['position'];
		$txt_email = $_POST['txt_email'];
		if(count($_POST['media'])>0){
      		$hardware = implode(",",$_POST['media']);
    	}
    	if(count($_POST['report'])>0){
      		$report = implode(",",$_POST['report']);
    	}
    		$sql_array2 = "SELECT cus_username FROM customer WHERE cus_username = '$user'";
    		$query_array2 = mysqli_query($conn1,$sql_array2);
    		$array2 = mysqli_fetch_all($query_array2,MYSQLI_BOTH);
				if(count($array2) > 0)
				{		
					echo "<script>window.top.window.showResult('1');</script>";
				}

				else
				{
				  $res1_sql = "SELECT cus_orga,cus_geo,cus_province,cus_db FROM customer WHERE cus_username = '$username'";
				  $res1_query = mysqli_query($conn1,$res1_sql);
				  $res1 = mysqli_fetch_array($res1_query,MYSQLI_BOTH);
			      $cus_orga = $res1['cus_orga'];
			      $cus_geo = $res1['cus_geo'];
			      $cus_province = $res1['cus_province'];
			      $cus_db = $res1['cus_db'];

			      $insert_sql = "INSERT INTO customer (cus_name,cus_orga,cus_email,cus_position,cus_geo,cus_province,cus_db,cus_m_password,cus_username,cus_type,cus_status) VALUES ('$name','$cus_orga','$txt_email','$position','$cus_geo','$cus_province','$cus_db','$pass_m','$user','staff','0')";
			      $insert_query = mysqli_query($conn1,$insert_sql);
			      
			      $res2_sql = "SELECT cus_id FROM customer WHERE cus_username = '$user'";
			      $res2_query = mysqli_query($conn1,$res2_sql);
			      $res2 = mysqli_fetch_array($res2_query,MYSQLI_BOTH);
			      $cus_id = $res2['cus_id'];

			      $insert_sql2 = "INSERT INTO customer_type (cus_id,cus_username,cus_type,cus_hardware_list,cus_report_list) VALUES('$cus_id','$user','staff','$hardware','$report')";
			      $insert_query2 = mysqli_query($conn1,$insert_sql2);

					echo "<script>window.top.window.showResult('2');</script>";
				}
?>
<meta charset="utf-8">