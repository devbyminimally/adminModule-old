<?php
	include 'connect_db.php';
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
    $time_start = $_GET['time_start'];
    $time_end = $_GET['time_end'];
    $time = '';
		$number1 = 0;
            $number2 = 0;
            $status1 = $_GET['status'];
            $status = '';
            if( $_GET['status'] != 'all'){
                $res_status1 = site_select_all("DISTINCT status","savedinventory ");
                   foreach ($res_status1 as $key_status1 => $value_status1) {
                    $number1++;
                    if($_GET['status'] == $number1){$status = " AND status = '".$value_status1['status']."'";}
                   }
            }
            $area1 = $_GET['area'];
            $area = '';
            if($_GET['area'] != 'all'){
                $area = " AND position_id = '".$_GET['area']."'";
            }

            $group1 = $_GET['group'];
            $group = '';
            if( $_GET['group'] != 'all'){
                $res_group1 = site_select_all("DISTINCT save_id","savedinventory ");
                   foreach ($res_group1 as $key_group1 => $value_group1) {
                    $number2++;
                    if($_GET['group'] == $number2){$group = " AND save_id = '".$value_group1['save_id']."'";}
                   }
            }

            if($time_start != '' && $time_end != ''){ $time = "AND (SUBSTR(date,12,5) BETWEEN '$time_start' AND '$time_end')"; }
            if($startdate == $enddate){
              $sql_mc = site_select_all("tag_id,book_name,position_id,save_id,status,date",
                  "savedinventory WHERE date LIKE '$startdate%' ".$time.$status.$area.$group." order by date desc");
            }
            else{
              $sql_mc = site_select_all("tag_id,book_name,position_id,save_id,status,date",
                  "savedinventory WHERE (date BETWEEN '$startdate' AND '$enddate') ".$time.$status.$area.$group." order by date desc");
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
                <h3>รายงานการตรวจสอบหนังสือ</h3>
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
                <th style="width:15%">วันที่</th>
                <th style="width:15%">ชื่อที่บันทึก</th>
                <th style="width:10%">รหัสหนังสือ</th>
                <th style="width:30%">ชื่อหนังสือ</th>
                <th style="width:10%">ตำแหน่ง</th>
                <th style="width:15%">สถานะ</th>

			</tr>
	</table>
	<?php
        $num = 0;
        foreach ($sql_mc as $key => $value_mc) {
            $num++;
    ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:5%"><?php echo $num; ?></td>
           <td style="width:15%"><?php echo $value_mc['date']; ?></td>
           <td style="width:15%"><?php echo $value_mc['save_id']; ?></td>
           <td style="width:10%"><?php echo $value_mc['tag_id']; ?></td>
           <td style="width:30%"><?php echo $value_mc['book_name']; ?></td>
           <td style="width:10%">
               <?php 
                   $res_position = site_select("position_name","positions WHERE position_id = '".$value_mc['position_id']."'"); 
                   echo $res_position['position_name'];
               ?>
           </td>
           <td style="width:15%"><?php echo $value_mc['status']; ?></td>
		</tr>
    </table>
    <?php } ?>
</page>