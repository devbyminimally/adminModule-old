<?php
	include "connect_db.php";
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$machine1 = $_POST['machine'];
	$machine = '';

	if($_POST['machine'] != 'all_machine'){$machine = "AND re_fg_count_station_id = '".$machine1."'"; }

	if($startdate == $enddate){
		$sql_fg_count1 = "SELECT re_fg_count_date,re_fg_count_station_id,re_fg_count FROM report_barrier_count WHERE re_fg_count_date LIKE '$startdate%' ".$machine." ORDER BY re_fg_count_date DESC";
		$sql_fg_count = mysqli_fetch_all(mysqli_query($conn,$sql_fg_count1),MYSQLI_BOTH);
	}
	else{
		$sql_fg_count1 = "SELECT re_fg_count_date,re_fg_count_station_id,re_fg_count FROM report_barrier_count WHERE (re_fg_count_date BETWEEN '$startdate' AND '$enddate') ".$machine." ORDER BY re_fg_count_date DESC";
		$sql_fg_count = mysqli_fetch_all(mysqli_query($conn,$sql_fg_count1),MYSQLI_BOTH);
	}
	$num_pdf = 0;
	foreach ($sql_fg_count as $key_count => $value_fg_count) {
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
			<a href="report_fg_count_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_fg_count_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red">**กรณีที่ report มีจำนวน record มากกว่า 400 จะไม่สามรถออกรายงานเป็น PDF ได้</font>
			<?php }else{ ?>
				<a href="#" onClick="javascript:window.open('report_fg_count_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&machine=<?php echo $machine1; ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
			<?php } ?>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered table-hover" id="dataTables-example">
		    	<thead>
					<tr>
						<th>ลำดับ</th>
						<th>วันที่</th>
						<th>ช่องทาง</th>
						<th>จำนวน</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($sql_fg_count as $key => $value_fg_count) {
							$num++;
					?>
					<tr>
						<td><?php echo $num; ?></td>
						<td><?php echo $value_fg_count['re_fg_count_date']; ?></td>
						<td><?php echo $value_fg_count['re_fg_count_station_id']; ?></td>
						<td><?php echo $value_fg_count['re_fg_count']; ?></td>
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
