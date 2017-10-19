<script type="text/javascript">
		function fn_time(){
			if(document.mc_form.time_h_start.value > document.mc_form.time_h_end.value){ 
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.mc_form.time_h_start.value == document.mc_form.time_h_end.value && document.mc_form.time_m_start.value > document.mc_form.time_m_end.value){
				alert( "เลือกช่วงเวลาไม่ถูกต้อง กรุณาเลือกใหม่อีกครั้ง" );return false;
			}
			if(document.mc_form.time_h_start.value == "--" || document.mc_form.time_h_end.value == "--" || document.mc_form.time_m_start.value == "--" || document.mc_form.time_m_end.value == "--"){
				alert( "กรุณาระบุเวลา" );return false;
			}
		}
</script>
<section class="content-header">
    <h1><?=$lang_report_mc; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i><?=$lang_report; ?></a></li>
      <li class="active"><?=$lang_report_mc; ?></li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li class="active"><a href="#"><?=$lang_report_mc_1; ?></a></li>
    	</ul>
		<div class="tab-content">
			<div class="row">
			    <div class="col-lg-12">
			    	<form class="form" id="mc_form" name="mc_form" method="post" onsubmit="return fn_time();" target="report_generate" action="report_mc_generate.php">
						<div class="form-group demo col-md-3">
						    <label><?=$lang_select_date; ?></label>
						    <div class="input-group">
			                    <div class="input-group-addon">
			                      <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" name="date" id="reservation">
			                </div><!-- /.input group -->
						</div>
						<div class="form-group col-md-9">
						    <label><?=$lang_rang_time;?></label>
						    	<table>
							    	<tr><td>
								    <select class="form-control input-sm" name="time_h_start" id="time_h_start" >
								    	<?php 
								    		echo "<option> -- </option>";
								    		for($time_h_s=0;$time_h_s<=23;$time_h_s++){
								    			if($time_h_s < 10){ ?>
													<option value="0<?php echo $time_h_s; ?>"<?php if($time_h_s < 1){echo "selected"; } ?>>0<?php echo $time_h_s; ?></option>
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
													<option value="0<?php echo $time_m_s; ?>"<?php if($time_m_s < 1){echo "selected"; } ?>>0<?php echo $time_m_s; ?></option>
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
													<option value="<?php echo $time_h_e; ?>"<?php if($time_h_e == 23){echo "selected"; } ?>><?php echo $time_h_e; ?></option>
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
													<option value="<?php echo $time_m_e; ?>"<?php if($time_m_e == 59){echo "selected"; } ?>><?php echo $time_m_e; ?></option>
												<?php }
										 	} 
										?>
									</select></td></tr>
								</table>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-3">
						    <label>ชื่อที่บันทึก</label>
						    <select class="form-control" name="group">
						    	<option value="all"><?=$lang_all; ?></option>
						    	<?php
						    		$num = 0;
						    		$sql_group = "SELECT DISTINCT save_id FROM savedinventory";
						    		$query_group = mysqli_query($conn,$sql_group);
									$res_group = mysqli_fetch_all($query_group,MYSQLI_BOTH);
						    		foreach ($res_group as $key_group => $value_group) {
						    			$num++;
						    	?>
						    	<option value="<?php echo $num; ?>"><?php echo $value_group['save_id']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						    <label>เลือกตำแหน่งที่เก็บ</label>
						    <select class="form-control" name="area">
						    	<option value="all"><?=$lang_all; ?></option>
						    	<?php
						    		$sql_area = "SELECT DISTINCT savedinventory.position_id , locations.location_name 
												FROM savedinventory 
												INNER JOIN locations 
												ON savedinventory.position_id = locations.id";
						    		$query_area = mysqli_query($conn,$sql_area);
									$res_area = mysqli_fetch_all($query_area,MYSQLI_BOTH);
						    		foreach ($res_area as $key_area => $value_area) {
						    	?>
						    	<option value="<?php echo $value_area['position_id']; ?>"><?php echo $value_area['location_name']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="form-group col-md-3">
						    <label><?=$lang_status; ?></label>
						    <select class="form-control" name="status">
						    	<option value="all"><?=$lang_all; ?></option>
						    	<?php
						    		$num1 = 0;
						    		$sql_status = "SELECT DISTINCT status FROM savedinventory";
						    		$query_status = mysqli_query($conn,$sql_status);
						 			$res_status = mysqli_fetch_all($query_status,MYSQLI_BOTH);
						    		foreach ($res_status as $key_status => $value_status) {
						    			$num1++;
						    	?>
						    	<option value="<?php echo $num1; ?>"><?php echo $value_status['status']; ?></option>
						    	<?php } ?>
						    </select>
						</div>
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group col-md-8">
			                <label><?=$lang_field; ?></label>
			                <select class="form-control select2" name="fieldName[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
				                <option value="1" selected="selected"><?=$lang_date; ?></option>
				                <option value="2" selected="selected"><?=$lang_name_save; ?></option>
			                    <option value="3" selected="selected"><?=$lang_book_id; ?></option>
			                    <option value="4" selected="selected"><?=$lang_book_name; ?></option>
			                    <option value="5" selected="selected"><?=$lang_position; ?></option>
			                    <option value="6" selected="selected"><?=$lang_status; ?></option>
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
