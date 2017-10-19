<section class="content-header">
    <h1>รายงาน Security Gate</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> REPORT</a></li>
      <li class="active">รายงาน Security Gate</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li><a href="?page=report_sg">รายงานหนังสือผ่านเข้า-ออกประตู </a></li>
    	    <li class="active"><a href="#">รายงานคนผ่านเข้า-ออกประตู</a></li>
    	    <li><a href="?page=report_sg_static_1">รายงานสถิติหนังสือ</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-lg-12">
			    	<form method="post" id="sg_form" name="sg_form" target="report_generate" action="report_sg_count_generate.php">
						<div class="form-group col-md-4">
						    <label>เลือกวันที่</label>
						    <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" name="date" id="reservation">
			                </div><!-- /.input group -->
						</div>
						<div class="form-group col-lg-3">
						    <label>หมายเลขเครื่อง</label>
						    <select class="form-control" name="machine">
						    	<option value="all_machine">ทั้งหมด</option>
						    	<?php
						    		$sql_machine = "SELECT DISTINCT re_sg_count_station_id FROM report_security_gate_count";
						    		$query_machine = mysqli_query($conn,$sql_machine);
						    		$res_machine = mysqli_fetch_all($query_machine,MYSQLI_BOTH);
						    		foreach ($res_machine as $key_machine => $value_machine) {
						    	?>
						    	<option value="<?php echo $value_machine['re_sg_count_station_id']; ?>"><?php echo $value_machine['re_sg_count_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-7">
			                <label>กำหนด field ที่ต้องการออกรายงาน</label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
			                  <option value="1" selected="selected">วันที่</option>
			                  <option value="2" selected="selected">หมายเลขเครื่อง</option>
			                  <option value="3" selected="selected">จำนวนหนังสือ</option>
			                </select>
			            </div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_sg" class="btn btn-primary">ออกรายงาน</button>
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