<?php
	  if(!isset($_SESSION)){
      session_start();
  	}
	//error_reporting(0);
	include "connect_confic.php";

	$username = $_SESSION['username'];
	$name = $_SESSION['name'];
  	$orga = $_SESSION['orga'];

  	if($name == ""){ echo "<META http-equiv=\"REFRESH\" content=\"0;url=login.php\">";}
  	else{

		$conn1 = mysqli_connect($serverName,$userName,$userPassword,'customer');
		mysqli_set_charset($conn1,"utf8");
		$sql = "SELECT cus_id,cus_db FROM customer WHERE cus_name = '$name' AND cus_orga = '$orga'";
		$query = mysqli_query($conn1,$sql);
		$res = mysqli_fetch_array($query,MYSQLI_BOTH);
		$cus_id1 = $res['cus_id'];
		$_SESSION['cus_id'] = $cus_id1;

		$dbName = $res['cus_db'];   
	  
		$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);

			if (!$conn) {
			    echo "Error: Unable to connect to MySQL." . PHP_EOL;
			    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			    exit;
			}
			mysqli_set_charset($conn,"utf8");
	
	}
?>