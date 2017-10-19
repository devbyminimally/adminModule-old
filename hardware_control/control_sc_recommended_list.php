<?php 
	include "connect_db.php"; 
	//$station_id = $_GET['station_id'];

	include("_api/nusoap.php");
  	$client = new nusoap_client($path_api,true); 
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/font-awesome/css/font-awesome.min.css">
	<!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lity-1.6.6/dist/lity.css"/>
	<!-- jQuery 2.1.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js"></script>
	<!-- DataTables -->
    <script src="AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="lity-1.6.6/dist/lity.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
	        $('#dataTables-example').DataTable({
	                "pageLength": 5,
	                "searching" : false,
        			"info":     false,
	                "lengthChange": false,
	                "order": [[ 1, "asc" ]],
	                "columnDefs": [
	                    { "orderable": false, "searchable": false, "targets": 0 },
	                    { "orderable": false, "targets": 3 },
	                    { "orderable": false, "targets": 4 }
                    ]
	        });
	    });
	</script>
</head>
<body>
	<div >
		<table class="table table-hover" id="dataTables-example" width="100%" >
			<thead>
				<tr>
					<th>#</th>
					<th>รหัสหนังสือ</th>
					<th>ชื่อหนังสือ</th>
					<th>ภาพปก</th>
					<th>ลบ</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$num = 0;
					$sql = "SELECT book_id,book_name,book_image FROM recommended_book ";
					$query = mysqli_query($conn,$sql);
					while ($res = mysqli_fetch_array($query,MYSQLI_BOTH)) {
						$num++;
				?>
				<tr>
					<td align="left"><?php echo $num; ?></td>
					<td align="left"><?php echo $res['book_id']; ?></td>
					<td align="left"><?php echo $res['book_name']; ?></td>
					<?php 
						$checkstatus = array('Barcode' => $res['book_id']);
						$result = $client->call('checkstatus',$checkstatus);
						foreach ($result as $key => $value) { 
							if($value['re_image'] == ''){
					?>
					<td align="left"><a href="<?php echo $path_selfcheck_img_recommended.$res['book_image']; ?>" data-lity><img src="<?php echo $path_selfcheck_img_recommended.$res['book_image']; ?>" style="width:50px;height:70px;"></a></td>
					<?php }else{ ?>
					<td align="left"><a href="<?php echo $path_api_image.$res['book_image']; ?>" data-lity><img src="<?php echo $path_api_image.$res['book_image']; ?>" style="width:50px;height:70px;"></a></td>
					<?php } } ?>
					<td align="left"><a href="#" onclick="delete_recommended('<?php echo $res['book_id']; ?>');"><img src="img/bin.png" width="30"></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<iframe name="sc_recommended_delete" id="sc_recommended_delete" style="width: 0px;height: 0px;" frameborder="0" scrolling="no"></iframe>
	<script type="text/javascript">
		function delete_recommended(id,hardware_id) {
	        if(confirm("คุณต้องการลบรหัสหนังสือนี้ออกจากรายการหนังสือแนะนำ?")){
		        document.getElementById("sc_recommended_delete").src = "control_sc_recommended_delete.php?book_id="+id;
	        }
	    }
	</script>
</body>
</html>