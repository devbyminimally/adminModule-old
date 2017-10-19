<?php
	$sql_fg = "SELECT DISTINCT hw_remark FROM hardware_detail WHERE hw_code = 'FG'";
	$query_fg = mysqli_query($conn,$sql_fg);
	$res_fg = mysqli_fetch_array($query_fg,MYSQLI_BOTH);
	$hw_remark = explode(',', $res_fg['hw_remark']);
?>
 <script type="text/javascript" language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('foo[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<section class="content-header">
    <h1>การควบคุมเไฟ FLAP GATE <small>( <?php echo $hw_remark[0]." แผง ".$hw_remark[1]." ช่องทางเดิน "?>)</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">การควบคุมไฟ FLAP GATE</li>
    </ol>
</section>
<section class="content">
	<form method="post">
	    <div class="box ">
            <div class="box-header with-border">
              <h3 class="box-title">เลือกช่องทางการเดินผ่าน</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
		            	<hr>
		              <div align="center">
		              	<button type="submit" name="change" class="btn btn-success btn-lg">เปลี่ยนแปลงช่องทางเดิน</button>
		              </div>
		    </div>
		</div>
	</form>
</section>

<?php
	if(isset($_POST['change'])){

	}
?>