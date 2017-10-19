<section class="content-header">
    <h1>รายงาน FLAP GATE</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> REPORT</a></li>
      <li class="active">รายงาน FLAP GATE</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li><a href="?page=report_fg">รายงานคนผ่านเข้า-ออกประตู</a></li>
    	    <li class="active"><a href="#">รายงานจำนวนคนผ่าน Flap Gate</a></li>
    	    <li><a href="?page=report_fg_time">รายงานระยะเวลาการใช้ห้องสมุด</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-md-12">
			    	<form class="form" id="fg_form" name="fg_form" method="post" target="report_generate" action="report_fg_count_generate.php">
						<div class="form-group col-md-4">
						    <label>เลือกวันที่</label>
						    <div class="input-group">
						        <div class="input-group-addon">
						          <i class="fa fa-calendar"></i>
						        </div>
						        <input type="text" class="form-control pull-right" name="date" id="reservation">
						    </div><!-- /.input group -->
						</div>
						<div class="form-group col-md-3">
						    <label>ช่องทาง</label>
						    <select class="form-control" name="machine">
						    	<option value="all_machine">ทั้งหมด</option>
						    	<?php
						    		$sql_machine = "SELECT DISTINCT re_fg_count_station_id FROM report_barrier_count";
						    		$query_machine = mysqli_query($conn,$sql_machine);
						    		$res_machine = mysqli_fetch_all($query_machine,MYSQLI_BOTH);
						    		foreach ($res_machine as $key_machine => $value_machine) {
						    	?>
						    	<option value="<?php echo $value_machine['re_fg_count_station_id']; ?>"><?php echo $value_machine['re_fg_count_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_fg" class="btn btn-primary">ออกรายงาน</button>
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