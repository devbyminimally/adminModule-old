<?php
	include 'connect_db.php';
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
		$type = $_GET['type'];
		$type_human = '';
			$sort_by_text = $_GET['sort_by'];
			$sort_by = '';
			$sort_by = "AND (re_fg_mem_id LIKE '%".$sort_by_text."%' OR re_fg_mem_name LIKE '%".$sort_by_text."%')"; 

			$num_type1 = 0;
			$res_type1 = site_select_all("DISTINCT re_fg_mem_type","report_barrier");
			foreach ($res_type1 as $key_type1 => $value_type1) {
				$num_type1++;
				if($type == $num_type1 ){$type_human = "AND re_fg_mem_type = '".$value_type1['re_fg_mem_type']."'"; }
			}

		if($startdate == $enddate){
			$sql_fg = site_select_all("DISTINCT(re_fg_mem_id),re_fg_mem_name,re_fg_mem_type",
					"report_barrier WHERE re_fg_datetime LIKE '$startdate%' ".$type_human.$sort_by." ");
		}
		else{
			$sql_fg = site_select_all("DISTINCT(re_fg_mem_id),re_fg_mem_name,re_fg_mem_type",
					"report_barrier WHERE (re_fg_datetime BETWEEN '$startdate' AND '$enddate') ".$type_human.$sort_by." ");
		}
?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 35%;">
            </td>
            <td style="width: 65%;">
                <br><br><br>
                <h3>รายการระยะเวลาการใช้ห้องสมุด</h3>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 11pt;">
        <tr>
            <td style="width:25%;"></td>
            <td style="width:10%; ">วันที่ </td>
            <td style="width:15%"><?php echo $startdate; ?></td>
            <td style="width:10%; "> ถึง วันที่ </td>
            <td style="width:15%"><?php echo $enddate; ?></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
			<tr>
				<th style="width:10%">ลำดับ</th>
		    	<th style="width:15%">รหัสสมาชิก</th>
		    	<th style="width:25%">ชื่อ-นามสกุล</th>
		    	<th style="width:25%">ประเภทสมาชิก</th>
		    	<th style="width:25%">ระยะเวลาใช้ห้องสมุด</th>
			</tr>
	</table>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
    	<?php
			function duration($remain){
							  //$remain=intval(strtotime($end1)-strtotime($begin1));
							  $wan=floor($remain/86400);
							  $l_wan=$remain%86400;
							  $hour=floor($l_wan/3600);
							  $l_hour=$l_wan%3600;
							  $minute=floor($l_hour/60);
							  $second=$l_hour%60;
							  return $wan." วัน ".$hour." ชั่วโมง ".$minute." นาที ".$second." วินาที";
							}
			$num = 0;
			foreach ($sql_fg as $key => $value_fg) {
				$num++;
			$re_fg_mem_id = $value_fg['re_fg_mem_id'];
			$i=0;
			$begin1='';
			$end1='';
			$time='';
			$sql = "SELECT * FROM report_barrier WHERE re_fg_mem_id = '$re_fg_mem_id'";
			if($startdate == $enddate){
				$sql .= " and re_fg_datetime LIKE '$startdate%' ".$type_human." ";
			}
			else{
				$sql .= " and (re_fg_datetime BETWEEN '$startdate' AND '$enddate') ".$type_human." ";
			}
			$query = mysqli_query($site_conn,$sql);
			while($res = mysqli_fetch_array($query,MYSQLI_BOTH)){
				if(strtolower(explode("_",$res['re_fg_in_out'])[1])=="in"){$begin1 = $res['re_fg_datetime'];$i++;}
		    	if(strtolower(explode("_",$res['re_fg_in_out'])[1])=="out"){$end1 = $res['re_fg_datetime'];$i++;}
				if($i == '2'){$time = intval(strtotime($end1)-strtotime($begin1))+$time; $i=0;}
			}
			$times = duration($time);
			if($times != ''){
		?>
		<tr>
			<td style="width:10%"><?php echo $num; ?></td>
			<td style="width:15%"><?php echo $value_fg['re_fg_mem_id']; ?></td>
			<td style="width:25%"><?php echo $value_fg['re_fg_mem_name']; ?></td>
			<td style="width:25%"><?php echo $value_fg['re_fg_mem_type']; ?></td>
			<td style="width:25%"><?php echo $times; ?></td>
		</tr>
		<?php }} ?>
    </table>
</page>