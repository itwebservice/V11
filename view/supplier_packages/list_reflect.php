<?php
include "../../model/model.php";
$active_flag = $_POST['active_flag'];
$city_id = $_POST['city_id']; 
$supplier_id = $_POST['supplier_id'];
$today_date = date('Y-m-d');
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="table_package" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>City</th>
			<th>Supplier_Type</th>
			<th>Supplier_Name</th>
			<th>valid_from</th>
			<th>Valid_TO</th>
			<th>Contract</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$count = 0;
	$query = "select * from supplier_packages where 1 ";
	if($active_flag!=""){
		$query .=" and active_flag='$active_flag' ";
	}
	if($city_id!=""){
		$query .=" and city_id='$city_id' ";
	}
	if($supplier_id!=""){
		$query .=" and supplier_type='$supplier_id' ";
	}
	$sq_serv = mysqlQuery($query);
	while($row_ser = mysqli_fetch_assoc($sq_serv)){
		$bg='';
		if($today_date > $row_ser['valid_to']){
			$sq_update = mysqlQuery("update supplier_packages set active_flag='Inactive' where package_id='$row_ser[package_id]'");
		}else{
			$sq_update = mysqlQuery("update supplier_packages set active_flag='Active' where package_id='$row_ser[package_id]'");
		}
		$sq_updateq = mysqli_fetch_assoc(mysqlQuery("select active_flag from supplier_packages where package_id='$row_ser[package_id]'"));
		if($sq_updateq['active_flag']=='Inactive'){
			$bg ='danger';
		}
		$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_ser[city_id]'"));
		?>
		<tr class="<?= $bg ?>">
			<td><?= ++$count ?></td>
			<td><?= $sq_city['city_name'] ?></td>
			<td><?= $row_ser['supplier_type'] ?></td>
			<td><?= $row_ser['name'] ?></td>		
			<td><?php echo get_date_user($row_ser['valid_from']);?></td>
			<td><?php echo get_date_user($row_ser['valid_to']);?></td>
			<?php
			if($row_ser['image_upload_url']!=""){
				$values = explode(';',$row_ser['image_upload_url']);
				$combined = "";
				foreach($values as $ev){
					$combined .= $row_ser['file_prefix'].$ev.";";
				}
				$newUrl1 = preg_replace('/(\/+)/','/',$combined); 
			?>	
			<td>
				<a href="<?php echo $newUrl1; ?>" id="img-dwnld<?= $count ?>"  title="Download File" class="btn btn-info btn-sm shwimg"><i class="fa fa-download"></i></a> </td>
			<?php } 
			else{ ?>
			<td></td>
			<?php }
			?>
			<td>
				<button class="btn btn-info btn-sm" id="update_btn-<?= $row_ser['package_id'] ?>" onclick="update_modal(<?= $row_ser['package_id'] ?>)" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
			</td>
		</tr>
		<script>
			$('#img-dwnld<?= $count ?>').click(function(e) {
				e.preventDefault();
				$(this).attr('href').split(";").forEach(element => { if(element != "")window.open(element); });
			});
		</script>
		<?php
		}
		?>
	</tbody>
</table>
</div></div></div>

<script type="text/javascript">
	$('#table_package').dataTable({
		"pagingType": "full_numbers"
	});
	
</script>