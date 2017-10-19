<?php $user1 = $_GET['us']; ?>
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
            <form method="post" name="form1" id="form1" action="user_edit_iframe.php"  target="iframe_target">
                <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <!--<th>ลำดับ </th>-->
                            <th>รายละเอียด </th>
                            <th width="35%">สิทธิ์การเข้าใช้งานอุปกรณ์ </th>
                            <th width="35%">สิทธิ์การเข้าถึงรายงาน </th>
                            <!--<th>แก้ไข </th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = '1';
                            $sqlstaff = "SELECT customer.cus_id,customer.cus_username,customer.cus_name,customer.cus_position,customer.cus_email,customer_type.cus_id,customer_type.cus_hardware_list,customer_type.cus_report_list
                                    FROM customer
                                    INNER JOIN customer_type
                                    ON customer.cus_id = customer_type.cus_id
                                    WHERE customer.cus_orga = '$orga'
                                    AND customer.cus_type = 'staff' 
                                    AND customer.cus_status = '0'";
                            $querystaff = mysqli_query($conn1,$sqlstaff);
                            while($resstaff = mysqli_fetch_array($querystaff,MYSQLI_ASSOC)){  
                                $hwstaff = $resstaff['cus_hardware_list'];
                                $hwstaff2 = explode(',',$hwstaff); 

                                $re = $resstaff['cus_report_list'];
                                $re2 = explode(',',$re); 
                            
                                $user = $resstaff['cus_username'];

                                $sqlhardware = "SELECT hw_name,hw_code FROM hardware_detail GROUP BY hw_code";
                                $queryhardware = mysqli_query($conn,$sqlhardware);
                                $reshardware = mysqli_fetch_all($queryhardware,MYSQLI_BOTH);
        
                                if($resstaff['cus_username'] == $user1){
                        ?>
                        <tr>
                            <!--<td align="center"><?php echo $i; ?></td>-->
                            <td align="center">
                                <input type="hidden" name="id"  value="<?php echo $resstaff['cus_id']; ?>">
                                <div class="row" >
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ชื่อสกุล</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="name" class="form-control" data-validation="required" value="<?php echo $resstaff['cus_name']; ?>">
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ชื่อผู้ใช้</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                         <input type="hidden" name="old_username" class="form-control" value="<?php echo $resstaff['cus_username']; ?>">
                                        <input type="text" name="username" class="form-control" data-validation="alphanumeric custom" data-validation-allowing="_" value="<?php echo $resstaff['cus_username']; ?>">
                                        <div id="iusername"></div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ตำแหน่ง</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="position" class="form-control" value="<?php echo $resstaff['cus_position']; ?>">
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>อีเมล</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="txt_email" data-validation="email" class="form-control" data-validation-error-msg="กรุณากรอกอีเมล" value="<?php echo $resstaff['cus_email']; ?>">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                  <?php
                                        foreach ($reshardware as $key => $value) {
                                            foreach ($hw2 as $value_hw2) {
                                                if($value_hw2 == $value['hw_code']){
                                                $check = "";
                                                foreach ($hwstaff2 as $valuestaff) { 
                                                    if($value['hw_code'] == $valuestaff){
                                                        $check = "checked";
                                                    }//if
                                                }//foreach ($hwstaff2 as $valuestaff)
                                  ?>
                                    <div class="col-md-12 col-lg-6">
                                        <input type="checkbox" name="media[]" class="minimal-blue" value="<?php echo $value['hw_code']; ?>" <?php echo $check; ?>> <?php echo $value['hw_name']; ?>
                                    </div> 
                                  <?php 
                                      } } }//foreach ($reshardware as $key => $value)
                                  ?>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                  <?php
                                        foreach ($reshardware as $key => $value) {
                                            foreach ($report_menu2 as $value_report_menu2) {
                                                if($value_report_menu2 == $value['hw_code']){
                                                $check = "";
                                                foreach ($re2 as $valuestaff) { 
                                                    if($value['hw_code'] == $valuestaff){
                                                        $check = "checked";
                                                    }//if
                                                }//foreach ($hwstaff2 as $valuestaff)
                                  ?>
                                    <div class="col-md-12 col-lg-6">
                                        <input type="checkbox" name="report[]" class="minimal-blue" value="<?php echo $value['hw_code']; ?>" <?php echo $check; ?>> <?php echo $value['hw_name']; ?>
                                    </div> 
                                  <?php 
                                      }}} //foreach ($reshardware as $key => $value)
                                  ?>
                                </div>
                            </td>
                            <!--<td align="center">
                              <input name="submit_edit" type="submit" class="btn btn-sm btn-flat btn-primary" id="submit_edit" value="ยืนยันการแก้ไข">
                            </td>-->
                        </tr>
                        <?php
                            $i++; 
                          }//if($resstaff['cus_username'] == $user1)
                         //else{
                          //$id = $resstaff['cus_id'];
                      ?>
                      
                      <!--<tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td align="center">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ชื่อสกุล</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="name" class="form-control input-sm" value="<?php echo $resstaff['cus_name']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ชื่อผู้ใช้</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="username" class="form-control input-sm" value="<?php echo $resstaff['cus_username']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-5" align="right"><b>ตำแหน่ง</b></div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <input type="text" name="position" class="form-control input-sm" value="<?php echo $resstaff['cus_position']; ?>" disabled>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" name="id"  value="<?php echo $resstaff['cus_id'];?>">
                                <input type="hidden" name="name"  value="<?php echo $resstaff['cus_username'];?>">
                                <div class="row">
                                  <?php
                                    foreach ($hwstaff2 as $hw_value) { 
                                      foreach ($reshardware as $key => $value) {
                                        if($hw_value == $value['hw_code']){
                                  ?>
                                    <div class="col-md-12 col-lg-6 "><li><?php echo $value['hw_name']; ?></li></div>
                                  <?php 
                                        } //if($hw_value == $value['hw_code1'])
                                      } //foreach ($reshardware as $key => $value)
                                    } //foreach ($hwstaff2 as $hw_value)
                                  ?>
                                </div>
                            </td>
                             <td>
                                <div class="row">
                                  <?php
                                    foreach ($re2 as $hw_value) { 
                                      foreach ($reshardware as $key => $value) {
                                        if($hw_value == $value['hw_code']){
                                  ?>
                                    <div class="col-md-12 col-lg-6 "><li><?php echo $value['hw_name']; ?></li></div>
                                  <?php 
                                        } //if($hw_value == $value['hw_code1'])
                                      } //foreach ($reshardware as $key => $value)
                                    } //foreach ($hwstaff2 as $hw_value)
                                  ?>
                                </div>
                            </td>
                            <td align="center"><a href="?page=user_edit&us=<?=$user; ?>"><img src="img/edit.png" width="30"></a></td>
                      </tr>-->
                      <?php 
                                //$i++; 
                            //}//else
                        }//while 
                      ?>
                    </tbody>
                </table>
                <div>
                    <a href="?page=user_detail" class="btn btn-lg btn-flat btn-default" role="button"><span class="fa fa-arrow-left"> </span> ย้อนกลับ</a>
                    <span class="pull-right">
                        <input name="submit_edit" type="submit" class="btn btn-lg btn-flat btn-success" id="submit_edit" value="ยืนยันการแก้ไข">
                    </span>
                </div>
            </form>
        </div>
    </div>
</section>
