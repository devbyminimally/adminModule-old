<?php
	$check_bd1 = "SELECT bb_date,bb_book_id,bb_book_name FROM bookbin_now";
	$query_check1 = mysqli_query($conn,$check_bd1);
	$res_check1 = mysqli_fetch_all($query_check1,MYSQLI_BOTH);
	$check_bd2 = "SELECT COUNT(re_bd_id) AS count_all , 
					SUM(CASE WHEN DATE(re_bd_date) = CURDATE() THEN 1 ELSE 0 END) AS count_today
					FROM report_bookdrop WHERE re_bd_book_status = 'Success'";
	$query_check2 = mysqli_query($conn,$check_bd2);
	$res_check2 = mysqli_fetch_array($query_check2,MYSQLI_BOTH);
?>
<section class="content-header">
    <h1>ตรวจสอบสถานะ Book Drop</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">ตรวจสอบสถานะ Book Drop</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-4 col-md-6">
			<div class="info-box">
                <span class="info-box-icon pull-right" style="width:120px;"><?=count($res_check1);?> <sup style="font-size: 20px"> เล่ม</sup></span>
                <div class="info-box-content" style="margin-left:10px;padding-top:25px;">
                  	<span class="info-box-text"><h4><b>หนังสือใน Book bin ตอนนี้</b></h4></span>
                </div>
            </div>
            <div align="center"><button class="btn btn-danger btn-flat btn-lg btn-block" onclick="confirm_clear('0','clear_bin')"> เคลียร์ Book Bin <i class="fa fa-trash"></i></button><br></div>
			<div class="box">
		        <div class="box-body">
				    <table class="table table-hover">
				    	<thead>
					    	<tr>
					    		<td style="font-size: 18px;">จำนวนหนังสือใน Book Bin วันนี้: </td>
					    		<th style="font-size: 18px;"><?=$res_check2['count_today'];?></th>
					    		<td style="font-size: 18px;">เล่ม</td>
					    	</tr>
					    	<tr>
					    		<td style="font-size: 18px;">จำนวนหนังสือใน Book Bin ทั้งหมด: </td>
					    		<th style="font-size: 18px;"><?=$res_check2['count_all'];?></th>
					    		<td style="font-size: 18px;">เล่ม</td>
					    	</tr>
					   	</thead>
				    </table>
				 </div>
			</div> 
			<div align="center"><a href="switch_report.php?page=report_bd" class="btn btn-primary btn-flat btn-lg btn-block">ดูรายงาน Bookdrop <i class="fa fa-fw fa-arrow-circle-right"></i></a><br><br></div>  
		</div>
		<div class="col-lg-8 col-md-6">
			<div class="box box-primary">
		        <div class="box-body">
				    <table class="table table-hover" id="dataTables-example" width="100%" >
						<thead>
							<tr>
								<th>#</th>
								<th>วัน-เวลา</th>
								<th>รหัสหนังสือ</th>
								<th>ชื่อหนังสือ</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($res_check1 as $key_check => $value_check) { ?>
							<tr>
								<td><?=$key_check+1;?></td>
								<td><?=$value_check['bb_date'];?></td>
								<td><?=$value_check['bb_book_id'];?></td>
								<td><?=$value_check['bb_book_name'];?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				 </div>
			</div>
		</div>
	</div>
	

</section>
<script type="text/javascript">
		$(document).ready(function() {
	        $('#dataTables-example').DataTable({
	                "pageLength": 10,
	                "lengthChange": false,
	                "order": [[ 1, "asc" ]],
	                "language": {
	                	"paginate": {
					        "first":      "หน้แรก",
					        "last":       "หน้าสุดท้าย",
					        "next":       "ถัดไป",
					        "previous":   "ก่อนหน้า"
					    },
	                	"emptyTable": "ไม่มีข้อมูลในตาราง",
	                	"infoEmpty": " ",
	                	"info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
		                "search": "ค้นหา :"
		            }

	        });
	    });

	    function confirm_clear(id,status) {
	        if(confirm("คุณต้องการเคลียร์หนังสือในถัง?")){
	            location = "user_drop.php?id="+id+"&status="+status;
	        }
	    }
</script>