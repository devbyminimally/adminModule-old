<?php
	   include 'connect_db.php';

        $fieldName = $_GET['fieldName'];
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
        $time_start = $_GET['time_start'];
        $time_end = $_GET['time_end'];
        $time = '';
		$status = $_GET['status'];
		$status = '';
        $number2 = 0;
        $group1 = $_GET['group'];
        $group = '';
        if( $_GET['group'] != 'all'){
            $sql_group1 = "SELECT DISTINCT re_sg_book_callno FROM report_security_gate";
            $query_group1 = mysqli_query($conn,$sql_group1);
            $res_group1 = mysqli_fetch_all($query_group1,MYSQLI_BOTH);
               foreach ($res_group1 as $key_group1 => $value_group1) {
                $number2++;
                if($_GET['group'] == $number2){$group = " AND re_sg_book_callno = '".$value_group1['re_sg_book_callno']."'";}
               }
        }
		else if($_GET['status'] == 'Not_Borrow'){$status = "AND re_sg_book_status = 'Not_Borrow'"; }
		if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(re_sg_datetime,12,5) BETWEEN '$time_start' AND '$time_end')"; }
        if($startdate == $enddate){
        $sql_sg1 = "SELECT re_sg_datetime,re_sg_book_id,re_sg_station_id,re_sg_book_callno,re_sg_book_name,re_sg_book_status FROM report_security_gate WHERE re_sg_datetime LIKE '$startdate%' ".$time.$status." order by re_sg_datetime desc";
        $query_sg = mysqli_query($conn,$sql_sg1);
        $sql_sg = mysqli_fetch_all($query_sg,MYSQLI_BOTH);
        }
        else{
            $sql_sg1 = "SELECT re_sg_datetime,re_sg_book_id,re_sg_station_id,re_sg_book_callno,re_sg_book_name,re_sg_book_status FROM report_security_gate WHERE (re_sg_datetime BETWEEN '$startdate' AND '$enddate') ".$time.$status." order by re_sg_datetime desc";
            $query_sg = mysqli_query($conn,$sql_sg1);
            $sql_sg = mysqli_fetch_all($query_sg,MYSQLI_BOTH);
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
                <h3>รายงานหนังสือผ่านประตู</h3>
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
				<th style="width:5%">ลำดับ</th>
                <?php 
                    foreach ($fieldName as $value_fieldName1) {
                        if($value_fieldName1 == 1){ echo "<th style='width:15%'>วันที่</th>"; }
                        if($value_fieldName1 == 2){ echo "<th style='width:10%'>รหัสหนังสือ</th>"; }
                        if($value_fieldName1 == 3){ echo "<th style='width:15%'>หมวดหมู่</th>"; }
                        if($value_fieldName1 == 4){ echo "<th style='width:25%'>ชื่อหนังสือ</th>"; }
                        if($value_fieldName1 == 5){ echo "<th style='width:15%'>สถานะ</th>"; }
                    }
                ?>
			</tr>
	</table>
	<?php
     $num = 0;
     foreach ($sql_sg as $key => $value_sg) {
     	$num++;
    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
			<td style="width:5%"><?php echo $num; ?></td>
            <?php 
                foreach ($fieldName as $value_fieldName2) {
                    if($value_fieldName2 == 1){echo "<td style='width:15%'>".$value_sg['re_sg_datetime']."</td>"; }
                    if($value_fieldName2 == 2){echo "<td style='width:10%'>".$value_sg['re_sg_book_id']."</td>"; }
                    if($value_fieldName2 == 3){echo "<td style='width:15%'>".wordwrap($value_sg['re_sg_book_callno'],48," ",true)."</td>"; }
                    if($value_fieldName2 == 4){echo "<td style='width:25%'>".wordwrap($value_sg['re_sg_book_name'],48," ",true)."</td>"; }
                    if($value_fieldName2 == 5){
                        if($value_sg['re_sg_book_status'] == 'BORROW'){
                            echo "<td style='width:15%'>ยืมแล้ว</td>"; 
                        }else{
                            echo "<td style='width:15%'>ยังไม่ถูกยืม</td>";
                        }
                    }
                }
            ?>
		</tr>
    </table>
    <?php } ?>
</page>