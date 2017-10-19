<section class="content-header">
    <h1><?=$lang_ba_list; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> CONTROL</a></li>
      <li class="active"><?=$lang_ba_list; ?></li>
    </ol>
</section>
<section class="content">
	<div class="box box-primary">
        <div class="box-body">
        	<table class="table table-bordered table-hover" id="dataTables-example">
		    	<thead>
					<tr>
						<th width="5%"><?=$lang_no; ?></th>
						<th><?=$lang_book_id; ?></th>
						<th><?=$lang_book_name; ?></th>
						<th width="30%"><?=$lang_detail; ?></th>
						<th><?=$lang_ba_coverbook; ?></th>
						<th><?=$lang_ba_edit2; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						$sql = "SELECT book_id,book_name,book_description,book_image FROM book_atm_register";
						$query = mysqli_query($conn,$sql);
						while ($res = mysqli_fetch_array($query,MYSQLI_BOTH)) {
							$num++;
					?>
					<tr>
						<td><?php echo $num; ?></td>
						<td><?php echo $res['book_id']; ?></td>
						<td><?php echo $res['book_name']; ?></td>
						<td><?php echo $res['book_description']; ?></td>
						<td><a href="<?php echo $path_image.$res['book_image']; ?>" data-lity><img src="<?php echo $path_image.$res['book_image']; ?>" style="width:50px;height:70px;"></a></td>
						<td><a href="?page=control_ba_edit&id=<?php echo $res['book_id']; ?>"><img src="img/edit.png" width="30"></a></td>
					</tr>
					<?php } ?>
				</tbody>
		    </table>
		</div>
	</div>
</section>
<br><br><br>
