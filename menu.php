  <?php
  $sqlmenu = "SELECT customer.cus_id,customer.cus_type,customer_type.cus_id,customer_type.cus_hardware_list,customer_type.cus_report_list
          FROM customer
          INNER JOIN customer_type
          ON customer.cus_id = customer_type.cus_id
          WHERE customer.cus_orga = '$orga' 
          AND customer.cus_username = '$username'";
  $querymenu = mysqli_query($conn1,$sqlmenu); //$conn ต้องเรียก db customer นะ นะ
  $resmenu = mysqli_fetch_array($querymenu,MYSQLI_ASSOC);
  $hw = $resmenu['cus_hardware_list'];
  $hw2 = explode(',',$hw); 
  $report_menu = $resmenu['cus_report_list'];
  $report_menu2 = explode(',',$report_menu); 

  $switch_home = "";
  $switch_report = "";
  $switch_control_sc = "";
  $switch_control_sg = "";
  $switch_control_fg = "";
  $switch_control_ba = "";
  $switch_control_bd = "";
  if(strpos($_SERVER['REQUEST_URI'],"switch_home.php") != ""){ $switch_home = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_report.php") != ""){ $switch_report = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_control_sc.php") != ""){ $switch_control_sc = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_control_sg.php") != ""){ $switch_control_sg = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_control_fg.php") != ""){ $switch_control_fg = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_control_ba.php") != ""){ $switch_control_ba = 'class="active"';}
  else if(strpos($_SERVER['REQUEST_URI'],"switch_control_bd.php") != ""){ $switch_control_bd = 'class="active"';}

?>
<section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" >
            <!----><li <?php echo $switch_home; ?>><a href="switch_home.php?page=home13"><i class="fa fa-home"></i> <span><?=$lang_home;?></span></a></li>
            <?php
                if($hw2[0] != ''){ 
            ?>
              <li class="header"><?=$lang_hw_control;?></li>
            <?php
                }
                foreach ($hw2 as $value) {
                  if($value == 'SC'){ 
            ?>
            <li <?php echo $switch_control_sc; ?>><a href="switch_control_sc.php?page=control_sc_video"><i class="fa fa-desktop"></i> <span>Self Check</span></a></li>
             <?php } 
                  if($value == 'SS'){
            ?>
            <li><a href="switch_control.php?page=control_ss"><i class="fa fa-book"></i> <span>Staff Station</span></a></li>
            <?php } 
                  if($value == 'BD'){
            ?>
            <li <?php echo $switch_control_bd; ?>><a href="switch_control_bd.php?page=control_bd_checkBin"><i class="glyphicon glyphicon-book"></i> <span>Book Drop</span></a></li>
            <?php } 
                  if($value == 'SG'){ 
            ?>
            <li <?php echo $switch_control_sg; ?>><a href="switch_control_sg.php?page=control_sg_light"><i class="fa fa-pause"></i><span> Security Gate</span></a></li>
            <?php } 
                  if($value == 'MC'){ 
            ?>
            <li><a href="switch_control.php?page=control_mc"><i class="fa fa-check-square-o"></i> <span>Mobile Checker</span></a></li>
            <?php } 
                  if($value == 'BA'){ 
            ?>
            <li <?php echo $switch_control_ba; ?>><a href="switch_control_ba.php?page=control_ba_add"><i class="glyphicon glyphicon-book"></i><span> Book ATM</span></a></li>
            <?php } 
                  if($value == 'FG'){ 
            ?>
            <li <?php echo $switch_control_fg; ?>><a href="switch_control_fg.php?page=control_fg_way"><i class="fa fa-tasks"></i> <span>Flap Gate</span></a></li>
            <?php 
              } } 
              if($report_menu != ''){
            ?>
            <li class="header"><?=$lang_report;?></li>
            <!--<li><a href="#"><i class="fa fa-circle-o text-green"></i> <span>Report-Dashboard</span></a></li>-->
            <li <?php echo $switch_report; ?>><a href="switch_report.php?page=report_<?php echo strtolower($report_menu2[0]); ?>"><i class="fa fa-circle-o text-green"></i> <span><?=$lang_report;?></span></a></li>
            <?php }
              if($resmenu['cus_type'] == 'admin'){ 
            ?>
              <li class="header">OTHER</li>
              <li><a href="switch_user.php?page=user_detail"><i class="fa fa-user"></i> <span><?=$lang_staff;?></span></a></li>
            <?php } ?>
          </ul>
</section>

