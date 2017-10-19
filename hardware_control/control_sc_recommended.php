<section class="content-header">
    <h1>กำหนดหนังสือแนะนำ</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active">กำหนดหนังสือแนะนำ</li>
    </ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-7">
			<div class="box box-primary">
				<div class="box-header with-border">
		          	<h3 class="box-title">รายการหนังสือ</h3>
		        </div><!-- /.box-header -->
		        <div class="box-body">
                  	<iframe name="sc_recommended_list" id="sc_recommended_list" src="control_sc_recommended_list.php" style="width: 100%;height: 10px;" frameborder="0" scrolling="no" onload="resizeIframe(this);"></iframe>
                </div>
            </div>

		</div>
		<div class="col-md-5">
			<div class="box box-primary">
		        <div class="box-body" align="center">
		        	<form class="form-inline" method="post" target="sc_recommended_add" action="control_sc_recommended_add_1.php">
		        		<div class="form-group">
						    <label >รหัสหนังสือ</label>
						    <input type="text" class="form-control" data-validation="required" name="barcode_id">
						</div>
						<button type="submit" name="search_book" class="btn btn-primary "><i class="fa fa-search"></i> ค้นหา</button>
					</form>
				    <hr>
				    <iframe name="sc_recommended_add" id="sc_recommended_add" style="width: 100%;height: 20px;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
				 </div>
			</div>
		</div>
	</div>
	

</section>

