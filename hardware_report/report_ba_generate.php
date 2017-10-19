<?php
	include "connect_db.php";
	$fieldName = $_POST['fieldName'];
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$status1 = $_POST['status'];
	$status = '';
	if( $_POST['status'] != 'all'){
		$status = " AND re_ba_book_status = '".$_POST['status']."'";
	}

	$type1 = $_POST['type'];
	$type = '';
	if($_POST['type'] != 'all'){
		$type = " AND re_ba_type = '".$_POST['type']."'";
	}

	$group1 = $_POST['group'];
	$group = '';
	if( $_POST['group'] != 'all'){
		$group = " AND re_ba_station_id = '".$_POST['group']."'";
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
	$num_pdf = 0;
	foreach ($sql_ba as $key => $value_ba) {
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
			<a href="report_ba_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_ba_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red">**กรณีที่ report มีจำนวน record มากกว่า 400 จะไม่สามรถออกรายงานเป็น PDF ได้</font>

			<?php }else{ ?>
				<a href="#" onClick="javascript:window.open('report_ba_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
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
