<?php 
	$sql_msg = "SELECT DATE_FORMAT(open_time, '%H:%i') as open_time , DATE_FORMAT(close_time, '%H:%i') as close_time , weekday
				FROM log_schedule 
				WHERE (hardware_type = 'SC' OR hardware_type = 'DC') 
				ORDER BY no DESC LIMIT 1";
	$query_msg = mysqli_query($conn,$sql_msg);
	$num_row = mysqli_num_rows($query_msg);
	$res_msg = mysqli_fetch_array($query_msg,MYSQLI_BOTH);
?>
<section class="content-header">
    <h1><?=$lang_sc_schedule; ?></h1>
    <ol class="breadcrumb">
      	<li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      	<li class="active"><?=$lang_sc_schedule; ?></li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-offset-1 col-md-9">
			<div class="box box-primary">
		        <div class="box-body">
					<form class="form-horizontal" method="post">
						<div class="form-group">
						    <label class="col-sm-3 control-label"><?=$lang_time_open;?></label>
						    <div class="col-sm-4">
						    	<input type="time" class="form-control" name="time_open">
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-3 control-label"><?=$lang_time_close;?></label>
						    <div class="col-sm-4">
						    	<input type="time" class="form-control" name="time_close">
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-3 control-label">กำหนดวันในสัปดาห์</label>
						    <div class="col-sm-9">
						    	<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day1" value="1"> วันอาทิตย์
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day2" value="2"> วันจันทร์
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day3" value="3"> วันอังคาร
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day4" value="4"> วันพุธ
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day5" value="5"> วันพฤหัสบดี
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day6" value="6"> วันศุกร์
								</label>
								<label class="checkbox-inline">
								  	<input type="checkbox" name="day_name[]" id="day7" value="7"> วันเสาร์
								</label>
						    </div>
						</div>
						<hr>
						<div class="box box-primary box-solid">
			                <div class="box-body row">
			                	<?php if($num_row != 0){ ?>
			                	<div class="col-sm-4" align="right"><b><?=$lang_time_open;?></b></div>
			                	<div class="col-sm-8">
			                		<?php echo $res_msg['open_time']; ?>
			                	</div>
			                	<div class="col-sm-4" align="right"><b><?=$lang_time_close;?></b></div>
			                	<div class="col-sm-8">
			                		<?php echo $res_msg['close_time']; ?>
			                	</div>
			                	<div class="col-sm-4" align="right"><b>วันที่เลือกในสัปดาห์</b></div>
			                	<div class="col-sm-8">
			                		<?php
			                			foreach (explode(',',$res_msg['weekday']) as $key => $weekday) {
			                				if($weekday == 1){ echo "วันอาทิตย์ ";}
			                				if($weekday == 2){ echo "วันจันทร์ ";}
			                				if($weekday == 3){ echo "วันอังคาร ";}
			                				if($weekday == 4){ echo "วันพุธ ";}
			                				if($weekday == 5){ echo "วันพฤหัสบดี ";}
			                				if($weekday == 6){ echo "วันศุกร์ ";}
			                				if($weekday == 7){ echo "วันเสาร์ ";}
			                			}
			                		?>
			                	</div>
			                	<?php }else{ ?>
			                	<div class="col-sm-12" align="center"><p class="lead text-danger">ไม่มีการตั้งเวลา เปิด-ปิด</p></div>
			                	<?php } ?>
			                </div>
			            </div>
			            <hr>
						<div>
					        <a href="#" class="btn btn-lg btn-flat btn-danger" role="button" onclick="drop_time();"><span class="fa fa-close fa-fw"> </span> ปิด</a>
					        <span class="pull-right">
					            <button name="submit_edit" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_edit"><span class="fa fa-clock-o fa-fw"> </span> ตั้งเวลา</button> 
					        </span>
					    </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    function drop_time() {
        if(confirm("คุณต้องการปิดการตั้งเวลาการให้บริการนี้?")){
            location = "user_drop.php?id=null&status=time_drop";
        }
    }

</script> 
<?php
	if(isset($_POST['submit_edit'])){
		$day_name = implode(',', $_POST['day_name']);
		$insert_sql = "INSERT INTO log_schedule(hardware_type,hardware_id,open_time,close_time,weekday)
						VALUES ('SC','1','".$_POST['time_open']."','".$_POST['time_close']."','$day_name')";
		$insert_query = mysqli_query($conn,$insert_sql);
		$insert_sql = "INSERT INTO log_schedule(hardware_type,hardware_id,open_time,close_time,weekday)
						VALUES ('SC','2','".$_POST['time_open']."','".$_POST['time_close']."','$day_name')";
		$insert_query = mysqli_query($conn,$insert_sql);

		echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_control_sc.php?page=control_sc_schedule\">";
	}

?>