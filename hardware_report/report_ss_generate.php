<?php
	include "connect_db.php";

	$fieldName = $_POST['fieldName'];
	$book_id_name1 = $_POST['book_id_name'];
	$book_id_name = '';
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$time_start = $_POST['time_h_start'].":".$_POST['time_m_start'];
	$time_end = $_POST['time_h_end'].":".$_POST['time_m_end'];
	$time = '';
	$type_ss1 = $_POST['type_ss'];
	$type_ss = '';
	$group = '';
	$number1 = '';
	$user1 = $_POST['user'];
	$user = '';
	if($_POST['book_id_name'] != ''){
		$book_id_name = " AND (re_ss_book_id LIKE '%".$_POST['book_id_name']."%' OR re_ss_book_name LIKE '%".$_POST['book_id_name']."%')";
	}
	if($_POST['type_ss'] != 'all_ss'){
		$type_ss = " AND re_ss_station_id = '".$_POST['type_ss']."'";
	}
	if($_POST['user'] != 'all'){
		$user = " AND re_ss_book_user = '".$_POST['user']."'";
	}
	if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(re_ss_book_datetime,12,5) BETWEEN '$time_start' AND '$time_end')"; }
	if($startdate == $enddate){
		$sql_ss1 = "SELECT re_ss_book_datetime,re_ss_book_user,re_ss_book_name,re_ss_book_callno,re_ss_book_id,re_ss_station_id FROM report_staff_station WHERE re_ss_book_datetime LIKE '$startdate%' ".$book_id_name.$time.$type_ss.$user." order by re_ss_book_datetime desc ";
		$query_ss = mysqli_query($conn,$sql_ss1);
		$sql_ss = mysqli_fetch_all($query_ss,MYSQLI_BOTH);
	}
	else{
		$sql_ss1 = "SELECT re_ss_book_datetime,re_ss_book_user,re_ss_book_name,re_ss_book_callno,re_ss_book_id,re_ss_station_id FROM report_staff_station WHERE (SUBSTR(re_ss_book_datetime,1,10) BETWEEN '$startdate' AND '$enddate') ".$book_id_name.$time.$type_ss.$user." order by re_ss_book_datetime desc ";
		$query_ss = mysqli_query($conn,$sql_ss1);
		$sql_ss = mysqli_fetch_all($query_ss,MYSQLI_BOTH);
	}
	$num_pdf = 0;
    foreach ($sql_ss as $key => $value_ss) {
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
			<div class="col-sm-12" align="right">
				ดาวน์โหลดรายงานแบบ : &nbsp;
				<a href="report_ss_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&book_id_name=<?php echo $book_id_name1;?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&type_ss=<?php echo $type_ss1; ?>&user=<?php echo $user1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
				<a href="report_ss_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&book_id_name=<?php echo $book_id_name1;?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&type_ss=<?php echo $type_ss1; ?>&user=<?php echo $user1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
				<?php if($num_pdf >= '400'){ ?>
					<img src="img/pdf-icon.png" style="width:30px">
					<br><font color="red">**กรณีที่ report มีจำนวน record มากกว่า 400 จะไม่สามรถออกรายงานเป็น PDF ได้</font>
				<?php }else{ ?>
				<a href="#" onclick="javascript:window.open('report_ss_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&book_id_name=<?php echo $book_id_name1;?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&type_ss=<?php echo $type_ss1; ?>&user=<?php echo $user1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>');"><img src="img/pdf-icon.png" style="width:30px"></a>
				<?php } ?>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered table-hover" id="dataTables-example">
				    		<thead>
				    			<tr>
				    				<th>ลำดับ</th>
				    				<?php 
				    					foreach ($fieldName as $value_fieldName1) {
				    						if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
						    				if($value_fieldName1 == 2){ echo "<th>รหัสเครื่อง</th>"; }
						    				if($value_fieldName1 == 3){ echo "<th>รหัสหนังสือ</th>"; }
						    				if($value_fieldName1 == 4){ echo "<th>เลขเรียกหนังสือ</th>"; }
						    				if($value_fieldName1 == 5){ echo "<th>ชื่อหนังสือ</th>"; }
						    				if($value_fieldName1 == 6){ echo "<th>ชื่อผู้ใช้</th>"; }
						    			}
				    				?>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<?php
				    				$num = 0;
				    				foreach ($sql_ss as $key => $value_ss) {
				    					$num++;
				    			?>
				    			<tr>
				    				<td><?php echo $num; ?></td>
				    				<?php 
				    					foreach ($fieldName as $value_fieldName2) {
						    				if($value_fieldName2 == 1){echo "<td>".$value_ss['re_ss_book_datetime']."</td>"; }
						    				if($value_fieldName2 == 2){echo "<td>".$value_ss['re_ss_station_id']."</td>"; }
						    				if($value_fieldName2 == 3){echo "<td>".$value_ss['re_ss_book_id']."</td>"; }
						    				if($value_fieldName2 == 4){echo "<td>".$value_ss['re_ss_book_callno']."</td>"; }
						    				if($value_fieldName2 == 5){echo "<td width='25%'>".$value_ss['re_ss_book_name']."</td>"; }
						    				if($value_fieldName2 == 6){echo "<td>".$value_ss['re_ss_book_user']."</td>"; }
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
