<?php
	include "connect_db.php";
	
	$fieldName = $_GET['fieldName'];
	$startdate = $_GET['start'];
	$enddate = $_GET['end'];
	$machine1 = $_GET['machine'];
	$machine = ''; 

	if($_GET['machine'] != 'all_machine'){$machine = "AND re_sg_count_station_id = '".$machine1."'"; }
	if($startdate == $enddate){
		$sql_sg_count1 = "SELECT re_sg_count_station_id,re_sg_count_date,re_sg_count FROM report_security_gate_count WHERE re_sg_count_date LIKE '$startdate%' ".$machine." order by re_sg_count_date desc";
		$query_sg_count = mysqli_query($conn,$sql_sg_count1);
		$sql_sg_count = mysqli_fetch_all($query_sg_count,MYSQLI_BOTH);
	}
	else{
		$sql_sg_count1 = "SELECT re_sg_count_station_id,re_sg_count_date,re_sg_count FROM report_security_gate_count WHERE (re_sg_count_date BETWEEN '$startdate' AND '$enddate') ".$machine." order by re_sg_count_date desc";
		$query_sg_count = mysqli_query($conn,$sql_sg_count1);
		$sql_sg_count = mysqli_fetch_all($query_sg_count,MYSQLI_BOTH);
	}
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=sg_count-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายงานคนผ่านประตู Security gate</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
			<tr>
				<th>ลำดับ</th>
				<?php 
					foreach ($fieldName as $value_fieldName1) {
						if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
		    			if($value_fieldName1 == 2){ echo "<th>หมายเลขเครื่อง</th>"; }
		    			if($value_fieldName1 == 3){ echo "<th>จำนวน</th>"; }
		    		}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_sg_count as $key => $value_sg_count) {
					$num++;
			?>
			<tr>
				<td><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td>".$value_sg_count['re_sg_count_date']."</td>"; }
		    			if($value_fieldName2 == 2){ echo "<td>".$value_sg_count['re_sg_count_station_id']."</td>"; }
		    			if($value_fieldName2 == 3){ echo "<td>".$value_sg_count['re_sg_count']."</td>"; }
		    		}
				?>
			</tr>
			<?php } ?>
		</tbody>
  </table>
</body>
</html>