<?php
include "connect_db.php";
    
	$book_id_name1 = $_GET['book_id_name'];
    $book_id_name = '';
    $startdate = $_GET['start'];
    $enddate = $_GET['end'];
    $time_start = $_GET['time_start'];
    $time_end = $_GET['time_end'];
    $time = '';
    $type_ss = $_GET['type_ss'];
    $type_ss = '';
    $user = $_GET['user'];
    $user = '';
    $number1 = '';
    $fieldName = $_GET['fieldName'];

    if($_GET['book_id_name'] != ''){
        $book_id_name = " AND (re_ss_book_id LIKE '%".$_GET['book_id_name']."%' OR re_ss_book_name LIKE '%".$_GET['book_id_name']."%')";
    }
    if($_GET['type_ss'] != 'all_ss'){
        $type_ss = " AND re_ss_station_id = '".$_GET['type_ss']."'";
    }
  if($_GET['user'] != 'all'){$user = "AND re_ss_book_user = '".$_GET['user']."'"; }
    if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(re_ss_book_datetime,12,5) BETWEEN '$time_start' AND '$time_end')"; }
  if($startdate == $enddate){
    $sql_ss1 = "SELECT re_ss_book_datetime,re_ss_book_user,re_ss_book_name,re_ss_book_callno,re_ss_book_id,re_ss_station_id FROM report_staff_station WHERE re_ss_book_datetime LIKE '$startdate%' ".$book_id_name.$time.$type_ss.$user." order by re_ss_book_datetime desc ";
    $query_ss = mysqli_query($conn,$sql_ss1);
    $sql_ss = mysqli_fetch_all($query_ss,MYSQLI_BOTH);
  }
  else{
    $sql_ss1 = "SELECT re_ss_book_datetime,re_ss_book_user,re_ss_book_name,re_ss_book_callno,re_ss_book_id,re_ss_station_id FROM report_staff_station WHERE (re_ss_book_datetime BETWEEN '$startdate' AND '$enddate') ".$book_id_name.$time.$type_ss.$user." order by re_ss_book_datetime desc ";
    $query_ss = mysqli_query($conn,$sql_ss1);
    $sql_ss = mysqli_fetch_all($query_ss,MYSQLI_BOTH);
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
                <h3>รายงาน STAFF STATION</h3>
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
                        if($value_fieldName1 == 1){ echo "<th style='width:20%'>วันที่</th>"; }
                        if($value_fieldName1 == 2){ echo "<th style='width:10%'>รหัสเครื่อง</th>"; }
                        if($value_fieldName1 == 3){ echo "<th style='width:10%'>รหัสหนังสือ</th>"; }
                        if($value_fieldName1 == 4){ echo "<th style='width:20%'>เลขเรียกหนังสือ</th>"; }
                        if($value_fieldName1 == 5){ echo "<th style='width:25%'>ชื่อหนังสือ</th>"; }
                        if($value_fieldName1 == 6){ echo "<th style='width:10%'>ชื่อผู้ใช้</th>"; }
                    }
                ?>
			</tr>
	</table>
	<?php
      $num = 0;
      foreach ($sql_ss as $key => $value_ss) {
        $num++;
    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
			<td style="width:5%"><?php echo $num; ?></td>
            <?php 
                foreach ($fieldName as $value_fieldName2) {
                    if($value_fieldName2 == 1){echo "<td style='width:20%'>".$value_ss['re_ss_book_datetime']."</td>"; }
                    if($value_fieldName2 == 2){echo "<td style='width:10%'>".$value_ss['re_ss_station_id']."</td>"; }
                    if($value_fieldName2 == 3){echo "<td style='width:10%'>".$value_ss['re_ss_book_id']."</td>"; }
                    if($value_fieldName2 == 4){echo "<td style='width:20%'>".str_replace("Callnumber=","",$value_ss['re_ss_book_callno'])."</td>"; }
                    if($value_fieldName2 == 5){echo "<td style='width:25%'>".wordwrap($value_ss['re_ss_book_name'],48," ",true)."</td>"; }
                    if($value_fieldName2 == 6){echo "<td style='width:10%'>".$value_ss['re_ss_book_user']."</td>"; }
                }
            ?>
		</tr>
    </table>
    <?php } ?>
</page>