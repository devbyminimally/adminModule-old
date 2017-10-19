<?php
	if(!isset($_SESSION)){
	    session_start();
	}
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
	$status1 = $_POST['status'];
	$status = '';
	if( $_POST['status'] != 'all'){
		$status = " AND re_sc_book_status = '".$_POST['status']."'";
	}

	$type1 = $_POST['type'];
	$type = '';
	if($_POST['type'] != 'all'){
		$type = " AND re_sc_type = '".$_POST['type']."'";
	}

	$group1 = $_POST['group'];
	$group = '';
	if( $_POST['group'] != 'all'){
		$group = " AND re_sc_station_id = '".$_POST['group']."'";
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
	$num_pdf = 0;
	foreach ($sql_sc as $key => $value_sc) {
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
			<?=$lang_download;?> : &nbsp;
			<a href="report_sc_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
			<a href="report_sc_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp;
			<?php if($num_pdf >= '400'){ ?>
				<img src="img/pdf-icon.png" style="width:30px">
				<br><font color="red">**<?=$lang_remark_1;?></font>

			<?php }else{ ?>
				<a href="#" onClick="javascript:window.open('report_sc_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>&<?php echo preg_replace('/fieldName[0-9]+/', 'fieldName[]',http_build_query($fieldName,'fieldName')); ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
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
