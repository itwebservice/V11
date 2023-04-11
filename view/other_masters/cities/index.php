<?php include "../../../model/model.php";?>
<div class="row text-right mg_tp_20"> <div class="col-md-12">
  <button class="btn btn-info btn-sm ico_left" onclick="generic_city_save_modal('master')" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;City</button>
</div> </div>
<hr/>

<div id="div_list_content" class="loader_parent">
    <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
        <table id="city_table" class="table table-hover" style="margin: 20px 0 !important;">   
        
        <thead>
            <tr>
                <th>Id</th>
                <th>City Name</th>
                <th>Status</th>
                <th>Actions</th>
                
            </tr>
        </thead>
    
        </table>
    </div></div></div>
</div>
<div id="div_city_list_update_modal"></div>
<input type="hidden" id='ajax_data' /> 
<script>
var columns = [
          { title: "City Id" },
          { title: "City Name" },
          { title: "Status" },
          { title: "Actions", className:"text-center" }
      ]
function list_reflect(){
  $("#city_table").dataTable().fnDestroy();
  $('#city_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'cities/list_reflect-server.php',
    });
  
}list_reflect();

function city_master_update_modal(city_id){
  
	$('#update_city-'+city_id).prop('disabled',true);
	$('#update_city-'+city_id).button('loading');
  $.post('cities/update_modal.php', {city_id : city_id}, function(data){
    $('#div_city_list_update_modal').html(data);
    $('#update_city-'+city_id).prop('disabled',false);
    $('#update_city-'+city_id).button('reset');
  });
}
</script>