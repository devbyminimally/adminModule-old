<?php
  include "connect_db.php";
  $lang = $_SESSION['lang'];
  if(isset($_GET['lang'])){
      $_SESSION['lang'] = $_GET['lang']; //เก็บค่าของภาษาไว้ใน SESSION
      if($_SESSION['lang'] == "en"){
        include "language/lang_en.php";
      }
      else{
          include "language/lang_th.php";
      }
  }
  else if ($_SESSION['lang'] == 'en') {
      include "language/lang_en.php";
  }
  else{
      include "language/lang_th.php";
  }include "language/lang_th.php";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/iCheck/flat/blue.css">

    <!-- jQuery 2.1.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="AdminLTE-2.3.0/plugins/slimScroll/jquery.slimscroll.js"></script>
    <!-- FastClick -->
    <script src="AdminLTE-2.3.0/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE-2.3.0/dist/js/app.js"></script>

    <style type="text/css">
      .imgmenu {
        filter: gray; /* IE6-9 */
        filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
        -webkit-filter: opacity(0.3); /* Google Chrome, Safari 6+ & Opera 15+ */
      }

      /* Disable grayscale on hover */
      .imgmenu:hover {
        filter: none;
        -webkit-filter: none;
      }
    </style>

</head>

<body class="hold-transition skin-blue-light sidebar-mini fixed">
  <div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="img/logo.png" width="30px"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo $orga; ?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
                <a href="?page=<?=$_GET['page']; ?>&lang=th" style="padding:12px">
                  <img src="img/flag_th.png" width="25px">
                </a>
              </li>
              <li>
                <a href="?page=<?=$_GET['page']; ?>&lang=en" style="padding:12px">
                  <img src="img/flag_en.png" width="25px">
                </a>
              </li>
              <!-- User Account , L&g&ut -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user"></i>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="img/logo.png" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $orga; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div align="center">
                      <a href="logout.php" class="btn btn-default btn-flat"><?php echo $lang_logout; ?> <i class="fa fa-sign-out text-red pull-right"></i></a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- เริ่มสไลด์ขวา การตั้งค่าอื่นๆ 
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
    </header>
    <?php 
      $control_fg_way = 'class="imgmenu"';
      $control_fg_light = 'class="imgmenu"';
      if($_GET['page'] == 'control_fg_way'){ $control_fg_way = ''; }
      else if($_GET['page'] == 'control_fg_light'){ $control_fg_light = ''; }
    ?>
    <aside class="main-sidebar">
      <?php include("menu.php"); ?>
    </aside>

      <div class="content-wrapper">
          <?php 
            switch ($_GET["page"]) {
            case "control_fg_way":
              include("hardware_control/control_fg_way.php");
              break;
            case "control_fg_light":
              include("hardware_control/control_fg_light.php");
              break;
            }
          ?>
      </div>

</body>

<footer class="main-footer" style="position: fixed;bottom: 0;height:80px;width: 100%;margin-left: 0px;">
        <div class="row">
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_fg_way" data-toggle="tooltip" data-placement="top" title="ควบคุมทางเข้า-ออก"><img src="img/menu/fg_1.png" style="width:50px;" <?php echo $control_fg_way; ?>></a>
          </div>
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_fg_light" data-toggle="tooltip" data-placement="top" title="ควบคุมแสง"><img src="img/menu/fg_2.png" style="width:50px;" <?php echo $control_fg_light; ?>></a>
          </div>
        </div>

</footer>
</html>