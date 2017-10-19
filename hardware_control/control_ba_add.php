<section class="content-header">
    <h1><?=$lang_ba_register1; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active"><?=$lang_ba_register1; ?></li>
    </ol>
</section>
<section class="content">
	<div class="box box-primary">
        <div class="box-body">
        	<form method="post" target="ba_add_generate" action="hardware_control/control_ba_add_generate.php">
			    <div class="row">
			    	<div class="col-md-3" align="right">
						<h4><b><?=$lang_book_id; ?>  </b></h4>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control input-lg" data-validation="required" name="barcode_id" autofocus>
					</div>
					<div class="col-sm-2">
				        <button type="submit" name="search_book" class="btn btn-primary btn-lg"><i class="fa fa-search"></i> <?=$lang_ba_search; ?></button>
				    </div>
			    </div>
			</form>
		    <hr>
		    <iframe name="ba_add_generate" id="ba_add_generate" style="width: 100%;" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
		 </div>
	</div>
</section>

