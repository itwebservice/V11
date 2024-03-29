<form id="frm_tab1">


<div class="panel panel-default panel-body app_panel_style feildset-panel mg_tp_20">
            <legend>Customer Details</legend>

	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

			<select name="customer_id" id="customer_id" class="customer_dropdown" title="Select Customer Name" style="width:100%" onchange="customer_info_load();get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','save','true','basic','basic');">

				<?php get_new_customer_dropdown($role,$branch_admin_id,$branch_status); ?>

			</select>

		</div>	
	    <div id="cust_details">	    
			<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

		      <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" title="Mobile No" readonly >

		    </div>

		    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

		      <input type="text" id="email_id" name="email_id" placeholder="Email ID" title="Email ID" readonly>

		    </div>

		    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">

	          <input type="text" id="company_name" class="hidden" name="company_name" title="Company Name" placeholder="Company Name" title="Company Name" readonly>

	        </div>  
            <div class="col-md-3 col-sm-4 col-xs-12">
              <input type="text" id="credit_amount" class="hidden" name="credit_amount" placeholder="Credit Note Balance" title="Credit Note Balance" readonly>
            </div> 
			</div>
		</div>
		<div class="row mg_tp_10">
			<div class="col-md-4">
				<input id="copy_details1" name="copy_details1" type="checkbox" onClick="copy_details();">
				&nbsp;&nbsp;<label for="copy_details1">Passenger Details same as above</label>
			</div>
		</div>
	</div>
		<div id="new_cust_div" class="mg_tp_10"></div>

	<hr>

	<h3 class="editor_title">Passenger Details</h3>
	<div class="panel panel-default panel-body app_panel_style">
		<div class="row mg_bt_10">

			<div class="col-xs-12 text-right text_center_xs">

				<button type="button" class="btn btn-excel" title="Add Row" onclick="addRow('tbl_dynamic_train_ticket_master')"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-pdf btn-sm" title="Delete Row" onclick="deleteRow('tbl_dynamic_train_ticket_master');"><i class="fa fa-trash"></i></button>

			</div>

		</div>    

		<div class="row">

			<div class="col-xs-12">

				<div class="table-responsive">

				<table id="tbl_dynamic_train_ticket_master" name="tbl_dynamic_train_ticket_master" class="table table-bordered no-marg" style="width: 100%;">

					<?php include_once('ticket_master_tbl.php'); ?>

				</table>

				</div>

			</div>

		</div> 
	</div> 
    <br><br> 



    <div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_right" data-toggle="tooltip" data-placement="bottom" title="Next">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

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

		var pass_count = 0;
        for(var i=0; i<rowCount; i++)
        {
			var row = table.rows[i];
			if(row.cells[0].childNodes[0].checked)
				pass_count++;
		}
		if(pass_count == 0){
			error_msg_alert("Atleast one passenger is required!");
			return false;
		}

        for(var i=0; i<rowCount; i++)

        {

			var row = table.rows[i];
			if(rowCount == 1){
				if(!row.cells[0].childNodes[0].checked){
					error_msg_alert("Atleast one passenger is required!");
					return false;
				}
			}
			

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