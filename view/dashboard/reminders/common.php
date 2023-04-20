<?php
include '../../../model/model.php';
global $encrypt_decrypt,$secret_key;
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$from_date = get_date_db($_POST['from_date']);
$count = 0;
$total_balance_amount = 0;
$today_date = $from_date;
?>
<div class="col-md-12">
    <div class="col-md-12 no-pad table_verflow"> 
        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
            <table class="table table-hover" style="width: 100% !important;" id="creminder_report">    
                <thead>
                    <tr class="table-heading-row">
                        <th>S_No.</th>
                        <th>Reminder</th>
                        <th>Reminder_To</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="display:flex">Actions&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Customer passport renewal -->
                        <?php
	                    $exp_date = date('Y-m-d', strtotime('+7 days', strtotime($today_date)));
                        $sq_pass = mysqlQuery("SELECT * from package_travelers_details where passport_expiry_date='$exp_date' and status!='Cancel'");
                        while($row_pass=mysqli_fetch_assoc($sq_pass))
                        {
                            $sq_booking = mysqli_fetch_assoc(mysqlQuery("SELECT customer_id,booking_date,booking_id from package_tour_booking_master where booking_id='$row_pass[booking_id]'"));
                            $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$sq_booking[customer_id]'"));
                            $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                            $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); 
                            $pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];
                            $date = $sq_booking['booking_date'];
                            $yr = explode("-", $date);
                            $year = $yr[0];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer passport renewal</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name.'('.$pass_name.')' ?></td>
                                    <td><?= 'Package Booking ID : '.get_package_booking_id($sq_booking['booking_id'],$year).' Expiry Date : '.get_date_user($exp_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="passport_renewal_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= $pass_name ?>','<?= get_date_user($exp_date) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            $sq_pass = mysqlQuery("SELECT * from travelers_details where passport_expiry_date='$exp_date' and status!='Cancel'");
                            while($row_pass=mysqli_fetch_assoc($sq_pass))
                            {
                                $sq_booking = mysqli_fetch_assoc(mysqlQuery("SELECT id,customer_id,form_date from tourwise_traveler_details where traveler_group_id='$row_pass[traveler_group_id]'"));
                                $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$sq_booking[customer_id]'"));
                                $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); 
                                $pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];
                                $date = $sq_booking['form_date'];
                                $yr = explode("-", $date);
                                $year = $yr[0];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer passport renewal</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name.'('.$pass_name.')' ?></td>
                                    <td><?= 'Group Booking ID : '.get_group_booking_id($sq_booking['id'],$year).' Expiry Date : '.get_date_user($exp_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="passport_renewal_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= $pass_name ?>','<?= get_date_user($exp_date) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            $sq_pass = mysqlQuery("SELECT * from ticket_master_entries where passport_expiry_date='$exp_date' and status!='Cancel'");
                            while($row_pass=mysqli_fetch_assoc($sq_pass))
                            {
                                $sq_booking = mysqli_fetch_assoc(mysqlQuery("SELECT created_at,ticket_id,customer_id from ticket_master where ticket_id='$row_pass[ticket_id]'"));
                                $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$sq_booking[customer_id]'"));
                                $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); 
                                $pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];
                                $date = $sq_booking['created_at'];
                                $yr = explode("-", $date);
                                $year = $yr[0];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer passport renewal</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name.'('.$pass_name.')' ?></td>
                                    <td><?= 'Flight Booking ID : '.get_ticket_booking_id($sq_booking['ticket_id'],$year).' Expiry Date : '.get_date_user($exp_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="passport_renewal_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= $pass_name ?>','<?= get_date_user($exp_date) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            $sq_pass = mysqlQuery("SELECT * from visa_master_entries where expiry_date='$exp_date' and status!='Cancel'");
                            while($row_pass=mysqli_fetch_assoc($sq_pass))
                            {
                                $sq_booking = mysqli_fetch_assoc(mysqlQuery("SELECT created_at,visa_id,customer_id from visa_master where visa_id='$row_pass[visa_id]'"));
                                $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$sq_booking[customer_id]'"));
                                $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); 
                                $pass_name = $row_pass['first_name'].' '.$row_pass['last_name'];
                                $date = $sq_booking['created_at'];
                                $yr = explode("-", $date);
                                $year = $yr[0];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer passport renewal</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name.'('.$pass_name.')' ?></td>
                                    <td><?= 'Visa Booking ID : '.get_visa_booking_id($sq_booking['visa_id'],$year).' Expiry Date : '.get_date_user($exp_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="passport_renewal_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= $pass_name ?>','<?= get_date_user($exp_date) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // Customer Birthday
                            $sq_customer = mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no,birth_date from customer_master where DATE_FORMAT(birth_date, '%m-%d') = DATE_FORMAT('$today_date', '%m-%d')");
                            while($row_cust=mysqli_fetch_assoc($sq_customer)){
                                $cust_name = ($row_cust['type'] == 'Corporate' || $row_cust['type'] == 'B2B') ? $row_cust['company_name'] : $row_cust['first_name'].' '.$row_cust['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key); 
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer Birthday</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Birth Date : '.get_date_user($row_cust['birth_date']) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="customer_birthday_reminder('<?= $contact_no ?>','<?= $cust_name ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // Happy Journey
                            $end_date = date('Y-m-d', strtotime('+1 days', strtotime($today_date)));
                            $sq_tour_groups = mysqlQuery("SELECT * from tour_groups where from_date='$end_date' and status!='Cancel'");
                            while($tour_detail=mysqli_fetch_assoc($sq_tour_groups))
                            {
                                $sq_tour = mysqli_fetch_assoc(mysqlQuery("SELECT tour_name from tour_master where tour_id='$tour_detail[tour_id]'"));
                                $tour_name = $sq_tour['tour_name'].'('.date('d-m-Y', strtotime($tour_detail['from_date'])).' to '.date('d-m-Y', strtotime($tour_detail['to_date'])).')';
                                $sq_cus = mysqlQuery("select * from tourwise_traveler_details where tour_group_id='$tour_detail[group_id]' and tour_group_status != 'Cancel' and delete_status='0'");
                                while($row_cus = mysqli_fetch_assoc($sq_cus)){
                                    
                                    $date = $row_cus['form_date'];
                                    $yr = explode("-", $date);
                                    $year = $yr[0];
                                    $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$sq_booking[customer_id]'"));
                                    $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                                    $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
                                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Happy Journey</td>
                                        <td><?= 'Customer' ?></td>
                                        <td><?= $cust_name ?></td>
                                        <td><?= 'Group Booking ID : '.get_group_booking_id($row_cus['id'],$year).' ('.$tour_name.')' ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="happy_journey_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= get_group_booking_id($row_cus['id'],$year).' ('.$tour_name.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                    <?php
                                }
                            }
                            $sq_tour_groups = mysqlQuery("SELECT * from package_tour_booking_master where tour_from_date='$end_date' ");
                            while($tour_detail=mysqli_fetch_assoc($sq_tour_groups))
                            {
                                $tour_name = $tour_detail['tour_name'].'('.date('d-m-Y', strtotime($tour_detail['tour_from_date'])).' to '.date('d-m-Y', strtotime($tour_detail['tour_to_date'])).')';
                                $date = $tour_detail['booking_date'];
                                $yr = explode("-", $date);
                                $year = $yr[0];
                                $sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$tour_detail[customer_id]'"));
                                $cust_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Happy Journey</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Package Booking ID : '.get_package_booking_id($tour_detail['booking_id'],$year).' ('.$tour_name.')' ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="happy_journey_reminder('<?= $contact_no ?>','<?= $cust_name ?>','<?= get_package_booking_id($tour_detail['booking_id'],$year).' ('.$tour_name.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // Customer feedback mail
                            $feedback_end_date = date('Y-m-d', strtotime('-5 days', strtotime($today_date)));
                            $sq_tour_group1 = mysqlQuery("select from_date,to_date,tour_id,group_id from tour_groups where to_date='$feedback_end_date'");
                            while($row_tour = mysqli_fetch_assoc($sq_tour_group1)){
                        
                                $tour_to_date = $row_tour['to_date'];
                                $tour_id = $row_tour['tour_id'];
                                $tour_group_id = $row_tour['group_id'];
                                $row_tour1 =  mysqli_fetch_assoc(mysqlQuery("select tour_name from tour_master where tour_id='$tour_id'"));
                                $tour_name = $row_tour1['tour_name'];
                                $journey_date = date('d-m-Y',strtotime($row_tour['from_date'])).' To '.date('d-m-Y',strtotime($row_tour['to_date']));
                    
                                $sq_bookings = mysqlQuery("select id,customer_id,form_date from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id' and delete_status='0'");
                                while($row_bookings = mysqli_fetch_assoc($sq_bookings)){
                    
                                    $tourwise_traveler_id = $row_bookings['id'];
                                    $customer_id = $row_bookings['customer_id'];
                    
                                    $date = $row_bookings['form_date'];
                                    $yr = explode("-", $date);
                                    $year = $yr[0];
                                    $tourwise_traveler_id1 = get_group_booking_id($tourwise_traveler_id,$year);
                                    
                                    $row_cust = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$customer_id'"));
                                    $contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
                                    $cust_name = ($row_cust['type'] == 'Corporate' || $row_cust['type'] == 'B2B') ? $row_cust['company_name'] : $row_cust['first_name'].' '.$row_cust['last_name'];
                                        ?>
                                        <tr class="<?= $bg ?>">
                                            <td><?= ++$count ?></td>
                                            <td>GIT Customer Feedback</td>
                                            <td><?= 'Customer' ?></td>
                                            <td><?= $cust_name ?></td>
                                            <td><?= 'Group Booking ID : '.get_group_booking_id($row_bookings['id'],$year).' ('.$tour_name.' From '.$journey_date.')' ?></td>
                                            <td><button class="btn btn-info btn-sm" onclick="customer_feedback_reminder('group','<?= $tourwise_traveler_id ?>','<?= $customer_id ?>','<?= $contact_no ?>','<?= $cust_name ?>','<?= get_group_booking_id($row_bookings['id'],$year).' ('.$tour_name.' From '.$journey_date.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                    <?php
                                }
                            }
                            $feedback_end_date = date('Y-m-d', strtotime('-3 days', strtotime($today_date)));
                            $sq_booking = mysqlQuery("select * from package_tour_booking_master where tour_to_date='$feedback_end_date' and delete_status='0' and booking_id not in (select booking_id from customer_feedback_master where booking_type='Package Booking')");                    
                            while($row_booking= mysqli_fetch_assoc($sq_booking)){
                                $customer_id = $row_booking['customer_id'];
                                $email_id = $row_booking['email_id'];
                                $mobile_no = $row_booking['mobile_no'];
                                $tour_name = $row_booking['tour_name'];
                                $booking_id = $row_booking['booking_id'];
                        
                                $date = $row_booking['booking_date'];
                                $yr = explode("-", $date);
                                $year = $yr[0];        
                                $booking_id1 = get_package_booking_id($booking_id,$year);
                        
                                $journey_date = date('d-m-Y',strtotime($row_booking['tour_from_date'])).' To '.date('d-m-Y',strtotime($row_booking['tour_to_date']));
                        
                                $row_cust = mysqli_fetch_assoc(mysqlQuery("SELECT type,first_name,last_name,company_name,contact_no from customer_master where customer_id='$customer_id'"));
                                $contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
                                $cust_name = ($row_cust['type'] == 'Corporate' || $row_cust['type'] == 'B2B') ? $row_cust['company_name'] : $row_cust['first_name'].' '.$row_cust['last_name'];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>FIT Customer Feedback</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Package Booking ID : '.get_package_booking_id($booking_id,$year).' ('.$tour_name.' From '.$journey_date.')' ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="customer_feedback_reminder('package','<?= $booking_id ?>','<?= $customer_id ?>','<?= $contact_no ?>','<?= $cust_name ?>','<?= get_package_booking_id($booking_id,$year).' ('.$tour_name.' From '.$journey_date.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                            <?php
                            }
                            // Task reminder to user
                            $cur_time = date('Y-m-d H:i');
                            $last_time = strtotime($cur_time);
                            $sq_branch = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='tasks/index.php'"));
                            $branch_status = $sq_branch['branch_status'];
                            $query = "select * from tasks_master where DATE(remind_due_date) = '$today_date' and task_status not in ('Disabled','Completed','Cancelled')";
                            include "../../../model/app_settings/branchwise_filteration.php";
                            $sq_task = mysqlQuery($query);
                            while($row_tasks = mysqli_fetch_assoc($sq_task)){
                            
                                $task_name = $row_tasks['task_name'];
                                $due_date = date('d-m-Y H:i', strtotime($row_tasks['due_date']));
                                $remind_by = $row_tasks['remind_by'];
                                $task_type = $row_tasks['task_type'];
                            
                                $sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_tasks[emp_id]'"));
                                $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
                                $email_id = $sq_emp_info['email_id'];
                                $mobile_no = $sq_emp_info['mobile_no'];
                                
                                if($row_tasks['remind'] != 'None'){
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Task Reminder</td>
                                    <td><?= 'User' ?></td>
                                    <td><?= $emp_name ?></td>
                                    <td><?= $task_name.' ('.$task_type.' task), Due Date/Time :'.$due_date ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="task_reminder('<?= $mobile_no ?>','<?= $emp_name ?>','<?= $task_name.' ('.$task_type.' task), Due Date/Time :'.$due_date ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                                }
                            }
                            // User Birthday
                            $sq_customer = mysqlQuery("SELECT * from emp_master where DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT('$today_date', '%m-%d')");
                            while($row_cust=mysqli_fetch_assoc($sq_customer)){
                                $cust_name = $row_cust['first_name'].' '.$row_cust['last_name'];
                                $contact_no = $row_cust['mobile_no']; 
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer Birthday</td>
                                    <td><?= 'User' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Birth Date : '.get_date_user($row_cust['dob']) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="customer_birthday_reminder('<?= $contact_no ?>','<?= $cust_name ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // User Anniversary
                            $sq_customer = mysqlQuery("SELECT * from emp_master where DATE_FORMAT(date_of_join, '%m-%d') = DATE_FORMAT('$today_date', '%m-%d')");
                            while($row_cust=mysqli_fetch_assoc($sq_customer)){
                                $cust_name = $row_cust['first_name'].' '.$row_cust['last_name'];
                                $contact_no = $row_cust['mobile_no']; 
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>User Anniversary</td>
                                    <td><?= 'User' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Joining Date : '.get_date_user($row_cust['date_of_join']) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="user_anniversary_reminder('<?= $contact_no ?>','<?= $cust_name ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // User Followups
                            $sq_emp = mysqlQuery("select * from emp_master where active_flag='Active'");
                            while($row_emp = mysqli_fetch_assoc($sq_emp)){

                                $enquirty_count = mysqli_num_rows(mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$row_emp[emp_id]'"));
                                if($enquirty_count > 0){
                                    $sq_enquiry = mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$row_emp[emp_id]'");
                                    while($row_enq = mysqli_fetch_assoc($sq_enquiry)){

                                        $sq_enquiry_entry = mysqli_num_rows(mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$row_emp[emp_id]' and enquiry_id in(select enquiry_id from enquiry_master_entries where followup_status in ('Active','In-Followup') and DATE(followup_date) = '$today_date')"));
                                        if($sq_enquiry_entry > 0){
                                            $followup_count++;
                                        }
                                    }
                                }
                            }
                            if($followup_count>0){

                                $sq_emp = mysqlQuery("select * from emp_master where active_flag='Active'");
                                while($row_emp = mysqli_fetch_assoc($sq_emp)){

                                    $enquiries = '';
                                    $emp_name = $row_emp['first_name'].' '.$row_emp['last_name'];
                                    $contact_no = $row_emp['mobile_no']; 
                                    $sq_enquiry_count = mysqli_num_rows(mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$row_emp[emp_id]' and enquiry_id in(select enquiry_id from enquiry_master_entries where followup_status in ('Active','In-Followup') and DATE(followup_date) = '$today_date')"));
                                    if($sq_enquiry_count > 0){
                                        $sq_enquiry = mysqlQuery("select * from enquiry_master where status!='Disabled' and assigned_emp_id='$row_emp[emp_id]'");
                                        while($row_enq = mysqli_fetch_assoc($sq_enquiry)){

                                            $sq_enquiry_entry = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master_entries where entry_id=(select max(entry_id) as entry_id from enquiry_master_entries where enquiry_id='$row_enq[enquiry_id]')"));
                                            $enquiry_content = $row_enq['enquiry_content'];
                                            $enquiry_id = $row_enq['enquiry_id'];
                                            $date = $row_enq['enquiry_date'];
                                            $yr = explode("-", $date);
                                            $year = $yr[0];

                                            $enquiry_content_arr1 = json_decode($enquiry_content, true);
                                            if($row_enq['enquiry_type'] =="Group Booking" || $row_enq['enquiry_type'] =="Package Booking"){
                                                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                                                    if($enquiry_content_arr2['name']=="tour_name"){
                                                        $tour_name = $enquiry_content_arr2['value'];
                                                    }
                                                }
                                            }else{
                                                $tour_name = 'NA';
                                            }
                                            if(($sq_enquiry_entry['followup_status']=="Active" || $sq_enquiry_entry['followup_status']=="In-Followup") && date('Y-m-d', strtotime($sq_enquiry_entry['followup_date'])) == $today_date){
                                                $enquiries .= get_enquiry_id($enquiry_id,$year).' ,';
                                            }
                                        }
                                        ?>
                                        <tr class="<?= $bg ?>">
                                            <td><?= ++$count ?></td>
                                            <td>Enquiry Followup</td>
                                            <td><?= 'User' ?></td>
                                            <td><?= $emp_name ?></td>
                                            <td><?= substr($enquiries, 0, -1); ?></td>
                                            <td><button class="btn btn-info btn-sm" onclick="user_followup_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= substr($enquiries, 0, -1) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            // daily summary report to admin
                            $sq_emp = mysqlQuery("select * from emp_master where emp_id='1'");
                            while($row_emp = mysqli_fetch_assoc($sq_emp)){

                                $emp_name = $row_emp['first_name'].' '.$row_emp['last_name'];
                                $contact_no = $row_emp['mobile_no']; 
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Daily Summary Report</td>
                                    <td><?= 'Admin' ?></td>
                                    <td><?= $emp_name ?></td>
                                    <td><?= 'Daily Summary Report Date : '.get_date_user($today_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="daily_summary_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= get_date_user($today_date) ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                            <?php } 
                            // Tax pay to admin
                            $row_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='1'"));
                            $emp_name = $row_emp['first_name'].' '.$row_emp['last_name'];
                            $contact_no = $row_emp['mobile_no']; 
                            $sq_settings = mysqli_fetch_assoc(mysqlQuery("select tax_type,tax_pay_date from app_settings where setting_id='1'"));
                            $tax_type= $sq_settings['tax_type'];
                            $tax_pay_date = $sq_settings['tax_pay_date'];
                            $tax_pay_day = date_parse_from_format('Y-m-d', $tax_pay_date)['day'];
                            $tax_date = date('Y-m-d', strtotime('+7 days', strtotime($today_date)));

                            $tax_day = date_parse_from_format('Y-m-d', $tax_date)['day'];
                            $quart_date = date('Y-m-d', strtotime("+3 months", strtotime($tax_pay_date)));
                            $quart_date1 = date('Y-m-d',strtotime("+6 months", strtotime($tax_pay_date)));
                            $quart_date2 =  date('Y-m-d',strtotime("+9 months", strtotime($tax_pay_date)));
                            $year_date  = date("d-m", strtotime($tax_pay_date));
                            $tax_year_date  = date("d-m", strtotime($tax_date));
                            if($tax_type=='Monthly' && $tax_pay_day==$tax_day){
                                $sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today_date' and status='Done'"));
                                if($sq_count==0){ ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Tax Pay</td>
                                        <td><?= 'Admin' ?></td>
                                        <td><?= $emp_name ?></td>
                                        <td><?= 'Tax Pay Date : '.date('d-m-Y', strtotime($tax_pay_date)).' ('.$tax_type.')' ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="tax_pay_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= date('d-m-Y', strtotime($tax_pay_date)).' ('.$tax_type.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                    <?php
                                }
                            }
                                
                            if($tax_type=='Quarterly' && ($tax_date==$tax_pay_date ||  $tax_date==$quart_date || $tax_date==$quart_date1 || $tax_date==$quart_date2)){
                                
                                $sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today_date' and status='Done'"));
                                if($sq_count==0){ ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Tax Pay</td>
                                        <td><?= 'Admin' ?></td>
                                        <td><?= $emp_name ?></td>
                                        <td><?= 'Tax Pay Date : '.date('d-m', strtotime($tax_date)).' ('.$tax_type.')' ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="tax_pay_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= date('d-m-Y', strtotime($tax_date)).' ('.$tax_type.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                    <?php
                                }
                            }

                            if($tax_type=='Yearly' && $year_date==$tax_year_date){
                                
                                $sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'tax_pay_raminder' and date='$today_date' and status='Done'"));
                                if($sq_count==0){
                                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Tax Pay</td>
                                        <td><?= 'Admin' ?></td>
                                        <td><?= $emp_name ?></td>
                                        <td><?= 'Tax Pay Date : '.date('d-m', strtotime($tax_date)).' ('.$tax_type.')' ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="tax_pay_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= date('d-m', strtotime($tax_date)).' ('.$tax_type.')' ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                    <?php
                                }	
                            }
                            // tour checklist to admin
                            $tour_name = '';
                            $tommorow = date('Y-m-d', strtotime('+1 day', strtotime($today_date)));
                            $sq_tour_groups = mysqlQuery("select * from tour_groups where from_date='$tommorow' and status='Active'");
                            while($row_tour_groups = mysqli_fetch_assoc($sq_tour_groups)){

                                $sq_tour = mysqli_fetch_assoc(mysqlQuery("select tour_name from tour_master where tour_id='$row_tour_groups[tour_id]'"));
                                $tour_name .= $sq_tour['tour_name'].'('.date('d-m-Y', strtotime($row_tour_groups['from_date'])).' to '.date('d-m-Y', strtotime($row_tour_groups['to_date'])).')';
                                $entity_list = "";
                    
                                $sq_tour = mysqlQuery("select * from tourwise_traveler_details where tour_id='$row_tour_groups[tour_id]' and tour_group_id='$row_tour_groups[group_id]' and tour_group_status!='Cancel'");
                                while($row_tour = mysqli_fetch_assoc($sq_tour)){
                                    $sq_checklist_count = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where tour_type='Group Tour' and booking_id='$row_tour[id]'"));
                                    if($sq_checklist_count!=0){
                                        $sq_checklist = mysqlQuery("select * from checklist_package_tour where tour_type='Group Tour' and booking_id='$row_tour[id]'");
                                        while($row_checklist = mysqli_fetch_assoc($sq_checklist)){
                                            $sq_to_do = mysqli_fetch_assoc(mysqlQuery("select * from to_do_entries where id='$row_checklist[entity_id]'"));
                                            $entity_list .= $sq_to_do['entity_name'].", ";		
                                        }
                                    }
                                }
                                if($entity_list != ''){
                                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Group Tour Checklist</td>
                                        <td><?= 'Admin' ?></td>
                                        <td><?= $emp_name ?></td>
                                        <td><?= 'Group Tour Checklist : '.$tour_name.' List : '.$entity_list ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="daily_summary_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= 'Group Tour Checklist : '.$tour_name.'List : '.$entity_list ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                <?php }
                            }
                            // tour checklist to admin
                            $tour_name = '';
                            $tommorow = date('Y-m-d', strtotime('+1 day', strtotime($today_date)));
                            $sq_tour_groups = mysqlQuery("select * from package_tour_booking_master where tour_from_date='$tommorow' and tour_status='' and delete_status='0'");
                            while($row_booking = mysqli_fetch_assoc($sq_tour_groups)){

                                $tour_name = $row_booking['tour_name'].'('.date('d-m-Y', strtotime($row_booking['tour_from_date'])).' to '.date('d-m-Y', strtotime($row_booking['tour_to_date'])).')';
                                $entity_list = "";
                    
                                $sq_checklist_count = mysqli_num_rows(mysqlQuery("select * from checklist_package_tour where tour_type='Package Tour' and booking_id='$row_booking[booking_id]'"));
                                if($sq_checklist_count!=0){
                                    $sq_checklist = mysqlQuery("select * from checklist_package_tour where tour_type='Package Tour' and booking_id='$row_booking[booking_id]'");
                                    while($row_checklist = mysqli_fetch_assoc($sq_checklist)){
                                        $sq_to_do = mysqli_fetch_assoc(mysqlQuery("select * from to_do_entries where id='$row_checklist[entity_id]'"));
                                        $entity_list .= $sq_to_do['entity_name'].", ";
                                    }
                                }
                                $date = $row_booking['booking_date'];
                                $yr = explode("-", $date);
                                $year = $yr[0];
                                $invoice_no = get_package_booking_id($row_booking['booking_id'],$year);
                                if($entity_list != ''){
                                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td><?= ++$count ?></td>
                                        <td>Package Tour Checklist</td>
                                        <td><?= 'Admin' ?></td>
                                        <td><?= $emp_name ?></td>
                                        <td><?= 'Package Tour Checklist : '.$invoice_no.'('.$tour_name.' List : '.$entity_list ?></td>
                                        <td><button class="btn btn-info btn-sm" onclick="daily_summary_reminder('<?= $contact_no ?>','<?= $emp_name ?>','<?= 'Package Tour Checklist : '.$invoice_no.'('.$tour_name.' List : '.$entity_list ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                    </tr>
                                <?php }
                            }
                            ?>
                    </tbody>
                </table>
            </div>
    </div></div>
    </div>
</div>
<script>
$('#creminder_report').dataTable({
    "pagingType": "full_numbers"
});
</script>