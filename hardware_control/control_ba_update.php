<?php 

	include "connect_db.php";

	echo $_POST['barcode'].$_POST['media_name'];
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	echo $extension = pathinfo($_FILES['cover_book']['name'], PATHINFO_EXTENSION);
	
	if ((($_FILES["cover_book"]["type"] == "image/png")
	|| ($_FILES["cover_book"]["type"] == "image/gif")
	|| ($_FILES["cover_book"]["type"] == "image/jpg")
	|| ($_FILES["cover_book"]["type"] == "image/jpeg"))){
	  	if ($_FILES["cover_book"]["error"] > 0){
	    	echo "Return Code: " . $_FILES["cover_book"]["error"] . "<br />";
	    }
	  	else{
		    echo "Upload: " . $_FILES["cover_book"]["name"] . "<br />";
		    echo "Type: " . $_FILES["cover_book"]["type"] . "<br />";
		    echo "Size: " . ($_FILES["cover_book"]["size"] / 1024) . " Kb<br />";
		    echo "Temp file: " . $_FILES["cover_book"]["tmp_name"] . "<br />";

	 		if (file_exists("book_atm_media/cover_book/" . $_FILES["cover_book"]["name"])){
	  			echo $_FILES["cover_book"]["name"] . " already exists. ";
	   		}
	 		else{
	   			move_uploaded_file($_FILES["cover_book"]["tmp_name"],
	   			"book_atm_media/cover_book/" . $_FILES["cover_book"]["name"]);
	   			echo "Stored in: " . "video/" . $_FILES["cover_book"]["name"];
	   		}
	   		echo $update = "UPDATE book_atm_register SET book_description = '".$_POST['detail']."', book_image = '".$_FILES["cover_book"]["name"]."', user_update = '$username', datetime_update = now() WHERE book_id = '".$_POST['barcode']."'";
			$query_insert = mysqli_query($conn,$update);
			//echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
			echo "<script>top.location.href='switch_control_ba.php?page=control_ba_list';</script>";
	 	}
	}
	else{
		//echo "Invalid file";
		echo $update = "UPDATE book_atm_register SET book_description = '".$_POST['detail']."', user_update = '$username', datetime_update = now() WHERE book_id = '".$_POST['barcode']."'";
			$query_insert = mysqli_query($conn,$update);
		echo "<script>top.location.href='switch_control_ba.php?page=control_ba_list';</script>";
	}

?>