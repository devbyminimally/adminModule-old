<?php
session_start();
ob_start();

       if(isset($_SESSION['username']) || isset($_SESSION['traceon'])){
		   session_destroy();
		   header("Location:login.php");
		   exit;
	   }
	   ?>