<section class="content-header">
    <h1>รายงาน Book ATM</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> REPORT</a></li>
      <li class="active">รายงาน Book ATM</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li class="active"><a href="#">รายงานการยืม-คืน-ยืมต่อ หนังสือ </a></li>
    	    <li><a href="?page=report_ba_pic">รายงานการยืม-คืน-ยืมต่อ หนังสือ (แสดงภาพ)</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-sm-12">
			    	<form class="form" id="ba_form" name="ba_form" method="post" target="report_generate" action="report_ba_generate.php" >
						<div class="form-group col-md-3">
						    <label>เลือกวันที่</label>
						    <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" name="date" id="reservation">
			                </div><!-- /.input group -->
						</div>
						<div class="form-group col-md-2">
						    <label>หมายเลขเครื่อง</label>
						    <select class="form-control" name="group" >
						    	<option value="all">ทั้งหมด</option>
						    	<?php
						    		$sql_group = "SELECT DISTINCT re_ba_station_id FROM report_bookatm";
						    		$query_group = mysqli_query($conn,$sql_group);
						    		$res_group = mysqli_fetch_all($query_group,MYSQLI_BOTH);
						    		foreach ($res_group as $key_group => $value_group) {
						    	?>
						    	<option value="<?php echo $value_group['re_ba_station_id']; ?>"><?php echo $value_group['re_sc_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-2">
						    <label>ประเภท</label>
						    <select class="form-control" name="type">
						    	<option value="all">ทั้งหมด</option>
						    	<option value="BORROW">ยืม</option>
						    	<option value="RETURN">คืน</option>
						    	<option value="RENEW">ยืมต่อ</option>
						    </select>
						</div>
						<div class="form-group col-md-2">
						    <label>สถานะหนังสือ</label>
						    <select class="form-control" name="status">
						    	<option value="all">ทั้งหมด</option>
						    	<option value="Success">สำเร็จ</option>
						    	<option value="Fail">ผิดพลาด</option>
						    </select>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-8">
			                <label>กำหนด field ที่ต้องการออกรายงาน</label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
				                <option value="1" selected="selected">วันที่</option>
				                <option value="2" selected="selected">รหัสเครื่อง</option>
				    			<option value="3" selected="selected">ประเภท</option>
			                    <option value="4" selected="selected">รหัสสมาชิก</option>
			                    <option value="5" selected="selected">ชื่อสมาชิก</option>
			                    <option value="6" selected="selected">รหัสหนังสือ</option>
			                    <option value="7" selected="selected">ชื่อหนังสือ</option>
			                    <option value="8" selected="selected">วันที่คืน</option>
			                    <option value="9" selected="selected">สถานะ</option>
			                </select>
			            </div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_ba" class="btn btn-primary">ออกรายงาน</button>
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
