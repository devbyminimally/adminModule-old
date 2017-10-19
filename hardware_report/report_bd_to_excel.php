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
		echo $sql_bd1 = "SELECT re_bd_station_id,re_bd_date,re_bd_type,re_bd_book_id,re_bd_book_name,re_bd_book_status FROM report_bookdrop WHERE DATE(re_bd_date) LIKE '$startdate%' ".$book_id_name.$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	else{
		$sql_bd1 = "SELECT re_bd_station_id,re_bd_date,re_bd_type,re_bd_book_id,re_bd_book_name,re_bd_book_status FROM report_bookdrop WHERE (DATE(re_bd_date) BETWEEN '$startdate' AND '$enddate') ".$book_id_name.$status.$group." ";
		$query_bd = mysqli_query($conn,$sql_bd1);
		$sql_bd = mysqli_fetch_all($query_bd,MYSQLI_BOTH);
	}
	
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=bd-".$startdate.$enddate.".xls");

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

<div align="center"><h1>รายงาน Bookdrop</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  	<table border="1" cellspacing="0" width="100%">
    	<thead>
			<tr>
				<th width="5%"><?=$lang_no; ?></th>
				<?php 
					foreach ($fieldName as $value_fieldName1) {
						if($value_fieldName1 == 1){ echo "<th>".$lang_date."</th>"; }
		    			if($value_fieldName1 == 2){ echo "<th>".$lang_station_id."</th>"; }
		    			if($value_fieldName1 == 3){ echo "<th>".$lang_book_id."</th>"; }
		    			if($value_fieldName1 == 4){ echo "<th>".$lang_book_name."</th>"; }
		    			if($value_fieldName1 == 5){ echo "<th>".$lang_status."</th>"; }
		    		}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach ($sql_bd as $key => $value_bd) {
					$num++;
			?>
			<tr>
				<td><?php echo $num; ?></td>
				<?php 
					foreach ($fieldName as $value_fieldName2) {
						if($value_fieldName2 == 1){ echo "<td>".$value_bd['re_bd_date']."</td>"; }
		    			if($value_fieldName2 == 2){ echo "<td>".$value_bd['re_bd_station_id']."</td>"; }
		    			if($value_fieldName2 == 3){ echo "<td>".$value_bd['re_bd_book_id']."</td>"; }
		    			if($value_fieldName2 == 4){ echo "<td>".$value_bd['re_bd_book_name']."</td>"; }
		    			if($value_fieldName2 == 5){ echo "<td>".$value_bd['re_bd_book_status']."</td>"; }
		    		}
				?>
			</tr>
			<?php } ?>
		</tbody>
    </table>
</body>
</html>