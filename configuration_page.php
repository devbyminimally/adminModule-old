<?php
    $sql_config = "SELECT config_name,config_value FROM configuration WHERE config_type = 'global'";
    $query_config = mysqli_query($conn,$sql_config);
    $res_config = mysqli_fetch_all($query_config,MYSQLI_ASSOC);
    foreach ($res_config as $value_config) {
        if($value_config['config_name'] == 'path_api') $path_api = $value_config['config_value'];
        elseif($value_config['config_name'] == 'logoLibrary') $logoLibrary = $value_config['config_value'];
        elseif($value_config['config_name'] == 'logoReceipt') $logoReceipt = $value_config['config_value'];
        elseif($value_config['config_name'] == 'path_camera') $path_camera = $value_config['config_value'];
        elseif($value_config['config_name'] == 'path_hid') $path_hid = $value_config['config_value'];
        elseif($value_config['config_name'] == 'path_imageBook') $path_imageBook = $value_config['config_value'];
        elseif($value_config['config_name'] == 'path_imageMember') $path_imageMember = $value_config['config_value'];
        elseif($value_config['config_name'] == 'path_presentation') $path_presentation = $value_config['config_value'];
        elseif($value_config['config_name'] == 'lenght_id') $lenght_id = $value_config['config_value'];
    }
?>
<section class="content-header">
    <h1>การตั้งค่า</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> OTHER</a></li>
        <li class="active">การตั้งค่า</li>
    </ol>
</section>
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#">การตั้งค่าทั่วไป</a></li>
            <li><a href="?page=configuration_sc">สำหรับ Selfcheck</a></li>
            <li><a href="?page=configuration_bd">สำหรับ Book Drop</a></li>
        </ul>

        <div class="tab-content">
            <form class="form-horizontal" name="frmMain" method="post" enctype="multipart/form-data" >
                <div style="max-height:400px;overflow-y: auto;overflow-x:hidden">
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">จำนวนหลักของรหัสหนังสือ</label>
                        <div class="col-sm-8 col-md-2">
                            <input type="text" name="lenght_id" class="form-control" data-validation="number" data-validation-allowing="range[1;100]" 
                            value="<?=$lenght_id;?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ลิ้งค์ API</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="path_api" class="form-control" 
                            value="<?=$path_api;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ลิ้งค์แสดงปกหนังสือ</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="path_imageBook" class="form-control" 
                            value="<?=$path_imageBook;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ลิ้งค์แสดงรูปสมาชิก</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="path_imageMember" class="form-control" 
                            value="<?=$path_imageMember;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ลิ้งค์บันทึกและเรียกใช้รูปภาพและวีดีโอประชาสัมพันธ์</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="path_presentation" class="form-control" 
                            value="<?=$path_presentation;?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">โลโก้</label>
                        <div class="col-sm-2 col-md-2" align="center">
                            <img src="<?=$logoLibrary; ?>" width="100px" class="img-thumbnail">
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <input type="file" name="logoLibrary" class="form-control" data-validation="mime size" data-validation-allowing="jpg, png, gif" data-validation-max-size="2M">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">โลโก้บนใบพิมพ์รายการ</label>
                        <div class="col-sm-2 col-md-2" align="center">
                            <img src="<?=$logoReceipt; ?>" width="100px" class="img-thumbnail">
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <input type="file" name="logoReceipt" class="form-control" data-validation="mime size" data-validation-allowing="bmp" data-validation-max-size="2M">
                        </div>
                    </div>
                </div>
                <hr>
                <div align="center">
                    <input name="submit_save" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_save" value="บันทึกการเปลี่ยนแปลง">
                </div>
            </form>
        </div>
    </div>
</section>
<?php
  if(isset($_POST['submit_save'])){
      foreach ($res_config as $value_config2) {
        if($value_config2['config_name'] == 'path_api' && $value_config2['config_value'] != $_POST['path_api']){
            $update_config = "UPDATE configuration SET config_value = '".$_POST['path_api']."' WHERE config_type = 'global' AND config_name = 'path_api'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'path_imageBook' && $value_config2['config_value'] != $_POST['path_imageBook']){
            $update_config = "UPDATE configuration SET config_value = '".$_POST['path_imageBook']."' WHERE config_type = 'global' AND config_name = 'path_imageBook'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'path_imageMember' && $value_config2['config_value'] != $_POST['path_imageMember']){
            $update_config = "UPDATE configuration SET config_value = '".$_POST['path_imageMember']."' WHERE config_type = 'global' AND config_name = 'path_imageMember'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'path_presentation' && $value_config2['config_value'] != $_POST['path_presentation']){
            $update_config = "UPDATE configuration SET config_value = '".$_POST['path_presentation']."' WHERE config_type = 'global' AND config_name = 'path_presentation'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'lenght_id' && $value_config2['config_value'] != $_POST['lenght_id']){
            $update_config = "UPDATE configuration SET config_value = '".$_POST['lenght_id']."' WHERE config_type = 'global' AND config_name = 'lenght_id'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'logoLibrary' && $_FILES['logoLibrary']['error'] == 'UPLOAD_ERR_OK'){
            move_uploaded_file($_FILES["logoLibrary"]["tmp_name"],"media_content/logo/" . $_FILES["logoLibrary"]["name"]);
            $update_config = "UPDATE configuration SET config_value = 'http://10.40.50.151/admin-module/media_content/logo/".$_FILES["logoLibrary"]["name"]."' WHERE config_type = 'global' AND config_name = 'logoLibrary'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
        elseif($value_config2['config_name'] == 'logoReceipt' && $_FILES['logoReceipt']['error'] == 'UPLOAD_ERR_OK'){
            move_uploaded_file($_FILES["logoReceipt"]["tmp_name"],"media_content/logo/" . $_FILES["logoReceipt"]["name"]);
            $update_config = "UPDATE configuration SET config_value = 'http://10.40.50.151/admin-module/media_content/logo/".$_FILES["logoReceipt"]["name"]."' WHERE config_type = 'global' AND config_name = 'logoReceipt'";
            $query_update_config = mysqli_query($conn,$update_config);
        }
      }
      echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 
      
  }

?>

