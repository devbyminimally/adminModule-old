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
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=sc_pic-".$startdate.$enddate.".xls");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
//echo "<b>รายงานเข้า-ออกห้องสมุด</b><br>";
?>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<title>title</title>

</head>
<body>

<div align="center"><h1><?=$lang_report_sc_2;?></h1></div>
<div align="center"><h3><?=$lang_date;?> <?php echo $startdate; ?> <?=$lang_to; ?> <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
		    			<tr>
		    				<th><?=$lang_no; ?></th>
							<th><?=$lang_date; ?></th>
							<th><?=$lang_detail; ?></th>
							<th><?=$lang_pic; ?></th>
		    			</tr>
		    		</thead>
		    		<tbody>
		    			<?php
		    				$num = 0;
		    				foreach ($sql_sc as $key => $value_sc) {
		    					$num++;
		    			?>
		    			<tr>
					    	<td><?php echo $num; ?></td>
					    	<td><?php echo $lang_date." :".$value_sc['re_sc_date']."<br>".$lang_due_date." :".$value_sc['re_sc_book_due_date']; ?></td>
					    	<td><?php echo $lang_station_id." :".$value_sc['re_sc_station_id']."<br>"; ?>
					    		<?php echo $lang_type." :".$value_sc['re_sc_type']."<br>"; ?>
					    		<?php echo $lang_member_id." :".$value_sc['re_sc_mem_id']."<br>"; ?>
					    		<?php echo $lang_member_name." :".$value_sc['re_sc_mem_name']."<br>"; ?>
					    		<?php echo $lang_book_id." :".$value_sc['re_sc_book_id']."<br>"; ?>
					    		<?php echo $lang_book_name." :".$value_sc['re_sc_book_name']."<br>"; ?>
					    		<?php echo $lang_status." :".$value_sc['re_sc_book_status']; ?></td>
					    	<td><img src="<?php echo $path_selfcheck_img.$value_sc['re_sc_station_id']."/".strtolower($value_sc['re_sc_type'])."/".$value_sc['re_sc_img']; ?>" style="height:150px"></td>
					    </tr>
		    			<?php } ?>
		    		</tbody>
      </table>
</body>
</html>