<?php include("connect_db.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" type="text/css" href="slider-pro-master/dist/css/slider-pro.min.css" media="screen"/>
	<link rel="stylesheet" href="AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="AdminLTE-2.3.0/dist/css/AdminLTE.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-2.3.0/plugins/font-awesome/css/font-awesome.min.css">
	<script src="jquery-form-validator/jquery.min.js"></script>
	<script src="AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="slider-pro-master/dist/js/jquery.sliderPro.min.js"></script>
	<style type="text/css">
	 	#preview .sp-selected-thumbnail {
			border: 6px solid #0099CC;
		}
	</style>
	<script type="text/javascript">
		$( document ).ready(function( $ ) {
			$( '#preview' ).sliderPro({
				width: 450,
				height: 250,
				thumbnailWidth: 90,
				thumbnailHeight: 60,
				buttons: false,
				fullScreen: false,
				shuffle: false,
				thumbnailArrows: true,
				arrows: true,
				fade: true,
				autoplay: true,
				autoplayDelay: 3000,
				autoplayOnHover: 'none',
				endVideoAction: 'nextSlide'
			});
		});

	</script>

</head>

<body>
<?php
	if(empty($_GET['arr'])){
		echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-ban"></i> กรุณาเลือกไฟล์จาก MY FILE เพื่อดูตัวอย่าง Playlist ของคุณ</h4></div>';
	}
	else{
?>
	<div id="preview" class="slider-pro">
		<div class="sp-slides">
			<?php 
				foreach (explode(',', $_GET['arr']) as $key => $value){
					$sql = "SELECT media_cover,media_filename,media_no FROM media_content WHERE media_no = '$value'";
					$query = mysqli_query($conn,$sql);
					$res = mysqli_fetch_array($query,MYSQLI_BOTH);
					if($res['media_filename'] != $res['media_cover']){
			?>
			<div class="sp-slide">
				<video class="sp-video" width="450" controls="controls">
	                <source src="<?=$path_selfcheck_present.$res['media_filename']; ?>" type="video/mp4"/>
	            </video>
			</div>
			<?php } else{ ?>
			<div class="sp-slide">
				<img class="sp-image" src="<?=$path_selfcheck_present.$res['media_filename']; ?>"/>
			</div>
			<?php }} ?>
		</div>
		<div class="sp-thumbnails">
			<?php 
				foreach (explode(',', $_GET['arr']) as $value_cover){
					$sql_cover = "SELECT media_cover,media_filename,media_no FROM media_content WHERE media_no = '$value_cover'";
					$query_cover = mysqli_query($conn,$sql_cover);
					$res_cover = mysqli_fetch_array($query_cover,MYSQLI_BOTH);
					if($res_cover['media_filename'] != $res_cover['media_cover']){
			?>
			<a class="sp-video" href="#"><img class="sp-thumbnail" src="<?=$path_selfcheck_present.$res_cover['media_cover']; ?>"></a>
			<?php } else{ ?>
			<img class="sp-thumbnail" src="<?=$path_selfcheck_present.$res_cover['media_cover']; ?>"/>
			<?php } }?>
		</div>
    </div>
<?php } ?>
</body>
</html>