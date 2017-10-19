<?php
	include "connect_db.php";

	$fieldName = $_POST['fieldName'];
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$machine1 = $_POST['machine'];
	$machine = '';

	if($_POST['machine'] != 'all_machine'){$machine = "AND re_sg_count_station_id = '".$machine1."'"; }
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
			<a href="report_sg_count_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_sg_count_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<a href="#" onClick="javascript:window.open('report_sg_count_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered table-hover" id="dataTables-example">
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
