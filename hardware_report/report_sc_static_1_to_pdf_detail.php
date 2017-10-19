<?php
	include "connect_db.php";
	if($_SESSION['lang'] == "en"){
	 	include "lang_en.php";
	}
	else{
	 	include "lang_th.php";
	}
	$sort_by = $_GET['sort_by'];
	$group_by = $_GET['group_by'];
	$month_start = $_GET['month_start'];
	$month_end = $_GET['month_end'];

	$header_group = '';

	if($_GET['group_by'] == 'group_book'){
		if($_GET['sort_by'] == 'sort_date'){
			$header_group = $lang_sort_by1;
			$sql_1 = "SELECT re_sc_station_id,DATE_FORMAT(re_sc_date,'%Y-%m-%d') AS re_sc_date,COUNT(re_sc_type) AS re_sc_type ,
					SUM(CASE WHEN re_sc_type = 'BORROW' THEN 1 ELSE 0 END) AS borrow_1 ,
					SUM(CASE WHEN re_sc_type = 'RETURN' THEN 1 ELSE 0 END) AS return_1 ,
					SUM(CASE WHEN re_sc_type = 'RENEW' THEN 1 ELSE 0 END) AS renew_1 
					FROM report_selfcheck 
					WHERE DATE_FORMAT(re_sc_date,'%Y-%m') BETWEEN '".$_GET['month_start']."' AND '".$_GET['month_end']."' 
					GROUP BY re_sc_station_id,DATE_FORMAT(re_sc_date,'%Y-%m-%d') ORDER BY re_sc_date ASC";
		}elseif ($_GET['sort_by'] == 'sort_month') {
			$header_group = $lang_sort_by2;
			$sql_1 = "SELECT re_sc_station_id,MONTHNAME(re_sc_date) AS re_sc_date,COUNT(re_sc_type) AS re_sc_type ,
					SUM(CASE WHEN re_sc_type = 'BORROW' THEN 1 ELSE 0 END) AS borrow_1 ,
					SUM(CASE WHEN re_sc_type = 'RETURN' THEN 1 ELSE 0 END) AS return_1 ,
					SUM(CASE WHEN re_sc_type = 'RENEW' THEN 1 ELSE 0 END) AS renew_1 
					FROM report_selfcheck 
					WHERE DATE_FORMAT(re_sc_date,'%Y-%m') BETWEEN '".$_GET['month_start']."' AND '".$_GET['month_end']."' 
					GROUP BY re_sc_station_id,MONTHNAME(re_sc_date) ORDER BY re_sc_date ASC";
		}else{
			$header_group = $lang_sort_by3;
			$sql_1 = "SELECT re_sc_station_id,YEAR(re_sc_date) AS re_sc_date,COUNT(re_sc_type) AS re_sc_type ,
					SUM(CASE WHEN re_sc_type = 'BORROW' THEN 1 ELSE 0 END) AS borrow_1 ,
					SUM(CASE WHEN re_sc_type = 'RETURN' THEN 1 ELSE 0 END) AS return_1 ,
					SUM(CASE WHEN re_sc_type = 'RENEW' THEN 1 ELSE 0 END) AS renew_1 
					FROM report_selfcheck GROUP BY re_sc_station_id,YEAR(re_sc_date) ORDER BY re_sc_date ASC";
		}
	}else{
		if($_GET['sort_by'] == 'sort_date'){
			$header_group = $lang_sort_by1;
			$sql_1 = "SELECT hardware_id, COUNT(no) AS no , DATE_FORMAT(login_datetime,'%Y-%m-%d') AS login_datetime
					FROM log_login 
					WHERE (DATE_FORMAT(login_datetime,'%Y-%m') BETWEEN '".$_GET['month_start']."' AND '".$_GET['month_end']."') AND hardware_type = 'SC' 
					GROUP BY hardware_id,DATE_FORMAT(login_datetime,'%Y-%m-%d') ORDER BY login_datetime ASC";
		}elseif ($_GET['sort_by'] == 'sort_month') {
			$header_group = $lang_sort_by2;
			$sql_1 = "SELECT hardware_id,COUNT(no) AS no , MONTHNAME(login_datetime) AS login_datetime
					FROM log_login 
					WHERE (DATE_FORMAT(login_datetime,'%Y-%m') BETWEEN '".$_GET['month_start']."' AND '".$_GET['month_end']."') AND hardware_type = 'SC' 
					GROUP BY hardware_id,MONTHNAME(login_datetime) ORDER BY login_datetime ASC";
		}else{
			$header_group = $lang_sort_by3;
			$sql_1 = "SELECT hardware_id,COUNT(no) AS no , YEAR(login_datetime) AS login_datetime
					FROM log_login GROUP BY hardware_id,YEAR(login_datetime) ORDER BY login_datetime ASC";
		}
		
	}
	$query_1 = mysqli_query($conn,$sql_1);
	$res_1 = mysqli_fetch_all($query_1,MYSQLI_BOTH);
?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 30%;">
            </td>
            <td style="width: 70%;">
                <br><br><br>
                <?php if($_GET['group_by'] == 'group_book'){ ?>
					<h3>รายงานแสดงสถิติหนังสือที่ถูกทำรายการ</h3>
				<?php }else{ ?>
					<h3>รายงานแสดงสถิติผู้ใช้บริการ Selfcheck</h3>
				<?php } ?>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <?php if($_GET['group_by'] == 'group_book'){ ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
			<tr>
				<th style="width:20%"><?=$lang_station_id; ?></th>
				<th style="width:20%"><?=$header_group; ?></th>
				<th style="width:15%"><?=$lang_borrow; ?></th>
				<th style="width:15%"><?=$lang_return; ?></th>
				<th style="width:15%"><?=$lang_renew; ?></th>
				<th style="width:15%"><?=$lang_total; ?></th>

			</tr>
	</table>
	<?php
		$num = 0;
		$total_borrow_1 = 0;
		$total_return_1 = 0;
		$total_renew_1 = 0;
		$total_re_sc_type = 0;
		foreach ($res_1 as $key => $value_sc) {
			$num++;
			$total_borrow_1 += $value_sc['borrow_1'];
			$total_return_1 += $value_sc['return_1'];
			$total_renew_1 += $value_sc['renew_1'];
			$total_re_sc_type += $value_sc['re_sc_type'];
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   	<td style="width:20%"><?php echo $value_sc['re_sc_station_id']; ?></td>
			<td style="width:20%"><?php echo $value_sc['re_sc_date']; ?></td>
			<td style="width:15%"><?php echo $value_sc['borrow_1']; ?></td>
			<td style="width:15%"><?php echo $value_sc['return_1']; ?></td>
			<td style="width:15%"><?php echo $value_sc['renew_1']; ?></td>
			<td style="width:15%"><?php echo $value_sc['re_sc_type']; ?></td>
		</tr>
    </table>
    <?php } ?>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   	<th style="text-align:right;width:20%"><?=$lang_total; ?> : </th>
			<th style="width:20%"></th>
			<th style="width:15%"><?php echo $total_borrow_1; ?></th>
			<th style="width:15%"><?php echo $total_return_1; ?></th>
			<th style="width:15%"><?php echo $total_renew_1; ?></th>
			<th style="width:15%"><?php echo $total_re_sc_type; ?></th>
		</tr>
    </table>
    <?php }else{ ?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
			<tr>
				<th style="width:30%"><?=$lang_station_id; ?></th>
				<th style="width:40%"><?=$header_group; ?></th>
				<th style="width:30%"><?=$lang_total; ?></th>

			</tr>
	</table>
	<?php
		$num = 0;
		$total_no = 0;
		foreach ($res_1 as $key => $value_sc) {
			$num++;
			$total_no += $value_sc['no'];
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   	<td style="width:30%"><?php echo "SCT1000".$value_sc['hardware_id']; ?></td>
			<td style="width:40%"><?php echo $value_sc['login_datetime']; ?></td>
			<td style="width:30%"><?php echo $value_sc['no']; ?></td>
		</tr>
    </table>
    <?php } ?>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   	<th style="width:30%"><?=$lang_total; ?> : </th>
		    <th style="width:40%"></th>
		    <th style="width:30%"><?php echo $total_no; ?></th>
		</tr>
    </table>
    <?php } ?>
</page>
