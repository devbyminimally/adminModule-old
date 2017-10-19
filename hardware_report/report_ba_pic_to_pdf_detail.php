<?php
		include "connect_db.php";
		$startdate = $_GET['start'];
		$enddate = $_GET['end'];
			$status1 = $_GET['status'];
			$status = '';
			if( $_GET['status'] != 'all'){
				$status = " AND re_ba_book_status = '".$_GET['status']."'";
			}

			$type1 = $_GET['type'];
			$type = '';
			if($_GET['type'] != 'all'){
				$type = " AND re_ba_type = '".$_GET['type']."'";
			}

			$group1 = $_GET['group'];
			$group = '';
			if( $_GET['group'] != 'all'){
				$group = " AND re_ba_station_id = '".$_GET['group']."'";
			}

			if($startdate == $enddate){
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_img_user,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE re_ba_date LIKE '$startdate%' ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
			else{
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_img_user,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE (re_ba_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 25%;">
            </td>
            <td style="width: 70%;">
                <br><br><br>
                <h3>รายงานการยืม-คืนผ่านเครื่อง Book ATM (แสดงรูป)</h3>
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
		    	<th style="width:20%">วันที่</th>
		    	<th style="width:40%">รายละเอียด</th>
		    	<th style="width:30%">รูปภาพ</th>

			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_ba as $key => $value_ba) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:10%"><?php echo $num; ?></td>
		   <td style="width:20%"><?php echo "วันที่ยืม :".$value_ba['re_ba_date']."<br>วันที่คืน :".$value_ba['re_ba_book_due_date']; ?></td>
		   <td style="width:40%"><?php echo "หมายเลขเครื่อง :".$value_ba['re_ba_station_id']."<br>"; ?>
			   	<?php echo "ประเภท :".$value_ba['re_ba_type']."<br>"; ?>
			   	<?php echo "รหัสสมาชิก :".$value_ba['re_ba_mem_id']."<br>"; ?>
			   	<?php echo "ชื่อสมาชิก :".$value_ba['re_ba_mem_name']."<br>"; ?>
			   	<?php echo "รหัสหนังสือ :".$value_ba['re_ba_book_id']."<br>"; ?>
			   	<?php echo "ชื่อหนังสือ :".$value_ba['re_ba_book_name']."<br>"; ?>
			   	<?php echo "สถานะ :".$value_ba['re_ba_book_status']; ?></td>
		   <td style="width:30%"><img src="<?php echo $path_book_atm_img."/".$value_ba['re_ba_img_user']; ?>" width=160></td>
		</tr>
    </table>
    <?php } ?>
</page>
