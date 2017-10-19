<section class="content-header">
    <h1>รายงานสถิติการใช้บริการ Book drop</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i><?=$lang_report; ?></a></li>
      <li class="active">รายงานสถิติการใช้บริการ Book drop</li>
    </ol>
</section>
<section class="content">
	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
    	    <li><a href="?page=report_bd">รายงานคืนหนังสือ</a></li>
    	    <li><a href="?page=report_bd_pic">รายงานคืนหนังสือ (แสดงภาพ)</a></li>
    	    <li class="active"><a href="#">รายงานสถิติการใช้บริการ Book drop</a></li>
    	</ul>
    	<div class="tab-content">
			<div class="row">
			    <div class="col-sm-12">
			    	<form class="form" id="bd_form" name="bd_form" method="post" target="report_generate" action="report_bd_static_1_generate.php" >
						<div class="col-md-12">&nbsp;</div>
						<div class="form-group  col-md-12">
							<label class="col-sm-2 control-label" align="right"><?=$lang_sort_by; ?></label>
							<label class="radio-inline">
                          		<input type="radio" class="minimal-blue" name="sort_by" value="sort_hour" checked> รายชั่วโมง
                        	</label>
			                <label class="radio-inline">
                          		<input type="radio" class="minimal-blue" name="sort_by" value="sort_date"> <?=$lang_sort_by1; ?>
                        	</label>
                        	<label class="radio-inline">
                          		<input type="radio" class="minimal-blue" name="sort_by" value="sort_month"> <?=$lang_sort_by2; ?>
                        	</label>
                        	<label class="radio-inline">
                          		<input type="radio" class="minimal-blue" name="sort_by" value="sort_year"> <?=$lang_sort_by3; ?>
                        	</label>
			            </div>
			            <div class="form-group  col-md-12">
			            	<label class="col-sm-2 control-label" align="right"><?=$lang_select_date; ?></label>
			            	<div class="col-md-2" id="input_date1">
			            		<input type="date" class="form-control input-sm" id="month_start" name="month_start" onchange="setMonth();">
			            	</div>
			                <div class="col-md-1" align="center"> <?=$lang_to; ?></div>
			                <div class="col-md-2" id="input_date2">
			            		<input type="date" class="form-control input-sm" id="month_end" name="month_end" disabled>
			            	</div>
			            </div>
						<div class="form-group col-md-12 ">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" name="report_bd" id="report_bd" class="btn btn-primary" disabled><?=$lang_export; ?></button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-12">
					<iframe name="report_generate" id="report_generate" src="about:blank;" style="width: 100%;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
			    </div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function setMonth(){

		var x = document.getElementById("month_start").value;
		//alert(x);
		document.getElementById("month_end").min = x;
		$("#month_end").prop('disabled', false);
		$("#report_bd").prop('disabled', false);
		$("#month_end").val(x);
	}
	
</script>