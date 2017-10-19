<?php
include "connect_db.php";
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
		$time_start = $_GET['time_start'];
	    $time_end = $_GET['time_end'];
	    $time = '';
		$number1 = 0;
			$number2 = 0;
			$status1 = $_GET['status'];
			$status = '';
			if( $_GET['status'] != 'all'){
				$res_status1 = site_select_all("DISTINCT status","savedinventory ");
				   foreach ($res_status1 as $key_status1 => $value_status1) {
				   	$number1++;
				   	if($_GET['status'] == $number1){$status = " AND status = '".$value_status1['status']."'";}
				   }
			}
			$area1 = $_GET['area'];
			$area = '';
			if($_GET['area'] != 'all'){
				$area = " AND position_id = '".$_GET['area']."'";
			}

			$group1 = $_GET['group'];
			$group = '';
			if( $_GET['group'] != 'all'){
				$res_group1 = site_select_all("DISTINCT save_id","savedinventory ");
				   foreach ($res_group1 as $key_group1 => $value_group1) {
				   	$number2++;
				   	if($_GET['group'] == $number2){$group = " AND save_id = '".$value_group1['save_id']."'";}
				   }
			}
			if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(date,12,5) BETWEEN '$time_start' AND '$time_end')"; }
			if($startdate == $enddate){
				$sql_mc = site_select_all("tag_id,book_name,position_id,save_id,status,date",
						"savedinventory WHERE date LIKE '$startdate%' ".$time.$status.$area.$group." order by date desc");
			}
			else{
				$sql_mc = site_select_all("tag_id,book_name,position_id,save_id,status,date",
						"savedinventory WHERE (date BETWEEN '$startdate' AND '$enddate') ".$time.$status.$area.$group." order by date desc");
			}
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=mc-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<title>title</title>

</head>
<body>

<div align="center"><h1>รายงานการตรวจสอบหนังสือ</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
		    			<tr>
		    				<th>ลำดับ</th>
		    				<th>วันที่</th>
		    				<th>ชื่อที่บันทึก</th>
		    				<th>รหัสหนังสือ</th>
		    				<th>ชื่อหนังสือ</th>
		    				<th>ตำแหน่ง</th>
		    				<th>สถานะ</th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			<?php
		    				$num = 0;
		    				foreach ($sql_mc as $key => $value_mc) {
		    					$num++;
		    			?>
		    			<tr>
		    				<td><?php echo $num; ?></td>
		    				<td><?php echo $value_mc['date']; ?></td>
		    				<td><?php echo $value_mc['save_id']; ?></td>
		    				<td><?php echo $value_mc['tag_id']; ?></td>
		    				<td width="20%"><?php echo $value_mc['book_name']; ?></td>
		    				<td>
		    					<?php 
		    						$res_position = site_select("position_name","positions WHERE position_id = '".$value_mc['position_id']."'"); 
		    						echo $res_position['position_name'];
		    					?>
		    				</td>
		    				<td><?php echo $value_mc['status']; ?></td>
		    			</tr>
		    			<?php } ?>
		    		</tbody>
      </table>
</body>
</html>