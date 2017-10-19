<?php 
      $home11 = 'class="imgmenu"';
      $home12 = 'class="imgmenu"';
      $home13 = 'class="imgmenu"';
      $home21 = 'class="imgmenu"';
      $home22 = 'class="imgmenu"';
      $home23 = 'class="imgmenu"';
      $home31 = 'class="imgmenu"';
      $home32 = 'class="imgmenu"';
      $home41 = 'class="imgmenu"';
      $home42 = 'class="imgmenu"';
      $home51 = 'class="imgmenu"';
      $home52 = 'class="imgmenu"';
      if($_GET['page'] == 'home11'){ $home11 = ''; }
      else if($_GET['page'] == 'home12'){ $home12 = ''; }
      else if($_GET['page'] == 'home13'){ $home13 = ''; }
      else if($_GET['page'] == 'home21'){ $home21 = ''; }
      else if($_GET['page'] == 'home22'){ $home22 = ''; }
      else if($_GET['page'] == 'home23'){ $home23 = ''; }
      else if($_GET['page'] == 'home31'){ $home31 = ''; }
      else if($_GET['page'] == 'home32'){ $home32 = ''; }
      else if($_GET['page'] == 'home41'){ $home41 = ''; }
      else if($_GET['page'] == 'home42'){ $home42 = ''; }
      else if($_GET['page'] == 'home51'){ $home51 = ''; }
      else if($_GET['page'] == 'home52'){ $home52 = ''; }

    ?>
<footer class="main-footer" style="position: fixed;bottom: 0;height:60px;width: 100%;margin-left: 0px;">
        <div class="row">
          <div class="col-sm-1 col-xs-2">
            <a href="?page=home11" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home1.jpg" <?php if($home11 != '' && $home12 != '' && $home13 != ''){echo 'class="imgmenu"'; } ?> style="width:40px;" ></a>
          </div>
          <div class="col-sm-1 col-xs-2">
            <a href="?page=home21" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home2.png" <?php if($home21 != '' && $home22 != '' && $home23 != ''){echo 'class="imgmenu"'; } ?> style="width:40px;"></a>
          </div>
          <div class="col-sm-1 col-xs-2">
            <a href="?page=home31" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home3.png" <?php if($home31 != '' && $home32 != '' ){echo 'class="imgmenu"'; } ?> style="width:40px;"></a>
          </div>
          <div class="col-sm-1 col-xs-2">
            <a href="?page=home41" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home4.png" <?php if($home41 != '' && $home42 != '' ){echo 'class="imgmenu"'; } ?> style="width:40px;"></a>
          </div>
          <div class="col-sm-1 col-xs-2">
            <a href="?page=home51" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home5.png" <?php if($home51 != '' && $home52 != '' ){echo 'class="imgmenu"'; } ?> style="width:40px;"></a>
          </div>

          <?php if($_GET['page'] == 'home11' || $_GET['page'] == 'home12' || $_GET['page'] == 'home13'){ ?>
            <div class="col-sm-2 col-xs-2">
                  <div class="col-sm-5" style="border-left-style: solid;">&nbsp;<br><br><br></div>
                  <div class="col-sm-7">
                      <a href="switch_home.php?page=home11" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home1-1.png" style="width:40px;" <?php echo $home11; ?>></a>
                  </div>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home12" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home1-2.png" style="width:40px;" <?php echo $home12; ?>></a>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home13" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home1-3.png" style="width:40px;" <?php echo $home13; ?>></a>
            </div>

          <?php } else if($_GET['page'] == 'home21' || $_GET['page'] == 'home22' || $_GET['page'] == 'home23'){ ?>
            <div class="col-sm-2 col-xs-2">
                  <div class="col-sm-5" style="border-left-style: solid;">&nbsp;<br><br><br></div>
                  <div class="col-sm-7">
                      <a href="switch_home.php?page=home21" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home2-1.png" style="width:40px;" <?php echo $home21; ?>></a>
                  </div>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home22" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home2-2.png" style="width:40px;" <?php echo $home22; ?>></a>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home23" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home2-3.png" style="width:40px;" <?php echo $home23; ?>></a>
            </div>

          <?php } else if($_GET['page'] == 'home31' || $_GET['page'] == 'home32'){ ?>
            <div class="col-sm-2 col-xs-2">
                  <div class="col-sm-5" style="border-left-style: solid;">&nbsp;<br><br><br></div>
                  <div class="col-sm-7">
                      <a href="switch_home.php?page=home31" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home3-1.png" style="width:40px;" <?php echo $home31; ?>></a>
                  </div>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home32" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home3-2.jpg" style="width:40px;" <?php echo $home32; ?>></a>
            </div>

          <?php } else if($_GET['page'] == 'home41' || $_GET['page'] == 'home42'){ ?>
            <div class="col-sm-2 col-xs-2">
                  <div class="col-sm-5" style="border-left-style: solid;">&nbsp;<br><br><br></div>
                  <div class="col-sm-7">
                      <a href="switch_home.php?page=home41" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home3-1.png" style="width:40px;" <?php echo $home41; ?>></a>
                  </div>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home42" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home4-2.png" style="width:40px;" <?php echo $home42; ?>></a>
            </div>

          <?php } else if($_GET['page'] == 'home51' || $_GET['page'] == 'home52'){ ?>
            <div class="col-sm-2 col-xs-2">
                  <div class="col-sm-5" style="border-left-style: solid;">&nbsp;<br><br><br></div>
                  <div class="col-sm-7">
                      <a href="switch_home.php?page=home51" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home3-1.png" style="width:40px;" <?php echo $home51; ?>></a>
                  </div>
            </div>
            <div class="col-sm-1 col-xs-2">
              <a href="switch_home.php?page=home52" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><img src="img/menu/home5-2.png" style="width:40px;" <?php echo $home52; ?>></a>
            </div>
          <?php } ?>  

        </div>

</footer>