<section class="content-header">
    <h1>รายงาน Book Drop</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> REPORT</a></li>
      <li class="active">รายงาน Book Drop</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li class="active"><a href="#">รายงานคืนหนังสือ</a></li>
    	    <li><a href="?page=report_bd_pic">รายงานคืนหนังสือ (แสดงภาพ)</a></li>
    	    <li><a href="?page=report_bd_static_1">รายงานสถิติการใช้บริการ Book drop</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-sm-12">
			    	<form class="form" id="bd_form" name="bd_form" method="post" target="report_generate" action="report_bd_generate.php" >
			    		<div class="form-group col-md-4">
						    <label>ใส่รหัสหนังสือหรือชื่อหนังสือ</label>
						    <input type="text" name="book_id_name" class="form-control" placeholder="ใส่รหัสหนังสือหรือชื่อหนังสือ">
						</div>
						<div class="form-group col-md-3">
						    <label><?=$lang_select_date; ?></label>
						    <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" name="date" id="reservation">
			                </div><!-- /.input group -->
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-3">
						    <label>หมายเลขเครื่อง</label>
						    <select class="form-control" name="group" >
						    	<option value="all">ทั้งหมด</option>
						    	<?php
						    		$sql_group = "SELECT DISTINCT re_bd_station_id FROM report_bookdrop";
						    		$query_group = mysqli_query($conn,$sql_group);
						    		$res_group = mysqli_fetch_all($query_group,MYSQLI_BOTH);
						    		foreach ($res_group as $key_group => $value_group) {
						    	?>
						    	<option value="<?php echo $value_group['re_bd_station_id']; ?>"><?php echo $value_group['re_bd_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						    <label><?=$lang_status; ?></label>
						    <select class="form-control" name="status">
						    	<option value="all">ทั้งหมด</option>
						    	<option value="SUCCESS">สำเร็จ</option>
						    	<option value="FAIL">ผิดพลาด</option>
						    </select>
						</div>
						
						<div class="form-group col-md-8">
			                <label><?=$lang_field; ?></label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
				                <option value="1" selected="selected"><?=$lang_date; ?></option>
				                <option value="2" selected="selected"><?=$lang_station_id; ?></option>
			                    <option value="3" selected="selected"><?=$lang_book_id; ?></option>
			                    <option value="4" selected="selected"><?=$lang_book_name; ?></option>
			                    <option value="5" selected="selected"><?=$lang_status; ?></option>
			                </select>
			            </div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_bd" class="btn btn-primary"><?=$lang_export; ?></button>
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
