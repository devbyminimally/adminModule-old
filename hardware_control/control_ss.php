 <script type="text/javascript" src="farbtastic\jquery.js"></script>
 <script type="text/javascript" src="farbtastic\farbtastic.js"></script>
 <link rel="stylesheet" href="farbtastic\farbtastic.css" type="text/css" />
 <script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $('#demo').hide();
    $('#picker').farbtastic('#hex');
  });
 </script>

 <script type="text/javascript" language="JavaScript">
<!--
//R = hexToR("#FFFFFF");
//G = hexToG("#FFFFFF");
//B = hexToB("#FFFFFF");

function hexToR(h) { return parseInt((cutHex(h)).substring(0,2),16) }
function hexToG(h) { return parseInt((cutHex(h)).substring(2,4),16) }
function hexToB(h) { return parseInt((cutHex(h)).substring(4,6),16) }
function cutHex(h) { return (h.charAt(0)=="#") ? h.substring(1,7) : h}

//-->

function toggle(source) {
  checkboxes = document.getElementsByName('foo[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">การควบคุมเครื่อง Staff Station</h1>
        </div>
        <!-- /.col-lg-12 -->
</div>

<div class="row">
	<form method="post" action="ss_confic_color.php">
		<div class="col-md-6">
			<div class="bs-component">
	              <div class="panel panel-default">
	                <div class="panel-body">
	                	<h4>เลือกเครื่อง</h4><hr>
	                	<table class="table table-bordered">
	                    <thead>
	                      <tr>
	                        <th><input type="checkbox" onClick="toggle(this)" /></th>
	                        <th>หมายเลขเครื่อง</th>
	                        <th>สีปัจจุบัน</th>
	                      </tr>
	                    </thead>
	                    <tbody>
	                    	<?php
	                    		$res_color = site_select_all("hardware_id,confic_value","staff_station WHERE confic_name = 'ss_light'");
	                    		foreach ($res_color as $key => $value_coclor) {
	                    			$hardware_id = $value_coclor['hardware_id'];
	                    		
	                    	?>
	                      <tr>
	                        <td><input type="checkbox" id="foo[]" name="foo[]" value="<?php echo $hardware_id; ?>"> </td>
	                        <td><?php echo $hardware_id; ?></td>
	                        <td style="background-color: rgb(<?php echo $value_coclor['confic_value']; ?>)"></td>
	                      </tr>
	                      <?php } ?>
	                    </tbody>
	                  </table>
	                </div>
	              </div>
	        </div>
		</div>
	    <div class="col-md-6">
	      <div class="bs-component">
	          <div class="panel panel-default">
	            <div class="panel-body">
	            	<h4>เลือกสี</h4><hr>
		            <div align="center">
		            <div class="form-item">
		            	<input type="text" class="form-control" id="hex" name="hex" value="#123456" />
		            </div>
		            	<div id="picker"></div><br>
		            	<button type="submit" name="bnt" id="bnt"class="btn btn-outline btn-success btn-lg" 
			             		onclick="this.form.r.value=hexToR(this.form.hex.value);
										this.form.g.value=hexToG(this.form.hex.value);
										this.form.b.value=hexToB(this.form.hex.value);
										return true;">
								เปลี่ยนสี
						</button><br>
			        	<input type="hidden" name="r" size="3" style="width:50px;">
						<input type="hidden" name="g" size="3" style="width:50px;">
						<input type="hidden" name="b" size="3" style="width:50px;">
					</div>
	            </div>
	          </div>            
	      </div>
	    </div>
    </form>
</div>

