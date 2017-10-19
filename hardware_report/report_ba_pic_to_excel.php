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

<div align="center"><h1>รายงานการยืม-คืนผ่านเครื่อง Book ATM(แสดงรูป)</h1></div>
<div align="center"><h3>วันที่ <?php echo $startdate; ?> ถึง วันที่ <?php echo $enddate; ?></h3><br></div>

  <table border="1" cellspacing="0" width="100%">
        <thead>
		    			<tr>
		    				<th>ลำดับ</th>
		    				<th>วันที่</th>
		    				<th>รายละเอียด</th>
		    				<th>รูปภาพ</th>
		    				
		    			</tr>
		    		</thead>
		    		<tbody>
		    			<?php
		    				$num = 0;
		    				foreach ($sql_ba as $key => $value_ba) {
		    					$num++;
		    			?>
		    			<tr>
		    				<td><?php echo $num; ?></td>
		    				<td><?php echo "วันที่ยืม :".$value_ba['re_ba_date']."<br>วันที่คืน :".$value_ba['re_ba_book_due_date']; ?></td>
		    				<td><?php echo "หมายเลขเครื่อง :".$value_ba['re_ba_station_id']."<br>"; ?>
		    					<?php echo "ประเภท :".$value_ba['re_ba_type']."<br>"; ?>
		    					<?php echo "รหัสสมาชิก :".$value_ba['re_ba_mem_id']."<br>"; ?>
		    					<?php echo "ชื่อสมาชิก :".$value_ba['re_ba_mem_name']."<br>"; ?>
		    					<?php echo "รหัสหนังสือ :".$value_ba['re_ba_book_id']."<br>"; ?>
		    					<?php echo "ชื่อหนังสือ :".$value_ba['re_ba_book_name']."<br>"; ?>
		    					<?php echo "สถานะ :".$value_ba['re_ba_book_status']; ?></td>
		    				<td><img src="<?php echo $path_book_atm_img."/".$value_ba['re_ba_img_user']; ?>" style="heigth:150px"></td>
		    			</tr>
		    			<?php } ?>
		    		</tbody>
      </table>
</body>
</html>