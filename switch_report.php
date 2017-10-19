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

    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/select2/select2.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/iCheck/all.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">

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
              <!--<li>
                <a href="?page=<?=$_GET['page']; ?>&lang=th" style="padding:12px">
                  <img src="img/flag_th.png" width="25px">
                </a>
              </li>
              <li>
                <a href="?page=<?=$_GET['page']; ?>&lang=en" style="padding:12px">
                  <img src="img/flag_en.png" width="25px">
                </a>
              </li>-->
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
                      <a href="logout.php" class="btn btn-default btn-flat"><?php echo $lang_logout; ?> <i class="fa fa-sign-out fa-lg text-red pull-right"></i></a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- เริ่มสไลด์ขวา การตั้งค่าอื่นๆ 
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears fa-spin"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
    </header>
    <aside class="main-sidebar">
      <?php include("menu.php"); ?>
    </aside>

      <div class="content-wrapper">
          <?php 
            switch ($_GET["page"]) {
		      case "report_dashboard":
		        include("hardware_report/report_dashboard.php");
		        break;
		      case "report_ss":
		        include("hardware_report/report_ss.php");
		        break;
          case "report_ss_static_1":
            include("hardware_report/report_ss_static_1.php");
            break;
		      case "report_sc":
		        include("hardware_report/report_sc.php");
		        break;
		      case "report_sc_pic":
		        include("hardware_report/report_sc_pic.php");
		        break;
          case "report_sc_static_1":
            include("hardware_report/report_sc_static_1.php");
            break;
		      case "report_bd":
		        include("hardware_report/report_bd.php");
		        break;
          case "report_bd_pic":
            include("hardware_report/report_bd_pic.php");
            break;
          case "report_bd_static_1":
            include("hardware_report/report_bd_static_1.php");
            break;
		      case "report_mc":
		        include("hardware_report/report_mc.php");
		        break;
          case "report_ba_pic":
            include("hardware_report/report_ba_pic.php");
            break;
          case "report_ba":
            include("hardware_report/report_ba.php");
            break;
		      case "report_sg":
		        include("hardware_report/report_sg.php");
		        break;
          case "report_sg1":
            include("hardware_report/report_sg1.php");
            break;
          case "report_sg_static_1":
            include("hardware_report/report_sg_static_1.php");
            break;
		      case "report_sg_count":
		        include("hardware_report/report_sg_count.php");
		        break;
		      case "report_fg":
		        include("hardware_report/report_fg.php");
		        break;
		      case "report_fg_count":
		        include("hardware_report/report_fg_count.php");
		        break;
		      case "report_fg_time":
		        include("hardware_report/report_fg_time.php");
		        break;
		      default:
		        include("report_dashboard.php");
		      }
          ?>
    </div>
  </div><!-- ./wrapper -->
  <br><br>
</body>

<?php include "footer_report.php"; ?>

    <!-- jQuery 2.1.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="AdminLTE-2.3.0/plugins/slimScroll/jquery.slimscroll.js"></script>
    <!-- FastClick -->
    <script src="AdminLTE-2.3.0/plugins/fastclick/fastclick.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="AdminLTE-2.3.0/plugins/iCheck/icheck.min.js"></script>
    <!-- Select2 -->
    <script src="AdminLTE-2.3.0/plugins/select2/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE-2.3.0/dist/js/app.js"></script>
    <!-- date-range-picker -->
    <script src="AdminLTE-2.3.0/plugins/daterangepicker/moment.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- DataTables -->
    <script src="AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
      $(function () {
          //Initialize Select2 Elements
          $(".select2").select2();
          //Date range picker
          $('#reservation').daterangepicker({
            "autoApply": true,
            "opens": "right"
          });
        });

        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                    responsive: true,
                    "paging":   50,
                    "searching" : false
            });
        });

        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue'
        });

        $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').on('ifChecked', 
          function(event){
            $("#month_start").val("");
            $("#month_end").val("");
            if(this.value == 'sort_year'){
              $("#month_start").prop('disabled', true);
              $("#month_end").prop('disabled', true);
              $("#report_sc").prop('disabled', false);
            }else if(this.value == 'sort_hour'){
              document.getElementById('input_date1').innerHTML = '<input type="date" class="form-control input-sm" id="month_start" name="month_start" onchange="setMonth();">';
              document.getElementById('input_date2').innerHTML = '<input type="date" class="form-control input-sm" id="month_end" name="month_end" disabled>';
              $("#month_start").prop('disabled', false);
              $("#month_end").prop('disabled', true);
              $("#report_sc").prop('disabled', true);
            }else if(this.value == 'sort_date' || this.value == 'sort_month'){
              document.getElementById('input_date1').innerHTML = '<input type="month" class="form-control input-sm" id="month_start" name="month_start" onchange="setMonth();">';
              document.getElementById('input_date2').innerHTML = '<input type="month" class="form-control input-sm" id="month_end" name="month_end" disabled>';
              $("#month_start").prop('disabled', false);
              $("#month_end").prop('disabled', true);
              $("#report_sc").prop('disabled', true);
            }
          });

    function resizeIframe(obj) {
      obj.style.height = (obj.contentWindow.document.body.scrollHeight+50) + 'px';
    }
    </script>
</html>
