<?php
//paid
$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(credit_charges) as sumc from payment_master where tourwise_traveler_id='$sq_group_info[id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum']+$query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

$sale_total_amount=$sq_group_info['net_total']+$query['sumc'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

if($sq_group_info['tour_group_status'] == 'Cancel'){
	//Group Tour cancel
	$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
	if($cancel_tour_count2 >= '1'){
		$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
		$cancel_amount2 = $cancel_tour['cancel_amount'];
	}
	else{ $cancel_amount2 = 0; }

	if($cancel_esti_count1 >= '1'){
		$cancel_amount = $cancel_amount1;
	}else{
		$cancel_amount = $cancel_amount2;
	}	
}
else{
	// Group booking cancel
	$cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
	if($cancel_esti_count1 >= '1'){
		$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
		$cancel_amount = $cancel_esti1['cancel_amount'];
	}
	else{ $cancel_amount = 0; }

}

$cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
if($sq_group_info['tour_group_status'] == 'Cancel'){
	if($cancel_amount > $paid_amount){
		$balance_amount = $cancel_amount - $paid_amount+$query['sumc'];
	}
	else{
		$balance_amount = 0;
	}
}else{
	if($cancel_esti_count1 >= '1'){
		if($cancel_amount > $paid_amount){
			$balance_amount = $cancel_amount - $paid_amount+$query['sumc'];
		}
		else{
			$balance_amount = 0;
		}
	}
	else{
		$balance_amount = $sale_total_amount - $paid_amount;
	}
}
$sale_total_amount1 = currency_conversion($currency,$sq_group_info['currency_code'],$sale_total_amount);
$paid_amount1 = currency_conversion($currency,$sq_group_info['currency_code'],$paid_amount);
$cancel_amount1 = currency_conversion($currency,$sq_group_info['currency_code'],$cancel_amount);
$balance_amount1 = currency_conversion($currency,$sq_group_info['currency_code'],$balance_amount);

$sale_total_amount1 = explode(' ',$sale_total_amount1);
$sale_total_amount = str_replace(',', '', $sale_total_amount1[1]);
$paid_amount1_string = explode(' ',$paid_amount1);
$paid_amount = str_replace(',', '', $paid_amount1_string[1]);
$cancel_amount1_string = explode(' ',$cancel_amount1);
$cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
$balance_amount1_string = explode(' ',$balance_amount1);
$balance_amount = str_replace(',', '', $balance_amount1_string[1]);
include "../../../../../../../model/app_settings/generic_sale_widget.php";
?>


<div class="row">

	<div class="col-md-12">

	    <div class="profile_box main_block" style="margin-top: 25px">

		    <h3 class="editor_title">Summary</h3>

		    <div class="table-responsive">

		        <table class="table table-bordered no-marg">

		            <thead>

		                <tr class="table-heading-row">

							<th>S_No.</th>

	         				<th>Date</th>

					        <th>Mode</th>

					        <th>Bank_Name</th>

					        <th>Cheque_No/ID</th>

					        <th class="text-right">Amount</th>

					    </tr>

					</thead>

					<tbody>

					<?php
					$count = 0;
					$query2 = "SELECT * from payment_master where tourwise_traveler_id='$id'";		
					$sq_group_payment = mysqlQuery($query2);	
					$bg = "";

					while($row_group_payment = mysqli_fetch_assoc($sq_group_payment)){

						if($row_group_payment['amount'] != '0'){

							$count++;
							$bg = '';
							if($row_group_payment['clearance_status']=="Pending"){ $bg="warning";}
						    else if($row_group_payment['clearance_status']=="Cancelled"){ $bg="danger";} 
						    else if($row_group_payment['clearance_status']=="Cleared"){ $bg="success";} 

							$paid_amount1 = currency_conversion($currency,$sq_group_info['currency_code'],$row_group_payment['amount'] + $row_group_payment['credit_charges']);
							?>

							<tr class="<?php echo $bg; ?>">
						        <td><?php echo $count; ?></td>
						        <td><?php echo get_date_user($row_group_payment['date']); ?></td>
						        <td><?php echo $row_group_payment['payment_mode']; ?></td>
						        <td><?php echo $row_group_payment['bank_name']; ?></td>
						        <td><?php echo $row_group_payment['transaction_id']; ?></td>
						        <td class="text-right"><?php echo $paid_amount1; ?></td>
						    </tr>
					    <?php
						} 
					}
					?>

					</tbody>

				</table>

			</div>

		</div>

	</div>

</div>

