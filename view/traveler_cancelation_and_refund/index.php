<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Group Tour Booking Cancel & Refund',66) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">
    <label for="rd_cgroup_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_cgroup_cancel" name="rd_cgroup" checked onchange="booking_content_reflect()">
        &nbsp;&nbsp;Cancel
    </label>
    <label for="rd_cgroup_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_cgroup_refund" name="rd_cgroup"  onchange="booking_content_reflect()">
        &nbsp;&nbsp;Refund
    </label>
</div>

<div id="div_booking_content_reflect"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function booking_content_reflect()
{
	var id = $('input[name="rd_cgroup"]:checked').attr('id');
	if(id=="rd_cgroup_cancel"){
		$.post('traveler_booking_cancelation_select.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_cgroup_refund"){
		$.post('refund_canceled_traveler_select.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
}
booking_content_reflect();
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>