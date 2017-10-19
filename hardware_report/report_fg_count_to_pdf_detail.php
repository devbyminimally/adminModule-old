<?php
	include 'connect_db.php';
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
		$machine1 = $_GET['machine'];
        $machine = '';

        if($_GET['machine'] != 'all_machine'){$machine = "AND re_fg_count_station_id = '".$machine1."'"; }

        if($startdate == $enddate){
            $sql_fg_count1 = "SELECT re_fg_count_date,re_fg_count_station_id,re_fg_count FROM report_barrier_count WHERE re_fg_count_date LIKE '$startdate%' ".$machine." ORDER BY re_fg_count_date DESC";
            $sql_fg_count = mysqli_fetch_all(mysqli_query($conn,$sql_fg_count1),MYSQLI_BOTH);
        }
        else{
            $sql_fg_count1 = "SELECT re_fg_count_date,re_fg_count_station_id,re_fg_count FROM report_barrier_count WHERE (re_fg_count_date BETWEEN '$startdate' AND '$enddate') ".$machine." ORDER BY re_fg_count_date DESC";
            $sql_fg_count = mysqli_fetch_all(mysqli_query($conn,$sql_fg_count1),MYSQLI_BOTH);
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
                <h3>รายงานจำนวนคนผ่าน Flap Gate</h3>
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
		    	<th style="width:40%">วันที่</th>
		    	<th style="width:30%">ช่องทาง</th>
		    	<th style="width:20%">จำนวน</th>

			</tr>
	</table>
	<?php
        $num = 0;
        foreach ($sql_fg_count as $key => $value_fg_count) {
          $num++;
    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
			<td style="width:10%"><?php echo $num; ?></td>
            <td style="width:40%"><?php echo $value_fg_count['re_fg_count_date']; ?></td>
            <td style="width:30%"><?php echo $value_fg_count['re_fg_count_station_id']; ?></td>
            <td style="width:20%"><?php echo $value_fg_count['re_fg_count']; ?></td>
		</tr>
    </table>
    <?php } ?>
</page>