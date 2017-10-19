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
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lity-1.6.6/dist/lity.css"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
    <link href="jquery-form-validator/validator.css" rel="stylesheet">
    <!-- jQuery 2.1.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- Slimscroll -->
    <script src="AdminLTE-2.3.0/plugins/slimScroll/jquery.slimscroll.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE-2.3.0/dist/js/app.js"></script>
    <!-- DataTables -->
    <script src="AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="lity-1.6.6/dist/lity.js"></script>
    <script src="jquery-form-validator/jquery.form.validator-th.min.js"></script>
    <script src="jquery-form-validator/security.js"></script>
    <script src="jquery-form-validator/file.js"></script>

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
      input[type=checkbox].checkit {
        display: none;
      }

      label input[type=checkbox].checkit ~ span {
        display: inline-block;
        vertical-align: middle;
        cursor: pointer;
        background: #fff;
        border: 1px solid #888;
        padding: 1px;
        height: 20px;
        width: 20px;
      }

      label input[type=checkbox].checkit:checked ~ span {
        /* image: Picol.org, cc-by 3.0, https://commons.wikimedia.org/wiki/File:Accept_Picol_icon.svg */
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M14 18L26 6l4 4-16 16L4 16l4-4z"/></svg>');
        background-size: 100%;
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
      $control_sc_video = 'class="imgmenu"';
      $control_sc_message = 'class="imgmenu"';
      $control_sc_recommended = 'class="imgmenu"';
      $control_sc_schedule = 'class="imgmenu"';
      if($_GET['page'] == 'control_sc_video'){ $control_sc_video = ''; }
      else if($_GET['page'] == 'control_sc_message'){ $control_sc_message = ''; }
      else if($_GET['page'] == 'control_sc_recommended'){ $control_sc_recommended = ''; }
      else if($_GET['page'] == 'control_sc_schedule'){ $control_sc_schedule = ''; }
    ?>
    <aside class="main-sidebar">
      <?php include("menu.php"); ?>
    </aside>

      <div class="content-wrapper">
          <?php 
            switch ($_GET["page"]) {
            case "control_sc_video":
              include("hardware_control/control_sc_video.php");
              break;
            case "control_sc_message":
              include("hardware_control/control_sc_message.php");
              break;
            case "control_sc_recommended":
              include("hardware_control/control_sc_recommended.php");
              break;
            case "control_sc_schedule":
              include("hardware_control/control_sc_schedule.php");
              break;
            }
          ?>
      </div>
<br><br><br>
</body>
<footer class="main-footer" style="position: fixed;bottom: 0;height:80px;width: 100%;margin-left: 0px;">
        <div class="row">
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sc_video" data-toggle="tooltip" data-placement="top" title="ควบคุมวีดีโอ"><img src="img/menu/video.png" style="width:50px;" <?php echo $control_sc_video; ?>></a>
          </div>
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sc_message" data-toggle="tooltip" data-placement="top" title="การแสดงข้อความ"><img src="img/menu/message.png" style="width:50px;" <?php echo $control_sc_message; ?>></a>
          </div>
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sc_recommended" data-toggle="tooltip" data-placement="top" title="กำหนดหนังสือแนะนำ"><img src="img/menu/add_book.png" style="width:50px;" <?php echo $control_sc_recommended; ?>></a>
          </div>
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sc_schedule" data-toggle="tooltip" data-placement="top" title="ตั้งเวลาเปิด-ปิด"><img src="img/menu/schedule.png" style="width:50px;" <?php echo $control_sc_schedule; ?>></a>
          </div>
        </div>

</footer>

<script type="text/javascript">
  $(function() {
      $(".my-colorpicker2").colorpicker();
  });

  function tab_radio() {
      if(document.getElementById("radio_image").checked == true){
        document.getElementById('upload_file').innerHTML = '<div class="form-group"><label>อัพโหลดรูปภาพ</label><input type="file" name="cover_book" id="cover_book" class="form-control" data-validation="mime size required" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์รูปภาพ และขนาดไม่เกิน 3 MB"></div>';
      }else{
        document.getElementById('upload_file').innerHTML = '<div class="form-group"><label>อัพโหลดรูปภาพปกสำหรับวีดีโอ</label><input type="file" name="image_cover" id="image_cover" class="form-control" data-validation="mime size required" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์รูปภาพ และขนาดไม่เกิน 3 MB"></div><div class="form-group"><label>อัพโหลดวีดีโอ</label><input type="file" name="video_content" id="video_content" class="form-control" data-validation="mime size required" data-validation-allowing="mp4" data-validation-max-size="10M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์วิดีโอ และขนาดไม่เกิน 10 MB"></div>';
      }
  }
  $(document).ready(function(){
      $.validate({
        modules : 'file'
      });
      $('#msg_pre_th').restrictLength( $('#pres-max-length_th') );
      $('#msg_pre_en').restrictLength( $('#pres-max-length_en') );

      $('.slim1').slimScroll({
          height: 'auto'
      });
  });

  function resizeIframe(obj) {
      obj.style.height = (obj.contentWindow.document.body.scrollHeight+60) + 'px';
  }
  var select_array = [],ifr_select_array = [];
  
  function toggle_check(img_name,img_no){
      var media = document.getElementsByName('select_file[]');
      var i , txt = '' ;
      for (i = 0; i < media.length; i++) {
          var id_img = 'img'+i;
          var value_img = '<img src="'+img_name+'" id="'+id_img+'" style="height:70px;">';

          if (media[i].checked && media[i].value == img_name) {
             select_array[select_array.length] = value_img;
             ifr_select_array[ifr_select_array.length] = img_no;
          }

          if(media[i].checked){
            document.getElementById(i).style.background = '#e5e5e5';
          }

          if(media[i].checked == false && media[i].value == img_name) {
            var index = select_array.indexOf(value_img);
            select_array.splice(index, 1);
            ifr_select_array.splice(index, 1);
          }

          if(media[i].checked == false){
            document.getElementById(i).style.background  = 'white';
          }
      }
      document.getElementById('media_selected').innerHTML = select_array;
      document.getElementById('detail').value = ifr_select_array;
  }

  function uncheckall(){
      var media = document.getElementsByName('select_file[]');
      var j ;
      for (j = 0; j < media.length; j++) {
          if(media[j].checked){
              media[j].checked = false;
              document.getElementById(j).style.background  = 'white';
              select_array = [];
              ifr_select_array = [];
              document.getElementById('media_selected').innerHTML = '';
          }
      }
  }

  function preview(){
    document.getElementById('ifr_video_preview').src = 'hardware_control/control_sc_video_preview.php?arr='+ifr_select_array;
  }

</script>
</html>