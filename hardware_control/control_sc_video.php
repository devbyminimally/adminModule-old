<?php
	function format_size($size) {
	      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	      if ($size == 0) { return('n/a'); } else {
	      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
	}
	$sql_present = "SELECT media_cover,media_filename,media_no FROM media_content";
	$query_present = mysqli_query($conn,$sql_present);
	$res_present = mysqli_fetch_all($query_present,MYSQLI_BOTH);
	$sql_playlist1 = "SELECT playlist_no,playlist_name,playlist FROM media_playlist";
	$query_playlist1 = mysqli_query($conn,$sql_playlist1);
	$res_playlist1 = mysqli_fetch_all($query_playlist1,MYSQLI_BOTH);
	$sql_playlist2 = "SELECT hardware_type,hardware_cmd_value FROM hardware_cmd_set WHERE hardware_cmd_name = 'playlist'";
	$query_playlist2 = mysqli_query($conn,$sql_playlist2);
	$res_playlist2 = mysqli_fetch_all($query_playlist2,MYSQLI_BOTH);
?>
<section class="content-header">
    <h1>อัพโหลด Playlist</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">อัพโหลด Playlist</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-6">	
			<div class="row">
				<div class="col-md-6">
					<div class="box box-primary collapsed-box">
						<div class="box-header with-border">
							<i class="fa fa-upload"></i>
					      	<h3 class="box-title">อัพโหลดสื่อประชาสัมพันธ์</h3>
					      	<div class="box-tools pull-right">
						      	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						    </div><!-- /.box-tools -->
					    </div><!-- /.box-header -->
						<div class="box-body">
							<form method="post" enctype="multipart/form-data">
								<div class="form-group">
								    <label>ประเภท</label>
								    <div class="radio">
								    	<label class="radio-inline">
								    		<input type="radio" id="radio_image" name="media_type" value="radio_image" onclick="tab_radio()" checked> รูปภาพ
								    	</label>
								    	<label class="radio-inline">
								    		<input type="radio" id="radio_video" name="media_type" value="radio_video" onclick="tab_radio()" > วิดีโอ
								    	</label>
								    </div>
								</div>
								<div id="upload_file">
									<div class="form-group">
									    <label>อัพโหลดรูปภาพ</label>
									    <input type="file" name="cover_book" id="cover_book" class="form-control" data-validation="mime size required" data-validation-allowing="jpg, png, gif" data-validation-max-size="3M" data-validation-error-msg="กรุณาอัพโหลดเฉพาะไฟล์รูปภาพ และขนาดไม่เกิน 3 MB">
									</div>
								</div>
								<button type="submit" name="submit_upload" class="btn btn-success btn-block btn-flat">อัพโหลด</button>
							</form>
						</div>
					</div>
					<div class="box box-primary">
					     <div class="box-body" style="max-height: 400px;overflow-y: auto;">
					     	<table class="table">
						        <thead>
						          	<tr>
						            	<th style="width: 50%;">Playlist Name</th>
						            	<th style="width: 50%;"></th>

						          	</tr>
						        </thead>
						        <tbody>
						        <?php
						        	foreach ($res_playlist1 as $value_playlist1) {
								?>
						          	<tr>
						            	<td><?=$value_playlist1['playlist_name']; ?></td>
						            	<td align="right">
						            		<button class="btn btn-success btn-xs" type="button" name="playlist_select" data-toggle="modal" data-target="#mySelectPlaylist" onclick="document.getElementById('new_playlist_name').value = '<?=$value_playlist1['playlist_no']; ?>';">เลือก</button>
						            		<button class="btn btn-primary btn-xs" type="button" name="playlist_preview" onclick="document.getElementById('ifr_video_preview').src='control_sc_video_preview.php?arr=<?=$value_playlist1['playlist']; ?>';"><i class="fa fa-eye fa-fw"></i></button>
						            		<button class="btn btn-danger btn-xs" type="submit" name="playlist_delete"><i class="fa fa-trash-o fa-fw"></i></button>
						            	</td>
						          	</tr>
						        <?php  } ?>
						        </tbody>
						    </table>
						</div>
					</div>			
				</div>
				<div class="col-md-6">
					<div class="box box-primary">
						<div class="box-header with-border">
							<i class="fa fa-file-image-o"></i>
			              	<h3 class="box-title">MY FILE</h3>
			            </div><!-- /.box-header -->
					    <div class="box-body" style="max-height: 470px;overflow-y: auto;">
					    	<ul class="products-list product-list-in-box">
					    	<?php
					    		$i = -1;
						     	foreach ($res_present as $value_present) {
						     		$i++;
						    ?>
			                    <li class="item" id="<?=$i; ?>">
			                      	<div class="product-img">
				                      	<label>
				                        	<input type="checkbox" class="checkit" name="select_file[]" value="<?=$path_selfcheck_present.$value_present['media_cover']; ?>" id="img<?=$i; ?>" onclick="toggle_check('<?=$path_selfcheck_present.$value_present['media_cover']; ?>','<?=$value_present['media_no']; ?>');"/>
				                        	<span></span>
				                        </label>
			                        	<img src="<?=$path_selfcheck_present.$value_present['media_cover']; ?>" alt="Product Image" style="margin-left: 5px;">
			                      	</div>
			                      	<div class="product-info" style="margin-left: 90px;">
			                        	<a href="#" class="product-title"><?=$value_present['media_filename']; ?></a>
			                        	<a href="#"><span class="label label-danger pull-right"><i class="fa fa-trash-o"></i></span></a>
			                        	<span class="product-description">
			                          		<?=format_size(filesize($path_selfcheck_present.$value_present['media_filename'])); ?>
			                        	</span>
			                      	</div>
			                    </li><!-- /.item -->
			                <?php } ?>
			                </ul>
			                <!--<div id="test"></div>-->
						</div>
					</div>
				</div>
			</div>	
		</div>
		<div class="col-lg-6">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary box-solid">
			            <div class="box-header with-border">
			              	<h3 class="box-title">กรุณาเลือกไฟล์จาก MY FILE เพื่อสร้าง Playlist ของคุณ</h3>
			            </div>
			            <div class="box-body">
			            	<div id="media_selected" class="well" style="padding: 10px;border-radius: 0px;overflow-x: auto;overflow-y: hidden;white-space: nowrap;height:100px;">
			            		<!-- แสดงวิดีโอและรูปภาพที่เลือก -->
			            	</div>
			            	<form method="post">
					            <div class="row">
					            	<div class="col-xs-6">
										<div class="input-group">
											<input type="hidden" name="detail" id="detail" class="form-control" >
											<input type="text" name="playlist_name" class="form-control" data-validation="required" data-validation-error-msg=" " placeholder="Playlist Name" >
											<span class="input-group-btn">
												<button type="submit" name="playlist_save" class="btn btn-success btn-flat"> <i class="fa fa-save"></i>  สร้าง</button>
											</span>
										</div>
									</div>
									<div class="col-xs-3">
										<button type="button" name="video_preview" id="video_preview" class="btn btn-primary btn-flat btn-block" onclick="preview();"> <i class="fa fa-eye"></i>  ตัวอย่าง</button>
									</div>
									<div class="col-xs-3">
										<button type="button" name="playlist_clear" class="btn btn-default btn-flat btn-block" onclick="uncheckall();"> ล้าง</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="box box-primary box-solid">
					     <div class="box-body" style="height: 350px;">
					     	<iframe src="about:blank;" id="ifr_video_preview" style="height: 100%;width: 100%;" scrolling="no" frameborder="0">
					     	</iframe>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="mySelectPlaylist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">เลือก Hardware ที่ต้องการแสดง Playlist นี้</h4>
	      	</div>
	      	<form method="post">
		     	<div class="modal-body">
		     		<input type="hidden" name="new_playlist_name" id="new_playlist_name">
		        	<table class="table table-hover table-condensed">
		        		<thead>
		        			<tr>
		        				<th>Hardware</th>
		        				<th>Station ID</th>
		        				<th>Old Playlist</th>
		        				<th>Select</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			<?php
								foreach ($res_playlist2 as $value_playlist2) {
									$sql_playlist3 = "SELECT hardware_cmd_value FROM hardware_cmd_set WHERE hardware_type = '".$value_playlist2['hardware_type']."' AND hardware_cmd_name = 'default_name'";
									$query_playlist3 = mysqli_query($conn,$sql_playlist3);
									$res_playlist3 = mysqli_fetch_array($query_playlist3,MYSQLI_BOTH);
									$sql_playlist4 = "SELECT hardware_cmd,hardware_cmd_value FROM hardware_cmd_set WHERE hardware_type = '".$value_playlist2['hardware_type']."' AND hardware_cmd_name = 'station_id'";
									$query_playlist4 = mysqli_query($conn,$sql_playlist4);
									$res_playlist4 = mysqli_fetch_array($query_playlist4,MYSQLI_BOTH);
									$sql_playlist5 = "SELECT playlist_name FROM media_playlist WHERE playlist_no = '".$value_playlist2['hardware_cmd_value']."'";
									$query_playlist5 = mysqli_query($conn,$sql_playlist5);
									$res_playlist5 = mysqli_fetch_array($query_playlist5,MYSQLI_BOTH);
							?>
		        			<tr>
		        				<td><?=$res_playlist3['hardware_cmd_value']; ?></td>
		        				<td><?=$res_playlist4['hardware_cmd_value']; ?></td>
		        				<td><?=$res_playlist5['playlist_name']; ?></td>
		        				<td>
		        					<label>
						                <input type="checkbox" class="checkit" name="select_hardware[]" value="<?=$res_playlist4['hardware_cmd']; ?>" />
						                <span></span>
						            </label>
						        </td>
		        			</tr>
		        			<?php } ?>
		        		</tbody>
		        	</table>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        	<button type="submit" name="save_change_playlist" class="btn btn-primary">Save changes</button>
		      	</div>
		    </form>
    	</div>
  	</div>
</div>
<?php
	if(isset($_POST['submit_upload'])){
		if($_POST['media_type'] == 'radio_image'){
			$extension = pathinfo($_FILES['cover_book']['name'], PATHINFO_EXTENSION);
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

				 		if (file_exists($path_selfcheck_present . $_FILES["cover_book"]["name"])){
				  			echo $_FILES["cover_book"]["name"] . " already exists. ";
				   		}
				 		else{
				   			move_uploaded_file($_FILES["cover_book"]["tmp_name"],
				   			$path_selfcheck_present . $_FILES["cover_book"]["name"]);
				   			echo "Stored in: " . $path_selfcheck_present . $_FILES["cover_book"]["name"];
				   		}
			   		
			   			$insert = "INSERT INTO media_content(media_filename,media_cover)
						VALUES('".$_FILES["cover_book"]["name"]."','".$_FILES["cover_book"]["name"]."')";
						$query_insert = mysqli_query($conn,$insert);
			   		
					echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
					//echo "<script>top.location.reload();</script>";
			 	}
			}
			else{
				echo "Invalid file";
			}
		}
		else{ // if($_POST['media_type'] == 'radio_video')
			$extension = pathinfo($_FILES['video_content']['name'], PATHINFO_EXTENSION);
			if ($_FILES["video_content"]["type"] == "video/mp4"){
			  	if ($_FILES["video_content"]["error"] > 0){
			    	echo "Return Code: " . $_FILES["video_content"]["error"] . "<br />";
			    }
			  	else{
				    //echo "Upload: " . $_FILES["video_content"]["name"] . "<br />";
				    //echo "Type: " . $_FILES["video_content"]["type"] . "<br />";
				    //echo "Size: " . ($_FILES["video_content"]["size"] / 1024) . " Kb<br />";
				    //echo "Temp file: " . $_FILES["video_content"]["tmp_name"] . "<br />";

				 		if (file_exists($path_selfcheck_present . $_FILES["video_content"]["name"])){
				  			echo $_FILES["video_content"]["name"] . " already exists. ";
				   		}
				   		if (file_exists($path_selfcheck_present . $_FILES["image_cover"]["name"])){
				  			echo $_FILES["image_cover"]["name"] . " already exists. ";
				   		}
				 		else{
				   			move_uploaded_file($_FILES["video_content"]["tmp_name"],
				   			$path_selfcheck_present . $_FILES["video_content"]["name"]);
				   			echo "Stored in: " . $path_selfcheck_present . $_FILES["video_content"]["name"];
				   			move_uploaded_file($_FILES["image_cover"]["tmp_name"],
				   			$path_selfcheck_present . $_FILES["image_cover"]["name"]);
				   			echo "Stored in: " . $path_selfcheck_present . $_FILES["image_cover"]["name"];
				   		}
			   		
			   			$insert = "INSERT INTO media_content(media_filename,media_cover)
						VALUES('".$_FILES["video_content"]["name"]."','".$_FILES["image_cover"]["name"]."')";
						$query_insert = mysqli_query($conn,$insert);
			   		
					echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
					//echo "<script>top.location.reload();</script>";
			 	}
			}
			else{
				echo "Invalid file";
			}
		}
	}
	if(isset($_POST['playlist_save'])){
		$playlist = "INSERT INTO media_playlist(playlist_name,playlist,user_update,datetime_update)
					VALUES('".$_POST["playlist_name"]."','".$_POST["detail"]."','$username',now())";
		$query_playlist = mysqli_query($conn,$playlist);
		echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
	}
	if(isset($_POST['save_change_playlist'])){
		foreach ($_POST['select_hardware'] as $value_select_hardware) {
			$update_playlist = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['new_playlist_name']."' WHERE hardware_cmd = '$value_select_hardware' AND hardware_cmd_name = 'playlist'";
		$query_update_playlist = mysqli_query($conn,$update_playlist);
		}
		
		echo "<META http-equiv=\"REFRESH\" content=\"0;\">";
	}

?>

