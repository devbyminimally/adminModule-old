<?php

	include "connect_db.php";
	
	$fieldName = $_GET['fieldName'];
    $startdate = $_GET['start'];
    $enddate = $_GET['end'];
    $time_start = $_GET['time_start'];
    $time_end = $_GET['time_end'];
    $time = '';
    $status = $_GET['status'];
	$status = '';
	if($_GET['status'] == 'Borrow'){$status = "AND re_sg_book_status = 'Borrow'"; }
	else if($_GET['status'] == 'Not_Borrow'){$status = "AND re_sg_book_status = 'Not_Borrow'"; }
	$number2 = 0;
	$group1 = $_GET['group'];
	$group = '';
	if( $_GET['group'] != 'all'){
		$sql_group1 = "SELECT DISTINCT re_sg_book_callno FROM report_security_gate";
		$query_group1 = mysqli_query($conn,$sql_group1);
		$res_group1 = mysqli_fetch_all($query_group1,MYSQLI_BOTH);
		   foreach ($res_group1 as $key_group1 => $value_group1) {
		   	$number2++;
		   	if($_GET['group'] == $number2){$group = " AND re_sg_book_callno = '".$value_group1['re_sg_book_callno']."'";}
		   }
	}
	if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(re_sg_datetime,12,5) BETWEEN '$time_start' AND '$time_end')"; }
	if($startdate == $enddate){
		$sql_sg1 = "SELECT re_sg_datetime,re_sg_book_id,re_sg_book_callno,re_sg_book_name,re_sg_book_status FROM report_security_gate WHERE re_sg_datetime LIKE '$startdate%' ".$time.$status.$group." order by re_sg_datetime desc";
		$query_sg = mysqli_query($conn,$sql_sg1);
		$sql_sg = mysqli_fetch_all($query_sg,MYSQLI_BOTH);
	}
	else{
		$sql_sg1 = "SELECT re_sg_datetime,re_sg_book_id,re_sg_book_callno,re_sg_book_name,re_sg_book_status FROM report_security_gate WHERE (re_sg_datetime BETWEEN '$startdate' AND '$enddate') ".$time.$status.$group." order by re_sg_datetime desc";
		$query_sg = mysqli_query($conn,$sql_sg1);
		$sql_sg = mysqli_fetch_all($query_sg,MYSQLI_BOTH);
	}
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=sg-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายงานหนังสือผ่านประตู</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  	<table border="1" cellspacing="0" width="100%">
    	<thead>
			<tr>
				<th width="5%">ลำดับ</th>
				<?php 
					foreach ($fieldName as $value_fieldName1) {
						if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
		    			if($value_fieldName1 == 2){ echo "<th>รหัสหนังสือ</th>"; }
		    			if($value_fieldName1 == 3){ echo "<th>หมวดหมู่</th>"; }
		    			if($value_fieldName1 == 4){ echo "<th>ชื่อหนังสือ</th>"; }
		    			if($value_fieldName1 == 5){ echo "<th>สถานะ</th>"; }
		    		}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_sg as $key => $value_sg) {
					$num++;
			?>
			<tr>
				<td><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td>".$value_sg['re_sg_datetime']."</td>"; }
		    			if($value_fieldName2 == 2){ echo "<td>".$value_sg['re_sg_book_id']."</td>"; }
		    			if($value_fieldName2 == 3){ echo "<td>".$value_sg['re_sg_book_callno']."</td>"; }
		    			if($value_fieldName2 == 4){ echo "<td>".$value_sg['re_sg_book_name']."</td>"; }
		    			if($value_fieldName2 == 5){ 
		    				if($value_sg['re_sg_book_status'] == 'BORROW'){
		    					echo "<td>ยืมแล้ว</td>"; 
		    				} else{
		    					echo "<td>ยังไม่ถูกยืม</td>";
		    				}
		    			}
		    		}
				?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>