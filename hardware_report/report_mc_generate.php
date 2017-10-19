<?php 
	include "connect_db.php";
	$lang = $_SESSION['lang'];
	if(isset($_GET['lang'])){
	 	$_SESSION['lang'] = $_GET['lang']; //เก็บค่าของภาษาไว้ใน SESSION
	   	if($_SESSION['lang'] == "en"){
	     	include "lang_en.php";
	   	}
	   	else{
	     	include "lang_th.php";
	   	}
	}
	else if ($_SESSION['lang'] == 'en') {
	 	include "lang_en.php";
	}
	else{
	 	include "lang_th.php";
	}
	$fieldName = $_POST['fieldName'];
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$time_start = $_POST['time_h_start'].":".$_POST['time_m_start'];
	$time_end = $_POST['time_h_end'].":".$_POST['time_m_end'];
	$time = '';
	$number1 = 0;
	$number2 = 0;
	$status1 = $_POST['status'];
	$status = '';
	if( $_POST['status'] != 'all'){
		$res_status1 = "SELECT DISTINCT status FROM savedinventory ";
		   foreach ($res_status1 as $key_status1 => $value_status1) {
		   	$number1++;
		   	if($_POST['status'] == $number1){$status = " AND status = '".$value_status1['status']."'";}
		   }
	}
	$area1 = $_POST['area'];
	$area = '';
	if($_POST['area'] != 'all'){
		$area = " AND position_id = '".$_POST['area']."'";
	}

	$group1 = $_POST['group'];
	$group = '';
	if( $_POST['group'] != 'all'){
		$sql_group1 = "SELECT DISTINCT save_id FROM savedinventory ";
		$query_group1 = mysqli_query($conn,$sql_group1);
		$res_group1 = mysqli_fetch_all($query_group1,MYSQLI_BOTH);
		   foreach ($res_group1 as $key_group1 => $value_group1) {
		   	$number2++;
		   	if($_POST['group'] == $number2){$group = " AND save_id = '".$value_group1['save_id']."'";}
		   }
	}
	if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(date,12,5) BETWEEN '$time_start' AND '$time_end')"; }
	if($startdate == $enddate){
		$sql_mc1 = "SELECT tag_id,book_name,position_id,save_id,status,date FROM savedinventory WHERE date LIKE '$startdate%' ".$time.$status.$area.$group." order by date desc";
		$query_mc = mysqli_query($conn,$sql_mc1);
		$sql_mc = mysqli_fetch_all($query_mc,MYSQLI_BOTH);
	}
	else{
		$sql_mc1 = "SELECT tag_id,book_name,position_id,save_id,status,date FROM savedinventory WHERE (date BETWEEN '$startdate' AND '$enddate') ".$time.$status.$area.$group." order by date desc";
		$query_mc = mysqli_query($conn,$sql_mc1);
		$sql_mc = mysqli_fetch_all($query_mc,MYSQLI_BOTH);

	}
	$num_pdf = 0;
	foreach ($sql_mc as $key => $value_mc) {
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
			<a href="report_mc_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&area=<?php echo $area1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_mc_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&area=<?php echo $area1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red"><?=$lang_remark_1; ?></font>
			<?php }else{ ?>
			<a href="#" onClick="javascript:window.open('report_mc_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&time_start=<?php echo $time_start;?>&time_end=<?php echo $time_end; ?>&status=<?php echo $status1; ?>&area=<?php echo $area1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
			<?php } ?>
		</div>
		<div class="col-lg-12">
		    <div class="dataTable_wrapper">
		    	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		    		<thead>
		    			<tr>
		    				<th><?=$lang_no; ?></th>
		    				<?php 
			    				foreach ($fieldName as $value_fieldName1) {
				    				if($value_fieldName1 == 1){ echo "<th>".$lang_date."</th>"; }
				    				if($value_fieldName1 == 2){ echo "<th>".$lang_name_save."</th>"; }
				    				if($value_fieldName1 == 3){ echo "<th>".$lang_book_id."</th>"; }
				    				if($value_fieldName1 == 4){ echo "<th>".$lang_book_name."</th>"; }
				    				if($value_fieldName1 == 5){ echo "<th>".$lang_position."</th>"; }
				    				if($value_fieldName1 == 6){ echo "<th>".$lang_status."</th>"; }
				    			}
				    		?>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			<?php
		    				$num = 0;
		    				foreach ($sql_mc as $key => $value_mc) {
		    					$num++;
		    			?>
		    			<tr>
		    				<td><?php echo $num; ?></td>
		    				<?php 
			    				foreach ($fieldName as $value_fieldName2) {
			    					$sql_position = "SELECT location_name FROM locations WHERE id = '".$value_mc['position_id']."'"; 
		    						$query_position = mysqli_query($conn,$sql_position);
						 			$res_position = mysqli_fetch_array($query_position,MYSQLI_BOTH);
				    				if($value_fieldName2 == 1){ echo "<td>".$value_mc['date']."</td>"; }
				    				if($value_fieldName2 == 2){ echo "<td>".$value_mc['save_id']."</td>"; }
				    				if($value_fieldName2 == 3){ echo "<td>".$value_mc['tag_id']."</td>"; }
				    				if($value_fieldName2 == 4){ echo "<td width='20%'>".$value_mc['book_name']."</td>"; }
				    				if($value_fieldName2 == 5){ echo "<td>".$res_position['location_name']."</td>"; }
				    				if($value_fieldName2 == 6){ echo "<td>".$value_mc['status']."</td>"; }
				    			}
				    		?>
		    			</tr>
		    			<?php } ?>
		    		</tbody>
		    	</table>
		    </div>
    	</div>
    </div>
</body>
</html>