<?php 
	$sql_msg = "SELECT hardware_cmd_value FROM join_hardware_cmd WHERE hardware_type = 'BD' AND hardware_cmd_name = 'station_id' ";
	$query_msg = mysqli_query($conn,$sql_msg);
	$res_msg = mysqli_fetch_all($query_msg,MYSQLI_BOTH);
?>
<section class="content-header">
    <h1>การกำหนดข้อความประชาสัมพันธ์</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">การกำหนดข้อความประชาสัมพันธ์</li>
    </ol>
</section>
<section class="content">
	<div class="box box-primary">
        <div class="box-body">
		    <div class="row">
		    	<form class="form-horizontal " method="post">
		    		<div class="col-md-6">
						<div class="form-group">
			    			<label class="col-sm-3 control-label"><?=$lang_message_thai; ?></label>
			    			<div class="col-sm-8">
			    				<textarea class="form-control" name="msg_pre_th" id="msg_pre_th" rows="3" data-validation="required"></textarea>
		    					<font color="gray"><?=$lang_message_left_1; ?> <span id="pres-max-length_th">1000</span> <?=$lang_message_left_2; ?></font>
		    				</div>
		    			</div>
		    			<div class="form-group">
		    				<label class="col-sm-3 control-label"><?=$lang_message_english; ?></label>
		    				<div class="col-sm-8">
		    					<textarea class="form-control" name="msg_pre_en" id="msg_pre_en" rows="3" data-validation="required"></textarea>
		    					<font color="gray"><?=$lang_message_left_1; ?> <span id="pres-max-length_en">1000</span> <?=$lang_message_left_2; ?></font>
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-6">
		    			<div class="form-group">
		    				<label class="col-sm-3 control-label"><?=$lang_station_id; ?></label>
		    				<div class="col-sm-6">
		    					<?php 	foreach ($res_msg as $value_msg) { ?>
		    					<label class="checkbox-inline">
								  <input type="checkbox" name="select_hardware[]" value="<?=$value_msg['hardware_cmd_value']; ?>"> <?=$value_msg['hardware_cmd_value']; ?>
								</label>
						        <?php } ?>
		    				</div>
		    			</div>
		    			<div class="form-group">
		    				<label class="col-sm-3 control-label"><?=$lang_playspeed; ?></label>
		    				<div class="col-sm-8">
								<label class="radio-inline">
								  <input type="radio" name="playspeed" value="150"> Slow
								</label>
		    					<label class="radio-inline">
								  <input type="radio" name="playspeed" value="6" checked> <?=$lang_default; ?>
								</label>
		    					<label class="radio-inline">
								  <input type="radio" name="playspeed" value="10" > Fast1
								</label>
								<label class="radio-inline">
								  <input type="radio" name="playspeed" value="15"> Fast2
								</label>
		    				</div>
		    			</div>
		    			<div class="form-group">
		    				<label class="col-sm-3 control-label"><?=$lang_fontsize; ?></label>
		    				<div class="col-sm-6">
		    					<div class="input-group">
		    						<input type="text" name="msg_size" id="msg_size" class="form-control" data-validation="number" data-validation-allowing="range[12;30]" data-validation-error-msg=" " value="14">
		    						<span class="input-group-addon">PX</span>
		    					</div>
		    					<font color="gray" size="2">**<?=$lang_remark_fontsize; ?></font>
		    				</div>
		    			</div>
		    			<div class="form-group">
		    				<label class="col-sm-3 control-label"><?=$lang_fontcolor; ?></label>
		    				<div class="col-sm-6">
		    					<div class=" input-group my-colorpicker2">
		    						<div class="input-group-addon"><i></i></div>
                      				<input type="text" class="form-control" name="msg_color" id="msg_color" value="#000000">
                      			</div>
		    				</div>
		    			</div>
		    		</div>
		    		<div class="col-md-12" align="center">
		    			<button type="submit" name="change_msg" class="btn btn-success btn-flat"><i class="fa fa-save"></i> <?=$lang_message_submit; ?></button>
		    			<button type="button" name="preview_msg" class="btn btn-primary btn-flat" onclick="preview_msg1();"><i class="fa fa-eye"></i> <?=$lang_message_preview; ?></button>
		    			<hr>
		    		</div>
		    	</form>
		    	<div class="col-md-12">
		    		<div id="result_msg_th"></div>
		    		<hr>
		    	</div>
		    	<div class="col-md-12">
		    		<div id="result_msg_en"></div>
		    	</div>
		    </div>
		 </div>
	</div>

</section>
<script type="text/javascript">
	function preview_msg1(){
		var txt_th = document.getElementById('msg_pre_th').value,
			txt_en = document.getElementById('msg_pre_en').value,
			txt_speed = document.getElementsByName('playspeed'),
			txt_size = document.getElementById('msg_size').value,
			txt_color = document.getElementById('msg_color').value;
		for (var i = 0; i < txt_speed.length; i++) {
			if (txt_speed[i].checked && txt_speed[i].value < 60) {
				//alert(txt_speed[i].value);
				var txt_speed2 = " SCROLLAMOUNT='"+txt_speed[i].value+"' ";
				var txt_style = " style='color:"+txt_color+";font-size:"+txt_size+"px;' ";
				document.getElementById('result_msg_th').innerHTML = "<MARQUEE "+txt_speed2+txt_style+"><?=$lang_message_thai; ?> : "+txt_th+"</MARQUEE>";
				document.getElementById('result_msg_en').innerHTML = "<MARQUEE "+txt_speed2+txt_style+"><?=$lang_message_english; ?> : "+txt_en+"</MARQUEE>";
			}
			else if(txt_speed[i].checked && txt_speed[i].value > 60){
				//alert(txt_speed[i].value);
				var txt_speed2 = " SCROLLDELAY='"+txt_speed[i].value+"' ";
				var txt_style = " style='color:"+txt_color+";font-size:"+txt_size+"px;' ";
				document.getElementById('result_msg_th').innerHTML = "<MARQUEE "+txt_speed2+txt_style+"><?=$lang_message_thai; ?> : "+txt_th+"</MARQUEE>";
				document.getElementById('result_msg_en').innerHTML = "<MARQUEE "+txt_speed2+txt_style+"><?=$lang_message_english; ?> : "+txt_en+"</MARQUEE>";
			}
		}
		


	}
</script>
<?php 
	if(isset($_POST['change_msg'])){
		echo "<br><br><br><br><br><br><br><br><br>";
		$msg_color = $_POST['msg_color'];
		$msg_size = $_POST['msg_size'];
		if($_POST['playspeed'] < 60){
			$playspeed = " SCROLLAMOUNT=\'".$_POST['playspeed']."\' ";
			$msg_style = " style=\'color:".$msg_color.";font-size:".$msg_size."px;\' ";
			$msg_for_thai = "<MARQUEE ".$playspeed.$msg_style.">".$_POST['msg_pre_th']."</MARQUEE>";
			$msg_for_english = "<MARQUEE ".$playspeed.$msg_style.">".$_POST['msg_pre_en']."</MARQUEE>";
		}else{
			$playspeed = " SCROLLDELAY=\'".$_POST['playspeed']."\' ";
			$msg_style = " style=\'color:".$msg_color.";font-size:".$msg_size."px;\' ";
			$msg_for_thai = "<MARQUEE ".$playspeed.$msg_style.">".$_POST['msg_pre_th']."</MARQUEE>";
			$msg_for_english = "<MARQUEE ".$playspeed.$msg_style.">".$_POST['msg_pre_en']."</MARQUEE>";
		}
		if(count($_POST['select_hardware']) != 0){
			foreach ($_POST['select_hardware'] as $key => $value_select_hardware) {
				$sql_msg2 = "SELECT hardware_cmd,hardware_cmd_value FROM join_hardware_cmd WHERE hardware_type = '".substr($value_select_hardware, 0, 2)."' AND hardware_id = '".substr($value_select_hardware, -1)."'";
				$query_msg2 = mysqli_query($conn,$sql_msg2);
				$res_msg2 = mysqli_fetch_array($query_msg2,MYSQLI_BOTH);

				$upload_th_sql = "UPDATE hardware_cmd_set SET hardware_cmd_value = '$msg_for_thai' WHERE hardware_cmd = '".$res_msg2['hardware_cmd']."' AND hardware_cmd_name = 'msg_th' ";
				echo $upload_th_query = mysqli_query($conn,$upload_th_sql);
				$upload_en_sql = "UPDATE hardware_cmd_set SET hardware_cmd_value = '$msg_for_english' WHERE hardware_cmd = '".$res_msg2['hardware_cmd']."' AND hardware_cmd_name = 'msg_en' ";
				$upload_en_query = mysqli_query($conn,$upload_en_sql);
			}
		}else {
			echo "<script type=\"text/javascript\">alert('กรุณาเลือกหมายเลขเครื่อง') </script>"; 
		}

		echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
	}

?>

