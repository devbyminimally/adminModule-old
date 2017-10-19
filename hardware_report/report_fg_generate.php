<?php
	include "connect_db.php";
	$fieldName = $_POST['fieldName'];
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$time_start = $_POST['time_h_start'].":".$_POST['time_m_start'];
	$time_end = $_POST['time_h_end'].":".$_POST['time_m_end'];
	$time = '';
	$gate = $_POST['type_gate'];
	$type = $_POST['type_human'];
	$type_gate = '';
	$type_human = '';

	$sort_by_text = $_POST['sort_by_text'];
	$sort_by = '';
	$sort_by = "AND (re_fg_mem_id LIKE '%".$sort_by_text."%' OR re_fg_mem_name LIKE '%".$sort_by_text."%')"; 

	$num_type1 = 0;
	$sql_type1 = "SELECT DISTINCT re_fg_mem_type FROM report_barrier";
	$query_type1 = mysqli_query($conn,$sql_type1);
	$res_type1 = mysqli_fetch_all($query_type1,MYSQLI_BOTH);
	foreach ($res_type1 as $key_type1 => $value_type1) {
		$num_type1++;
		if($_POST['type_human'] == $num_type1 ){$type_human = "AND re_fg_mem_type = '".$value_type1['re_fg_mem_type']."'"; }
	}

	if($_POST['type_gate'] == 'in_gate'){$type_gate = "AND lower(re_fg_in_out) like '%in'"; }
	else if($_POST['type_gate'] == 'out_gate'){$type_gate = "AND lower(re_fg_in_out) like '%out'"; }

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
	$num_pdf = 0;
	foreach ($sql_fg as $key => $value_fg) {
		$num_pdf++;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">


	<script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
	<script src="AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
    	$(document).ready(function() {
	        $('#dataTables-example').DataTable({
	                responsive: true,
	                "searching" : false,
	                "pageLength": 10,
	                "lengthChange": false
	        });
	    });
    </script>
</head>
<body>
	<div class="row">
		<div class="col-lg-12" align="right">
			ดาวน์โหลดรายงานแบบ : &nbsp;
			<a href="report_fg_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&gate=<?php echo $gate; ?>&type=<?php echo $type; ?>&sort_by=<?php echo $sort_by_text; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_fg_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&gate=<?php echo $gate; ?>&type=<?php echo $type; ?>&sort_by=<?php echo $sort_by_text; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red">**กรณีที่ report มีจำนวน record มากกว่า 400 จะไม่สามรถออกรายงานเป็น PDF ได้</font>
			<?php }else{ ?>
				<a href="#" onClick="javascript:window.open('report_fg_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&gate=<?php echo $gate; ?>&type=<?php echo $type; ?>&sort_by=<?php echo $sort_by_text; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
			<?php } ?>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered table-hover" id="dataTables-example">
		    	<thead>
		    		<tr>
		    			<th width="5%">ลำดับ</th>
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
		    			<td><?php echo $num; ?></td>
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
		</div>
		<div class="overlay" id="loading">
		        <i class="fa fa-refresh fa-spin"></i>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$(window).load(function(){
		$("#loading").hide();
	})
</script>
