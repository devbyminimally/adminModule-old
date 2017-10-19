<?php
		include "connect_db.php";
		$fieldName = $_GET['fieldName'];
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
			$status1 = $_GET['status'];
			$status = '';
			if( $_GET['status'] != 'all'){
				$status = " AND re_ba_book_status = '".$_GET['status']."'";
			}

			$type1 = $_GET['type'];
			$type = '';
			if($_GET['type'] != 'all'){
				$type = " AND re_ba_type = '".$_GET['type']."'";
			}

			$group1 = $_GET['group'];
			$group = '';
			if( $_GET['group'] != 'all'){
				$group = " AND re_ba_station_id = '".$_GET['group']."'";
			}

			if($startdate == $enddate){
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE re_ba_date LIKE '$startdate%' ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
			else{
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE (re_ba_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=ba-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายงานการยืม-คืนผ่านเครื่อง Book ATM</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
			<tr>
				<th width="5%">ลำดับ</th>
			<?php 
				foreach ($fieldName as $value_fieldName1) {
					if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
					if($value_fieldName1 == 2){ echo "<th>รหัสเครื่อง</th>"; }
					if($value_fieldName1 == 3){ echo "<th>ประเภท</th>"; }
					if($value_fieldName1 == 4){ echo "<th>รหัสสมาชิก</th>"; }
					if($value_fieldName1 == 5){ echo "<th>ชื่อสมาชิก</th>"; }
					if($value_fieldName1 == 6){ echo "<th>รหัสหนังสือ</th>"; }
					if($value_fieldName1 == 7){ echo "<th>ชื่อหนังสือ</th>"; }
					if($value_fieldName1 == 8){ echo "<th>วันที่คืน</th>"; }
					if($value_fieldName1 == 9){ echo "<th>สถานะ</th>"; }
				}
			?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_ba as $key => $value_ba) {
					$num++;
			?>
			<tr>
				<td><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td>".$value_ba['re_ba_date']."</td>"; }
						if($value_fieldName2 == 2){ echo "<td>".$value_ba['re_ba_station_id']."</td>"; }
						if($value_fieldName2 == 3){ echo "<td>".$value_ba['re_ba_type']."</td>"; }
						if($value_fieldName2 == 4){ echo "<td>".$value_ba['re_ba_mem_id']."</td>"; }
						if($value_fieldName2 == 5){ echo "<td>".$value_ba['re_ba_mem_name']."</td>"; }
						if($value_fieldName2 == 6){ echo "<td>".$value_ba['re_ba_book_id']."</td>"; }
						if($value_fieldName2 == 7){ echo "<td>".$value_ba['re_ba_book_name']."</td>"; }
						if($value_fieldName2 == 8){ echo "<td>".$value_ba['re_ba_book_due_date']."</td>"; }
						if($value_fieldName2 == 9){ echo "<td>".$value_ba['re_ba_book_status']."</td>"; }
					}
				?>
			</tr>
			<?php } ?>
		</tbody>
  </table>
</body>
</html>