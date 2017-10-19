<?php
	if(!isset($_SESSION)){
	    session_start();
	}
	include "connect_db.php";
	if($_SESSION['lang'] == "en"){
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
				$status = " AND re_sc_book_status = '".$_GET['status']."'";
			}

			$type1 = $_GET['type'];
			$type = '';
			if($_GET['type'] != 'all'){
				$type = " AND re_sc_type = '".$_GET['type']."'";
			}

			$group1 = $_GET['group'];
			$group = '';
			if( $_GET['group'] != 'all'){
				$group = " AND re_sc_station_id = '".$_GET['group']."'";
			}

			if($startdate == $enddate){
				$sql_sc1 = "SELECT re_sc_station_id,re_sc_img,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE re_sc_date LIKE '$startdate%' ".$status.$type.$group." ";
				$query_sc = mysqli_query($conn,$sql_sc1);
				$sql_sc = mysqli_fetch_all($query_sc,MYSQLI_BOTH);
			}
			else{
				$sql_sc1 = "SELECT re_sc_station_id,re_sc_img,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE (re_sc_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
				$query_sc = mysqli_query($conn,$sql_sc1);
				$sql_sc = mysqli_fetch_all($query_sc,MYSQLI_BOTH);
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
                <h3><?=$lang_report_sc_2;?></h3>
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
		    	<th style="width:40%"><?=$lang_detail; ?></th>
		    	<th style="width:30%"><?=$lang_pic; ?></th>

			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_sc as $key => $value_sc) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:10%"><?php echo $num; ?></td>
		   <td style="width:20%"><?php echo $lang_date." :".$value_sc['re_sc_date']."<br>".$lang_due_date." :".$value_sc['re_sc_book_due_date']; ?></td>
		   <td style="width:40%"><?php echo $lang_station_id." :".$value_sc['re_sc_station_id']."<br>"; ?>
					    		<?php echo $lang_type." :".$value_sc['re_sc_type']."<br>"; ?>
					    		<?php echo $lang_member_id." :".$value_sc['re_sc_mem_id']."<br>"; ?>
					    		<?php echo $lang_member_name." :".$value_sc['re_sc_mem_name']."<br>"; ?>
					    		<?php echo $lang_book_id." :".$value_sc['re_sc_book_id']."<br>"; ?>
					    		<?php echo $lang_book_name." :".$value_sc['re_sc_book_name']."<br>"; ?>
					    		<?php echo $lang_status." :".$value_sc['re_sc_book_status']; ?></td>
		   <td style="width:30%"><img src="<?php echo $path_selfcheck_img.$value_sc['re_sc_station_id']."/".strtolower($value_sc['re_sc_type'])."/".$value_sc['re_sc_img']; ?>" width=160></td>
		</tr>
    </table>
    <?php } ?>
</page>
