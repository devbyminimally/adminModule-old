<?php

	$mode_list = array("RFID card", "Alway open", "Alway close");
	$inout_list = array("In/Out", "In only", "Out only");

	$url = "192.168.3.73";
	$sgConnect = false;
	$msgErr = "";
function ping($host)
{
        $str = shell_exec('ping '.$host.' -w 1');
		return substr($str,-7,4);//loss
}
if(ping($url)!="loss")
{
	$sgConnect = true;
}

	if(!$sgConnect)
	{
		$msgErr = "<center><font color='red'>ไม่สามารถเชื่อมต่อกับ Flap Gate ได้</font></center>";
	}
	else
	{
		$currvalues = file_get_contents("http://".$url."/info.php");
		$currvalue = explode(",", $currvalues); //[2] [6] [10]
		
		$gate1 = trim(explode(":",$currvalue[2])[1]);
		$gate2 = trim(explode(":",$currvalue[6])[1]);
		$gate3 = trim(explode(":",$currvalue[10])[1]);
		$g1InCheck = "";
		$g1OutCheck = "";
		$g2InCheck = "";
		$g2OutCheck = "";
		$g3InCheck = "";
		$g3OutCheck = "";
		if($gate1==$inout_list[0]){
			$g1InCheck = "checked";
			$g1OutCheck = "checked";
		}
		if($gate1==$inout_list[1]){
			$g1InCheck = "checked";
		}
		if($gate1==$inout_list[2]){
			$g1OutCheck = "checked";
		}

		if($gate2==$inout_list[0]){
			$g2InCheck = "checked";
			$g2OutCheck = "checked";
		}
		if($gate2==$inout_list[1]){
			$g2InCheck = "checked";
		}
		if($gate2==$inout_list[2]){
			$g2OutCheck = "checked";
		}

		if($gate3==$inout_list[0]){
			$g3InCheck = "checked";
			$g3OutCheck = "checked";
		}
		if($gate3==$inout_list[1]){
			$g3InCheck = "checked";
		}
		if($gate3==$inout_list[2]){
			$g3OutCheck = "checked";
		}
	}
function startsWith($haystack, $needle)
{
    return strncmp($haystack, $needle, strlen($needle)) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === '' || substr_compare($haystack, $needle, -strlen($needle)) === 0;
}
if($sgConnect)
	{
?>
 <script type="text/javascript" language="JavaScript">
function checkGate(source) {
	if(document.getElementById(source.id.substring(0,8)+"In").checked && document.getElementById(source.id.substring(0,8)+"Out").checked)
	{
		document.getElementById("gate_inout_" + source.id.substring(7,8)).value = "<?=$inout_list[0]?>";
		document.getElementById("gate_mode_" + source.id.substring(7,8)).value = "<?=$mode_list[0]?>";
	}
	else if(document.getElementById(source.id.substring(0,8)+"In").checked && !document.getElementById(source.id.substring(0,8)+"Out").checked)
	{
		document.getElementById("gate_inout_" + source.id.substring(7,8)).value = "<?=$inout_list[1]?>";
		document.getElementById("gate_mode_" + source.id.substring(7,8)).value = "<?=$mode_list[0]?>";
	}
	else if(!document.getElementById(source.id.substring(0,8)+"In").checked && document.getElementById(source.id.substring(0,8)+"Out").checked)
	{
		document.getElementById("gate_inout_" + source.id.substring(7,8)).value = "<?=$inout_list[2]?>";
		document.getElementById("gate_mode_" + source.id.substring(7,8)).value = "<?=$mode_list[0]?>";
	}
	else if(!document.getElementById(source.id.substring(0,8)+"In").checked && !document.getElementById(source.id.substring(0,8)+"Out").checked)
	{
		document.getElementById("gate_inout_" + source.id.substring(7,8)).value = "<?=$inout_list[0]?>";
		document.getElementById("gate_mode_" + source.id.substring(7,8)).value = "<?=$mode_list[2]?>";
	}
}
</script>
<?php } ?>
<?php
	$sql_fg = "SELECT DISTINCT hw_remark FROM hardware_detail WHERE hw_code = 'FG'";
	$query_fg = mysqli_query($conn,$sql_fg);
	$res_fg = mysqli_fetch_array($query_fg,MYSQLI_BOTH);
	$hw_remark = explode(',', $res_fg['hw_remark']);
?>
 <script type="text/javascript" language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('foo[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<section class="content-header">
    <h1 onclick="location.replace('http://<?=$url?>/');">การควบคุมทางเข้า-ออก FLAP GATE <small>( <?php echo $hw_remark[0]." แผง ".$hw_remark[1]." ช่องทางเดิน ". $url?>)</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">การควบคุมทางเข้า-ออก FLAP GATE</li>
    </ol>
</section>
<?php if($sgConnect){ ?>
<section class="content">
	<form method="post" action="http://<?=$url?>/setting_conf.php" target="ifraSubmit">
	    <div class="box ">
            <div class="box-header with-border">
              	<h3 class="box-title">เลือกช่องทางการเดินผ่าน</h3>
              	<div class="box-tools pull-right">
                	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              	</div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
		        <table align="center">
		            <tbody>
		                <tr>
					  	    <td></td>
					  		<td style="width:200px; background-color: rgb(192,192,192);height:40px"></td>
		                	<td></td>
		                  	<td style="width:120px; background-color: rgb(175,238,238)"></td>
		                </tr>
		              	<tr>
							<td align="right" style="height:50px;"><input type="checkbox" id="chkGate1Out" onclick="checkGate(this);" value="path1_left" <?=$g1OutCheck ?>></td>
			              	<td></td>
			                <td><input type="checkbox" id="chkGate1In" onclick="checkGate(this);" value="path1_right" <?=$g1InCheck ?>></td>
							<td align="center" style="background-color: rgb(175,238,238)"><span class="glyphicon glyphicon-arrow-left"></span></td>
		                </tr>
		              	<tr>
							<td></td>
							<td style="background-color: rgb(192,192,192);height:40px;width:300px"></td>
			                <td></td>
			                <td align="center" style="background-color: rgb(175,238,238);width:150px">ทางเข้าห้องสมุด</td>
		              	</tr>
		              	<tr>
							<td align="right" style="height:50px"><input type="checkbox" id="chkGate2Out" onclick="checkGate(this);" value="path2_left" <?=$g2OutCheck ?>></td>
			              	<td></td>
							<td><input type="checkbox" id="chkGate2In" onclick="checkGate(this);" value="path2_right" <?=$g2InCheck ?>></td>
			                <td align="center" style="background-color: rgb(175,238,238)"><span class="glyphicon glyphicon-arrow-left"></span></td>
		              	</tr>
		              	<tr>
							<td></td>
			                <td style="background-color: rgb(192,192,192);height:40px"></td>
			                <td></td>
							<td style="background-color: rgb(175,238,238)"></td>
		              	</tr>
		              	<tr>
			                <td>&nbsp;</td>
			                <td></td>
			                <td></td>
			                <td></td>
		              	</tr>
		            </tbody>
		        </table>
		        <hr>
		        <div align="center">
		        	<button type="submit" name="bt_Save" class="btn btn-success btn-lg">เปลี่ยนแปลงช่องทางเดิน</button>
		        </div>
			</div>
		</div>
		<div style="display:none;">
			<table>
				<tr>
					<td style="width:150px" ><b>Device Serial</b></td>
					<td >
					<input type="text" name="device_ser" value="FG0001">
					</td>
				</tr>
				<tr>
					<td ><b>Gate 1 Mode</b></td>
					<td >
						<select id="gate_inout_1" name="gate_inout_1">
						<?php
							foreach($inout_list as $inoutl) {
							   if ( startsWith($gate1, $inoutl) == 1 ) {
									echo '<option value="'.$inoutl.'" selected="selected">'.$inoutl.'</option>';
								} else {
									echo '<option value="'.$inoutl.'">'.$inoutl.'</option>';
								}
							}
						?>
						</select>
						
						<select id="gate_mode_1" name="gate_mode_1">
						<?php
									echo '<option value="'.$mode_list[0].'" selected="selected">'.$mode_list[0].'</option>';
									echo '<option value="'.$mode_list[1].'">'.$mode_list[1].'</option>';
									echo '<option value="'.$mode_list[2].'">'.$mode_list[2].'</option>';
						?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td ><b>Gate 2 Mode</b></td>
					<td >
						<select id="gate_inout_2" name="gate_inout_2">
						<?php
							foreach($inout_list as $inoutl) {
							   if ( startsWith($gate2, $inoutl) == 1 ) {
									echo '<option value="'.$inoutl.'" selected="selected">'.$inoutl.'</option>';
								} else {
									echo '<option value="'.$inoutl.'">'.$inoutl.'</option>';
								}
							}
						?>
						</select>
						
						<select id="gate_mode_2" name="gate_mode_2">
						<?php
									echo '<option value="'.$mode_list[0].'" selected="selected">'.$mode_list[0].'</option>';
									echo '<option value="'.$mode_list[1].'">'.$mode_list[1].'</option>';
									echo '<option value="'.$mode_list[2].'">'.$mode_list[2].'</option>';
						?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td ><b>Gate 3 Mode</b></td>
					<td >
						<select id="gate_inout_3" name="gate_inout_3">
						<?php
							foreach($inout_list as $inoutl) {
							   if ( startsWith($gate3, $inoutl) == 1 ) {
									echo '<option value="'.$inoutl.'" selected="selected">'.$inoutl.'</option>';
								} else {
									echo '<option value="'.$inoutl.'">'.$inoutl.'</option>';
								}
							}
						?>
						</select>
						
						<select id="gate_mode_3" name="gate_mode_3">
						<?php
									echo '<option value="'.$mode_list[0].'" selected="selected">'.$mode_list[0].'</option>';
									echo '<option value="'.$mode_list[1].'">'.$mode_list[1].'</option>';
									echo '<option value="'.$mode_list[2].'">'.$mode_list[2].'</option>';
						?>
						</select>
						
					</td>
				</tr>
				
				<tr>
					<td><b>Gate 4 Mode</b></td>
					<td>
						<select id="gate_inout_4" name="gate_inout_4">
						<?php
							foreach($inout_list as $inoutl) {
							   if ( startsWith($gate3, $inoutl) == 1 ) {
									echo '<option value="'.$inoutl.'" selected="selected">'.$inoutl.'</option>';
								} else {
									echo '<option value="'.$inoutl.'">'.$inoutl.'</option>';
								}
							}
						?>
						</select>
						
						<select id="gate_mode_4" name="gate_mode_4">
						<?php
									echo '<option value="'.$mode_list[0].'" selected="selected">'.$mode_list[0].'</option>';
									echo '<option value="'.$mode_list[1].'">'.$mode_list[1].'</option>';
									echo '<option value="'.$mode_list[2].'">'.$mode_list[2].'</option>';
						?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td ><b>RFID URL</b></td>
					<td colspan="2">
						<input style="width: 500px" type="text" name="rfid_url" value="http://192.168.3.9/hongkhaiflapbarrier.php//CHECK_MEMBER/FG0001/">
					</td>
				</tr>
				
				<tr>
					<td ><b>IN OUT URL</b></td>
					<td colspan="2">
						<input style="width: 500px" type="text" name="inout_url" value="http://192.168.3.9/hongkhaiflapbarrier.php//IN_OUT/FG0001/">
					</td>
				</tr>
			</table>
			<iframe id="ifraSubmit" name="ifraSubmit" width="50%" height="120px" frameborder="0"></iframe>
			</div>
	</form>
</section>
<?php
	}else{
	 echo $msgErr;
	}
?>