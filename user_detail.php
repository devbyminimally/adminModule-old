<section class="content-header">
    <h1>ข้อมูลเจ้าหน้าที่</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> OTHER</a></li>
        <li class="active">ข้อมูลเจ้าหน้าที่</li>
    </ol>
</section>
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#">รายละเอียด/แก้ไข ข้อมูลเจ้าหน้าที่ </a></li>
            <li><a href="?page=user_add">เพิ่มข้อมูลเจ้าหน้าที่</a></li>
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>ลำดับ </th>
                        <th>ชื่อ-นามสกุล </th>
                        <th>ชื่อผู้ใช้ </th>
                        <th>อีเมล </th>
                        <th width="25%">สิทธิ์การเข้าใช้งานอุปกรณ์ </th>
                        <th width="25%">สิทธิ์การเข้าถึงรายงาน </th>
                        <th>แก้ไข </th>
                        <th>ระงับสิทธิ์ </th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $i = 1;
                        $sql = "SELECT customer.cus_id,customer.cus_username,customer.cus_name,customer.cus_position,customer.cus_email,customer.cus_status,customer_type.cus_hardware_list,customer_type.cus_report_list
                                FROM customer
                                INNER JOIN customer_type
                                ON customer.cus_id = customer_type.cus_id
                                WHERE customer.cus_orga = '$orga'
                                AND customer.cus_type = 'staff' ";
                        $query = mysqli_query($conn1,$sql);
                        while($res = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                        $hw = $res['cus_hardware_list'];
                        $hw2 = explode(',',$hw); 

                        $re = $res['cus_report_list'];
                        $re2 = explode(',',$re); 

                        $user = $res['cus_username'];
                        $id = $res['cus_id'];

                        $sqlhardware = "SELECT hw_name,hw_code FROM hardware_detail GROUP BY hw_code";
                        $queryhardware = mysqli_query($conn,$sqlhardware);
                        $reshardware = mysqli_fetch_all($queryhardware,MYSQLI_BOTH);

                        if($res['cus_status'] == '0'){
                            
                    ?>
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $res['cus_name']; ?></td>
                        <td><?php echo $res['cus_username']; ?></td>
                        <td><?php echo $res['cus_email']; ?></td>
                        <td>
                            <input type="hidden" name="id"  value="<?php echo $res['cus_id'];?>">
                            <input type="hidden" name="name"  value="<?php echo $res['cus_username'];?>">
                            <div class="row">
                            <?php
                              foreach ($hw2 as $hw_value) { 
                                foreach ($reshardware as $key => $value) {
                                  if($hw_value == $value['hw_code']){
                            ?>
                              <div class="col-xs-12 col-sm-6 col-md-6 ">
                                <li><?php echo $value['hw_name']; ?></li>
                              </div>
                            <?php } } } ?>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                            <?php
                              foreach ($re2 as $re_value) { 
                                foreach ($reshardware as $key => $value) {
                                  if($re_value == $value['hw_code']){
                            ?>
                              <div class="col-xs-12 col-sm-6 col-md-6 ">
                                <li><?php echo $value['hw_name']; ?></li>
                              </div>
                            <?php } } } ?>
                            </div>
                        </td>
                        <td align="center">
                            <a href="?page=user_edit&us=<?=$user; ?>"><img src="img/edit.png" width="30"></a>
                        </td>
                        <td align="center">
                            <a href="#" onclick="confirm_block('<?php echo $id; ?>','<?=$res['cus_status']; ?>');"><img src="img/unlock.png" width="30"></a>
                        </td>
                    </tr>

                  <?php 
                      $i++; 
                      }else if($res['cus_status'] == '1'){
                  ?>

                    <tr>
                        <td align="center"><font color="#BDBDBD"><?php echo $i; ?></font></td>
                        <td><font color="#BDBDBD"><?php echo $res['cus_name']; ?></font></td>
                        <td><font color="#BDBDBD"><?php echo $res['cus_username']; ?></font></td>
                        <td><font color="#BDBDBD"><?php echo $res['cus_email']; ?></font></td>
                        <td><font color="#BDBDBD">
                            <input type="hidden" name="id"  value="<?php echo $res['cus_id'];?>">
                            <input type="hidden" name="name"  value="<?php echo $res['cus_username'];?>">
                            <div class="row">
                            <?php
                                foreach ($hw2 as $hw_value) { 
                                  foreach ($reshardware as $key => $value) {
                                    if($hw_value == $value['hw_code']){
                            ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 "><li><?php echo $value['hw_name']; ?></li></div>
                            <?php } } } ?>
                            </div>
                        </font></td>
                        <td><font color="#BDBDBD">
                            <div class="row">
                            <?php
                              foreach ($re2 as $re_value) { 
                                foreach ($reshardware as $key => $value) {
                                  if($re_value == $value['hw_code']){
                            ?>
                              <div class="col-xs-12 col-sm-6 col-md-6 ">
                                <li><?php echo $value['hw_name']; ?></li>
                              </div>
                            <?php } } } ?>
                            </div>
                        </font></td>
                        <td align="center">
                            <a href="#"><img src="img/notedit.png" width="30"></a>
                        </td>
                        <td align="center">
                            <a href="#" onclick="cancle_block('<?php echo $id; ?>','<?=$res['cus_status']; ?>');"><img src="img/lock.png" width="30"></a>
                        </td>
                    </tr>
                    <?php $i++; } } ?>
                </tbody>
                <div class="col"
            </table>
        </div>
    </div>
</section>
<script type="text/javascript">
    function cancle_block(id,status) {
        if(confirm("คุณต้องการยกเลิกการระงับบัญชีผู้ใช้นี้?")){
            location = "user_drop.php?id="+id+"&status="+status;
        }
    }

    function confirm_block(id,status) {
        if(confirm("คุณต้องการระงับบัญชีผู้ใช้นี้?")){
            location = "user_drop.php?id="+id+"&status="+status;
        }
    }
</script> 