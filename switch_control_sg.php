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

    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    $soundContent = file_get_contents_curl($gateUrl."api/sounds?".$gateToken);
    $sounds = explode(",",$soundContent);

    $profileContent = file_get_contents_curl($gateUrl."api/profiles?".$gateToken);
    $profiles = explode(",",$profileContent);

    $sql_sg = "SELECT DISTINCT hw_remark FROM hardware_detail WHERE hw_code = 'SG'";
    $query_sg = mysqli_query($conn,$sql_sg);
    $res_sg = mysqli_fetch_array($query_sg,MYSQLI_BOTH);
    $hw_remark = explode(',', $res_sg['hw_remark']);
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
    <link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/skins/_all-skins.min.css">
    <link href="jquery-form-validator/validator.css" rel="stylesheet">
    <link rel="stylesheet" href="farbtastic/farbtastic.css" type="text/css" />

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
    <script src="jquery-form-validator/jquery.form.validator-th.min.js"></script>
    <script src="jquery-form-validator/security.js"></script>
    <script src="jquery-form-validator/file.js"></script>
    <script type="text/javascript" src="farbtastic/farbtastic.js"></script>

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
    <script type="text/javascript">

      $(document).ready(function() {
        $('#demo').hide();
        $('#picker').farbtastic('#hex');
      });  

      function gateAlarm(mode)
      {
        switch (mode)
        {
        case "0":
          document.getElementById("ifraAction").src = "<?=$gateUrl?>api/mute?<?=$gateToken?>";
          break;      
        case "1":
          document.getElementById("ifraAction").src = "<?=$gateUrl?>api/alarm?<?=$gateToken?>";
          break;
        default:
          document.getElementById("ifraAction").src = "<?=$gateUrl?>api/mute?<?=$gateToken?>";
          break;
        }
      }
      
      function deleteSound(){
        cboSoundValue = document.getElementById('cboSoundAlarm').value;
        document.getElementById("ifraAction").src = "<?=$gateUrl?>api/sounds/delete/"+cboSoundValue+"?<?=$gateToken?>";
        document.location.href = document.location.href;
      }

      function saveSetting(){
        cboSoundValue = document.getElementById('cboSoundAlarm').value;
        cboProfileValue = document.getElementById('cboProfile').value;
        $.post("<?=$gateUrl?>api/config/edit?<?=$gateToken?>",
        {
          token: "TraceonToken",
          submit: "Save",
          data: '{ "led": {    "number": 133,    "style": {      "notready": "' + cboProfileValue + '",      "ready": "basecolor.json",      "alarm": "red.json"    }  },  "sound": {    "alarm": {      "volume": 100,      "path": "' + cboSoundValue + '"    },    "waring": {      "path": "alarm_2.mp3"    }  },  "server": {    "port": 3000,    "token": "TraceonToken",    "ipfillter": [      "127.0.0.1",      "192.168.3.*"    ]  },  "serial": {    "arduino": {      "vid": [        "0x2341",        "0x1a86",        "0x10c4"      ],      "number": 1    },    "reader": {      "vid": [        "0x0557",        "0x0403",        "0x067b"      ],      "number": 2    }  },  "tcp": {    "port": 3001  },  "xband": {    "threshold": 8  } }'
        },
        function(data, status){
          alert("Data: " + data + "\nStatus: " + status);
        });

        setTimeout("document.getElementById('ifraSetting').src = document.getElementById('ifraSetting').src;", 500);
      }

      function saveNotReadyProfile()
      {
        var colorProfile = document.getElementById('hex').value.substring(1,7);
        if(colorProfile.length > 0)
        {
          $.post("<?=$gateUrl?>api/profiles/edit?<?=$gateToken?>",
          {
          token: "TraceonToken",
          submit: "Save",
          name : "basecolor.json",
          save_as : "0",
          data: '{  "led": {    "speed": 1,    "style": 0,    "color": ['+ color170(colorProfile) +']  }}'
          },
          function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
          });
        }
        else
        {
          cboProfileValue = document.getElementById('cboProfile').value;
          document.getElementById("ifraAction").src = "<?=$gateUrl?>api/config?<?=$gateToken?>&lednotreadyprofile=" + cboProfileValue;
        }
        setTimeout("document.getElementById('ifraSetting').src = document.getElementById('ifraSetting').src;", 500);
      }

      function color170(hexColor)
      {
        var rtnColor = '';
        for(var i=0;i<170;i++)
        {
          rtnColor += '"' + hexColor + '",';
        }
        rtnColor = rtnColor.substring(0, rtnColor.length-1);
        return rtnColor;
      }
    </script>
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
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li>
                <a href="?page=<?=$_GET['page']; ?>&lang=th" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="img/flag_th.png" width="20px">
                </a>
              </li>
              <li>
                <a href="?page=<?=$_GET['page']; ?>&lang=en" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="img/flag_en.png" width="20px">
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
      $control_sg_light = 'class="imgmenu"';
      $control_sg_sound = 'class="imgmenu"';
      if($_GET['page'] == 'control_sg_light'){ $control_sg_light = ''; }
      else if($_GET['page'] == 'control_sg_sound'){ $control_sg_sound = ''; }
    ?>
    <aside class="main-sidebar">
      <?php include("menu.php"); ?>
    </aside>
      <div class="content-wrapper">
        <iframe id="ifraAction" name="ifraAction" width="0px" height="0px" frameborder="0" ></iframe>
      <iframe id="ifraSetting" name="ifraSetting" width="0px" height="0px"  frameborder="0" src="<?=$gateUrl?>admin/config?<?=$gateToken?>"></iframe>
          <?php 
            switch ($_GET["page"]) {
            case "control_sg_light":
              include("hardware_control/control_sg_light.php");
              break;
            case "control_sg_sound":
              include("hardware_control/control_sg_sound.php");
              break;
            case "control_sg_light_set":
              include("hardware_control/control_sg_light_set.php");
              break;
            }
          ?>
      </div>
      
</body>
<br><br>
<script type="text/javascript">
    $.validate({
        modules : 'file'
    });
</script>
<footer class="main-footer" style="position: fixed;bottom: 0;height:80px;width: 100%;margin-left: 0px;">
        <div class="row">
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sg_light" data-toggle="tooltip" data-placement="top" title="ควบคุมแสง"><img src="img/menu/fg_2.png" style="width:50px;" <?php echo $control_sg_light; ?>></a>
          </div>
          <div class="col-xs-2 col-sm-1">
            <a href="?page=control_sg_sound" data-toggle="tooltip" data-placement="top" title="ควบคุมเสียง"><img src="img/menu/home4.png" style="width:50px;" <?php echo $control_sg_sound; ?>></a>
          </div>
        </div>

</footer>
</html>