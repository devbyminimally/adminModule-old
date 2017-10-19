<section class="content-header">
    <h1 class="page-header">การควบคุมเสียงเครื่อง SECURITY GATE <small>( <?php echo $hw_remark[0]." แผง ".$hw_remark[1]." ช่องทางเดิน "?>)</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">การควบคุมเสียงเครื่อง SECURITY GATE</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-3">
			<div class="box">
		        <div class="box-body no-padding">
		        	<table class="table">
					    <thead>
					      	<tr>
					        	<th style="width: 75%;">LASTEST SOUND</th>
					        	<th style="width: 20%;">Select</th>
					      	</tr>
					    </thead>
					    <tbody>
					    <?php
					    	$i = 0;
							$sql_last = "SELECT save FROM log_save WHERE hardware_type = 'SG' AND type = 'sound' ORDER BY datetime_update DESC";
							$query_last = mysqli_query($conn,$sql_last);
							while($res_last = mysqli_fetch_array($query_last,MYSQLI_BOTH)){ $i++;
						?>
					      	<tr>
					      		<form method="post">
					        	<td><?=$res_last['save']; ?><input type="hidden" name="text_sound" id="text_sound<?=$i; ?>" value="<?=$res_last['save']; ?>"></td>
					        	<td align="center"><button class="btn btn-xs" type="submit" name="change_sound" onclick="document.getElementById('cboSoundAlarm').value = document.getElementById('text_sound<?=$i; ?>').value; saveSetting();" ><i class="fa fa-volume-up fa-fw" style="color: #4F4F4F;"></i></button></td>
					        	</form>
					      	</tr>
					    <?php  } ?>
					    </tbody>
					</table>
		        </div>
		    </div>
		</div>
		<div class="col-lg-8">
			<div class="box ">
		        <div class="box-body">
		        	<form id="uploadSound" enctype="multipart/form-data" action="<?=$gateUrl?>api/sounds/upload?<?=$gateToken?>" method="post" class="form-inline">
				        <div class="form-group">
							<label>Upload Sound Alarm</label>
							<input type="file" name="sound" class="form-control" data-validation="mime size required" data-validation-allowing="mp3" data-validation-max-size="3M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์ .mp3 และขนาดไม่เกิน 3 MB" multiple/>
							<button type="submit" class="btn btn-primary btn-flat" name="submit"><i class="fa fa-upload fa-fw"></i> Upload Sound </button> 
						</div>
					</form>
					<hr>
					<form class="form-inline" method="post" name="form_select_sound">
						<div class="form-group">
							<label>Select Alarm</label>
							<input type="hidden" name="cboProfile" id="cboProfile" value="<?=$profiles[0] ?>">
							<select class="form-control" id="cboSoundAlarm" name="cboSoundAlarm">
								<?php
									$sql_default = "SELECT hardware_cmd_value FROM hardware_cmd_set WHERE hardware_type = 'SG' AND hardware_cmd_name = 'alarm'";
									$query_default = mysqli_query($conn,$sql_default);
									$res_default = mysqli_fetch_array($query_default,MYSQLI_BOTH);
									foreach($sounds as $vals)
									{
										if($vals == $res_default['hardware_cmd_value']){
											echo "<option value='".$vals."' selected>".$vals."</option>";
										}
										else{
											echo "<option value='".$vals."'>".$vals."</option>";
										}
										
									}
								?>
							</select>
							<button onclick="saveSetting();" type="submit" name="select_sound" class="btn btn-success btn-flat"><i class="fa fa-check fa-fw"></i> Select Sound</button>
							<button onclick="deleteSound();" class="btn btn-danger btn-flat"><i class="fa fa-close fa-fw"></i> Delete Sound</button>
						</div>
					</form>
					<hr>					
					<table class="table">
						<tbody>
							<tr>
								<th>ทดสอบเสียงจาก Software</th>
								<td>
									<audio controls> 
										<source src="<?=$gateUrl;?>api/sounds/download/<?=$res_default['hardware_cmd_value']?>?<?=$gateToken?>" type="audio/mpeg"> 
										Your browser does not support the audio element. 
									</audio>
								</td>
							</tr>
							<tr>
								<th>ทดสอบเสียงจาก Hardware</th>
								<td id="test_sound"><a onclick="play_control();" class="btn btn-app"><i class="fa fa-play text-primary" ></i> Play</a></td>
							</tr>
						</tbody>
					</table>
						
						
			    </div>            
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function play_control() {
		gateAlarm('1');
		document.getElementById('test_sound').innerHTML = '<a onclick="stop_control();" class="btn btn-app"><i class="fa fa-stop text-danger" ></i> Stop</a>';
		
	}
	function stop_control() {
		gateAlarm('0');
		document.getElementById('test_sound').innerHTML = '<a onclick="play_control();" class="btn btn-app"><i class="fa fa-play text-primary" ></i> Play</a>';
		
	}
</script>
<?php 
	if(isset($_POST['select_sound'])){
		$sql_count = "SELECT COUNT(save) AS count_save , MIN(datetime_update) AS min_date FROM log_save WHERE hardware_type = 'SG' AND TYPE = 'sound'";
		$query_count = mysqli_query($conn,$sql_count);
		$res_count = mysqli_fetch_array($query_count,MYSQLI_BOTH);
		if($res_count['count_save'] <= 10){
			$insert_sound = "INSERT INTO log_save(hardware_type,hardware_id,type,save,datetime_update)
							VALUES('SG','1','sound','".$_POST['cboSoundAlarm']."',now())";
			$insert_query = mysqli_query($conn,$insert_sound);
		}else{
			$update_sound1 = "UPDATE log_save SET save = '".$_POST['cboSoundAlarm']."', datetime_update = now() WHERE hardware_type = 'SG' AND type = 'sound' AND datetime_update = '".$res_count['min_date']."'";
			$update_query1 = mysqli_query($conn,$update_sound1);
		}

		$update_sound2 = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['cboSoundAlarm']."' WHERE hardware_type = 'SG' AND hardware_cmd_name = 'alarm'";
		$update_query2 = mysqli_query($conn,$update_sound2);

		echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 

	}
	if(isset($_POST['change_sound'])){
		$sql_count = "SELECT COUNT(save) AS count_save , MIN(datetime_update) AS min_date FROM log_save WHERE hardware_type = 'SG' AND TYPE = 'sound'";
		$query_count = mysqli_query($conn,$sql_count);
		$res_count = mysqli_fetch_array($query_count,MYSQLI_BOTH);
		if($res_count['count_save'] <= 10){
			$insert_sound = "INSERT INTO log_save(hardware_type,hardware_id,type,save,datetime_update)
							VALUES('SG','1','sound','".$_POST['text_sound']."',now())";
			$insert_query = mysqli_query($conn,$insert_sound);
		}else{
			$update_sound1 = "UPDATE log_save SET save = '".$_POST['text_sound']."', datetime_update = now() WHERE hardware_type = 'SG' AND type = 'sound' AND datetime_update = '".$res_count['min_date']."'";
			$update_query1 = mysqli_query($conn,$update_sound1);
		}

		$update_sound2 = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['text_sound']."' WHERE hardware_type = 'SG' AND hardware_cmd_name = 'alarm'";
		$update_query2 = mysqli_query($conn,$update_sound2);

		echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 

	}

?>