<?php
	include "connect_db.php";

	$fieldName = $_POST['fieldName'];
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$time_start = $_POST['time_h_start'].":".$_POST['time_m_start'];
	$time_end = $_POST['time_h_end'].":".$_POST['time_m_end'];
	$time = '';
	$status1 = $_POST['status'];
	$status = '';
	if($_POST['status'] == 'Borrow'){$status = "AND re_sg_book_status = 'Borrow'"; }
	else if($_POST['status'] == 'Not_Borrow'){$status = "AND re_sg_book_status = 'Not_Borrow'"; }
	$number2 = 0;
	$group1 = $_POST['group'];
	$group = '';
	if( $_POST['group'] != 'all'){
		$sql_group1 = "SELECT DISTINCT re_sg_book_callno FROM report_security_gate";
		$query_group1 = mysqli_query($conn,$sql_group1);
		$res_group1 = mysqli_fetch_all($query_group1,MYSQLI_BOTH);
		   foreach ($res_group1 as $key_group1 => $value_group1) {
		   	$number2++;
		   	if($_POST['group'] == $number2){$group = " AND re_sg_book_callno = '".$value_group1['re_sg_book_callno']."'";}
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
	$num_pdf = 0;
	foreach ($sql_sg as $key => $value_sg) {
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
			<?=$lang_download; ?> : &nbsp;
			<a href="report_sg_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_sg_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red"><?=$lang_remark_1; ?></font>

			<?php }else{ ?>
				<a href="#" onClick="javascript:window.open('report_sg_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
			<?php } ?>
		</div>
		<div class="col-md-12">
			<table class="table table-bordered table-hover" id="dataTables-example">
		    	<thead>
		    		<tr>
		    			<th width="5%"><?=$lang_no; ?></th>
		    			<?php 
			    			foreach ($fieldName as $value_fieldName1) {
			    				if($value_fieldName1 == 1){ echo "<th>".$lang_date."</th>"; }
				    			if($value_fieldName1 == 2){ echo "<th>".$lang_book_id."</th>"; }
				    			if($value_fieldName1 == 3){ echo "<th>หมวดหมู่</th>"; }
				    			if($value_fieldName1 == 4){ echo "<th>".$lang_book_name."</th>"; }
				    			if($value_fieldName1 == 5){ echo "<th>".$lang_status."</th>"; }
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
