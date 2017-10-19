<?php

    include "connect_db.php";
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

      
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=fg_count".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายงานจำนวนคนผ่าน Flap Gate</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
      <tr>
        <th>ลำดับ</th>
        <th>วันที่</th>
        <th>ช่องทาง</th>
        <th>จำนวน</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $num = 0;
        foreach ($sql_fg_count as $key => $value_fg_count) {
          $num++;
      ?>
      <tr>
        <td><?php echo $num; ?></td>
        <td><?php echo $value_fg_count['re_fg_count_date']; ?></td>
        <td><?php echo $value_fg_count['re_fg_count_station_id']; ?></td>
        <td><?php echo $value_fg_count['re_fg_count']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
</table>
</body>
</html>