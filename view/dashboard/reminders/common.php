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
                            $year =$yr[0];
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer passport renewal</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name.'('.$pass_name.')' ?></td>
                                    <td><?= 'Package Booking ID : '.get_package_booking_id($sq_booking['booking_id'],$year).' Expiry Date : '.get_date_user($exp_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
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
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
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
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
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
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                            // Customer Birthday
                            $sq_customer = mysqlQuery("SELECT * from customer_master where (MONTH(birth_date), DAY(birth_date)) = (MONTH(CURDATE()),DAY(CURDATE()))");
                            while($row_cust=mysqli_fetch_assoc($sq_customer)){
                                $cust_name = ($row_cust['type'] == 'Corporate' || $row_cust['type'] == 'B2B') ? $row_cust['company_name'] : $row_cust['first_name'].' '.$row_cust['last_name'];
                                $contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key); 
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td>Customer Birthday</td>
                                    <td><?= 'Customer' ?></td>
                                    <td><?= $cust_name ?></td>
                                    <td><?= 'Birth Date : '.get_date_user($today_date) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
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
                                        <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
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
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('<?= $contact_no ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
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