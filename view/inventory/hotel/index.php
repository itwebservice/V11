<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >
<div class="row text-right">
	<div class="col-md-12 mg_bt_20">
		<button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>Inventory</button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
        <div class="col-md-3 col-sm-6">
            <select id="city_id_filter1" name="city_id_filter1" style="width:100%" title="Select City Name" onchange="list_reflect();">
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select id="status" name="status" class="form-control" style="width:100%" title="Select Status" onchange="list_reflect();">
				<option value="">Status</option>
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div id="div_list" class="main_block"></div>
<div id="div_modal"></div>
<div id="div_update_modal"></div>

<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

<script>
city_lzloading('#city_id_filter1');
function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('hotel/save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect(){
	var city_id = $('#city_id_filter1').val();
    var branch_status = $('#branch_status').val();
	var status = $('#status').val();
    var branch_admin_id = $('#branch_admin_id').val();
	$.post('hotel/change_active_status.php', {}, function(data){		
	});
	$.post('hotel/list_reflect.php', {city_id : city_id,branch_status:branch_status,branch_admin_id:branch_admin_id,active_flag:status}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
function history_modal(purchase_id){

	$('#hhistory'+purchase_id).prop('disabled', true);
	$('#hhistory'+purchase_id).button('loading');
	$.post('hotel/history_modal.php', {purchase_id : purchase_id}, function(data){
		
		$('#div_modal').html(data);
		$('#hhistory'+purchase_id).button('reset');
		$('#hhistory'+purchase_id).prop('disabled', false);
	});
}
function update_modal(entry_id){

	$('#update_modal_inv_update_hotel-'+entry_id).prop('disabled',true);
	$('#update_modal_inv_update_hotel-'+entry_id).button('loading');
	$.post('hotel/update_modal.php', {entry_id:entry_id}, function(data){
		$('#div_update_modal').html(data);
		$('#update_modal_inv_update_hotel-'+entry_id).prop('disabled',false);
		$('#update_modal_inv_update_hotel-'+entry_id).button('reset');
	});
}
function excel_report(entry_id){
	window.location = 'hotel/excel_report.php?entry_id='+entry_id;
}
</script>