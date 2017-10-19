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
	$sort_by = $_POST['sort_by'];

		if($_POST['sort_by'] == 'sort_date'){
			$header_group = $lang_sort_by1;
			$month_start = $_POST['month_start'];
			$month_end = $_POST['month_end'];
			$sql_1 = "SELECT re_bd_station_id ,COUNT(re_bd_id) as no , DATE_FORMAT(re_bd_date,'%Y-%m-%d') AS re_bd_date
					FROM report_bookdrop
					WHERE DATE_FORMAT(re_bd_date,'%Y-%m') BETWEEN '".$_POST['month_start']."' AND '".$_POST['month_end']."'
					GROUP BY re_bd_station_id,DATE_FORMAT(re_bd_date,'%Y-%m-%d') ORDER BY re_bd_date ASC";
		}elseif ($_POST['sort_by'] == 'sort_hour') {
			$header_group = 'รายชั่วโมง';
			$month_start = $_POST['month_start'];
			$month_end = $_POST['month_end'];
			$sql_1 = "SELECT re_bd_station_id,COUNT(re_bd_id) AS no , DATE_FORMAT(re_bd_date,'%Y-%m-%d %H:00') AS re_bd_date
					FROM report_bookdrop 
					WHERE (DATE(re_bd_date) BETWEEN '".$_POST['month_start']."' AND '".$_POST['month_end']."')
					GROUP BY re_bd_station_id,DATE_FORMAT(re_bd_date,'%Y-%m-%d %H') ORDER BY re_bd_date ASC";
		}elseif ($_POST['sort_by'] == 'sort_month') {
			$header_group = $lang_sort_by2;
			$month_start = $_POST['month_start'];
			$month_end = $_POST['month_end'];
			$sql_1 = "SELECT re_bd_station_id ,COUNT(re_bd_id) as no , MONTHNAME(re_bd_date) AS re_bd_date
					FROM report_bookdrop
					WHERE DATE_FORMAT(re_bd_date,'%Y-%m') BETWEEN '".$_POST['month_start']."' AND '".$_POST['month_end']."'
					GROUP BY re_bd_station_id,MONTHNAME(re_bd_date) ORDER BY re_bd_date ASC";
		}else{
			$month_start = '';
			$month_end = '';
			$header_group = $lang_sort_by3;
			$sql_1 = "SELECT re_bd_station_id ,COUNT(re_bd_id) as no , YEAR(re_bd_date) AS re_bd_date
					FROM report_bookdrop
					GROUP BY re_bd_station_id,YEAR(re_bd_date) ORDER BY re_bd_date ASC";
		}
		
	$query_1 = mysqli_query($conn,$sql_1);
	$res_1 = mysqli_fetch_all($query_1,MYSQLI_BOTH);

	$num_pdf = 0;
	foreach ($res_1 as $key => $value_bd) {
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
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-hover" id="example">
		        	<thead>
			    		<tr>
			    			<th><?=$header_group; ?></th>
			    			<th><?=$lang_station_id; ?></th>
			    			<th><?=$lang_total; ?></th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<?php
			    			$num = 0;
			    			foreach ($res_1 as $key => $value_bd) {
			    				$num++;
			    		?>
			    		<tr>
			    			<td><?php echo $value_bd['re_bd_date']; ?></td>
			    			<td><?php echo $value_bd['re_bd_station_id']; ?></td>
			    			<td><?php echo $value_bd['no']; ?></td>
			    		</tr>
			    		<?php } ?>
			    	</tbody>
			    	<tfoot style="background-color: #F5F5F5;">
			            <tr>
			                <th style="text-align:right"><?=$lang_total; ?> : </th>
			                <th></th>
			                <th></th>
			            </tr>
			        </tfoot>
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

$(document).ready(function() {
    var table = $('#example').DataTable({
    	responsive: true,
	    "searching" : false,
	    "pageLength": 10,
	    "lengthChange": false
    });
    for(var num_col=1;num_col<6;num_col++){
		var column = table.column( num_col );

		var intVal = function ( i ) {
		    			return typeof i === 'string' ?i*1 : typeof i === 'number' ?i : 0;
		    		};
		 
		$( column.footer() ).html(
		    column.data().reduce( function (a,b) {
		        return intVal(a) + intVal(b);
		    } )
		);
	}
} );
</script>
