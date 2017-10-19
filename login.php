<?php 
	
	include "connect_confic.php";
    if(!isset($_SESSION)){
        session_start();
    }
	if(isset($_GET['lang'])){
    	$_SESSION['lang'] = $_GET['lang']; //เก็บค่าของภาษาไว้ใน SESSION
     	if($_SESSION['lang'] == "en"){
			include "language/lang_en.php";
		}
		else{
			include "language/lang_th.php";
		}
    }
    else{
    	include "language/lang_th.php";
    	$_SESSION['lang'] =  "th";
    }
?>
<html>
 <head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css" >
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css" >
 
 <!-- Bootstrap core CSS -->
        <link href="jquery-form-validator/validator.css" rel="stylesheet">
        <script src="jquery-form-validator/jquery.min.js"></script>
        <script src="jquery-form-validator/jquery.form.validator-th.min.js"></script>
        <script src="jquery-form-validator/security.js"></script>
        <script src="jquery-form-validator/file.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" ></script>
 </head>

 <body>
 <div class="container-fliud">
	 <div class="panel panel-primary" style="border-radius: 0;height:11%;background:#2e7ed0;" >
	  <div class="panel-body">
	    <div class="row">
	    	<div class="col-xs-4 col-lg-4" align="left">
	    		<img src="img/logo.png" width="50px">
	    	</div>
	    	<div class="col-xs-4 col-lg-4" align="center">
	    	</div>
	    	<div class="col-xs-4 col-lg-4" align="right">
	    		<a href="?lang=th"><img src="img/flag_th.png" width="30px"></a>
	    		<a href="?lang=en"><img src="img/flag_en.png" width="30px"></a>
	    	</div>
	    </div>
	  </div>
	</div>

	 <div class="panel panel-primary" style="height:83%;" align="center">
	  <div class="panel-body">
	  	<div class="row">
			<div class="col-sm-12">&nbsp;</div>
			<div class="col-sm-12">&nbsp;</div>
			<div class="col-md-4 col-md-offset-4">
		  		<div class="panel panel-primary" align="center">
				  <div class="panel-body">
				  		<p class="lead"><?php echo $lang_login; ?></p>
				  		<hr>
				  		<form name="form" method="post" class="form-horizontal" >
					        <div class="form-group">
					        	<label class="col-xs-3 control-label"><?php echo $lang_username; ?></label>
					        	<div class="col-xs-8">
					        		<input type="text" name="user" autofocus data-validation="required" data-validation-error-msg="<?php echo $lang_validate_user; ?>"  class="form-control" placeholder="<?php echo $lang_username; ?>">
					        	</div>
					        </div>

					        <div class="form-group">
					        	<label class="col-xs-3 control-label"><?php echo $lang_password; ?></label>
					        	<div class="col-xs-8">
					        		<input type="password" name="pass" data-validation="required" data-validation-error-msg="<?php echo $lang_validate_pass; ?>"  class="form-control" placeholder="<?php echo $lang_password; ?>">
					        	</div>
					        </div>
					        <hr>
					        	<input name="submit" type="submit" class="btn btn-lg btn-primary btn-block" style="width:50%" id="submit" value="<?php echo $lang_login; ?>">
					    </form>
				  </div>
				</div>
			</div>
		</div>
	  </div>
	</div>

</div>
 <script>
	 $.validate({
		 modules: 'security, file',
		 onModulesLoaded: function () {
		 	$('input[name="pass_confirmation"]').displayPasswordStrength();
		 }
	 });
 </script>

 </body>
 </html>
<?php
	if(isset($_POST['submit'])){
		$user = $_POST['user'];
		$pass = md5($_POST['pass']);

		$conn1 = mysqli_connect($serverName,$userName,$userPassword,'customer');

		if (!$conn1) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}
		mysqli_set_charset($conn1,"utf8");

		$sql = "SELECT customer.cus_name,customer.cus_orga,customer.cus_status,customer_type.cus_id,customer_type.cus_hardware_list,customer_type.cus_report_list
				FROM customer 
				INNER JOIN customer_type
          		ON customer.cus_id = customer_type.cus_id
				WHERE customer.cus_username = '$user' AND customer.cus_m_password = '$pass'";
		$query = mysqli_query($conn1,$sql);
		$row = mysqli_num_rows($query);
		$res = mysqli_fetch_array($query,MYSQLI_BOTH);
		$report_menu = $res['cus_report_list'];
  		$report_menu2 = explode(',',$report_menu);

		if($row == 1 && $res['cus_status'] == 0){
			$_SESSION['username'] = $user;
			$_SESSION['name'] = $res['cus_name'];
			$_SESSION['orga'] = $res['cus_orga'];
			echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_home.php?page=home13\">";
			//echo "<META http-equiv=\"REFRESH\" content=\"0;url=switch_report.php?page=report_".strtolower($report_menu2[0])."\">";
		}
		elseif ($res['cus_status'] == 1) {
			echo "<script type='text/javascript'>alert('บัญชีของท่านโดนระงับการใช้งาน')</script>";
		}
		else{
			echo "<script type='text/javascript'>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง')</script>";
		}
	}
?>