<?php
	include "../connect_db.php";
	if ($_SESSION['lang'] == 'en') {
    	include "../language/lang_en.php";
	}
	else{
	    include "../language/lang_th.php";
	}

	$barcode_id = $_POST['barcode_id'];

	include("../_api/nusoap.php");
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
	<link rel="stylesheet" href="../AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="../AdminLTE-2.3.0/plugins/font-awesome/css/font-awesome.min.css">
	<link href="../jquery-form-validator/validator.css" rel="stylesheet">


	<script src="../AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="../AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
	<script src="../jquery-form-validator/jquery.form.validator-th.min.js"></script>
    <script src="../jquery-form-validator/security.js"></script>
    <script src="../jquery-form-validator/file.js"></script>

</head>
<body>

<?php

	$sql_ = "SELECT book_id FROM book_atm_register WHERE book_id = '$barcode_id'";
	$query_ = mysqli_query($conn,$sql_);
	$res_num = mysqli_num_rows($query_);

	if($res_num == 0){
		foreach ($result as $key => $value) {
			if($value['error'] == 1){
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> '.$value['error_description'].'</h4></div>';
			}
			else{
?>
				<form class="form-horizontal" method="post" enctype="multipart/form-data" target="ba_add_submit" action="control_ba_add_submit.php">
					<div class="form-group">
					    <label class="col-sm-3 control-label"><?=$lang_ba_barcode; ?></label>
					    <div class="col-sm-6">
					        <p class="form-control-static"><?php echo $value['barcode']; ?></p>
					        <input type="hidden" name="barcode" value="<?php echo $value['barcode']; ?>">
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-3 control-label"><?=$lang_book_name; ?></label>
					    <div class="col-sm-6">
					        <p class="form-control-static"><?php echo $value['media_name']; ?></p>
					        <input type="hidden" name="media_name" value="<?php echo $value['media_name']; ?>">
					    </div>
					</div>
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label"><?=$lang_ba_detail; ?></label>
				    	<div class="col-sm-6">
				      		<textarea name="detail" id="detail" class="form-control" rows="3" data-validation="required"></textarea>
				      		<font color="gray"><?=$lang_message_left_1; ?> <span id="pres-max-detail">500</span> <?=$lang_message_left_2; ?></font>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label"><?=$lang_ba_coverbook; ?></label>
				    	<div class="col-sm-6">
				      		<input type="file" name="cover_book" id="cover_book" class="form-control" data-validation="mime size required" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="<?=$lang_ba_remark_img; ?> 3 MB">
				    	</div>
				  	</div>
				  	<hr>
				  	<div class="form-group">
				    	<div class="col-sm-offset-3 col-sm-6">
				      		<button type="submit" class="btn btn-success btn-lg" name="submit_book"><?=$lang_ba_add_book; ?></button>
				    	</div>
				  	</div>
				</form>
<?php
			}
		}
	}else{
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4>	<i class="icon fa fa-check"></i> '.$lang_ba_register2.'</h4></div>';
		
?>

<?php
	}
?>

<iframe name="ba_add_submit" id="ba_add_submit" style="width: 0px;" frameborder="0" ></iframe>

<script type="text/javascript">
	$.validate({
    	modules : 'file'
  	});
  	$('#detail').restrictLength( $('#pres-max-detail') );
</script>	
	
</body>
</html>