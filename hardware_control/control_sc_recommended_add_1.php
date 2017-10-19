<?php
	include "connect_db.php";
	$barcode_id = $_POST['barcode_id'];

	include("_api/nusoap.php");
  	$client = new nusoap_client($path_api,true); 
	$checkstatus = array('Barcode' => $barcode_id);
	$result = $client->call('checkstatus',$checkstatus);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/font-awesome/css/font-awesome.min.css">
	<link href="jquery-form-validator/validator.css" rel="stylesheet">
	<!-- iCheck -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/iCheck/all.css">

	<script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
	<script src="jquery-form-validator/jquery.form.validator-th.min.js"></script>
    <script src="jquery-form-validator/security.js"></script>
    <script src="jquery-form-validator/file.js"></script>
    <!-- FastClick -->
    <script src="AdminLTE-2.3.0/plugins/fastclick/fastclick.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="AdminLTE-2.3.0/plugins/iCheck/icheck.min.js"></script>

</head>
<body>

<?php

	$sql_ = "SELECT book_id FROM recommended_book WHERE book_id = '$barcode_id'";
	$query_ = mysqli_query($conn,$sql_);
	$res_num = mysqli_num_rows($query_);

	if($res_num == 0){
		foreach ($result as $key => $value) {
			if($value['error'] == 1){
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> '.$value['error_description'].'</h4></div>';
			}
			else{
?>
				<form class="form-horizontal" method="post" enctype="multipart/form-data" target="sc_recommended_add_2" action="control_sc_recommended_add_2.php">
					<div class="form-group">
					    <label class="col-xs-4 control-label">รหัสหนังสือ</label>
					    <div class="col-xs-8">
					        <p class="form-control-static"><?php echo $value['barcode']; ?></p>
					        <input type="hidden" name="barcode" value="<?php echo $value['barcode']; ?>">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-xs-4 control-label">ชื่อหนังสือ</label>
					    <div class="col-xs-8">
					        <p class="form-control-static"><?php echo $value['media_name']; ?></p>
					        <input type="hidden" name="media_name" value="<?php echo $value['media_name']; ?>">
					        <input type="hidden" name="re_image" value="<?php echo $value['re_image']; ?>">
					    </div>
					</div>
				  	<div class="form-group">
				    	<label class="col-xs-4 control-label">ภาพหน้าปกหนังสือ</label>
				    	<div class="col-xs-8">
				    		<?php if($value['re_image'] == ''){ ?>
				      			<input type="file" name="cover_book" id="cover_book" class="form-control" data-validation="mime size required" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์รูปภาพ และขนาดไม่เกิน 3 MB">
				      		<?php }else{ ?>
				      			<img src="<?php echo $path_api_image.$value['re_image']; ?>" style="width:100px;height:140px;">
				  			<?php } ?>
				    	</div>
				  	</div>
				  	<hr>
				  	<div class="form-group">
				    	<div class="col-xs-offset-4 col-xs-8">
				      		<button type="submit" class="btn btn-success btn-lg" name="submit_book">เพิ่มรายการหนังสือ</button>
				    	</div>
				  	</div>
				</form>
<?php
			}
		}
	}else{
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4>	<i class="icon fa fa-check"></i> รหัสหนังสือนี้ได้รับการลงทะเบียนแล้ว</h4></div>';
	}
?>

<iframe name="sc_recommended_add_2" id="sc_recommended_add_2" style="width: 0px;height: 0px;" frameborder="0" ></iframe>

<script type="text/javascript">
	$.validate({
    	modules : 'file',
    	validateOnBlur : false, // disable validation when input looses focus
    	errorMessagePosition : 'top', // Instead of 'inline' which is default
    	scrollToTopOnError : false // Set this property to true on longer forms
  	});

</script>	
	
</body>
</html>