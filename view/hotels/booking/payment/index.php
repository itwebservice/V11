<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
include 'payment_save_modal.php';
?>
<input type="hidden" id="whatsapp_switch" value="<?= $whatsapp_switch ?>">
<div class="row text-right mg_bt_20">
    <div class="col-xs-12">
        <button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i
                class="fa fa-file-excel-o"></i></button>
        <button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#payment_save_modal"><i
                class="fa fa-plus"></i>&nbsp;&nbsp;Receipt</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <select name="cust_type_filter" id="cust_type_filter" class="form-control"
                onchange="dynamic_customer_load(this.value,'company_filter');company_name_reflect();"
                title="Customer Type">
                <?php get_customer_type_dropdown(); ?>
            </select>
        </div>
        <div id="company_div" class="hidden">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10" id="customer_div">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <select name="booking_id_filter" id="booking_id_filter" style="width:100%" title="Booking ID">
                <?php get_hotel_booking_dropdown($role, $branch_admin_id, $branch_status, $emp_id, $role_id)  ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <select name="payment_mode_filter" id="payment_mode_filter" class="form-control" title="Mode">
                <?php echo get_payment_mode_dropdown(); ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 hidden">
            <select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
                <?php get_financial_year_dropdown(); ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="From Date"
                title="From Date" onchange="get_to_date(this.id,'payment_to_date_filter');">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="To Date"
                title="To Date" onchange="validate_validDate('payment_from_date_filter','payment_to_date_filter')">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <button class="btn btn-sm btn-info ico_right"
                onclick="payment_list_reflect();bank_receipt();">Proceed&nbsp;&nbsp;<i
                    class="fa fa-arrow-right"></i></button>
        </div>
    </div>
</div>

<div id="div_payment_list" class="main_block mg_tp_20">
    <div class="table-responsive">
        <table id="hotel_r_book" class="table table-hover" style="margin: 20px 0 !important;">
        </table>
    </div>
</div>
<div id="div_payment_update"></div>
<div id="receipt_data"></div>

<script>
$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({
    timepicker: false,
    format: 'd-m-Y'
});
$('#booking_id_filter,#cust_type_filter').select2();
dynamic_customer_load('', '');

var columns = [{
        title: "S_No"
    },
    {
        title: " "
    },
    {
        title: "Receipt_ID"
    },
    {
        title: "Booking_ID"
    },
    {
        title: "Customer_Name"
    },
    {
        title: "Receipt_Date"
    },
    {
        title: "Mode"
    },
    {
        title: "Branch_Name"
    },
    {
        title: "Amount",
        className: "success"
    },
    {
        title: "Actions",
        className: "text-center action_width"
    },
];

function payment_list_reflect() {
    var booking_id = $('#booking_id_filter').val();
    var customer_id = $('#customer_id_filter').val();
    var payment_mode = $('#payment_mode_filter').val();
    var financial_year_id = $('#financial_year_id_filter').val();
    var payment_from_date = $('#payment_from_date_filter').val();
    var payment_to_date = $('#payment_to_date_filter').val();
    var cust_type = $('#cust_type_filter').val();
    var company_name = $('#company_filter').val();
    var branch_status = $('#branch_status').val();

    $.post('payment/payment_list_reflect.php', {
        booking_id: booking_id,
        customer_id: customer_id,
        payment_mode: payment_mode,
        financial_year_id: financial_year_id,
        payment_from_date: payment_from_date,
        payment_to_date: payment_to_date,
        cust_type: cust_type,
        company_name: company_name,
        branch_status: branch_status
    }, function(data) {
        //$('#div_payment_list').html(data);
        pagination_load(data, columns, true, true, 10, 'hotel_r_book', true);
    });
}
payment_list_reflect();

$(document).ready(function() {
    $("[data-toggle='tooltip']").tooltip({
        placement: 'bottom'
    });
    $("[data-toggle='tooltip']").click(function() {
        $('.tooltip').remove()
    })
});

function payment_update_modal(payment_id) {
    $('#editr-'+payment_id).prop('disabled',true);
    $('#editr-'+payment_id).button('loading');
    var branch_status = $('#branch_status').val();
    $.post('payment/payment_update_modal.php', {
        payment_id: payment_id,
        branch_status: branch_status
    }, function(data) {
		$('#editr-'+payment_id).prop('disabled',false);
		$('#editr-'+payment_id).button('reset');
        $('#div_payment_update').html(data);
    });
}

function bank_receipt() {
    var payment_mode = $('#payment_mode_filter').val();
    $.post('payment/bank_receipt_generate.php', {
        payment_mode: payment_mode
    }, function(data) {
        $('#receipt_data').html(data);
    });
}

function excel_report() {
    var customer_id = $('#customer_id_filter').val();
    var booking_id = $('#booking_id_filter').val();
    var from_date = $('#payment_from_date_filter').val();
    var to_date = $('#payment_to_date_filter').val();
    var payment_mode = $('#payment_mode_filter').val();
    var financial_year_id = $('#financial_year_id_filter').val();
    var cust_type = $('#cust_type_filter').val();
    var company_name = $('#company_filter').val();
    var branch_status = $('#branch_status').val();

    window.location = 'payment/excel_report.php?customer_id=' + customer_id + '&booking_id=' + booking_id +
        '&from_date=' + from_date + '&to_date=' + to_date + '&payment_mode=' + payment_mode + '&financial_year_id=' +
        financial_year_id + '&cust_type=' + cust_type + '&company_name=' + company_name + '&branch_status=' +
        branch_status;
}

function cash_bank_receipt_generate() {
    var bank_name_reciept = $('#bank_name_reciept').val();
    var payment_id_arr = new Array();

    $('input[name="chk_hotel_booking_payment"]:checked').each(function() {
        payment_id_arr.push($(this).val());
    });
    if (payment_id_arr.length == 0) {
        error_msg_alert('Please select at least one payment to generate receipt!');
        return false;
    }
    var base_url = $('#base_url').val();
    var url = base_url + "view/bank_receipts/hotel_booking_payment/cash_bank_receipt.php?payment_id_arr=" +
        payment_id_arr + '&bank_name_reciept=' + bank_name_reciept;
    window.open(url, '_blank');
}

function cheque_bank_receipt_generate() {
    var bank_name_reciept = $('#bank_name_reciept').val();
    var payment_id_arr = new Array();
    var branch_name_arr = new Array();
    $('input[name="chk_hotel_booking_payment"]:checked').each(function() {
        var id = $(this).attr('id');
        var offset = id.substring(25);
        var branch_name = $('#branch_name_' + offset).val();

        payment_id_arr.push($(this).val());
        branch_name_arr.push(branch_name);
    });

    if (payment_id_arr.length == 0) {
        error_msg_alert('Please select at least one payment to generate receipt!');
        return false;
    }

    $('input[name="chk_hotel_booking_payment"]:checked').each(function() {

        var id = $(this).attr('id');
        var offset = id.substring(26);
        var branch_name = $('#branch_name_' + offset).val();

        if (branch_name == "") {
            error_msg_alert("Please enter branch name for selected payments!");
            exit(0);
        }
    });

    var base_url = $('#base_url').val();
    var url = base_url + "view/bank_receipts/hotel_booking_payment/cheque_bank_receipt.php?payment_id_arr=" +
        payment_id_arr + '&branch_name_arr=' + branch_name_arr + '&bank_name_reciept=' + bank_name_reciept;
    window.open(url, '_blank');
}

function whatsapp_send_r(booking_id, payment_amount, base_url) {
    $.post(base_url + 'controller/hotel/payment/whatsapp_send.php', {
        booking_id: booking_id,
        payment_amount: payment_amount
    }, function(data) {
        window.open(data);
    });
}

function p_delete_entry(payment_id) {
    $('#vi_confirm_box').vi_confirm_box({
        callback: function(data1) {
            if (data1 == "yes") {
                var branch_status = $('#branch_status').val();
                var base_url = $('#base_url').val();
                $.post(base_url + 'controller/hotel/payment/payment_delete.php', {
                    payment_id: payment_id
                }, function(data) {
                    success_msg_alert(data);
                    payment_list_reflect();
                });
            }
        }
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<style>
.action_width {
    display: flex;
}
</style>