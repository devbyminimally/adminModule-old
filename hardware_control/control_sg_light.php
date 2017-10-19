<?php
	$sql_default = "SELECT hardware_cmd_value FROM hardware_cmd_set WHERE hardware_type = 'SG' AND hardware_cmd_name = 'light'";
	$query_default = mysqli_query($conn,$sql_default);
	$res_default = mysqli_fetch_array($query_default,MYSQLI_BOTH);
?>

<section class="content-header">
    <h1 class="page-header">การควบคุมแสงไฟเครื่อง SECURITY GATE <small>( <?php echo $hw_remark[0]." แผง ".$hw_remark[1]." ช่องทางเดิน "?>)</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">การควบคุมแสงไฟเครื่อง SECURITY GATE</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<form method="post" class="form-horizontal">
		    <div class="col-xs-4 col-lg-3">
		    	<div class="box" style="border-top-color: <?=$res_default['hardware_cmd_value'];?>;">
		            <div class="box-body no-padding">
		            	<table class="table">
					        <thead>
					          	<tr>
					            	<th style="width: 75%;">LASTEST COLOR</th>
					            	<th style="width: 20%;">Preview</th>
					          	</tr>
					        </thead>
					        <tbody>
					        <?php
					        	$i = 0;
								$sql_last = "SELECT save FROM log_save WHERE hardware_type = 'SG' AND type = 'color' ORDER BY datetime_update DESC";
								$query_last = mysqli_query($conn,$sql_last);
								while($res_last = mysqli_fetch_array($query_last,MYSQLI_BOTH)){ $i++;
							?>
					          	<tr>
					            	<td><?=$res_last['save']; ?><input type="hidden" name="text_color" id="text_color<?=$i; ?>" value="<?=$res_last['save']; ?>"></td>
					            	<td align="center"><button class="btn btn-xs" type="submit" name="change_color" onclick="document.getElementById('hex').value = document.getElementById('text_color<?=$i; ?>').value;saveNotReadyProfile();" style="background-color: <?=$res_last['save']; ?>;" ><i class="fa fa-eye fa-fw" style="color: #D3D3D3;"></i></button></td>
					          	</tr>
					        <?php  } ?>
					        </tbody>
					    </table>
			        </div>
			    </div>
			</div>
			<div class="col-xs-8 col-lg-5">
				<div class="box" style="border-top-color: <?=$res_default['hardware_cmd_value'];?>;">
		            <div class="box-header with-border">
		              <h3 class="box-title">NEW COLOR</h3>
		            </div><!-- /.box-header -->
		            <div class="box-body">
				        <div align="center">
				        	<!--<div class="form-group">
							    <label class="col-sm-3 control-label">PROFILE</label>
							    <div class="col-sm-9">

							    	<select id="cboProfile" name="cboProfile" class="form-control">
										<?php
											foreach($profiles as $vals)
											{
												echo "<option value='",$vals,"'>",$vals,"</option>";
											}
										?>
									</select>
							    </div>
							</div><hr>-->
				          	<div id="picker" onmousemove="document.getElementById('preview_color').style='width:250px;background-color:'+document.getElementById('hex').value;"></div><br>
				          	<div class="form-group">
							    <label class="col-sm-4 control-label">COLOR CODE</label>
							    <div class="col-sm-8">
							      	<input type="text" style="font-size:20px;font-weight: bold" class="form-control" id="hex" name="hex" value="<?=$res_default['hardware_cmd_value'];?>"  />
							      	<input type="hidden" name="cboProfile" id="cboProfile" value="<?=$profiles[0] ?>">
							    </div>
							</div><hr>
				          	<button type="submit" name="bnt" id="bnt" class="btn btn-success btn-lg btn-flat" onclick="saveNotReadyProfile();"><i class="fa fa-eye fa-fw"></i> Change</button><br>
						</div>
			        </div>
			    </div>            
			</div>
		</form>
			<div class="col-xs-12 col-lg-4">
				<div class="box" style="border-top-color:<?=$res_default['hardware_cmd_value'];?>;">
		            <div class="box-header with-border">
		              <h3 class="box-title">PREVIEW</h3>
		            </div><!-- /.box-header -->
		            <div class="box-body">
				        <div align="center">
					        <?php 
					        	$selecthw_sql = "SELECT DISTINCT hw_img FROM hardware_detail WHERE hw_code = 'SG'";
					        	$selecthw_query = mysqli_query($conn,$selecthw_sql);
					        	$selecthw_res = mysqli_fetch_array($selecthw_query,MYSQLI_BOTH);
					        ?>
					        <div style="background-color:<?=$res_default['hardware_cmd_value'];?>;width: 250px;" id="preview_color">
					        	<img src="img/hw/<?php echo $selecthw_res['hw_img']; ?>" height="400px">
					        </div>
						</div>
			        </div>
			    </div>            
			</div>
	</div>
</section>
<?php 
	if(isset($_POST['bnt']) || isset($_POST['change_color'])){
		$sql_count = "SELECT COUNT(save) AS count_save , MIN(datetime_update) AS min_date FROM log_save WHERE hardware_type = 'SG' AND TYPE = 'color'";
		$query_count = mysqli_query($conn,$sql_count);
		$res_count = mysqli_fetch_array($query_count,MYSQLI_BOTH);
		if($res_count['count_save'] <= 10){
			$insert_color = "INSERT INTO log_save(hardware_type,hardware_id,type,save,datetime_update)
							VALUES('SG','1','color','".$_POST['hex']."',now())";
			$insert_query = mysqli_query($conn,$insert_color);
		}else{
			$update_color1 = "UPDATE log_save SET save = '".$_POST['hex']."', datetime_update = now() WHERE hardware_type = 'SG' AND type = 'color' AND datetime_update = '".$res_count['min_date']."'";
			$update_query1 = mysqli_query($conn,$update_color1);
		}

		$update_color2 = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['hex']."' WHERE hardware_type = 'SG' AND hardware_cmd_name = 'light'";
		$update_query2 = mysqli_query($conn,$update_color2);

		echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 

	}

?>