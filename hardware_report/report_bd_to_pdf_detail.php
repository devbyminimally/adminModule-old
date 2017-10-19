<?php
	include "connect_db.php";
	$lang = $_SESSION['lang'];
	if(isset($_GET['lang'])){
	 	$_SESSION['lang'] = $_GET['lang']; //เก็บค่าของภาษาไว้ใน SESSION
	   	if($_SESSION['lang'] == "en"){
	     	include "lang_en.php";
	   	}
	   	else{
	     	include "lang_th.php";
	   	}
	}
	else if ($_SESSION['lang'] == 'en') {
	 	include "lang_en.php";
	}
	else{
	 	include "lang_th.php";
	}
	$fieldName = $_GET['fieldName'];

	$book_id_name1 = $_GET['book_id_name'];
	$book_id_name = '';
	if($_GET['book_id_name'] != ''){
		$book_id_name = " AND ( re_bd_book_id LIKE '%".$_GET['book_id_name']."%' OR re_bd_book_name LIKE '%".$_GET['book_id_name']."%')";
	}

	$startdate = $_GET['start'];
	$enddate = $_GET['end'];
	$status1 = $_GET['status'];
	$status = '';
	if( $_GET['status'] != 'all'){
		$status = " AND re_bd_book_status = '".$_GET['status']."'";
	}

	$group1 = $_GET['group'];
	$group = '';
	if( $_GET['group'] != 'all'){
		$group = " AND re_bd_station_id = '".$_GET['group']."'";
	}

	if($startdate == $enddate){
		$sql_bd1 = "SELECT re_bd_station_id,re_bd_date,re_bd_type,re_bd_book_id,re_bd_book_name,re_bd_book_status FROM report_bookdrop WHERE DATE(re_bd_date) LIKE '$startdate%' ".$book_id_name.$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	else{
		$sql_bd1 = "SELECT re_bd_station_id,re_bd_date,re_bd_type,re_bd_book_id,re_bd_book_name,re_bd_book_status FROM report_bookdrop WHERE (DATE(re_bd_date) BETWEEN '$startdate' AND '$enddate') ".$book_id_name.$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
?>

<page backcolor="#FEFEFE" backimg="./res/bas_page.png" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;page" style="font-family: freeserif">
<bookmark title="Lettre" level="0" ></bookmark>
	<table cellspacing="0" style="width: 100%; align: center; font-size: 14px">
        <tr>
            <td style="width: 40%;">
            </td>
            <td style="width: 60%;">
                <br><br><br>
                <h3>รายงาน Book Drop</h3>
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
				<th style="width:10%"><?=$lang_no; ?></th>
				<?php 
					foreach ($fieldName as $value_fieldName1) {
						if($value_fieldName1 == 1){ echo "<th style='width:20%'>".$lang_date."</th>"; }
		    			if($value_fieldName1 == 2){ echo "<th style='width:20%'>".$lang_station_id."</th>"; }
		    			if($value_fieldName1 == 3){ echo "<th style='width:10%'>".$lang_book_id."</th>"; }
		    			if($value_fieldName1 == 4){ echo "<th style='width:30%'>".$lang_book_name."</th>"; }
		    			if($value_fieldName1 == 5){ echo "<th style='width:10%'>".$lang_status."</th>"; }
		    		}
				?>
			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_bd as $key => $value_bd) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
			<td style="width:10%"><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td style='width:20%'>".$value_bd['re_bd_date']."</td>"; }
		    			if($value_fieldName2 == 2){ echo "<td style='width:20%'>".$value_bd['re_bd_station_id']."</td>"; }
		    			if($value_fieldName2 == 3){ echo "<td style='width:10%'>".$value_bd['re_bd_book_id']."</td>"; }
		    			if($value_fieldName2 == 4){ echo "<td style='width:30%'>".$value_bd['re_bd_book_name']."</td>"; }
		    			if($value_fieldName2 == 5){ echo "<td style='width:10%'>".$value_bd['re_bd_book_status']."</td>"; }
		    		}
				?>
		</tr>
    </table>
    <?php } ?>
</page>
