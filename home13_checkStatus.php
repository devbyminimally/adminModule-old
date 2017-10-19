<?php
	include "connect_db.php";
	//print_r($_GET['hw2']);
	$hwConnect = false;
    function ping($host){
        $str = shell_exec('ping '.$host.' -w 1');
        return $str;//loss
    }

    $sg_reader = true;

    foreach ($_GET['hw2'] as $value) {
    	$sql = "SELECT * FROM join_hardware_cmd WHERE hardware_cmd = '$value'";
    	$query = mysqli_query($conn,$sql);
    	while($res = mysqli_fetch_array($query,MYSQLI_BOTH)){
    		if($res['hardware_cmd_name'] == 'ip_address' && !empty($res['hardware_cmd_value'])){
                echo ping($res['hardware_cmd_value']);
    			if(strpos(ping($res['hardware_cmd_value']),"(0% loss)") > 0){
			        $hwConnect = true;
			        if($res['hardware_type'] == 'SG'){
			        	$str = file_get_contents("http://".$res['hardware_cmd_value']);
						$mydata = json_decode($str,true);

						foreach ($mydata['readers'] as $key => $reader) {
							if (strtolower($mydata['readers'][$key]['status']) != 'online') {
								$sg_reader = false;
							}
						}
						if ($sg_reader != true) {
							$update_status = "UPDATE hardware_cmd_set SET hardware_cmd_value = '6' WHERE hardware_cmd = '".$res['hardware_cmd']."' AND hardware_cmd_name = 'status_hw'";
			      			$update_query_status = mysqli_query($conn,$update_status);
			      			echo $res['hardware_type']."--------- warning<br>";
						}else{
							$update_status = "UPDATE hardware_cmd_set SET hardware_cmd_value = '1' WHERE hardware_cmd = '".$res['hardware_cmd']."' AND hardware_cmd_name = 'status_hw'";
			      			$update_query_status = mysqli_query($conn,$update_status);
			      			echo $res['hardware_type']."--------- online<br>";
						}
			        }
                    echo $res['hardware_type']."--------- online<br>";
			    }
			    if(!$hwConnect){
			      	$update_status_printer = "UPDATE hardware_cmd_set SET hardware_cmd_value = '0' WHERE hardware_cmd = '".$res['hardware_cmd']."' AND hardware_cmd_name = 'status_hw'";
			      	$update_query_status_printer = mysqli_query($conn,$update_status_printer);

                    $update_status_printer11 = "UPDATE hardware_cmd_set SET hardware_cmd_value = '0' WHERE hardware_cmd = '".$res['hardware_cmd']."' AND hardware_cmd_name = 'status_hw'";
                    $update_query_status_printer11 = mysqli_query($conn_hk1,$update_status_printer11);
			      	echo $res['hardware_type']."--------- offline<br>";
			    }
    		}
    	}
    	$sql2 = "SELECT * FROM join_hardware_cmd WHERE hardware_cmd = '$value'";
    	$query2 = mysqli_query($conn,$sql2);
    	while($res2 = mysqli_fetch_array($query2,MYSQLI_BOTH)){
    		if($res2['hardware_cmd_name'] == 'status_hw'){
    			if($res2['hardware_cmd_value'] == 1){
                    echo "<script>parent.document.getElementById('status".$value."').innerHTML = \"<i class='fa fa-check-circle fa-2x text-success' data-toggle='tooltip' data-placement='left' title='ใช้งานได้ปกติ'></i>\";</script>";
 
                }elseif ($res2['hardware_cmd_value'] == 0) {
                    echo "<script>parent.document.getElementById('status".$value."').innerHTML = \"<i class='fa fa-times-circle fa-2x text-danger' data-toggle='tooltip' data-placement='left' title='ปิดเครื่อง'></i>\";</script>";
 
                }else{
                    $message_status = '';
                    $status_list1 = explode(',', $res2['hardware_cmd_value']);
                    foreach ($status_list1 as $key => $status_list) {
                        if($status_list == 2){ $message_status = 'สถานะเครื่องพิมพ์ : ฝาเครื่องพิมพ์เปิดอยู่'.$message_status;}
                        if($status_list == 3){ $message_status = 'สถานะเครื่องพิมพ์ : กระดาษพิมพ์ใกล้หมด'.$message_status;}
                        if($status_list == 4){ $message_status = 'สถานะเครื่องพิมพ์ : กระดาษพิมพ์หมด'.$message_status;}
                        if($status_list == 5){ $message_status = 'สถานะเครื่องพิมพ์ : ไม่สามารถเชื่อมต่ออปุกรณ์ได้'.$message_status;}
                        if($status_list == 6){ $message_status = 'สถานะเครื่องอ่าน RFID : ไม่สามารถเชื่อมต่ออปุกรณ์ได้'.$message_status;}
                        if($status_list == 7){ $message_status = 'สถานะเครื่องอ่านบาร์โค้ด : ไม่สามารถเชื่อมต่ออปุกรณ์ได้'.$message_status;}
                        if($status_list == 8){ $message_status = 'สถานะกล้องบันทึกภาพ : ไม่สามารถเชื่อมต่ออปุกรณ์ได้'.$message_status;}
                        if($status_list == 9){ $message_status = 'สถานะเครื่องอ่านลายนิ้วมือ : ไม่สามารถเชื่อมต่ออปุกรณ์ได้'.$message_status;}
                    }

                    echo "<script>parent.document.getElementById('status".$value."').innerHTML = \"<i class='fa fa-exclamation-triangle fa-2x text-warning' data-toggle='tooltip' data-placement='left' title='".$message_status."'></i>\";</script>";
                }
    		}
    	}	

    }
    
echo "<META http-equiv=\"REFRESH\" content=\"10;\">"; 
?>
