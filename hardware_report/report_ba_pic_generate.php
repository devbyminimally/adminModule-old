<?php
	include "connect_db.php";

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
		$sql_ba1 = "SELECT re_ba_station_id,re_ba_img_user,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE re_ba_date LIKE '$startdate%' ".$status.$type.$group." ";
		$query_ba = mysqli_query($conn,$sql_ba1);
		$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
	}
	else{
		$sql_ba1 = "SELECT re_ba_station_id,re_ba_img_user,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE (re_ba_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
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
				<!--<a href="report_sc_pic_to_word.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>"><img src="img/word-icon.png" style="width:30px"></a>&nbsp;
				<a href="report_sc_pic_to_excel.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>"><img src="img/excel-icon.png" style="width:30px"></a>&nbsp; -->
				<?php if($num_pdf >= '200'){ ?>
					<img src="img/pdf-icon.png" style="width:30px">
					<br><font color="red">**กรณีที่ report มีจำนวน record มากกว่า 200 จะไม่สามารถออกรายงานเป็น PDF ได้</font>

				<?php }else{ ?>
					<a href="#" onClick="javascript:window.open('report_ba_pic_to_pdf.php?start=<?php echo $startdate;?>&end=<?php echo $enddate; ?>&status=<?php echo $status1; ?>&type=<?php echo $type1; ?>&group=<?php echo $group1; ?>')"><img src="img/pdf-icon.png" style="width:30px"></a>
				<?php } ?>
			</div>
			<div class="col-md-12">
				<table class="table table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>ลำดับ</th>
							<th>วันที่</th>
							<th>รายละเอียด</th>
							<th>รูปภาพ</th>
							
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
					    	<td><?php echo "วันที่ยืม :".$value_ba['re_ba_date']."<br>วันที่คืน :".$value_ba['re_ba_book_due_date']; ?></td>
					    	<td><?php echo "หมายเลขเครื่อง :".$value_ba['re_ba_station_id']."<br>"; ?>
					    		<?php echo "ประเภท :".$value_ba['re_ba_type']."<br>"; ?>
					    		<?php echo "รหัสสมาชิก :".$value_ba['re_ba_mem_id']."<br>"; ?>
					    		<?php echo "ชื่อสมาชิก :".$value_ba['re_ba_mem_name']."<br>"; ?>
					    		<?php echo "รหัสหนังสือ :".$value_ba['re_ba_book_id']."<br>"; ?>
					    		<?php echo "ชื่อหนังสือ :".$value_ba['re_ba_book_name']."<br>"; ?>
					    		<?php echo "สถานะ :".$value_ba['re_ba_book_status']; ?></td>
					    	<td><img src="<?php echo $path_book_atm_img."/".$value_ba['re_ba_img_user']; ?>" style="height:150px"></td>
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
