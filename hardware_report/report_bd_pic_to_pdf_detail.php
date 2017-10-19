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
		$sql_bd1 = "SELECT re_bd_bookbin,re_bd_station_id,re_bd_date,re_bd_mem_id,re_bd_type,re_bd_mem_name,re_bd_book_id,re_bd_book_name,re_bd_book_due_date,re_bd_book_status,re_bd_book_img,re_bd_user_img FROM report_bookdrop WHERE DATE_FORMAT(re_bd_date,'%Y-%m-%d') LIKE '$startdate%' ".$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	else{
		$sql_bd1 = "SELECT re_bd_bookbin,re_bd_station_id,re_bd_date,re_bd_mem_id,re_bd_type,re_bd_mem_name,re_bd_book_id,re_bd_book_name,re_bd_book_due_date,re_bd_book_status,re_bd_book_img,re_bd_user_img FROM report_bookdrop WHERE (DATE_FORMAT(re_bd_date,'%Y-%m-%d') BETWEEN '$startdate' AND '$enddate') ".$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	$num_pdf = 0;
	foreach ($sql_bd as $key => $value_bd) {
		$num_pdf++;
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
                <h3>รายงาน Book Drop (แสดงภาพ) </h3>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 11pt;">
        <tr>
            <td style="width:25%;"></td>
            <td style="width:10%; "><?=$lang_date;?> </td>
            <td style="width:15%"><?php echo $startdate; ?></td>
            <td style="width:10%; "> <?=$lang_to; ?></td>
            <td style="width:15%"><?php echo $enddate; ?></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
			<tr>
				<th style="width:10%"><?=$lang_no; ?></th>
		    	<th style="width:20%"><?=$lang_date; ?></th>
		    	<th style="width:30%"><?=$lang_detail; ?></th>
		    	<th style="width:20%">ภาพผู้ใช้งาน</th>
		    	<th style="width:20%">ภาพหนังสือที่คืน</th>

			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_bd as $key => $value_bd) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:10%"><?php echo $num; ?></td>
		   <td style="width:20%"><?php echo $lang_date." :".$value_bd['re_bd_date']."<br>".$lang_due_date." :".$value_bd['re_bd_book_due_date']; ?></td>
		   <td style="width:30%"><?php echo $lang_station_id." :".$value_bd['re_bd_station_id']."<br>"; ?>
					    		<?php echo $lang_book_id." :".$value_bd['re_bd_book_id']."<br>"; ?>
					    		<?php echo $lang_book_name." :".$value_bd['re_bd_book_name']."<br>"; ?>
					    		<?php echo $lang_status." :".$value_bd['re_bd_book_status']; ?></td>
		   <td style="width:20%"><img src="<?php echo $path_selfcheck_img.$value_bd['re_bd_station_id']."/".strtolower($value_bd['re_bd_type'])."/".$value_bd['re_bd_user_img']; ?>" width=160></td>
		   <td style="width:20%"><img src="<?php echo $path_selfcheck_img.$value_bd['re_bd_station_id']."/".strtolower($value_bd['re_bd_type'])."/".$value_bd['re_bd_book_img']; ?>" width=160></td>
		</tr>
    </table>
    <?php } ?>
</page>
