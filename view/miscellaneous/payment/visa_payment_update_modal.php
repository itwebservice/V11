<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$payment_id = $_POST['payment_id'];
$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_payment_master where payment_id='$payment_id'"));

$sq_visa = mysqli_fetch_assoc(mysqlQuery("select * from  miscellaneous_master where misc_id='$sq_payment_info[misc_id]'"));
$date = $sq_visa['created_at'];
$yr = explode("-", $date);
$year = $yr[0];

$enable = ($sq_payment_info['payment_mode']=="Cash"||$sq_payment_info['payment_mode']=="Credit Note"||$sq_payment_info['payment_mode']=="Credit Card"|| $sq_payment_info['payment_mode'] == "Advance") ? "disabled" : "";
?>

<div class="modal fade" id="visa_payment_update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Receipt</h4>
      </div>
      <div class="modal-body">
        <form id="frm_visa_payment_update">
        <input type="hidden" id="payment_id_update" name="id_update" value="<?= $payment_id ?>">
        <input type="hidden" id="payment_amount_old" name="payment_amount_old" value="<?= $sq_payment_info['payment_amount'] ?>"> 
        <input type="hidden" id="payment_mode_old" name="payment_mode_old" value="<?= $sq_payment_info['payment_mode'] ?>"> 
        <input type="hidden" id="payment_bank_old" name="payment_bank_old" value="<?= $sq_payment_info['bank_id'] ?>"> 

          <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
              <select name="customer_id1" id="customer_id1" title="Customer Name" style="width:100%" disabled onchange="visa_id_dropdown_load('customer_id1', 'visa_id1');">
                <?php 
                $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa[customer_id]'"));
                if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
                ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['company_name'] ?></option>
                <?php } else{ ?>
                  <option value="<?= $sq_customer['customer_id'] ?>"><?= $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'] ?></option>
                  <?php } ?>
              </select>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <select name="visa_id1" id="visa_id1" style="width:100%" title="Booking ID" disabled>              
			        <option value="<?= $sq_visa['misc_id'] ?>"><?= get_misc_booking_id($sq_visa['misc_id'],$year) ?></option>
              <?php
              $sq_visa = mysqlQuery("select * from miscellaneous_master where customer_id='$sq_visa[customer_id]' and delete_status='0'");
              while($row_visa = mysqli_fetch_assoc($sq_visa)){ ?>
                <option value="<?= $row_visa['misc_id'] ?>"><?= get_misc_booking_id($row_visa['misc_id'],$year) ?></option>
                <?php } ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_date1" name="payment_date1" class="form-control" placeholder="*Date" title="Date" value="<?= date('d-m-Y', strtotime($sq_payment_info['payment_date'])) ?>" readonly>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
            <input type="text" id="payment_amount1" name="payment_amount1" class="form-control" placeholder="Amount" title="Amount" value="<?= $sq_payment_info['payment_amount'] ?>" onchange="validate_balance(this.id);get_credit_card_charges('identifier','payment_mode1','payment_amount1','credit_card_details1','credit_charges1');">
          </div>          
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
            <select name="payment_mode1" id="payment_mode1" class="form-control" title="Mode" disabled onchange="payment_master_toggles(this.id, 'bank_name1', 'transaction_id1', 'bank_id1')">
            <option value="<?php echo $sq_payment_info['payment_mode'] ?>"><?php echo $sq_payment_info['payment_mode'] ?></option>
                <?php get_payment_mode_dropdown(); ?>
            </select>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
            <input type="text" id="bank_name1" name="bank_name1" class="form-control bank_suggest" placeholder="Bank Name" title="Bank Name" value="<?= $sq_payment_info['bank_name'] ?>" <?= $enable ?>>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
            <input type="number" id="transaction_id1" name="transaction_id1" onchange="validate_specialChar(this.id)" class="form-control" placeholder="Cheque No/ID" title="Cheque No/ID" value="<?= $sq_payment_info['transaction_id'] ?>" <?= $enable ?>>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
            <select name="bank_id1" id="bank_id1" title="Creditor Bank" <?= $enable ?> disabled>
              <?php 
              if($sq_payment_info['bank_id'] != '0'){
              $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from bank_master where bank_id='$sq_payment_info[bank_id]'"));
              ?>
              <option value="<?= $sq_bank['bank_id'] ?>"><?= $sq_bank['bank_name'] ?></option>
              <?php } ?>
              <?php get_bank_dropdown(); ?>
            </select>
          </div>
        </div>
        <?php if($sq_payment_info['payment_mode'] == 'Credit Card'){?>
				<div class="row mg_tp_10">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<input type="text" id="credit_charges1" name="credit_charges1" title="Credit card charges" value="<?=$sq_payment_info['credit_charges']?>" disabled>
						<input type="hidden" id="credit_charges_old" name="credit_charges_old" title="Credit card charges" value="<?=$sq_payment_info['credit_charges']?>" disabled>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<input class="text" type="text" id="credit_card_details1" name="credit_card_details1" title="Credit card details"  value="<?= $sq_payment_info['credit_card_details'] ?>" disabled>
					</div>
				</div>
        <?php } ?>
        <input type="hidden" id="canc_status1" name="canc_status1" class="form-control" value="<?=$sq_payment_info['status']?>"/>
        <div class="row text-center mg_tp_20">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_visa_p_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
        </div>
        </form>
        
      </div>     
    </div>
  </div>
</div>

<script>
$('#customer_id1, #visa_id1').select2();

$('#visa_payment_update_modal').modal('show');  
$(function(){

$('#frm_visa_payment_update').validate({
  rules:{
    visa_id1 : { required : true },
    payment_date1 : { required : true },
    payment_amount1 : { required : true, number: true },
    payment_mode1 : { required : true }, 
    bank_id1 : { required : function(){  if($('#payment_mode1').val()!="Cash"){ return true; }else{ return false; }  }  },     
  },
  submitHandler:function(form){

    var payment_id = $('#payment_id_update').val();
    var misc_id = $('#visa_id1').val();
    var payment_date = $('#payment_date1').val();
    var payment_old_value = $('#payment_amount_old').val();
    var payment_amount = $('#payment_amount1').val();
    var payment_mode = $('#payment_mode1').val();
    var bank_name = $('#bank_name1').val();
    var transaction_id = $('#transaction_id1').val();  
    var bank_id = $('#bank_id1').val();
    var payment_old_mode = $('#payment_mode_old').val();
    var payment_bank_old = $('#payment_bank_old').val();
    var credit_charges = $('#credit_charges1').val();
    var credit_card_details = $('#credit_card_details1').val();
    var credit_charges_old = $('#credit_charges_old').val();
    var canc_status = $('#canc_status1').val();
    
    if(!check_updated_amount(payment_old_value,payment_amount)){
      error_msg_alert("You can update receipt to 0 only!");
      return false;
    }

    var base_url = $('#base_url').val();
      $('#btn_visa_p_update').button('loading');
      $.ajax({
        type: 'post',
        url: base_url+'controller/miscellaneous/miscellaneous_master_payment_update.php',
        data:{ payment_id : payment_id, misc_id : misc_id, payment_date : payment_date, payment_amount : payment_amount, payment_mode : payment_mode, bank_name : bank_name, transaction_id : transaction_id, bank_id : bank_id, payment_old_value : payment_old_value, payment_old_mode : payment_old_mode,payment_bank_old : payment_bank_old ,credit_charges:credit_charges,credit_card_details:credit_card_details,credit_charges_old:credit_charges_old,canc_status:canc_status},
        success: function(result){
          var msg = result.split('-');
          if(msg[0]=='error'){
            msg_alert(result);
            $('#btn_visa_p_update').button('reset');
          }
          else{
            msg_alert(result);
            reset_form('frm_visa_payment_update');
            $('#btn_visa_p_update').button('reset');
            $('#visa_payment_update_modal').modal('hide');  
            visa_payment_list_reflect();
          }
          
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>