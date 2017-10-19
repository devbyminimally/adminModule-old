<?php
	$sql_edit = "SELECT book_id,book_name,book_description,book_image FROM book_atm_register WHERE book_id = '".$_GET['id']."'";
	$query_edit = mysqli_query($conn,$sql_edit);
	$res_edit = mysqli_fetch_array($query_edit,MYSQLI_BOTH);
?>
<section class="content-header">
    <h1><?=$lang_ba_edit; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active"><?=$lang_ba_edit; ?></li>
    </ol>
</section>
<section class="content">
	<div class="box box-primary">
        <div class="box-body">
        	<form class="form-horizontal" method="post" enctype="multipart/form-data" target="ba_update" action="control_ba_update.php">
	        	<div class="row">
	        		<div class="col-md-3" align="center">
	        			<img src="<?php echo $path_image.$res_edit['book_image']; ?>" style="width:60%;height:60%;">
	        		</div>
        			<div class="col-md-9">
					    <div class="form-group">
						    <label class="col-md-3 control-label"><?=$lang_ba_barcode; ?></label>
						    <div class="col-md-8">
						        <p class="form-control-static"><?php echo $_GET['id']; ?></p>
						        <input type="hidden" name="barcode" value="<?php echo $_GET['id']; ?>">
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-md-3 control-label"><?=$lang_book_name; ?></label>
						    <div class="col-md-8">
						        <p class="form-control-static"><?php echo $res_edit['book_name']; ?></p>
						        <input type="hidden" name="media_name" value="<?php echo $res_edit['book_name']; ?>">
						    </div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=$lang_ba_detail; ?></label>
							<div class="col-md-8">
						  		<textarea name="detail" id="detail" class="form-control" rows="5" data-validation="required"><?php echo $res_edit['book_description']; ?></textarea>
						  		<font color="gray"><?=$lang_message_left_1; ?> <span id="pres-max-detail">500</span> <?=$lang_message_left_2; ?></font>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label"><?=$lang_ba_coverbook; ?></label>
							<div class="col-md-8">
						  		<input type="file" name="cover_book" id="cover_book" class="form-control" data-validation="mime size" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="<?=$lang_ba_remark_img; ?> 3 MB">
							</div>
						</div>
						<hr>
        			</div>
        		</div>
	        	<div>
			        <a href="?page=control_ba_list" class="btn btn-lg btn-flat btn-default" role="button"><span class="fa fa-arrow-left"> </span> <?=$lang_ba_back; ?></a>
			        <span class="pull-right">
			            <input name="submit_edit" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_edit" value="ยืนยันการแก้ไข">
			        </span>
			    </div>
	        </form>	
		    <iframe name="ba_update" id="ba_update" style="width: 0px;" frameborder="0" ></iframe>
		 </div>
	</div>
</section>

