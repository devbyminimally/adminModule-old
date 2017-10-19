<?php 
	$sql_footer = "SELECT DISTINCT hw_code FROM hardware_detail";
	$query_footer = mysqli_query($conn,$sql_footer);
	$res_footer = mysqli_fetch_all($query_footer,MYSQLI_BOTH);
  
  $report_ss = 'class="imgmenu"';
  $report_sc = 'class="imgmenu"';
  $report_fg = 'class="imgmenu"';
  $report_sg = 'class="imgmenu"';
  $report_bd = 'class="imgmenu"';
  $report_mc = 'class="imgmenu"';
  $report_se = 'class="imgmenu"';
  $report_ba = 'class="imgmenu"';
    if($_GET['page'] == 'report_ss' || $_GET['page'] == 'report_ss_static_1'){ $report_ss = ''; }
    else if($_GET['page'] == 'report_sc' || $_GET['page'] == 'report_sc_pic' || $_GET['page'] == 'report_sc_static_1'){ $report_sc = ''; }
    else if($_GET['page'] == 'report_fg' || $_GET['page'] == 'report_fg_count' || $_GET['page'] == 'report_fg_time'){ $report_fg = ''; }
    else if($_GET['page'] == 'report_bd'){ $report_bd = ''; }
    else if($_GET['page'] == 'report_sg' || $_GET['page'] == 'report_sg_count' || $_GET['page'] == 'report_sg_static_1'){ $report_sg = ''; }
    else if($_GET['page'] == 'report_mc'){ $report_mc = ''; }
    else if($_GET['page'] == 'report_se'){ $report_se = ''; }
    else if($_GET['page'] == 'report_ba'){ $report_ba = ''; }
?>
<footer class="main-footer" style="position: fixed;bottom: 0;height:60px;width: 100%;margin-left: 0px;">
  <div class="row">
  		<?php 
  			foreach ($report_menu2 as $hw_code) { 
  				if($hw_code == 'SS'){
  		?>
          	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_ss" data-toggle="tooltip" data-placement="top" title="REPORT STAFFSTATION"><img src="img/hw/ss.png" <?php if($report_ss != ''){echo 'class="imgmenu"'; } ?> style="width:50px;" ></a>
          	</div>
        <?php } if($hw_code == 'SC'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_sc" data-toggle="tooltip" data-placement="top" title="REPORT SELFCHECK"><img src="img/hw/sc.png" <?php if($report_sc != ''){echo 'class="imgmenu"'; } ?> style="width:30px;" ></a>
          	</div>
        <?php } if($hw_code == 'BD'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_bd" data-toggle="tooltip" data-placement="top" title="REPORT BOOK DROP"><img src="img/hw/bd.png" <?php if($report_bd != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
          	</div>
        <?php } if($hw_code == 'SG'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_sg" data-toggle="tooltip" data-placement="top" title="REPORT SECURITYGATE"><img src="img/hw/sg.png" <?php if($report_sg != ''){echo 'class="imgmenu"'; } ?> style="width:30px;" ></a>
          	</div>
        <?php } if($hw_code == 'FG'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_fg" data-toggle="tooltip" data-placement="top" title="REPORT FLAPGATE"><img src="img/hw/fg.jpg" <?php if($report_fg != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
          	</div>
        <?php } if($hw_code == 'MC'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_mc" data-toggle="tooltip" data-placement="top" title="REPORT MOBILE CHECKER"><img src="img/hw/mc.png" <?php if($report_mc != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
          	</div>
        <?php } if($hw_code == 'SE'){ ?>
        	<div class="col-sm-1 col-xs-2">
            	<a href="?page=report_se" data-toggle="tooltip" data-placement="top" title="REPORT SEARCHSTATION"><img src="img/hw/se.png" <?php if($report_se != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
          	</div>
        <?php } if($hw_code == 'BA'){ ?>
          <div class="col-sm-1 col-xs-2">
              <a href="?page=report_ba" data-toggle="tooltip" data-placement="top" title="REPORT BOOK ATM"><img src="img/hw/ba.png" <?php if($report_ba != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
            </div>
        <?php }} ?>

  </div>
</footer>