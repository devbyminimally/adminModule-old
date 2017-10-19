<?php
	include "connect_db.php";
	$book_id = $_GET['book_id'];

	
	$delete = "DELETE FROM recommended_book WHERE book_id = '$book_id'";
	$query = mysqli_query($conn,$delete);
	
	echo "<script>parent.location.reload();</script>"; 
?>