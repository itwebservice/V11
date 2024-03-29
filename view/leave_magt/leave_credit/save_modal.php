<?php 
include "../../../model/model.php";
?>

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">leave Credit</h4>
      </div>
      <div class="modal-body">
        
        <form id="frm_save">
        <div class="panel-body">
                          
         <div class="row mg_bt_10">
              <div class="col-md-4"><label for="emp_id">User Name</label></div>
                <div class="col-sm-6 col-xs-12">
                <select name="emp_id" id="emp_id1"  class="form-control" style="width: 100%;" title="User Name" title="User Name">
                  <option value="">*Select User</option>
                  <?php
                    $sq_user = mysqlQuery("select emp_id, first_name, last_name from emp_master where role_id!=1 and active_flag='Active' order by first_name");
         
                  while($row_user = mysqli_fetch_assoc($sq_user)){

                    ?>

                    <option value="<?= $row_user['emp_id'] ?>"><?= $row_user['first_name'].' '.$row_user['last_name'] ?></option>

                    <?php

                  }

                  ?>

                </select>

              </div>
          </div>
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="casual">Casual Leave</label></div>
              <div class="col-sm-6 col-xs-12">
                <input type="text" id="casual" name="casual" onchange="validate_balance(this.id);" placeholder="*Casual" title="Casual" >
              </div>
             
          </div>                      
          <div class="row mg_bt_10">
            <div class="col-md-4"><label for="paid">Paid Leave</label></div>
              <div class="col-sm-6 col-xs-12">
                  <input type="text" id="paid" name="paid" onchange="validate_balance(this.id);" placeholder="*Paid" title="Paid">
                </div> 
          </div> 
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="medical">Medical Leave</label></div>      
                  <div class="col-sm-6 col-xs-12">
                    <input type="text" id="medical" name="medical" onchange="validate_balance(this.id);" placeholder="*Medical" title="Medical">
              </div> 
          </div> 
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="maternity">Maternity Leave</label></div> 
                  <div class="col-md-6">
                    <input type="text" id="maternity" name="maternity" onchange="validate_balance(this.id);" placeholder="Maternity" title="Maternity">
                  </div> 
          </div> 
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="paternity">Paternity Leave</label></div>    
                  <div class="col-sm-6 col-xs-12">
                    <input type="text" id="paternity" name="paternity" onchange="validate_balance(this.id);"  placeholder="Paternity" title="Paternity">
                  </div>
            </div>
          <div class="row mg_bt_10">
              <div class="col-md-4"><label for="leave_without_pay">Leave without Pay</label></div>                 
                  <div class="col-sm-6 col-xs-12">
                    <input type="text" id="leave_without_pay" onchange="validate_balance(this.id);" name="leave_without_pay" placeholder="Leave without Pay" title="Leave without Pay">
                  </div>
              </div> 

            <div class="row text-center mg_tp_20">
              <div class="col-xs-12">
                <button class="btn btn-sm btn-success" id="btn_credit_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
              </div>
            </div>
          </div>
          </form>

      </div>     
    </div>
  </div>
</div>

<script>
$('#save_modal').modal('show');
$('#emp_id1').select2();

$(function(){

$('#frm_save').validate({
  rules:{
      emp_id : { required : true },
      casual : { required : true },
      paid : { required : true },
      medical : { required : true }, 
  },
  submitHandler:function(form){

      $('#btn_credit_save').prop('disabled',true);
      var emp_id = $('#emp_id1').val();
      var paid = $('#paid').val();
      var casual = $('#casual').val();
      var medical = $('#medical').val();
      var maternity = $('#maternity').val();
      var paternity = $('#paternity').val();
      var leave_without_pay = $('#leave_without_pay').val();
      var base_url = $('#base_url').val();

      $('#btn_credit_save').button('loading');
      
      $.ajax({
        type: 'post',
        url: base_url+'controller/leave/leave_credit_save.php',
        data:{ emp_id : emp_id, paid : paid, casual : casual, medical : medical, maternity : maternity , paternity : paternity, leave_without_pay : leave_without_pay },
        success: function(result){
          $('#btn_credit_save').button('reset');
          $('#btn_credit_save').prop('disabled',false);
          msg_alert(result);
          $('#save_modal').modal('hide');
          list_reflect();
        }
      });
  }
});

});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
