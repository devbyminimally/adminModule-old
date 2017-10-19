<?php
    include "connect_db.php";

    $fieldName = $_GET['fieldName'];
    $startdate = $_GET['start'];
    $enddate = $_GET['end'];
    $type = $_GET['type'];
    $type_human = '';
    $sort_by_text = $_GET['sort_by'];
    $sort_by = '';
    $sort_by = "AND (re_fg_mem_id LIKE '%".$sort_by_text."%' OR re_fg_mem_name LIKE '%".$sort_by_text."%')"; 

    $num_type1 = 0;
    $sql_type1 = "SELECT DISTINCT re_fg_mem_type FROM report_barrier";
    $query_type1 = mysqli_query($conn,$sql_type1);
    $res_type1 = mysqli_fetch_all($query_type1,MYSQLI_BOTH);
    foreach ($res_type1 as $key_type1 => $value_type1) {
      $num_type1++;
      if($type == $num_type1 ){$type_human = "AND re_fg_mem_type = '".$value_type1['re_fg_mem_type']."'"; }
    }

    if($startdate == $enddate){
      $sql_fg1 = "SELECT DISTINCT(re_fg_mem_id),re_fg_mem_name,re_fg_mem_type FROM report_barrier WHERE re_fg_datetime LIKE '$startdate%' ".$type_human.$sort_by;
      $query_fg = mysqli_query($conn,$sql_fg1);
      $sql_fg = mysqli_fetch_all($query_fg,MYSQLI_BOTH);
    }
    else{
      $sql_fg1 = "SELECT DISTINCT(re_fg_mem_id),re_fg_mem_name,re_fg_mem_type FROM report_barrier WHERE (re_fg_datetime BETWEEN '$startdate' AND '$enddate') ".$type_human.$sort_by;
      $query_fg = mysqli_query($conn,$sql_fg1);
      $sql_fg = mysqli_fetch_all($query_fg,MYSQLI_BOTH);
    }

    
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=fg_time-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<div align="center"><h1>รายการระยะเวลาการใช้ห้องสมุด</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
      <tr>
          <th>ลำดับ</th>
          <?php 
            foreach ($fieldName as $value_fieldName1) {
            if($value_fieldName1 == 1){ echo "<th>รหัสสมาชิก</th>"; }
            if($value_fieldName1 == 2){ echo "<th>ชื่อ-นามสกุล</th>"; }
            if($value_fieldName1 == 3){ echo "<th>ประเภทสมาชิก</th>"; }
            if($value_fieldName1 == 4){ echo "<th>ระยะเวลาใช้ห้องสมุด</th>"; }
          }
          ?>
        </tr>
    </thead>
    <tbody>
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
          $query = mysqli_query($conn,$sql);
          while($res = mysqli_fetch_array($query,MYSQLI_BOTH)){
            if(strtolower(explode("_",$res['re_fg_in_out'])[1])=="in"){
              $begin1 = $res['re_fg_datetime'];
              $i++;
            }
            if(strtolower(explode("_",$res['re_fg_in_out'])[1])=="out"){
              $end1 = $res['re_fg_datetime'];
              $i++;
            }
            if($i == '2'){
              $time = intval(strtotime($end1)-strtotime($begin1))+$time; 
              $i=0;
            }
          }
        $times = duration($time);
          if($times != ''){
        ?>
        <tr>
          <td><?php echo $num; ?></td>
          <?php 
          foreach ($fieldName as $value_fieldName2) {
            if($value_fieldName2 == 1){ echo "<td>".$value_fg['re_fg_mem_id']."</td>"; }
            if($value_fieldName2 == 2){ echo "<td>".$value_fg['re_fg_mem_name']."</td>"; }
            if($value_fieldName2 == 3){ echo "<td>".$value_fg['re_fg_mem_type']."</td>"; }
            if($value_fieldName2 == 4){ echo "<td>".$times."</td>"; }
          }
        ?>
        </tr>
        <?php }} ?>
    </tbody>
    </table>
</body>
</html>