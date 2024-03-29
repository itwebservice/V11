<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>
<?= begin_panel('Flight Ticket Booking Cancel & Refund',73) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">
    <label for="rd_ticket_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_ticket_cancel" name="rd_ticket"  onchange="booking_content_reflect()" checked>
        &nbsp;&nbsp;Cancel
    </label>    
    <label for="rd_ticket_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_ticket_refund" name="rd_ticket"  onchange="booking_content_reflect()">
        &nbsp;&nbsp;Refund
    </label>    
    <label for="rd_ticket_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_ticket_report" name="rd_ticket" onchange="booking_content_reflect()">
        &nbsp;&nbsp;Report
    </label>
</div>

<div id="div_booking_content_reflect"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function booking_content_reflect()
{
	var id = $('input[name="rd_ticket"]:checked').attr('id');
	if(id=="rd_ticket_cancel_and_refund"){
		$.post('cancel_and_refund/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_ticket_cancel"){
		$.post('cancel/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_ticket_refund"){
		$.post('refund/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_ticket_report"){
		$.post('report/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
}
booking_content_reflect();
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>