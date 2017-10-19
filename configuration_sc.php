<?php
    $function_borrow = "";
    $function_renew = "";
    $function_return = "";
    $member_booking_detail = "";
    $member_borrow_detail = "";
    $member_overdue_detail = "";
    $member_payment_fine = "";
    $member_payment_balance = "";
    $sql_ip = "SELECT hardware_cmd_value,hardware_cmd FROM hardware_cmd_set WHERE hardware_cmd_name = 'station_id' AND (hardware_type = 'SC' OR hardware_type = 'DC') ORDER BY hardware_cmd ASC";
    $query_ip = mysqli_query($conn,$sql_ip);
    $res_ip = mysqli_fetch_all($query_ip,MYSQLI_ASSOC);
    $sql_config = "SELECT config_name,config_value FROM configuration WHERE config_type = 'SC'";
    $query_config = mysqli_query($conn,$sql_config);
    $res_config = mysqli_fetch_all($query_config,MYSQLI_ASSOC);
    foreach ($res_config as $value_config) {
        if($value_config['config_name'] == 'function_borrow' && $value_config['config_value'] == 1) $function_borrow = "checked";
        elseif($value_config['config_name'] == 'function_renew' && $value_config['config_value'] == 1) $function_renew = "checked";
        elseif($value_config['config_name'] == 'function_return' && $value_config['config_value'] == 1) $function_return = "checked";
        elseif($value_config['config_name'] == 'member_booking_detail' && $value_config['config_value'] == 1) $member_booking_detail = "checked";
        elseif($value_config['config_name'] == 'member_borrow_detail' && $value_config['config_value'] == 1) $member_borrow_detail = "checked";
        elseif($value_config['config_name'] == 'member_overdue_detail' && $value_config['config_value'] == 1) $member_overdue_detail = "checked";
        elseif($value_config['config_name'] == 'member_payment_fine' && $value_config['config_value'] == 1) $member_payment_fine = "checked";
        elseif($value_config['config_name'] == 'member_payment_balance' && $value_config['config_value'] == 1) $member_payment_balance = "checked";
        elseif($value_config['config_name'] == 'printer_name') $printer_name = $value_config['config_value'];
        elseif($value_config['config_name'] == 'regorComd') $regorComd = $value_config['config_value'];
        elseif($value_config['config_name'] == 'password_shutdown') $password_shutdown = $value_config['config_value'];
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
            <li class="active"><a href="#">สำหรับ Selfcheck</a></li>
            <li><a href="?page=configuration_bd">สำหรับ Book Drop</a></li>
        </ul>

        <div class="tab-content">
            <form class="form-horizontal" name="frmMain" method="post" >
                <div style="max-height:400px;overflow-y: auto;overflow-x:hidden">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-md-3">
                                <label class="col-sm-12 col-md-12 control-label">เลือกฟังก์ชั่น   </label>
                            </div>
                            <div class="col-sm-8 col-md-7">
                                <div class="checkbox"> 
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="function_borrow" <?=$function_borrow;?>> ฟังก์ชั่นยืม
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="function_renew" <?=$function_renew;?>> ฟังก์ชั่นยืมต่อ
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="function_return" <?=$function_return;?>> ฟังก์ชั่นคืน
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="member_booking_detail" <?=$member_booking_detail;?>> รายการหนังสือจอง
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="member_borrow_detail" <?=$member_borrow_detail;?>> รายการหนังสือยืมอยู่
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="member_overdue_detail" <?=$member_overdue_detail;?>> รายการหนังสือเกินกำหนด
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="member_payment_fine" <?=$member_payment_fine;?>> แสดงค่าปรับ
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>
                                            <input type="checkbox" class="minimal-blue" name="function[]" value="member_payment_balance" <?=$member_payment_balance;?>> แสดงยอดเงินคงเหลือ
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
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
                </div>
                <hr>
                <div align="center">
                    <input name="submit_saveSC" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_saveSC" value="บันทึกการเปลี่ยนแปลง">
                </div>
            </form>
        </div>
    </div>
</section>
<?php
    if(isset($_POST['submit_saveSC'])){
        $function_borrow = 0;
        $function_renew = 0;
        $function_return = 0;
        $member_booking_detail = 0;
        $member_borrow_detail = 0;
        $member_overdue_detail = 0;
        $member_payment_fine = 0;
        $member_payment_balance = 0;
        if(count($_POST['function'])>0){
            foreach ($_POST['function'] as $value_function) {
                if($value_function == 'function_borrow') $function_borrow = 1;
                elseif($value_function == 'function_renew')$function_renew = 1;
                elseif($value_function == 'function_return')$function_return = 1;
                elseif($value_function == 'member_booking_detail')$member_booking_detail = 1;
                elseif($value_function == 'member_borrow_detail')$member_borrow_detail = 1;
                elseif($value_function == 'member_overdue_detail')$member_overdue_detail = 1;
                elseif($value_function == 'member_payment_fine')$member_payment_fine = 1;
                elseif($value_function == 'member_payment_balance')$member_payment_balance = 1;
            }
        }
        foreach ($res_ip as $value_ip1) {
            $update_ip = "UPDATE hardware_cmd_set SET hardware_cmd_value = '".$_POST['ip_address']."' WHERE hardware_cmd_name = 'ip_address' AND hardware_cmd = '".$value_ip1['hardware_cmd']."'";
            $query_update_ip = mysqli_query($conn,$update_ip);
        }
        foreach ($res_config as $value_config3) {    
            if($value_config3['config_name'] == 'printer_name'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['printer_name']."' WHERE config_type = 'SC' AND config_name = 'printer_name'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'regorComd'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['regorComd']."' WHERE config_type = 'SC' AND config_name = 'regorComd'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'password_shutdown'){
                $update_config = "UPDATE configuration SET config_value = '".$_POST['password_shutdown']."' WHERE config_type = 'SC' AND config_name = 'password_shutdown'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'function_borrow'){
                $update_config = "UPDATE configuration SET config_value = '".$function_borrow."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'function_renew'){
                $update_config = "UPDATE configuration SET config_value = '".$function_renew."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'function_return'){
                $update_config = "UPDATE configuration SET config_value = '".$function_return."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'member_booking_detail'){
                $update_config = "UPDATE configuration SET config_value = '".$member_booking_detail."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'member_borrow_detail'){
                $update_config = "UPDATE configuration SET config_value = '".$member_borrow_detail."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'member_overdue_detail'){
                $update_config = "UPDATE configuration SET config_value = '".$member_overdue_detail."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'member_payment_fine'){
                $update_config = "UPDATE configuration SET config_value = '".$member_payment_fine."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
            elseif($value_config3['config_name'] == 'member_payment_balance'){
                $update_config = "UPDATE configuration SET config_value = '".$member_payment_balance."' WHERE config_type = 'SC' AND config_name = '".$value_config3['config_name']."'";
                $query_update_config = mysqli_query($conn,$update_config);
            }
        }
        echo "<META http-equiv=\"REFRESH\" content=\"0;\">"; 
    }

?>