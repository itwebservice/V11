<?php

include_once('../model.php');
global $model,$secret_key,$encrypt_decrypt;
 
	$today=date('Y-m-d');
	
	$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'emp_birthday' and date='$today' and status='Done'"));
	
	if($sq_count==0)
	{
		$sq_emplyee = mysqlQuery("SELECT * from emp_master active_flag='Active' and where (MONTH(dob), DAY(dob)) = (MONTH(CURDATE()),DAY(CURDATE()))");
		while($row_emp=mysqli_fetch_assoc($sq_emplyee))
		{
			$name = $row_emp['first_name']." ".$row_emp['last_name'];
			$email = $row_emp['email_id'];
			$contact_no = $row_emp['mobile_no'];

				email($name,$email);
				baddy_sms($name,$contact_no);
		}
		$row=mysqlQuery("SELECT max(id) as max from remainder_status");
	 	$value=mysqli_fetch_assoc($row);
	 	$max=$value['max']+1;
		$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','emp_birthday','$today','Done')");
	}


	$sq_count1 = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'cust_birthday' and date='$today' and status='Done'"));
	if($sq_count1==0)
	{
		$sq_customer = mysqlQuery("SELECT * from customer_master active_flag='Active' andwhere (MONTH(birth_date), DAY(birth_date)) = (MONTH(CURDATE()),DAY(CURDATE()))");
		while($row_cust=mysqli_fetch_assoc($sq_customer)){
			$name = $row_cust['first_name']." ".$row_cust['last_name'];
			
			$email = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key); 
			$contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key); 
			
			email($name,$email);
			baddy_sms($name,$contact_no);
		}
	  $row=mysqlQuery("SELECT max(id) as max from remainder_status");
	  $value=mysqli_fetch_assoc($row);
	  $max=$value['max']+1;
	  $sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','cust_birthday','$today','Done')");
	}

	function email($name,$email)
	{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	$content='';  
    global $model;
    $subject = 'Wish You Happy Birthday :  From - '.$app_name.' .';
	$model->app_email_send('72',$name,$email, $content,$subject,'1');
 
	}

	  function baddy_sms($name,$mobile_no)
	{
	   global $app_name;
	   $message = "Dear ".$name.", Wishing you a happy birthday, a wonderful year, and success in all you do.Regard ".$app_name." ";
	   global $model;
	   $model->send_message($mobile_no, $message);
	}


?>
