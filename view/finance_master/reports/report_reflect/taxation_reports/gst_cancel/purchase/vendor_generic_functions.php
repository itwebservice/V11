<?php 
function get_vendor_name($vendor_type, $vendor_type_id)
{
	if($vendor_type=="Hotel Vendor"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$vendor_type_id'"));
		$vendor_type_val = $sq_hotel['hotel_name'];
	}	
	if($vendor_type=="Transport Vendor"){
		$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
		$vendor_type_val = $sq_transport['transport_agency_name'];
	}	
	if($vendor_type=="Car Rental Vendor"){
		$sq_cra_rental_vendor = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_cra_rental_vendor['vendor_name'];
	}
	if($vendor_type=="DMC Vendor"){
		$sq_dmc_vendor = mysqli_fetch_assoc(mysqlQuery("select * from dmc_master where dmc_id='$vendor_type_id'"));
		$vendor_type_val = $sq_dmc_vendor['company_name'];
	}
	if($vendor_type=="Visa Vendor"){
		$sq_visa_vendor = mysqli_fetch_assoc(mysqlQuery("select * from visa_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_visa_vendor['vendor_name'];
	}
	if($vendor_type=="Passport Vendor"){
		$sq_passport_vendor = mysqli_fetch_assoc(mysqlQuery("select * from passport_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_passport_vendor['vendor_name'];
	}
	if($vendor_type=="Ticket Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Train Ticket Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Excursion Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Insurance Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Other Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from other_vendors where vendor_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['vendor_name'];
	}
	if($vendor_type=="Cruise Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from cruise_master where cruise_id='$vendor_type_id'"));
		$vendor_type_val = $sq_vendor['company_name'];
	}

	return $vendor_type_val;
}

function get_service_info($estimate_type)
{
	if($estimate_type=="Group Tour"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Group Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}	
	if($estimate_type=="Excursion Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Excursion'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}	
	if($estimate_type=="Forex Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Forex'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Passport Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Passport'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Car Rental"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Car Rental'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Passport Vendor"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Group Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Bus Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Bus'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Hotel Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Hotel / Accommodation'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Visa Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Visa'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Package Tour"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Package Tour'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Train Ticket Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Train'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Ticket Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Flight'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Miscellaneous Booking"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Miscellaneous'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}
	if($estimate_type=="Other Expense"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Other Expense'"));
		$vendor_type_val = $sq_hotel['hsn_sac_code'];
	}

	return $vendor_type_val;
}

function get_vendor_info($vendor_type, $vendor_type_id)
{
	$vendor_type_arr = array();
	if($vendor_type=="Hotel Vendor"){
		$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_hotel['service_tax_no'];
		$vendor_type_arr[1] = $sq_hotel['state_id'];
	}	
	if($vendor_type=="Transport Vendor"){
		$sq_transport = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_transport['service_tax_no'];
		$vendor_type_arr[1] = $sq_transport['state_id'];
	}	
	if($vendor_type=="Car Rental Vendor"){
		$sq_cra_rental_vendor = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_cra_rental_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_cra_rental_vendor['state_id'];
	}
	if($vendor_type=="DMC Vendor"){
		$sq_dmc_vendor = mysqli_fetch_assoc(mysqlQuery("select * from dmc_master where dmc_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_dmc_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_dmc_vendor['state_id'];
	}
	if($vendor_type=="Visa Vendor"){
		$sq_visa_vendor = mysqli_fetch_assoc(mysqlQuery("select * from visa_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_visa_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_visa_vendor['state_id'];
	}
	if($vendor_type=="Passport Vendor"){
		$sq_passport_vendor = mysqli_fetch_assoc(mysqlQuery("select * from passport_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_passport_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_passport_vendor['state_id'];
	}
	if($vendor_type=="Ticket Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Train Ticket Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from train_ticket_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Excursion Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from site_seeing_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Insurance Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from insuarance_vendor where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Other Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from other_vendors where vendor_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state_id'];
	}
	if($vendor_type=="Cruise Vendor"){
		$sq_vendor = mysqli_fetch_assoc(mysqlQuery("select * from cruise_master where cruise_id='$vendor_type_id'"));
		$vendor_type_arr[0] = $sq_vendor['service_tax_no'];
		$vendor_type_arr[1] = $sq_vendor['state'];
	}

	return array('service_tax'=>$vendor_type_arr[0],'state_id'=>$vendor_type_arr[1]);
}
function get_estimate_type_name($estimate_type, $estimate_type_id){

	global $app_version;

	if($estimate_type=="Group Tour"){

		$sq_tour_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$estimate_type_id'"));
		$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));

		$sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where active_flag='Active' and tour_id='$sq_tour_group[tour_id]'"));
		$tour_name = $sq_tour['tour_name'];

		$estimate_type_val = $tour_name."( ".$tour_group." )";

	}
	if($estimate_type=="Package Tour"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$estimate_type_id' "));
		$date = $sq_booking['booking_date'];
        $yr = explode("-", $date);
        $year =$yr[0];		
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}		
		$estimate_type_val = get_package_booking_id($sq_booking['booking_id'], $year)." : ".$cust_name;
	}
	if($estimate_type=="Car Rental"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_booking where booking_id='$estimate_type_id' "));	
		$date = $sq_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];		
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}		
		$estimate_type_val = get_car_rental_booking_id($sq_booking['booking_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Visa Booking"){
		$sq_visa = mysqli_fetch_assoc(mysqlQuery("select * from visa_master where visa_id='$estimate_type_id' "));
		$date = $sq_visa['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];	
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
   		$estimate_type_val = get_visa_booking_id($sq_visa['visa_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Passport Booking"){
		$sq_passport = mysqli_fetch_assoc(mysqlQuery("select * from passport_master where passport_id='$estimate_type_id'"));
		$date = $sq_passport['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];	
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_passport[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
   		$estimate_type_val = get_passport_booking_id($sq_passport['passport_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Ticket Booking"){
		$sq_ticket = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$estimate_type_id' "));
		$date = $sq_ticket['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];	
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		$estimate_type_val = get_ticket_booking_id($sq_ticket['ticket_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Train Ticket Booking"){
		$sq_ticket = mysqli_fetch_assoc(mysqlQuery("select * from train_ticket_master where train_ticket_id='$estimate_type_id' "));
		$date = $sq_ticket['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];	
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		$estimate_type_val = get_train_ticket_booking_id($sq_ticket['train_ticket_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Hotel Booking"){
		$sq_hotel_booking = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$estimate_type_id' "));
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_hotel_booking[customer_id]'"));
		$date = $sq_hotel_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		$estimate_type_val = get_hotel_booking_id($sq_hotel_booking['booking_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Bus Booking"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from bus_booking_master where booking_id='$estimate_type_id' "));
        $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		$date = $sq_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
        $estimate_type_val = get_bus_booking_id($sq_booking['booking_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Forex Booking"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from forex_booking_master where booking_id='$estimate_type_id'"));
        $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		$date = $sq_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
        $estimate_type_val = get_forex_booking_id($sq_booking['booking_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Miscellaneous Booking"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master where misc_id='$estimate_type_id' "));
        $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		$date = $sq_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
        $estimate_type_val = get_misc_booking_id($sq_booking['misc_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="Excursion Booking"){
		$sq_exc = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master where exc_id='$estimate_type_id' "));
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_exc[customer_id]'"));
		$date = $sq_exc['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		$estimate_type_val = get_exc_booking_id($sq_exc['exc_id'], $year).' : '.$cust_name;
	}
	if($estimate_type=="B2B Booking"){
		$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$estimate_type_id'"));
		$date = $sq_booking['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
		if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
			$cust_name = $sq_customer['company_name'];
		}else{
			$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		$estimate_type_val = get_b2b_booking_id($sq_booking['booking_id'], $year).' : '.$cust_name;
	}

	return $estimate_type_val;

}

?>