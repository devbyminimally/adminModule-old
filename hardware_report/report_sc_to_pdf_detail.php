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

	$fieldName = $_GET['fieldName'];
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
		$sql_sc1 = "SELECT re_sc_station_id,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE re_sc_date LIKE '$startdate%' ".$status.$type.$group." ";
		$query_sc = mysqli_query($conn,$sql_sc1);
		$sql_sc = mysqli_fetch_all($query_sc,MYSQLI_BOTH);
	}
	else{
		$sql_sc1 = "SELECT re_sc_station_id,re_sc_date,re_sc_mem_id,re_sc_type,re_sc_mem_name,re_sc_book_id,re_sc_book_name,re_sc_book_due_date,re_sc_book_status FROM report_selfcheck WHERE (re_sc_date BETWEEN '$startdate' AND '$enddate') ".$status.$type.$group." ";
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
                <h3><?=$lang_report_sc_1;?></h3>
            </td>
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 11pt;">
        <tr>
            <td style="width:25%;"></td>
            <td style="width:10%; "><?=$lang_date;?> </td>
            <td style="width:15%"><?php echo $startdate; ?></td>
            <td style="width:10%; "> <?=$lang_to; ?> </td>
            <td style="width:15%"><?php echo $enddate; ?></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
			<tr>
		    	<th style="width:5%"><?=$lang_no; ?></th>
				<?php 
			    	foreach ($fieldName as $value_fieldName1) {
			    		if($value_fieldName1 == 1){ echo "<th>".$lang_date."</th>"; }
					    if($value_fieldName1 == 2){ echo "<th>".$lang_station_id."</th>"; }
					    if($value_fieldName1 == 3){ echo "<th>".$lang_type."</th>"; }
					    if($value_fieldName1 == 4){ echo "<th>".$lang_member_id."</th>"; }
					    if($value_fieldName1 == 5){ echo "<th>".$lang_member_name."</th>"; }
					    if($value_fieldName1 == 6){ echo "<th>".$lang_book_id."</th>"; }
					    if($value_fieldName1 == 7){ echo "<th>".$lang_book_name."</th>"; }
					    if($value_fieldName1 == 8){ echo "<th>".$lang_due_date."</th>"; }
					    if($value_fieldName1 == 9){ echo "<th>".$lang_status."</th>"; }
					}
			    ?>

			</tr>
	</table>
	<?php
		$num = 0;
		foreach ($sql_sc as $key => $value_sc) {
			$num++;
	?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">
		<tr>
		   <td style="width:5%"><?php echo $num; ?></td>
		    <?php 
				foreach ($fieldName as $value_fieldName2) {
					if($value_fieldName2 == 1){ echo "<td style='width:10%'>".$value_sc['re_sc_date']."</td>"; }
					if($value_fieldName2 == 2){ echo "<td style='width:10%'>".$value_sc['re_sc_station_id']."</td>"; }
					if($value_fieldName2 == 3){ echo "<td style='width:10%'>".$value_sc['re_sc_type']."</td>"; }
					if($value_fieldName2 == 4){ echo "<td style='width:10%'>".$value_sc['re_sc_mem_id']."</td>"; }
					if($value_fieldName2 == 5){ echo "<td style='width:10%'>".$value_sc['re_sc_mem_name']."</td>"; }
					if($value_fieldName2 == 6){ echo "<td style='width:10%'>".$value_sc['re_sc_book_id']."</td>"; }
					if($value_fieldName2 == 7){ echo "<td style='width:15%'>".wordwrap($value_sc['re_sc_book_name'],48," ",true)."</td>"; }
					if($value_fieldName2 == 8){ echo "<td style='width:10%'>".$value_sc['re_sc_book_due_date']."</td>"; }
					if($value_fieldName2 == 9){ echo "<td style='width:10%'>".$value_sc['re_sc_book_status']."</td>"; }
				}
			?>
		</tr>
    </table>
    <?php } ?>
</page>
