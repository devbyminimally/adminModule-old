<section class="content-header">
    <h1><?=$lang_report_sc; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i><?=$lang_report; ?></a></li>
      <li class="active"><?=$lang_report_sc; ?></li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li><a href="?page=report_sc"><?=$lang_report_sc_1; ?></a></li>
    	    <li class="active"><a href="#"><?=$lang_report_sc_2; ?></a></li>
    	    <li><a href="?page=report_sc_static_1"><?=$lang_report_sc_3; ?></a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-sm-12">
			    	<form class="form" id="sc_form" name="sc_form" method="post" target="report_generate" action="report_sc_pic_generate.php" >
						<div class="form-group col-md-3">
						    <label><?=$lang_select_date; ?></label>
						    <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" name="date" id="reservation">
			                </div><!-- /.input group -->
						</div>
						<div class="form-group col-md-2">
						    <label><?=$lang_station_id; ?></label>
						    <select class="form-control" name="group" >
						    	<option value="all"><?=$lang_all; ?></option>
						    	<?php
						    		$sql_group = "SELECT DISTINCT re_sc_station_id FROM report_selfcheck";
						    		$query_group = mysqli_query($conn,$sql_group);
						    		$res_group = mysqli_fetch_all($query_group,MYSQLI_BOTH);
						    		foreach ($res_group as $key_group => $value_group) {
						    	?>
						    	<option value="<?php echo $value_group['re_sc_station_id']; ?>"><?php echo $value_group['re_sc_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-2">
						    <label><?=$lang_type; ?></label>
						    <select class="form-control" name="type">
						    	<option value="all"><?=$lang_all; ?></option>
						    	<option value="BORROW"><?=$lang_borrow; ?></option>
						    	<option value="RETURN"><?=$lang_return; ?></option>
						    	<option value="RENEW"><?=$lang_renew; ?></option>
						    </select>
						</div>
						<div class="form-group col-md-2">
						    <label><?=$lang_status; ?></label>
						    <select class="form-control" name="status">
						    	<option value="all"><?=$lang_all; ?></option>
						    	<option value="Success"><?=$lang_success; ?></option>
						    	<option value="Fail"><?=$lang_fail; ?></option>
						    </select>
						</div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_sc" class="btn btn-primary"><?=$lang_export; ?></button>
						</div>
					</form>
				</div>
				<div class="col-md-12">
					<iframe name="report_generate" id="report_generate" src="about:blank;" style="width: 100%;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
			    </div>
			</div>
		</div>
	</div>
</section>