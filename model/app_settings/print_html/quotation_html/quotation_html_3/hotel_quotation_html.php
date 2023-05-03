<?php 
//Generic Files
include "../../../../model.php"; 
include "printFunction.php";
global $app_quot_img,$similar_text,$qout_note,$currency,$tcs_note;

$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='hotel_quotation/index.php'"));
$branch_status = $sq['branch_status'];
$branch_details = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id='$branch_admin_id'"));

$quotation_id = $_GET['quotation_id'];
$sq_terms_cond = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Hotel Quotation' and active_flag ='Active'")); 

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from hotel_quotation_master where quotation_id='$quotation_id'"));

$enquiryDetails = json_decode($sq_quotation['enquiry_details'], true);
$hotelDetails = json_decode($sq_quotation['hotel_details'], true);
$costDetails = json_decode($sq_quotation['costing_details'], true);

$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));

$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
$quotation_date = $sq_quotation['quotation_date'];
$yr = explode("-", $quotation_date);
$year =$yr[0];

if($sq_emp_info['first_name']==''){
  $emp_name = 'Admin';
}
else{
  $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
}


$tax_show = '';
$newBasic = $basic_cost1 = $sq_quotation['subtotal'] ;
$service_charge = $sq_quotation['service_charge'];
$bsmValues = json_decode($sq_quotation['bsm_values']);
//////////////////Service Charge Rules
$service_tax_amount = 0;
if($costDetails['tax_amount'] !== 0.00 && ($costDetails['tax_amount']) !== ''){
  $service_tax_subtotal1 = explode(',',$costDetails['tax_amount']);
  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
    $service_tax = explode(':',$service_tax_subtotal1[$i]);
    $service_tax_amount +=  $service_tax[2];
    $percent = $service_tax[1];
    $name .= $service_tax[0]  . $service_tax[1] .', ';
  }
}
$service_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$service_tax_amount);

$basic_cost1 = floatval($costDetails['hotel_cost']);
$service_charge = floatval($costDetails['service_charge']);
////////////////////Markup Rules
$markupservice_tax_amount = 0;
if($costDetails['markup_tax'] !== 0.00 && $costDetails['markup_tax'] !== ""){
  $service_tax_markup1 = explode(',',$costDetails['markup_tax']);
  for($i=0;$i<sizeof($service_tax_markup1);$i++){
    $service_tax = explode(':',$service_tax_markup1[$i]);
    $markupservice_tax_amount += $service_tax[2];
  }
}
$markupservice_tax_amount_show = currency_conversion($currency,$sq_quotation['currency_code'],$markupservice_tax_amount);

if(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '')  && $bsmValues[0]->markup != ''){
  $tax_show = '';
  $newBasic = $basic_cost1 + floatval($costDetails['markup_cost']) + $markupservice_tax_amount + $service_charge + $service_tax_amount;
}
elseif(($bsmValues[0]->service == '' || $bsmValues[0]->basic == '')  && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount + $service_tax_amount);
  $newBasic = $basic_cost1 + floatval($costDetails['markup_cost']) + $service_charge;
}
elseif(($bsmValues[0]->service != '' || $bsmValues[0]->basic != '') && $bsmValues[0]->markup == ''){
  $tax_show = $percent.' '. ($markupservice_tax_amount);
  $newBasic = $basic_cost1 + floatval($costDetails['markup_cost']) + $service_charge + $service_tax_amount;
}
else{
  $tax_show = $percent.' '. ($service_tax_amount);
  $newBasic = $basic_cost1 + floatval($costDetails['markup_cost']) + $service_charge + $markupservice_tax_amount;
}
////////////////Currency conversion ////////////
$currency_amount1 = currency_conversion($currency,$sq_quotation['currency_code'],floatval($costDetails['total_amount']));
?>

    <!-- landingPage -->
    <section class="landingSec main_block">

      <div class="landingPageTop main_block">
        <img src="<?= $app_quot_img?>" class="img-responsive">
        <h1 class="landingpageTitle">HOTEL QUOTATION</em></h1>
        <span class="landingPageId"><?= get_quotation_id($quotation_id,$year) ?></span>
        <div class="landingdetailBlock">
          <div class="detailBlock text-center" style="border-top:0px;">
            <div class="detailBlockIcon detailBlockBlue">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= get_date_user($sq_quotation['quotation_date']) ?></h3>
              <span class="contentLabel">QUOTATION DATE</span>
            </div>
          </div>


          <div class="detailBlock text-center">
            <div class="detailBlockIcon detailBlockYellow">
                <i class="fa fa-users"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= $enquiryDetails['total_members'] ?></h3>
              <span class="contentLabel">TOTAL GUEST</span>
            </div>
          </div>

          <div class="detailBlock text-center">
            <div class="detailBlockIcon detailBlockRed">
                <i class="fa fa-tag"></i>
            </div>
            <div class="detailBlockContent">
              <h3 class="contentValue"><?= $currency_amount1 ?></h3>
              <span class="contentLabel">PRICE</span>
            </div>
          </div>
        </div>
      </div>

      <div class="ladingPageBottom main_block side_pad">

        <div class="row">
          <div class="col-md-4">
            <div class="landigPageCustomer mg_tp_10">
              <h3 class="customerFrom">PREPARED FOR</h3>
              <span class="customerName mg_tp_10"><i class="fa fa-user"></i> : <?= $enquiryDetails['customer_name'] ?></span><br>
              <span class="customerMail mg_tp_10"><i class="fa fa-envelope"></i> : <?= $enquiryDetails['email_id'] ?></span><br>
              <span class="customerMobile mg_tp_10"><i class="fa fa-phone"></i> : <?= $enquiryDetails['country_code'].$enquiryDetails['whatsapp_no'] ?></span><br>
              <span class="generatorName mg_tp_10">PREPARED BY <?= $emp_name?></span><br>
            </div>
          </div>
          <div class="col-md-2">
          </div>
          <div class="col-md-6">
            <div class="print_header_logo main_block">
              <img src="<?= $admin_logo_url ?>" class="img-responsive">
            </div>
            <div class="print_header_contact text-right main_block">
              <span class="title"><?php echo $app_name; ?></span><br>
              <p class="address no-marg"><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['address1'].','.$branch_details['address2'].','.$branch_details['city'] : $app_address; ?></p>
              <p class="no-marg"><i class="fa fa-phone" style="margin-right: 5px;"></i><?php echo ($branch_status=='yes' && $role!='Admin') ? $branch_details['contact_no']  : $app_contact_no; ?></p>
              <p class="no-marg"><i class="fa fa-envelope" style="margin-right: 5px;"></i><?php echo ($branch_status=='yes' && $role!='Admin' && $branch_details['email_id'] != '') ? $branch_details['email_id'] : $app_email_id; ?></p>
              <?php if($app_website != ''){ ?><p><i class="fa fa-globe" style="margin-right: 5px;"></i><?php echo $app_website; ?></p><?php } ?>
            </div>
          </div>
        </div>
        
      </div>
    </section>

          <!-- Hotel -->
          <section class="transportDetails main_block side_pad mg_tp_30">
            <div class="row">
              <div class="col-md-3">
                <div class="transportImg">
                  <img src="<?= BASE_URL ?>images/quotation/hotel.png" style="height: 190px; width: 280px;" class="img-responsive">
                </div>
              </div>
              <div class="col-md-9">
                <div class="table-responsive mg_tp_30">
                  <table class="table table-bordered no-marg" id="tbl_emp_list">
                    <thead>
                      <tr class="table-heading-row">
                        <th>City</th>
                        <th>Hotel</th>
                        <th>R_Category</th>
                        <th>Meal_Plan</th>
                        <th>H_Category</th>
                        <th>Check_IN</th>
                        <th>Check_OUT</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $int_flag = '';
                    foreach($hotelDetails as $values){
                        $cityName = mysqli_fetch_assoc(mysqlQuery("SELECT `city_name` FROM `city_master` WHERE `city_id`=".$values['city_id']));
                        $hotelName = mysqli_fetch_assoc(mysqlQuery("SELECT `hotel_name`,`state_id` FROM `hotel_master` WHERE `hotel_id`=".$values['hotel_id']));
                        if($values['tour_type'] == 'International' && $int_flag == ''){
                          $int_flag = true;
                        }
                      ?>
                      <tr>
                          <td><?php echo $cityName['city_name']; ?></td>
                          <td><?php echo $hotelName['hotel_name']; ?></td>
                          <td><?= $values['hotel_cat'] ?></td>
                          <td><?= $values['meal_plan'] ?></td>
                          <td><?= $values['hotel_type'] ?></td>
                          <td><?= get_date_user($values['checkin']) ?></td>
                          <td><?= get_date_user($values['checkout']) ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>  
            </div>
          </section>
    </section>
            <?php
            if($quot_note!=''){ ?>
            <!-- Inclusion Exclusion -->
            <div class="row">

              <div class="col-md-12 mg_tp_30">
                <div class="termsConditions main_block">
                  <div class="tncContent">
                  <pre class="real_text"><?php echo $quot_note; ?></pre>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
 

    <!-- Terms and Conditions -->
    <?php if($sq_terms_cond['terms_and_conditions'] != ''){ ?>
    <section class="incluExcluTerms main_block fullHeightLand">

      <!-- Terms and Conditions -->
      <div class="row">
        
        <div class="col-md-12 mg_tp_30">
          <div class="incluExcluTermsTabPanel main_block">
              <h3 class="tncTitle">Terms &amp; Conditions</h3>
              <div class="tncContent">
                  <pre class="real_text"><?php echo $sq_terms_cond['terms_and_conditions']; ?></pre>      
              </div>
          </div>
        </div>
      </div>
      
    </section>
    <?php } ?>
    <!-- Ending Page -->
    <section class="endPageSection main_block">

      <div class="row">
        
        <!-- Costing -->
        <div class="col-md-4 constingBankingPanel endPageLeft fullHeightLand">
              <h3 class="costBankTitle text-right">COSTING Details</h3>
              <?php
              $total_fare = currency_conversion($currency,$sq_quotation['currency_code'],$newBasic);
              $service_tax_amount_show = explode(' ',$service_tax_amount_show);
              $service_tax_amount_show1 = str_replace(',','',$service_tax_amount_show[1]);
              $markupservice_tax_amount_show = explode(' ',$markupservice_tax_amount_show);
              $markupservice_tax_amount_show1 = str_replace(',','',$markupservice_tax_amount_show[1]);
              ?>
              <!-- Group Costing -->
              <div class="col-md-12 text-right mg_bt_20">
                <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tourCost.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $total_fare ?></h4>
                <p>TOTAL COST</p>
              </div>
              <div class="col-md-12 text-right mg_bt_20">
                <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/tax.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= str_replace(',','',$name).$service_tax_amount_show[0].' '.number_format($service_tax_amount_show1 + $markupservice_tax_amount_show1 + $costDetails['roundoff'],2) ?></h4>
                <p>TAX</p>
              </div>
              <div class="col-md-12 text-right mg_bt_20">
                <div class="icon main_block"><img src="<?= BASE_URL ?>images/quotation/p4/quotationCost.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $currency_amount1 ?></h4>
                <p>QUOTATION COST</p>
              </div>
              <?php
              $tcs_note_show = ($int_flag == true) ? $tcs_note : '';
              if ($tcs_note_show != '') { ?>
                <div class="col-md-12 text-right" style="margin-top:10px; ">
                  <h5 class="text-right"><?= $tcs_note_show ?></h5></div>
              <?php } ?>
              <?php 
              if(check_qr()) { ?>
              <div class="col-md-12 text-right" style="margin-top:20px; margin-bottom:20px;">
                        <?= get_qr('Landscape Creative') ?>
                <br>
                <h4 class="no-marg">Scan & Pay </h4>
              </div>
              <?php } ?>
        </div>
        
        <!-- Guest Detail -->
        <div class="col-md-4 passengerPanel endPagecenter fullHeightLand">
              <h3 class="costBankTitle text-center">TOTAL GUEST(s)</h3>
              <div class="col-md-12 text-center mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/Icon/adultIcon.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $enquiryDetails['total_adult'] ?></h4>
                <p>Adult</p>
              </div>
              <div class="col-md-12 text-center mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/Icon/childIcon.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $enquiryDetails['children_with_bed']+$enquiryDetails['children_without_bed'] ?></h4>
                <p>CWB/CWOB</p>
              </div>
              <div class="col-md-12 text-center mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/Icon/infantIcon.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= $enquiryDetails['total_infant'] ?></h4>
                <p>Infant</p>
              </div>
              
        </div>
        
        <!-- Bank Detail -->
        <div class="col-md-4 constingBankingPanel endPageright fullHeightLand">
              <h3 class="costBankTitle text-left">BANK DETAILS</h3>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/bankName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($bank_name_setting != '') ? $bank_name_setting : 'NA' ?></h4>
                <p>BANK NAME</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/branchName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($bank_branch_name!= '') ? $bank_branch_name : 'NA' ?>(<?= ($bank_ifsc_code != '') ? strtoupper($bank_ifsc_code) : 'NA' ?>)</h4>
            <p>BRANCH</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accName.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($acc_name != '') ? $acc_name : 'NA' ?></h4>
                <p>A/C TYPE</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/accNumber.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($bank_acc_no != '') ? $bank_acc_no : 'NA' ?></h4>
                <p>A/C NO</p>
              </div>
              <div class="col-md-12 text-left mg_bt_20">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($bank_account_name != '') ? $bank_account_name : 'NA' ?></h4>
            <p>BANK ACCOUNT NAME</p>
              </div>
              <div class="col-md-12 text-left">
                <div class="icon"><img src="<?= BASE_URL ?>images/quotation/p4/code.png" class="img-responsive"></div>
                <h4 class="no-marg"><?= ($bank_swift_code != '') ? strtoupper($bank_swift_code) : 'NA' ?></h4>
                <p>SWIFT CODE</p>
              </div>

        </div>
      
      </div>

    </section>

  </body>
</html>