<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');

include_once('fouth_coming_attractions_save_modal.php');
?>

<div class="app_panel">
<?= begin_panel('Sightseeing Attractions',101) ?>

<div class="row">
	<div class="col-md-12 text-right">
    <button type="button" data-toggle="tooltip" class="btn btn-excel" title="Note : Email is autosend by the system."><i class="fa fa-question-circle"></i></button>
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#fouth_coming_attractions_save_modal"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Attraction</button>
	</div>
</div>





<div id="fourth_coming_attraction_content"></div>

<div id="div_view_modal"></div>

</div>

<!--Update Modal Div-->
<div id="div_fourth_coming_attractions_update_modal"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script type="text/javascript">
  
function attractions_view_modal()
{
  $.post('view_attractions_modal.php', {}, function(data){
      $('#div_fourth_coming_attractions_update_modal').html(data);
  });
}
function view_modal(att_id)
{
    $('#view_btn-'+att_id).button('loading');
    $('#view_btn-'+att_id).prop('disabled',true);
    $.post('view/index.php', { att_id: att_id }, function(data){
      $('#div_view_modal').html(data);
      $('#view_btn-'+att_id).button('reset');
      $('#view_btn-'+att_id).prop('disabled',false);
    });
}
</script>
<script src="../js/fourth_coming_attraction.js"></script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>