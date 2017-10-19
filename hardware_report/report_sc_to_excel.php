<?php
	if(!isset($_SESSION)){
	    session_start();
	}
	include "connect_db.php";
	if($_SESSION['lang'] == "en"){
	 	include "lang_en.php";
	}
	else{
	 	include "lang_th.php";
	}

	$fieldName = $_GET['fieldName'];
	$startdate = $_GET['start'];
	$enddate = $_GET['end'];
	$status1 = $_GET['status'];
	$status = '';
	if( $_GET['status'] != 'all'){
		$status = " AND re_sc_book_status = '".$_GET['status']."'";
	}

	$type1 = $_GET['type'];
	$type = '';
	if($_GET['type'] != 'all'){
		$type = " AND re_sc_type = '".$_GET['type']."'";
	}

	$group1 = $_GET['group'];
	$group = '';
	if( $_GET['group'] != 'all'){
		$group = " AND re_sc_station_id = '".$_GET['group']."'";
	}

	if($startdate == $enddate){
		$sql_sc1 = "SELECT re_sc_station_id,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE re_sc_date LIKE '$startdate%' ".$status.$type.$group." ";
		$query_sc = mysqli_query($conn,$sql_sc1);
		$sql_sc = mysqli_fetch_all($query_sc,MYSQLI_BOTH);
	}
	else{
		$sql_sc1 = "SELECT re_sc_station_id,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE (re_sc_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
		$query_sc = mysqli_query($conn,$sql_sc1);
		$sql_sc = mysqli_fetch_all($query_sc,MYSQLI_BOTH);
	}
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=sc-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1><?=$lang_report_sc_1;?></h1></div>
<div align="center"><h3><?=$lang_date;?> <?php echo $startdate; ?> <?=$lang_to; ?> <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
			<tr>
				<th width="5%"><?=$lang_no; ?></th>
			<?php 
				foreach ($fieldName as $value_fieldName1) {
					if($value_fieldName1 == 1){ echo "<th>".$lang_date."</th>"; }
				    if($value_fieldName1 == 2){ echo "<th>".$lang_station_id."</th>"; }
				    if($value_fieldName1 == 3){ echo "<th>".$lang_type."</th>"; }
				    if($value_fieldName1 == 4){ echo "<th>".$lang_member_id."</th>"; }
				    if($value_fieldName1 == 5){ echo "<th>".$lang_member_name."</th>"; }
				    if($value_fieldName1 == 6){ echo "<th>".$lang_book_id."</th>"; }
				    if($value_fieldName1 == 7){ echo "<th>".$lang_book_name."</th>"; }
				    if($value_fieldName1 == 8){ echo "<th>".$lang_due_date."</th>"; }
				    if($value_fieldName1 == 9){ echo "<th>".$lang_status."</th>"; }
				}
			?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_sc as $key => $value_sc) {
					$num++;
			?>
			<tr>
				<td><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td>".$value_sc['re_sc_date']."</td>"; }
						if($value_fieldName2 == 2){ echo "<td>".$value_sc['re_sc_station_id']."</td>"; }
						if($value_fieldName2 == 3){ echo "<td>".$value_sc['re_sc_type']."</td>"; }
						if($value_fieldName2 == 4){ echo "<td>".$value_sc['re_sc_mem_id']."</td>"; }
						if($value_fieldName2 == 5){ echo "<td>".$value_sc['re_sc_mem_name']."</td>"; }
						if($value_fieldName2 == 6){ echo "<td>".$value_sc['re_sc_book_id']."</td>"; }
						if($value_fieldName2 == 7){ echo "<td>".$value_sc['re_sc_book_name']."</td>"; }
						if($value_fieldName2 == 8){ echo "<td>".$value_sc['re_sc_book_due_date']."</td>"; }
						if($value_fieldName2 == 9){ echo "<td>".$value_sc['re_sc_book_status']."</td>"; }
					}
				?>
			</tr>
			<?php } ?>
		</tbody>
  </table>
</body>
</html>