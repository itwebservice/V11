<?php
include_once("../../../model/model.php");
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Description</th>
			<th>Type</th>
			<th>Tour_Type</th>
			<th>For</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_inc = mysqlQuery("select * from inclusions_exclusions_master");
		while($row_inc = mysqli_fetch_assoc($sq_inc)){

			$bg = ($row_inc['active_flag']=="Active") ? "" : "danger";
			if($row_inc['for_value'] == 'Group'){
				$label = 'Group Tour';
			}else if($row_inc['for_value'] == 'Package'){
				$label = 'Package Tour';
			}else{
				$label = $row_inc['for_value'];
			}
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_inc['inclusion'] ?></td>
				<td><?= $row_inc['type'] ?></td>
				<td><?= $row_inc['tour_type'] ?></td>
				<td><?= $label ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_inc['inclusion_id'] ?>)" title="Update Details" id="incl_update-<?= $row_inc['inclusion_id'] ?>"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php

		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>