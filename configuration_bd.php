<?php
    $sql_ip = "SELECT hardware_cmd_value,hardware_cmd FROM hardware_cmd_set WHERE hardware_cmd_name = 'station_id' AND hardware_type = 'BD' ORDER BY hardware_cmd ASC";
    $query_ip = mysqli_query($conn,$sql_ip);
    $res_ip = mysqli_fetch_all($query_ip,MYSQLI_ASSOC);

    $sql_config = "SELECT config_name,config_value FROM configuration WHERE config_type = 'BD'";
    $query_config = mysqli_query($conn,$sql_config);
    $res_config = mysqli_fetch_all($query_config,MYSQLI_ASSOC);
    foreach ($res_config as $value_config) {
        if($value_config['config_name'] == 'printer_name') $printer_name = $value_config['config_value'];
        elseif($value_config['config_name'] == 'regorComd') $regorComd = $value_config['config_value'];
        elseif($value_config['config_name'] == 'password_shutdown') $password_shutdown = $value_config['config_value'];
        elseif($value_config['config_name'] == 'screen_saver') $screen_saver = $value_config['config_value'];
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
            <li><a href="?page=configuration_page">การตั้งค่าทั่วไป</a></li>
            <li><a href="?page=configuration_sc">สำหรับ Selfcheck</a></li>
            <li class="active"><a href="#">สำหรับ Book Drop</a></li>
        </ul>

        <div class="tab-content">
            <form class="form-horizontal" name="frmMain" method="post"  enctype="multipart/form-data" >
                <div style="max-height:400px;overflow-y: auto;overflow-x:hidden">
                    <?php 
                        foreach ($res_ip as $value_ip) {
                            $sql_ip_edit = "SELECT hardware_cmd_value FROM hardware_cmd_set WHERE hardware_cmd_name = 'ip_address' AND hardware_cmd = '".$value_ip['hardware_cmd']."'";
                            $query_ip_edit = mysqli_query($conn,$sql_ip_edit);
                            $res_ip_edit = mysqli_fetch_array($query_ip_edit,MYSQLI_ASSOC);
                    ?>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">IP address (<?=$value_ip['hardware_cmd_value']; ?>)</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="ip_address" class="form-control" 
                            value="<?=$res_ip_edit['hardware_cmd_value'];?>">
                        </div>
                    </div> 
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ชื่อเครื่องพิมพ์ใบเสร็จ</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="printer_name" class="form-control" 
                            value="<?=$printer_name;?>">
                        </div>
                    </div>   
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">Com port</label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" name="regorComd" class="form-control" 
                            value="<?=$regorComd;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">รหัสปิดเครื่อง</label>
                        <div class="col-sm-8 col-md-4">
                            <input type="text" name="password_shutdown" class="form-control" data-validation="length" data-validation-length="4-4"
                            value="<?=$password_shutdown;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-3 control-label">ภาพ Screen saver</label>
                        <div class="col-sm-2 col-md-2" align="center">
                            <img src="<?=$screen_saver; ?>" width="200px" class="img-thumbnail">
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <input type="file" name="screen_saver" class="form-control" data-validation="mime size" data-validation-allowing="jpg, png, gif" data-validation-max-size="2M">
                        </div>
                    </div>            
                </div>
                <hr>
                <div align="center">
                    <input name="submit_saveBD" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_saveBD" value="บันทึกการเปลี่ยนแปลง">
                </div>
            </form>
        </div>
    </div>
</section>
<?php
    if(isset($_POST['submit_saveBD'])){
        foreach ($res_ip as $value_ip1) {
            $update_ip = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['ip_address']."' WHERE hardware_cmd_name = 'ip_address' AND hardware_cmd = '".$value_ip1['hardware_cmd']."'";
            $query_update_ip = mysqli_query($conn,$update_ip);
        }
        foreach ($res_config as $value_config3) {    
            if($value_config3['config_name'] == 'printer_name'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['printer_name']."' WHERE config_type = 'BD' AND config_name = 'printer_name'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'regorComd'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['regorComd']."' WHERE config_type = 'BD' AND config_name = 'regorComd'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'password_shutdown'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['password_shutdown']."' WHERE config_type = 'BD' AND config_name = 'password_shutdown'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'screen_saver' ){
                move_uploaded_file($_FILES["screen_saver"]["tmp_name"],"bookdrop_media/screen_sever/" . $_FILES["screen_saver"]["name"]);
                $update_config = "UPDATE configuration SET config_value = 'http://10.40.50.151/admin-module/bookdrop_media/screen_sever/".$_FILES["screen_saver"]["name"]."' WHERE config_type = 'BD' AND config_name = 'screen_saver'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
        }
        echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 
    }

?>
