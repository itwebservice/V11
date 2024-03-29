<?php
include "../../../../model/model.php";
$request_id1 = $_GET['request'];
$supplier_id1 = $_GET['supplier'];
$enquiry_id1 = $_GET['enquiry_id']; 
$request_id = base64_decode($request_id1);
$supplier_id = base64_decode($supplier_id1);
$enquiry_id = base64_decode($enquiry_id1);
?>
<head>

  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">

 <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.datetimepicker.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
   <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/admin.php">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">
            
  <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.datetimepicker.full.js"></script> 
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>

</head>
<div class="container">
    <div class="app_panel_head">
      <h2>Quotation Reply Information</h2>
    </div>
    <div class="row text-right mg_bt_10">
	<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" onclick="vendor_request_view_modal(<?= $request_id ?>)"><i class="fa fa-eye"></i>&nbsp;&nbsp;View Enquiry</button>&nbsp;&nbsp;
			<!-- <button class="btn btn-info btn-sm ico_left" onclick="window.location='../../../../view/vendor_login/'"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Login</button> -->
	</div>
</div>
<div id="div_req_view"></div>
<form id="frm_enquiry_save" class="mg_tp_20">
	<input type="hidden" id="request_id" name="request_id" value="<?= $request_id ?>" >
	<input type="hidden" id="supplier_id" name="supplier_id" value="<?= $supplier_id ?>" >
	<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id1 ?>" >
	<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>" >
<div class="panel panel-default panel-body app_panel_style feildset-panel" style="margin-bottom: 30px;">
	<div class="main_block mg_tp_20">
		<div class="col-md-4 text-right"><label for="app_name">Hotel AMOUNT</label></div>
		<div class="col-md-4 no-pad">
			<input type="text" class="form-control" id="txt_trans" name="txt_trans" placeholder="Hotel Amount" title="Hotel Amount" onchange="total_cost_reflect()">
		</div>
	</div>
	<div class="main_block mg_tp_20">
		<div class="col-md-4 text-right"><label for="app_website">TOTAL AMOUNT</label></div>
		<div class="col-md-4 no-pad">
			<input type="text" class="form-control" id="txt_cost" name="txt_cost" placeholder="*Total Amount" title="Total Amount" readonly> 
		</div>
		<div class="col-md-2">
        <select name="currency_code" id="currency_code1" title="Currency" style="width:100%">
			<?php
			$sq_app_setting = mysqli_fetch_assoc(mysqlQuery("select currency from app_settings"));
			$q_currency = $sq_app_setting['currency'];
			if($q_currency!=''){

				$sq_currencyd = mysqli_fetch_assoc(mysqlQuery("SELECT `id`,`currency_code` FROM `currency_name_master` WHERE id=" . $q_currency));
				?>
				<option value="<?= $sq_currencyd['id'] ?>"><?= $sq_currencyd['currency_code'] ?></option>
				<?php
			}
			$sq_currency = mysqlQuery("select * from currency_name_master order by default_currency desc");
			while($row_currency = mysqli_fetch_assoc($sq_currency)){
			?>
			<option value="<?= $row_currency['id'] ?>"><?= $row_currency['currency_code'] ?></option>
			<?php
			}
			?>
        </select>

        </div>
	</div>

	<div class="main_block mg_tp_20">
		<div class="col-md-4 text-right"><label for="app_name">OTHER COMMENTS </label></div>
		<div class="col-md-6 no-pad">
			<textarea   class="feature_editor" id="txt_enquiry_specification" name="txt_enquiry_specification" placeholder="Other Comments" class="form-control" title="Other Comments"></textarea>
		</div>
	</div>
	<div class="main_block mg_tp_20">
		<div class="col-md-4 text-right"><label for="app_website">Created By</label></div>
		<div class="col-md-4 no-pad">
			<input type="text" class="form-control" id="txt_creat" name="txt_creat" placeholder="*Created By" title="Created By"> 
		</div>
	</div>
	<div class="main_block text-center mg_tp_20">
	 <div class="col-md-12">
		<button class="btn btn-sm btn-success" id="form_send"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
	 </div>
    </div>
</div>
<div id="site_alert"></div>
<div id="vi_confirm_box"></div>
</form>
</div>
<script>
 
function total_cost_reflect()
{
  var hotel_cost = $('#txt_trans').val();

  if(hotel_cost==""){ hotel_cost = 0;}
   
  $('#txt_cost').val(hotel_cost);
 
}
function vendor_request_view_modal(request_id)
{
	$.post('view/index.php', { request_id : request_id }, function(data){
		$('#div_req_view').html(data);
	});
}
 
 $(function(){
  $('#frm_enquiry_save').validate({
    rules:{
            txt_trans : { number :true },
            txt_cost : { required :true, number :true },
            txt_creat : { required : true },
            
    },
    submitHandler:function(form){
	   var hotel_cost = $("#txt_trans").val(); 
	   var total_cost = $("#txt_cost").val(); 
	   var enquiry_spec = $("#txt_enquiry_specification").val(); 
	   var request_id = $('#request_id').val();
	   var supplier_id = $('#supplier_id').val();
	   var created_by = $('#txt_creat').val();
	   var base_url = $('#base_url').val();
	   var currency_code = $('#currency_code1').val();
	   var enquiry_id = $('#enquiry_id').val();

	  $('#form_send').button('loading');
		$.ajax({
			type:'post',
			url: base_url+'controller/vendor/quotation_request/hotel_quotation_reply_save.php',
			data:{hotel_cost : hotel_cost, total_cost : total_cost ,enquiry_spec : enquiry_spec, request_id : request_id, supplier_id : supplier_id , created_by : created_by, currency_code : currency_code, enquiry_id : enquiry_id},
			success: function(message){
				success_msg_alert(message);
				$('#form_send').button('reset');
				reset_form('frm_enquiry_save');
			}
		});
    }
  });
});
</script> 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>