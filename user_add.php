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
            <li><a href="?page=user_detail">รายละเอียด/แก้ไข ข้อมูลเจ้าหน้าที่ </a></li>
            <li class="active"><a href="#">เพิ่มข้อมูลเจ้าหน้าที่</a></li>
        </ul>
        <div class="tab-content">
            <form class="form-horizontal" name="frmMain" method="post" action="user_add_iframe.php"  target="iframe_target" >
              <iframe id="iframe_target" name="iframe_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe> 
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">ชื่อจริง-นามสกุล</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="text" name="name" data-validation="required" class="form-control" placeholder="ชื่อจริง-นามสกุล">
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">ตำแหน่ง</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="text" name="position" class="form-control" placeholder="ตำแหน่ง">
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">อีเมล</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="text" name="txt_email" data-validation="email" class="form-control" placeholder="mail@website.com" data-validation-error-msg="กรุณากรอกอีเมล">
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">ชื่อผู้ใช้</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="text" name="user" data-validation="alphanumeric custom" data-validation-allowing="_" class="form-control" placeholder="ชื่อผู้ใช้">
                    <div id="iusername"></div>
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">รหัสผ่าน</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="password" name="pass_confirmation" data-validation="required" class="form-control" placeholder="รหัสผ่าน">
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 col-md-3 control-label">ยืนยันรหัสผ่าน</label>
                  <div class="col-sm-8 col-md-6">
                    <input type="password" name="pass" data-validation="confirmation" class="form-control" placeholder="ยืนยันรหัสผ่าน">
                  </div>
              </div>
              <hr>
              <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                      <label class="col-sm-12 col-md-12 control-label">สิทธิ์การควบคุมอุปกรณ์   </label>
                    </div>
                    <div class="col-sm-12 col-md-7">
                      <div class="checkbox">  
                      <?php
                              $sqlhardware = "SELECT hw_code,hw_name FROM hardware_detail GROUP BY hw_code";
                              $queryhardware = mysqli_query($conn,$sqlhardware);
                              $reshardware = mysqli_fetch_all($queryhardware,MYSQLI_BOTH);
                              foreach ($reshardware as $key => $value) {
                                foreach ($hw2 as $value_hw2) {
                                  if($value_hw2 == $value['hw_code']){
                                
                      ?>
                      <div class="col-sm-12 col-md-4">
                        <label>
                          <input type="checkbox" class="minimal-blue" name="media[]" value="<?php echo $value['hw_code']; ?>"> <?php echo $value['hw_name']; ?>
                        </label>
                      </div>
                        <?php  }}} ?>
                      </div><!-- check box -->
                    </div><!-- col-sm-12 col-md-7-->
                </div><!-- row -->
              </div><!-- form-group -->
              <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                      <label class="col-sm-12 col-md-12 control-label">สิทธิ์การเข้าถึงรายงาน   </label>
                    </div>
                    <div class="col-sm-12 col-md-7">
                      <div class="checkbox">  
                      <?php
                              $sqlhardware = "SELECT hw_code,hw_name FROM hardware_detail GROUP BY hw_code";
                              $queryhardware = mysqli_query($conn,$sqlhardware);
                              $reshardware = mysqli_fetch_all($queryhardware,MYSQLI_BOTH);
                              foreach ($reshardware as $key => $value) {
                                foreach ($report_menu2 as $value_report_menu2) {
                                  if($value_report_menu2 == $value['hw_code']){
                      ?>
                      <div class="col-sm-12 col-md-4">
                        <label>
                          <input type="checkbox" class="minimal-blue" name="report[]" value="<?php echo $value['hw_code']; ?>"> <?php echo $value['hw_name']; ?>
                        </label>
                      </div>
                        <?php  }}} ?>
                      </div><!-- check box -->
                    </div><!-- col-sm-12 col-md-7-->
                </div><!-- row -->
              </div><!-- form-group -->
              <hr>
              <div align="center">
                  <input name="submit_staff" type="submit" class="btn btn-lg btn-primary" id="submit_staff" value="เพิ่มเจ้าหน้าที่">
              </div>
            </form>
        </div>
    </div>
</section>
