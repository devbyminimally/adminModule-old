<?php
		include "connect_db.php";
		$fieldName = $_GET['fieldName'];
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
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE re_ba_date LIKE '$startdate%' ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
			else{
				$sql_ba1 = "SELECT re_ba_station_id,re_ba_date,re_ba_mem_id,re_ba_type,re_ba_mem_name,re_ba_book_id,re_ba_book_name,re_ba_book_due_date,re_ba_book_status FROM report_bookatm WHERE (re_ba_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
				$query_ba = mysqli_query($conn,$sql_ba1);
				$sql_ba = mysqli_fetch_all($query_ba,MYSQLI_BOTH);
			}
?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 30%;">
            </td>
            <td style="width: 70%;">
                <br><br><br>
                <h3>รายงานการยืม-คืนผ่านเครื่อง Book ATM </h3>
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
			    		if($value_fieldName1 == 1){ echo "<th style='width:10%'>วันที่</th>"; }
						if($value_fieldName1 == 2){ echo "<th style='width:10%'>รหัสเครื่อง</th>"; }
						if($value_fieldName1 == 3){ echo "<th style='width:10%'>ประเภท</th>"; }
						if($value_fieldName1 == 4){ echo "<th style='width:10%'>รหัสสมาชิก</th>"; }
						if($value_fieldName1 == 5){ echo "<th style='width:10%'>ชื่อสมาชิก</th>"; }
						if($value_fieldName1 == 6){ echo "<th style='width:10%'>รหัสหนังสือ</th>"; }
						if($value_fieldName1 == 7){ echo "<th style='width:15%'>ชื่อหนังสือ</th>"; }
						if($value_fieldName1 == 8){ echo "<th style='width:10%'>วันที่คืน</th>"; }
						if($value_fieldName1 == 9){ echo "<th style='width:10%'>สถานะ</th>"; }
					}
			    ?>

			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_ba as $key => $value_ba) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:5%"><?php echo $num; ?></td>
		    <?php 
				foreach ($fieldName as $value_fieldName2) {
					if($value_fieldName2 == 1){ echo "<td style='width:10%'>".$value_ba['re_ba_date']."</td>"; }
					if($value_fieldName2 == 2){ echo "<td style='width:10%'>".$value_ba['re_ba_station_id']."</td>"; }
					if($value_fieldName2 == 3){ echo "<td style='width:10%'>".$value_ba['re_ba_type']."</td>"; }
					if($value_fieldName2 == 4){ echo "<td style='width:10%'>".$value_ba['re_ba_mem_id']."</td>"; }
					if($value_fieldName2 == 5){ echo "<td style='width:10%'>".$value_ba['re_ba_mem_name']."</td>"; }
					if($value_fieldName2 == 6){ echo "<td style='width:10%'>".$value_ba['re_ba_book_id']."</td>"; }
					if($value_fieldName2 == 7){ echo "<td style='width:15%'>".wordwrap($value_ba['re_ba_book_name'],48," ",true)."</td>"; }
					if($value_fieldName2 == 8){ echo "<td style='width:10%'>".$value_ba['re_ba_book_due_date']."</td>"; }
					if($value_fieldName2 == 9){ echo "<td style='width:10%'>".$value_ba['re_ba_book_status']."</td>"; }
				}
			?>
		</tr>
    </table>
    <?php } ?>
</page>
