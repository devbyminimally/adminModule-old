<?php 
	include "connect_db.php";

	echo $_POST['barcode'].$_POST['media_name'];
	
	if($_POST['re_image'] == ''){
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

			 		if (file_exists($path_selfcheck_img_recommended . $_FILES["cover_book"]["name"])){
			  			echo $_FILES["cover_book"]["name"] . " already exists. ";
			   		}
			 		else{
			   			move_uploaded_file($_FILES["cover_book"]["tmp_name"],
			   			$path_selfcheck_img_recommended . $_FILES["cover_book"]["name"]);
			   			echo "Stored in: " . $path_selfcheck_img_recommended . $_FILES["cover_book"]["name"];
			   		}
		   		
		   			echo $insert = "INSERT INTO recommended_book(book_id,book_name,book_image,user_update,datetime_update)
						VALUES('".$_POST['barcode']."','".$_POST['media_name']."','".$_FILES["cover_book"]["name"]."','$username',now())";
					$query_insert = mysqli_query($conn,$insert);
		   		
				//echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
				echo "<script>top.location.reload();</script>";
		 	}
		}
		else{
			echo "Invalid file";
		}
	}else{
			$insert = "INSERT INTO recommended_book(book_id,book_name,book_image,user_update,datetime_update)
				VALUES('".$_POST['barcode']."','".$_POST['media_name']."','".$_POST['re_image']."','$username',now())";
			$query_insert = mysqli_query($conn,$insert);
		   		
				//echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
				echo "<script>top.location.reload();</script>";
	}
	

?>