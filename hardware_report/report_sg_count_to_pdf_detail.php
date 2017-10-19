<?php
	include 'connect_db.php';

        $fieldName = $_GET['fieldName'];
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
		$machine1 = $_GET['machine'];
		$machine = '';

		if($_GET['machine'] != 'all_machine'){$machine = "AND re_sg_count_station_id = '".$machine1."'"; }
		if($startdate == $enddate){
            $sql_sg_count1 = "SELECT re_sg_count_station_id,re_sg_count_date,re_sg_count FROM report_security_gate_count WHERE re_sg_count_date LIKE '$startdate%' ".$machine." order by re_sg_count_date desc";
            $query_sg_count = mysqli_query($conn,$sql_sg_count1);
            $sql_sg_count = mysqli_fetch_all($query_sg_count,MYSQLI_BOTH);
        }
        else{
            $sql_sg_count1 = "SELECT re_sg_count_station_id,re_sg_count_date,re_sg_count FROM report_security_gate_count WHERE (re_sg_count_date BETWEEN '$startdate' AND '$enddate') ".$machine." order by re_sg_count_date desc";
            $query_sg_count = mysqli_query($conn,$sql_sg_count1);
            $sql_sg_count = mysqli_fetch_all($query_sg_count,MYSQLI_BOTH);
        }
  ?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 30%;">
            </td>
            <td style="width: 55%;">
                <br><br><br>
                <h3>รายงานคนผ่านประตู Security gate</h3>
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
                <?php 
                    foreach ($fieldName as $value_fieldName1) {
                        if($value_fieldName1 == 1){ echo "<th style='width:40%'>วันที่</th>"; }
                        if($value_fieldName1 == 2){ echo "<th style='width:30%'>หมายเลขเครื่อง</th>"; }
                        if($value_fieldName1 == 3){ echo "<th style='width:20%'>จำนวน</th>"; }
                    }
                ?>
			</tr>
	</table>
	<?php
     	$num = 0;
		foreach ($sql_sg_count as $key => $value_sg_count) {
			$num++;
    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
			<td style="width:10%"><?php echo $num; ?></td>
            <?php 
                    foreach ($fieldName as $value_fieldName2) {
                        if($value_fieldName2 == 1){ echo "<td style='width:40%'>".$value_sg_count['re_sg_count_date']."</td>"; }
                        if($value_fieldName2 == 2){ echo "<td style='width:30%'>".$value_sg_count['re_sg_count_station_id']."</td>"; }
                        if($value_fieldName2 == 3){ echo "<td style='width:20%'>".$value_sg_count['re_sg_count']."</td>"; }
                    }
                ?>
		</tr>
    </table>
    <?php } ?>
</page>