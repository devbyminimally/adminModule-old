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
    $sql_ss1 = "SELECT re_ss_book_datetime,re_ss_book_user,re_ss_book_name,re_ss_book_callno,re_ss_book_id,re_ss_station_id FROM report_staff_station WHERE (SUBSTR(re_ss_book_datetime,1,10) BETWEEN '$startdate' AND '$enddate') ".$book_id_name.$time.$type_ss.$user." order by re_ss_book_datetime desc ";
    $query_ss = mysqli_query($conn,$sql_ss1);
    $sql_ss = mysqli_fetch_all($query_ss,MYSQLI_BOTH);
  }
 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=ss-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายงาน STAFF STATION</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ลำดับ</th>
          <?php 
            foreach ($fieldName as $value_fieldName1) {
              if($value_fieldName1 == 1){ echo "<th>วันที่</th>"; }
              if($value_fieldName1 == 2){ echo "<th>รหัสเครื่อง</th>"; }
              if($value_fieldName1 == 3){ echo "<th>รหัสหนังสือ</th>"; }
              if($value_fieldName1 == 4){ echo "<th>เลขเรียกหนังสือ</th>"; }
              if($value_fieldName1 == 5){ echo "<th>ชื่อหนังสือ</th>"; }
              if($value_fieldName1 == 6){ echo "<th>ชื่อผู้ใช้</th>"; }
            }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
          $num = 0;
          foreach ($sql_ss as $key => $value_ss) {
            $num++;
        ?>
        <tr>
          <td><?php echo $num; ?></td>
          <?php 
            foreach ($fieldName as $value_fieldName2) {
              if($value_fieldName2 == 1){echo "<td>".$value_ss['re_ss_book_datetime']."</td>"; }
              if($value_fieldName2 == 2){echo "<td>".$value_ss['re_ss_station_id']."</td>"; }
              if($value_fieldName2 == 3){echo "<td>".$value_ss['re_ss_book_id']."</td>"; }
              if($value_fieldName2 == 4){echo "<td>".$value_ss['re_ss_book_callno']."</td>"; }
              if($value_fieldName2 == 5){echo "<td width='25%'>".$value_ss['re_ss_book_name']."</td>"; }
              if($value_fieldName2 == 6){echo "<td>".$value_ss['re_ss_book_user']."</td>"; }
            }
          ?>
        </tr>
        <?php } ?>
      </tbody>
</table>
</body>
</html>