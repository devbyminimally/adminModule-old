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
	$date = explode(' ถึง ', $_POST['date']);
	$startdate = $date[0];
	$enddate = $date[1];
	$status1 = $_POST['status'];
	$status = '';
	if( $_POST['status'] != 'all'){
		$status = " AND re_bd_book_status = '".$_POST['status']."'";
	}

	$group1 = $_POST['group'];
	$group = '';
	if( $_POST['group'] != 'all'){
		$group = " AND re_bd_station_id = '".$_POST['group']."'";
	}

	if($startdate == $enddate){
		$sql_bd1 = "SELECT re_bd_bookbin,re_bd_station_id,re_bd_date,re_bd_mem_id,re_bd_type,re_bd_mem_name,re_bd_book_id,re_bd_book_name,re_bd_book_due_date,re_bd_book_status,re_bd_book_img,re_bd_user_img FROM report_bookdrop WHERE DATE_FORMAT(re_bd_date,'%Y-%m-%d') LIKE '$startdate%' ".$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	else{
		$sql_bd1 = "SELECT re_bd_bookbin,re_bd_station_id,re_bd_date,re_bd_mem_id,re_bd_type,re_bd_mem_name,re_bd_book_id,re_bd_book_name,re_bd_book_due_date,re_bd_book_status,re_bd_book_img,re_bd_user_img FROM report_bookdrop WHERE (DATE_FORMAT(re_bd_date,'%Y-%m-%d') BETWEEN '$startdate' AND '$enddate') ".$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	$num_pdf = 0;
	foreach ($sql_bd as $key => $value_bd) {
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
				<?php if($num_pdf >= '200'){ ?>
					<img src="img/pdf-icon.png" style="width:30px">
					<br><font color="red">**<?=$lang_remark_2;?></font>

				<?php }else{ ?>
					<a href="#" onClick="javascript:window.open('report_bd_pic_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&group=<?php echo $group1; ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
				<?php } ?>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th><?=$lang_no; ?></th>
							<th><?=$lang_date; ?></th>
							<th><?=$lang_detail; ?></th>
							<th>ภาพผู้ใช้งาน</th>
							<th>ภาพหนังสือที่คืน</th>
							
						</tr>
					</thead>
					<tbody>
					    <?php
					    	$num = 0;
					    	foreach ($sql_bd as $key => $value_bd) {
					    		$num++;
					    ?>
					    <tr>
					    	<td><?php echo $num; ?></td>
					    	<td><?php echo $lang_date." :".$value_bd['re_bd_date'] ?></td>
					    	<td><?php echo $lang_station_id." :".$value_bd['re_bd_station_id']."<br>"; ?>
					    		<?php echo $lang_book_id." :".$value_bd['re_bd_book_id']."<br>"; ?>
					    		<?php echo $lang_book_name." :".$value_bd['re_bd_book_name']."<br>"; ?>
					    		<?php echo $lang_status." :".$value_bd['re_bd_book_status']; ?></td>
					    	<td><img onerror="this.onerror=null;this.src='img/notFound.gif';" src="<?php echo $path_selfcheck_img.$value_bd['re_bd_station_id']."/".strtolower($value_bd['re_bd_type'])."/".$value_bd['re_bd_user_img']; ?>" style="height:150px"></td>
					    	<td><img onerror="this.onerror=null;this.src='img/notFound.gif';" src="<?php echo $path_selfcheck_img.$value_bd['re_bd_station_id']."/".strtolower($value_bd['re_bd_type'])."/".$value_bd['re_bd_book_img']; ?>" style="height:150px"></td>
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
