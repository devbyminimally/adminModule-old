<script type="text/javascript">
		function fn_time(){
			if(document.ss_form.time_h_start.value > document.ss_form.time_h_end.value){ 
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.ss_form.time_h_start.value == document.ss_form.time_h_end.value && document.ss_form.time_m_start.value > document.ss_form.time_m_end.value){
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.ss_form.time_h_start.value == "--" || document.ss_form.time_h_end.value == "--" || document.ss_form.time_m_start.value == "--" || document.ss_form.time_m_end.value == "--"){
				alert( "กรุณาระบุเวลา" );return false;
			}
		}

</script>
<section class="content-header">
    <h1>รายงาน STAFF STATION</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> REPORT</a></li>
      <li class="active">รายงาน STAFF STATION</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li class="active"><a href="#" data-toggle="tab">รายงานหนังสือที่ลงทะเบียน RFID </a></li>
    	    <li><a href="?page=report_ss_static_1"><?=$lang_report_ss_1; ?></a></li>
    	    
    	</ul>
    	<div class="tab-content">
			<div class="row">
				<div class="col-md-12">
	    			<form class="form" id="ss_form" name="ss_form" method="post" onsubmit="return fn_time();" target="report_generate" action="report_ss_generate.php">
			    		<div class="form-group col-md-4">
						    <label>ใส่รหัสหนังสือหรือชื่อหนังสือ</label>
						    <input type="text" name="book_id_name" class="form-control" placeholder="ใส่รหัสหนังสือหรือชื่อหนังสือ">
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
						<div class="form-group col-md-5">
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
						    <label>เลือกเครื่อง </label>
							<select class="form-control" name="type_ss">
						    	<option value="all_ss">ทั้งหมด</option>
						    	<?php
						    		$sql_type = "SELECT DISTINCT re_ss_station_id FROM report_staff_station";
						    		$query_type = mysqli_query($conn,$sql_type);
						    		$res_type = mysqli_fetch_all($query_type,MYSQLI_BOTH);
						    		foreach ($res_type as $key_type => $value_type) {
						    	?>
						    	<option value="<?php echo $value_type['re_ss_station_id']; ?>"><?php echo $value_type['re_ss_station_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div> 
						<div class="form-group col-md-3">
						    <label>ชื่อผู้ใช้</label>
						    <select class="form-control" name="user">
						    	<option value="all">ทั้งหมด</option>
						    	<?php
						    		$sql_user = "SELECT DISTINCT re_ss_book_user FROM report_staff_station";
						    		$query_user = mysqli_query($conn,$sql_user);
						    		$res_user = mysqli_fetch_all($query_user,MYSQLI_BOTH);
						    		foreach ($res_user as $key_user => $value_user) {
						    	?>
						    	<option value="<?php echo $value_user['re_ss_book_user']; ?>"><?php echo $value_user['re_ss_book_user']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-8">
			                <label>กำหนด field ที่ต้องการออกรายงาน</label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
			                  <option value="1" selected="selected">วันที่</option>
			                  <option value="2" selected="selected">รหัสเครื่อง</option>
			                  <option value="3" selected="selected">รหัสหนังสือ</option>
			                  <option value="4" selected="selected">เลขเรียกหนังสือ</option>
			                  <option value="5" selected="selected">ชื่อหนังสือ</option>
			                  <option value="6" selected="selected">ชื่อผู้ใช้</option>
			                </select>
			            </div>
						<div class="form-group col-md-12">
							<label></label>
							<button type="submit" name="report_ss" class="btn btn-primary">ออกรายงาน</button>
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

