<?php
include '../../../model/model.php';
global $encrypt_decrypt,$secret_key;
$from_date = get_date_db($_POST['from_date']);
$to_date = get_date_db($_POST['to_date']);
$count = 0;
$total_balance_amount = 0;
$today_date = date('Y-m-d');
?>
<div class="col-md-12">
    <div class="col-md-12 no-pad table_verflow"> 
        <div class="row"> <div class="col-md-12"> <div class="table-responsive">
            <table class="table table-hover" style="width: 100% !important;" id="reminder_report">    
                <thead>
                    <tr class="table-heading-row">
                        <th>S_No.</th>
                        <th>Tour_Type</th>
                        <th>Booking_ID</th>
                        <th>Customer_Name</th>
                        <th>Due_Date</th>
                        <th>Total_Amount</th>
                        <th>Paid_Amount</th>
                        <th>Balance_Amount</th>
                        <th style="display:flex">Actions&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Package Tour -->
                        <?php
                        $sq_tour_details = mysqlQuery("select * from package_tour_booking_master where due_date between '$from_date' and '$to_date' and tour_status!='cancel' and delete_status='0'");
                        while($row_tour_details= mysqli_fetch_assoc($sq_tour_details)){

                            $booking_id = $row_tour_details['booking_id'];
                            $date = $row_tour_details['booking_date'];
                            $yr = explode("-", $date);
                            $year = $yr[0];
                            $package_id = get_package_booking_id($booking_id,$year);

                            $total_amount = $row_tour_details['net_total'];
                            $customer_id = $row_tour_details['customer_id'];

                            $sq_total_paid =  mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
                            $customer_name = mysqli_fetch_assoc(mysqlQuery("select type,first_name,last_name,company_name from customer_master where customer_id='$customer_id'"));
                            $customer_name1 = ($customer_name['type'] == 'Corporate'||$customer_name['type'] == 'B2B') ? $customer_name['company_name'] : $customer_name1 = $customer_name['first_name'].' '.$customer_name['last_name'];
                            $paid_amount = $sq_total_paid['sum'];
                            $cancel_est = mysqli_fetch_assoc(mysqlQuery("select cancel_amount from package_refund_traveler_estimate where booking_id='$sq_package_info[booking_id]'"));
                            $cancel_amount = $cancel_est['cancel_amount'];
                            if ($cancel_amount != '') {
                                if ($cancel_amount <= $paid_amount) {
                                    $balance_amount = 0;
                                } else {
                                    $balance_amount =  $cancel_amount - $paid_amount + $credit_card_amount;
                                }
                            } else {
                                $cancel_amount = ($cancel_amount == '') ? '0' : $cancel_amount;
                                $balance_amount = $total_amount - $paid_amount;
                            }
                            $total_balance_amount += floatval($balance_amount);
                            $bg = ($today_date > get_date_db($row_tour_details['due_date'])) ? 'danger' : '';
                            if($balance_amount>0){
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td><?= 'Package Tour' ?></td>
                                    <td><?= $package_id ?></td>
                                    <td><?= $customer_name1 ?></td>
                                    <td><?= get_date_user($row_tour_details['due_date']) ?></td>
                                    <td class="text-right"><?= number_format($total_amount,2) ?></td>
                                    <td class="text-right"><?= number_format($paid_amount,2) ?></td>
                                    <td class="text-right"><?= number_format($balance_amount,2) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('package','<?= $customer_name1 ?>','<?= number_format($total_amount,2) ?>','<?= number_format($paid_amount,2) ?>','<?= number_format($balance_amount,2) ?>','<?= $row_tour_details['mobile_no'] ?>','<?= $package_id ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <!-- Group Tour -->
                        <?php
                        $sq_tour_details = mysqlQuery("select * from tourwise_traveler_details where balance_due_date between '$from_date' and '$to_date' and delete_status='0'");
                        while($row_tour_details = mysqli_fetch_assoc($sq_tour_details)){

                            $booking_id = $row_tour_details['id'];
                            $date = $row_tour_details['form_date'];
                            $yr = explode("-", $date);
                            $year = $yr[0];
                            $booking_id1 = get_group_booking_id($booking_id,$year);

                            $total_amount = $row_tour_details['net_total'];
                            $customer_id = $row_tour_details['customer_id'];

                            $sq_total_paid =  mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
                            $customer_name = mysqli_fetch_assoc(mysqlQuery("select type,first_name,last_name,company_name from customer_master where customer_id='$customer_id'"));
                            $customer_name1 = ($customer_name['type'] == 'Corporate'||$customer_name['type'] == 'B2B') ? $customer_name['company_name'] : $customer_name1 = $customer_name['first_name'].' '.$customer_name['last_name'];
                            $contact_no = $encrypt_decrypt->fnDecrypt($customer_name['contact_no'], $secret_key);
                            $paid_amount = $sq_total_paid['sum'];
                            $pass_count = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_tour_details[traveler_group_id]'"));
                            $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_tour_details[traveler_group_id]' and status='Cancel'"));    
                            
                            if($row_tour_details['tour_group_status'] == 'Cancel'){
                                //Group Tour cancel
                                $cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_tour_details[id]'"));
                                if($cancel_tour_count2 >= '1'){
                                    $cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_tour_details[id]'"));
                                    $cancel_amount = $cancel_tour['cancel_amount'];
                                }
                                else{ $cancel_amount = 0; }
                            }
                            else{
                                // Group booking cancel
                                $cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_tour_details[id]'"));
                                if($pass_count==$cancelpass_count){
                                    $cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_tour_details[id]'"));
                                    $cancel_amount = $cancel_esti1['cancel_amount'];
                                }
                                else{ $cancel_amount = 0; }
                            }
                            
                            $cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
                            if($row_tour_details['tour_group_status'] == 'Cancel'){
                                if($cancel_amount > $paid_amount){
                                    $balance_amount = $cancel_amount - $paid_amount + $query['sumc'];
                                }
                                else{
                                    $balance_amount = 0;
                                }
                            }else{
                                if($pass_count == $cancelpass_count){
                                    if($cancel_amount > $paid_amount){
                                        $balance_amount = $cancel_amount - $paid_amount + $query['sumc'];
                                    }
                                    else{
                                        $balance_amount = 0;
                                    }
                                }
                                else{
                                    $balance_amount = $total_amount - $paid_amount;
                                }
                            }
                            $total_balance_amount += floatval($balance_amount);
                            $bg = ($today_date > get_date_db($row_tour_details['balance_due_date'])) ? 'danger' : '';
                            if($balance_amount>0){
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td><?= ++$count ?></td>
                                    <td><?= 'Group Tour' ?></td>
                                    <td><?= $booking_id1 ?></td>
                                    <td><?= $customer_name1 ?></td>
                                    <td><?= get_date_user($row_tour_details['balance_due_date']) ?></td>
                                    <td class="text-right"><?= number_format($total_amount,2) ?></td>
                                    <td class="text-right"><?= number_format($paid_amount,2) ?></td>
                                    <td class="text-right"><?= number_format($balance_amount,2) ?></td>
                                    <td><button class="btn btn-info btn-sm" onclick="whatsapp_reminder('group','<?= $customer_name1 ?>','<?= number_format($total_amount,2) ?>','<?= number_format($paid_amount,2) ?>','<?= number_format($balance_amount,2) ?>','<?= $contact_no ?>','<?= $booking_id1 ?>')" data-toggle="tooltip" title="Send WhatsApp Reminder"><i class="fa fa-whatsapp"></i></button></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="7" class="text-right">Total Balance: </th>
                            <th class="<?= 'success' ?> text-right"><?= number_format($total_balance_amount,2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
    </div></div>
    </div>
</div>
<script>
$('#reminder_report').dataTable({
    "pagingType": "full_numbers"
});
</script>
