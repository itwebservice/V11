<form id="frm_tab1">

	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Customer Name" style="width:100%" onchange="customer_info_load()" disabled>
				<?php 
				$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
				if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
                ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                <?php }  else{ ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
                <?php } ?>
				<?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
			</select>			
		</div>
		<script>
			customer_info_load();
		</script>	
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	      <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly>
	    </div>
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
	      <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>
	    </div>	  
	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
        <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>
        </div>    
	</div>
	<hr>
	<h3 class="editor_title">Passenger Details</h3>
	<div class="panel panel-default panel-body app_panel_style">
		<div class="row mg_bt_10">
			<div class="col-xs-12 text-right text_center_xs">
				<button type="button" class="btn btn-excel" title="Add Row" onclick="addRow('tbl_dynamic_train_ticket_master')"><i class="fa fa-plus"></i></button>
			</div>
		</div>    
		
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table id="tbl_dynamic_train_ticket_master" name="tbl_dynamic_train_ticket_master" class="table table-bordered no-marg">
					<?php include_once('ticket_master_tbl.php'); ?>
				</table>
				</div>
			</div>
		</div> 
	</div> 
    <br><br> 

    <div class="row text-center">
		<div class="col-xs-12">
			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div> 


</form>

<script>
$('#customer_id').select2();
$('#frm_tab1').validate({
	rules:{
			customer_id : { required : true },
			tour_type : { required : true },
	},
	submitHandler:function(form){

        var msg = "";
        var table = document.getElementById("tbl_dynamic_train_ticket_master");
        var rowCount = table.rows.length;
		var checked_count = 0;
		for (var i = 0; i < rowCount; i++) {
			var row = table.rows[i];
			if (row.cells[0].childNodes[0].checked) {
				checked_count++;
			}
		}
		if (checked_count == 0) {
			error_msg_alert("Atleast one passenger details is required!");
			return false;
		}
        
        for(var i=0; i<rowCount; i++)
        {
          var row = table.rows[i];
           
          if(row.cells[0].childNodes[0].checked)
          {

			  var first_name = row.cells[3].childNodes[0].value;
			  var middle_name = row.cells[4].childNodes[0].value;
			  var last_name = row.cells[5].childNodes[0].value;
			  var birth_date = row.cells[6].childNodes[0].value;
			  var adolescence = row.cells[7].childNodes[0].value;
			  var coach_number = row.cells[8].childNodes[0].value;
			  var seat_number = row.cells[9].childNodes[0].value;
			  var ticket_number = row.cells[10].childNodes[0].value;
			  
			  
			  if(first_name==""){ msg +="First name is required in row:"+(i+1)+"<br>"; }
			  if(birth_date==""){ msg +="Birth date is required in row:"+(i+1)+"<br>"; }
			  if(adolescence==""){ msg +="Adolescence is required in row:"+(i+1)+"<br>"; }
			
			  
          }      
        }

        if(msg!=""){
        	error_msg_alert(msg);
        	return false;
        }

		$('a[href="#tab2"]').tab('show');

	}
});
</script>