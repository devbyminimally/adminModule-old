<section class="content-header">
    <h1>ควบคุมอุปกรณ์</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">ควบคุมอุปกรณ์</li>
    </ol>
</section>
<section class="content">

<?php
    foreach ($hw2 as $value_hw_list) {
?>
    <div class="box ">
        <!--<div class="box-header with-border">
            <h3 class="box-title"><?php echo $res_hw1['hardware_cmd_value']; ?></h3>
        </div>-->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-2" align="center">
                    <img src="img/hw/<?=$value_hw_list; ?>.png" style="width: 80px;">
                </div>
                <div class="col-sm-10">
                    <table class="table table-hover">
                      <thead>
                          <tr>
                            <th width="20%">NAME</th>
                            <th width="20%">STATION ID</th>
                            <th width="20%">POWER OFF</th>
                            <th width="20%">STATUS</th>
                            
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $sql_hw1 = "SELECT hardware_cmd,hardware_id FROM hardware_cmd WHERE hardware_type = '$value_hw_list'";
                              $query_hw1 = mysqli_query($conn,$sql_hw1);
                              while($res_hw1 = mysqli_fetch_array($query_hw1,MYSQLI_BOTH)){
                                  $arr_hw2[] =  $res_hw1['hardware_cmd'];
                                  echo "<tr>";
                                  $sql_hw3 = "SELECT hardware_cmd_name,hardware_cmd_value FROM hardware_cmd_set WHERE hardware_cmd = '".$res_hw1['hardware_cmd']."' ";
                                  $query_hw3 = mysqli_query($conn,$sql_hw3);
                                  while($res_hw3 = mysqli_fetch_array($query_hw3,MYSQLI_BOTH)){
                                      if($res_hw3['hardware_cmd_name'] == 'default_name'){ 
                                          echo "<td>".$res_hw3['hardware_cmd_value']."</td>"; 
                                      }
                                      if($res_hw3['hardware_cmd_name'] == 'station_id'){ 
                                          echo "<td>".$res_hw3['hardware_cmd_value']."</td>"; 
                                      }
                                  }

                                  $ip_sc ='';
                                  $mac_sc = '';
                                  $sql_hw4 = "SELECT hardware_cmd_name,hardware_cmd_value FROM hardware_cmd_set WHERE hardware_cmd = '".$res_hw1['hardware_cmd']."' ";
                                  $query_hw4 = mysqli_query($conn,$sql_hw4);
                                  while($res_hw4 = mysqli_fetch_array($query_hw4,MYSQLI_BOTH)){
                                      if($res_hw4['hardware_cmd_name'] == 'status_hw'){

                                          echo "<td id='status".$res_hw1['hardware_cmd']."'><img src='img/gif-load.gif' width='25px'></td>";
                                      }
                                      if($res_hw4['hardware_cmd_name'] == 'ip_address'){ 
                                          $ip_sc = $res_hw4['hardware_cmd_value'];
                                          if($value_hw_list == 'SC'){ ?>
                                            <td><a href='#' onclick="alert('shutdown');document.getElementById('ifr_shutdown').src = 'http://<?=$res_hw4['hardware_cmd_value'];?>/self_check/shutdown.php';"><i class='fa fa-power-off fa-2x text-danger'></i></a></td> 
                                          <?php }else if($value_hw_list == 'BD'){ ?>
                                            <td><a href='#' onclick="alert('shutdown');document.getElementById('ifr_shutdown').src = 'http://<?=$res_hw4['hardware_cmd_value'];?>/book_drop/shutdown.php';"><i class='fa fa-power-off fa-2x text-danger'></i></a></td> 
                                          <?php }else {
                                            echo "<td>-</td>";
                                          }
                                      }
                                  }
                                  echo "</tr>"; 
                              } 
                          ?>
                      </tbody>
                    </table>
                    
                </div>
            </div>
        </div><!-- /.box-body -->
    </div>
<?php } ?>
<script type="text/javascript">
  function shutdown_sc(){
    
  }
</script>

<iframe src="about:blank;" id="ifr_shutdown" style="width:0px;height:0px;" border="0"></iframe>
<iframe src="home13_checkStatus.php?<?php echo preg_replace('/hw2[0-9]+/', 'hw2[]',http_build_query($arr_hw2,'hw2')); ?>" style="width:0px;height:0px;" border="0"></iframe>
<br><br><br>
</section>
