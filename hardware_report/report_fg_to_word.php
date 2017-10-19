<?php
		include "connect_db.php";
		$fieldName = $_GET['fieldName'];
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
		$time_start = $_GET['time_start'];
	    $time_end = $_GET['time_end'];
	    $time = '';
		$gate = $_GET['gate'];
		$type = $_GET['type'];
		$type_gate = '';
		$type_human = '';
			$sort_by_text = $_GET['sort_by'];
			$sort_by = '';
			$sort_by = "AND (re_fg_mem_id LIKE '%".$sort_by_text."%' OR re_fg_mem_name LIKE '%".$sort_by_text."%')"; 

		$num_type1 = 0;
		$sql_type1 = "SELECT DISTINCT re_fg_mem_type FROM report_barrier";
		$query_type1 = mysqli_query($conn,$sql_type1);
		$res_type1 = mysqli_fetch_all($query_type1,MYSQLI_BOTH);
		foreach ($res_type1 as $key_type1 => $value_type1) {
			$num_type1++;
			if($type == $num_type1 ){$type_human = "AND re_fg_mem_type = '".$value_type1['re_fg_mem_type']."'"; }
		}

		if($gate == 'in_gate'){$type_gate = "AND re_fg_in_out like '%IN'"; }
		else if($gate == 'out_gate'){$type_gate = "AND re_fg_in_out like '%OUT'"; }
		if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(re_fg_datetime,12,5) BETWEEN '$time_start' AND '$time_end')"; }
		if($startdate == $enddate){
			$sql_fg1 = "SELECT re_fg_datetime,re_fg_in_out,re_fg_mem_id,re_fg_mem_name,re_fg_mem_type FROM report_barrier WHERE re_fg_datetime LIKE '$startdate%' ".$time.$type_gate.$type_human.$sort_by." ORDER BY re_fg_datetime DESC";
			$query_fg = mysqli_query($conn,$sql_fg1);
			$sql_fg = mysqli_fetch_all($query_fg,MYSQLI_BOTH);
		}
		else{
			$sql_fg1 = "SELECT re_fg_datetime,re_fg_in_out,re_fg_mem_id,re_fg_mem_name,re_fg_mem_type FROM report_barrier WHERE (re_fg_datetime BETWEEN '$startdate' AND '$enddate') ".$time.$type_gate.$type_human.$sort_by." ORDER BY re_fg_datetime DESC";
			$query_fg = mysqli_query($conn,$sql_fg1);
			$sql_fg = mysqli_fetch_all($query_fg,MYSQLI_BOTH);
		}

header("Content-type: application/octet-stream");
header("content-disposition: attachment;filename=".$startdate.$enddate.".doc"); 
?>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<title>title</title>

</head>
<body>

<div align="center"><h1>รายงานเข้า-ออกห้องสมุด</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
			<tr>
				<th>ลำดับ</th>
				<?php 
		          	foreach ($fieldName as $value_fieldName1) {
			            if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
			            if($value_fieldName1 == 2){ echo "<th>รหัสสมาชิก</th>"; }
			            if($value_fieldName1 == 3){ echo "<th>ชื่อ-นามสกุล</th>"; }
			            if($value_fieldName1 == 4){ echo "<th>ประเภทสมาชิก</th>"; }
			            if($value_fieldName1 == 5){ echo "<th>ประเภทผ่านประตู</th>"; }
		          }
		        ?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_fg as $key => $value_fg) {
					$num++;
			?>
			<tr>
				<td align="center"><?php echo $num; ?></td>
				<?php 
		          	foreach ($fieldName as $value_fieldName2) {
			            if($value_fieldName2 == 1){ echo "<td>".$value_fg['re_fg_datetime']."</td>"; }
			            if($value_fieldName2 == 2){ echo "<td>".$value_fg['re_fg_mem_id']."</td>"; }
			            if($value_fieldName2 == 3){ echo "<td>".$value_fg['re_fg_mem_name']."</td>"; }
			            if($value_fieldName2 == 4){ echo "<td>".$value_fg['re_fg_mem_type']."</td>"; }
			            if($value_fieldName2 == 5){ 
			              	if(strpos(strtolower($value_fg['re_fg_in_out']), 'in') !== false ){
			                	echo "<td>เข้า</td>"; 
			              	}else{ 
			                	echo "<td>ออก</td>"; 
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