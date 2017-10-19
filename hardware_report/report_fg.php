<script type="text/javascript">
		function fn_time(){
			if(document.fg_form.time_h_start.value > document.fg_form.time_h_end.value){ 
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.fg_form.time_h_start.value == document.fg_form.time_h_end.value && document.fg_form.time_m_start.value > document.fg_form.time_m_end.value){
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.fg_form.time_h_start.value == "--" || document.fg_form.time_h_end.value == "--" || document.fg_form.time_m_start.value == "--" || document.fg_form.time_m_end.value == "--"){
				alert( "กรุณาระบุเวลา" );return false;
			}
		}
</script>
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
    	    <li class="active"><a href="#">รายงานคนผ่านเข้า-ออกประตู</a></li>
    	    <li><a href="?page=report_fg_count">รายงานจำนวนคนผ่าน Flap Gate</a></li>
    	    <li><a href="?page=report_fg_time">รายงานระยะเวลาการใช้ห้องสมุด</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
				<div class="col-md-12">
			    	<form class="form" id="fg_form" name="fg_form" method="post" onsubmit="return fn_time();" target="report_generate" action="report_fg_generate.php">
			    		<div class="form-group col-sm-4">
			    			<label>ใส่รหัส,ชื่อหรือนามสกุล</label>
						    <input type="text" name="sort_by_text" class="form-control" placeholder="ใส่ข้อมูล">
						</div>
						<div class="form-group col-md-3">
						    <label>เลือกวันที่</label>
						    <div class="input-group">
				                <div class="input-group-addon">
				                  <i class="fa fa-calendar"></i>
				                </div>
				                <input type="text" class="form-control pull-right" name="date" id="reservation">
				            </div><!-- /.input group -->
						</div>
						<div class="form-group col-md-4">
						    <label>เลือกช่วงเวลา</label>
						    	<table>
						    			<tr><td>
							    		<select class="form-control input-sm" name="time_h_start" id="time_h_start" >
							    			<?php 
							    				echo "<option> -- </option>";
							    				for($time_h_s=0;$time_h_s<=23;$time_h_s++){
							    					if($time_h_s < 10){ ?>
														<option value="0<?php echo $time_h_s; ?>"<?php if($time_h_s < 1){ echo " selected"; } ?>>0<?php echo $time_h_s; ?></option>
													<?php }else{ ?>
														<option value="<?php echo $time_h_s; ?>"><?php echo $time_h_s; ?></option>
													<?php }
											 	} 
											?>
										</select></td><td>
							    		<select class="form-control input-sm" name="time_m_start" id="time_m_start" >
							    			<?php 
							    				echo "<option> -- </option>";
							    				for($time_m_s=0;$time_m_s<=59;$time_m_s++){ 
							    					if($time_m_s < 10){ ?>
														<option value="0<?php echo $time_m_s; ?>"<?php if($time_m_s < 1){ echo " selected"; } ?>>0<?php echo $time_m_s; ?></option>
													<?php }else{ ?>
														<option value="<?php echo $time_m_s; ?>"><?php echo $time_m_s; ?></option>
													<?php }
											 	} 
											?>
										</select></td> <td>&nbsp;</td> <td>ถึง</td> <td>&nbsp;</td> <td>
							    		<select class="form-control input-sm" name="time_h_end" id="time_h_end" >
							    			<?php 
							    				echo "<option> -- </option>";
							    				for($time_h_e=0;$time_h_e<=23;$time_h_e++){ 
							    					if($time_h_e < 10){ ?>
														<option value="0<?php echo $time_h_e; ?>">0<?php echo $time_h_e; ?></option>
													<?php }else{ ?>
														<option value="<?php echo $time_h_e; ?>"<?php if($time_h_e == 23){ echo " selected"; } ?>><?php echo $time_h_e; ?></option>
													<?php }
											 	} 
											?>
										</select></td><td>
							    		<select class="form-control input-sm" name="time_m_end" id="time_m_end" >
							    			<?php 
							    				echo "<option> -- </option>";
							    				for($time_m_e=0;$time_m_e<=59;$time_m_e++){ 
													if($time_m_e < 10){ ?>
														<option value="0<?php echo $time_m_e; ?>">0<?php echo $time_m_e; ?></option>
													<?php }else{ ?>
														<option value="<?php echo $time_m_e; ?>"<?php if($time_m_e == 59){ echo " selected"; } ?>><?php echo $time_m_e; ?></option>
													<?php }
											 	} 
											?>
										</select></td></tr>
								</table>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-3">
						    <label>ประเภทบุคคล</label>
						    <select class="form-control" name="type_human">
						    	<option value="all">ทั้งหมด</option>
						    	<?php
						    		$num_type = 0;
						    		$sql_type = "SELECT DISTINCT re_fg_mem_type FROM report_barrier";
						    		$query_type = mysqli_query($conn,$sql_type);
						    		$res_type = mysqli_fetch_all($query_type,MYSQLI_BOTH);
						    		foreach ($res_type as $key_type => $value_type) {
						    			$num_type++;
						    	?>
						    	<option value="<?php echo $num_type; ?>"><?php echo $value_type['re_fg_mem_type']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						    <label>ประเภทผ่านประตู</label>
						    <select class="form-control" name="type_gate">
						    	<option value="all_gate">ทั้งหมด</option>
						    	<option value="in_gate">เข้า</option>
						    	<option value="out_gate">ออก</option>
						    </select>
						</div>
						<div class="form-group col-md-8">
			                <label>กำหนด field ที่ต้องการออกรายงาน</label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
			                  <option value="1" selected="selected">วันที่</option>
			                  <option value="2" selected="selected">รหัสสมาชิก</option>
			                  <option value="3" selected="selected">ชื่อ-นามสกุล</option>
			                  <option value="4" selected="selected">ประเภทสมาชิก</option>
			                  <option value="5" selected="selected">ประเภทผ่านประตู</option>
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
