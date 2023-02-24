<?php
include '../../../model/model.php';
global $app_name;
include_once "../../../Tours_B2B/layouts/login_header.php";
?>

    <!-- ********** Component :: Registration Page ********** -->
    <div class="c-coloredWrapper">
      <div class="container-fluid">
        <h2 class="c-heading lg extra-bold uppercase font-2">
          Registration Form
        </h2>
        <div class="loginWindow">
          <div class="row">
            <div class="col-lg-12">
              <span class="c-heading sm uppercase font-2"
                >Personal Details</span
              >
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Company Name"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Accounting Name"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select IATA Status</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="IATA Reg. No."
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Contact Number"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="PAN / TAN No."
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="GSTIN"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select Currency</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Rental / Own"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Website URL"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <span class="c-heading sm uppercase font-2">Address Details</span>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Address Line 1"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Address Line 1"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Pin Code"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select State</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select City</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select Country</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Timezone"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <span class="c-heading sm uppercase font-2"
                >Contact Person Details</span
              >
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="First Name"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Last Name"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Contact Number"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Whtsapp No."
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select Designation</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Address"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <input
                    type="text"
                    class="c-textbox rounded"
                    placeholder="Pin Code"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select State</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select City</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <select class="form-control c-textbox rounded">
                  <option>Select Country</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <span class="c-heading sm uppercase font-2">Documents</span>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <label>ID Proof/Address Proof</label>
                  <input
                    type="file"
                    class="c-textbox rounded"
                    placeholder="ID Proof/Address Proof"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="c-select2DD">
                  <label>Registration Certificate</label>
                  <input
                    type="file"
                    class="c-textbox rounded"
                    placeholder="Registration Certificate"
                    autocomplete="off"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col text-center">
              <button class="c-button md">Register</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ********** Component :: Registration Page End ********** -->

    <!-- ********** Component :: Login Page ********** -->
    <div class="c-container aboutUs">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-6 col-sm-12">
            <div class="about-image">
              <img src="./images/about.jpg" alt="about" />
            </div>
          </div>
          <div class="col-lg-7 col-md-6 col-sm-12">
            <div class="subheading uppercase">
              MORE THAN 13 YEARS OF TOUR & TRAVEL EXPERIENCE
            </div>
            <div class="mainheading uppercase">WE ARE ARTIO TRAVEL!</div>
            <div class="staticText">
              We are a travel agency which has more than 13 years of tour
              experience in Istanbul, Cappadocia, Ephesus, Gallipoli, Pamukkale,
              Mediterranean coast, East Turkey, Troy, Blacksea region and other
              popular destinations in Turkey.
            </div>
            <div class="staticText">
              We are a travel agency which has more than 13 years of tour
              experience in Istanbul, Cappadocia, Ephesus, Gallipoli, Pamukkale,
              Mediterranean coast, East Turkey, Troy, Blacksea region and other
              popular destinations in Turkey.
            </div>
            <div class="staticText">
              We are a travel agency which has more than 13 years of tour
              experience in Istanbul, Cappadocia, Ephesus, Gallipoli, Pamukkale,
              Mediterranean coast, East Turkey, Troy, Blacksea region and other
              popular destinations in Turkey.
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ********** Component :: Login Page ********** -->

    <!-- ********** Component :: Info Section ********** -->
    <section class="c-container with-gray-background">
      <div class="container">
        <h2 class="container-heading">Why Choose Us?</h2>

        <!-- *** Component :: Card Pallet ***** -->
        <div class="c-cardPallet">
          <div class="overflow-hidden">
            <div class="cardPalletBox column-5-no-margin">
              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/best-price.png" alt="img" />
                </div>
                <h5 class="boxTitle">Competitive Pricing</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>

              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/award-winning.png" alt="img" />
                </div>
                <h5 class="boxTitle">Award Winning Services</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>

              <article class="icon-box">
                <div class="imageBox">
                  <img
                    src="images/icon/whyUs/worldWide-coverage.png"
                    alt="img"
                  />
                </div>
                <h5 class="boxTitle">Worldwide Coverage</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>

              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/support.png" alt="img" />
                </div>
                <h5 class="boxTitle">24X7 Support</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>

              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/unlimited-offers.png" alt="img" />
                </div>
                <h5 class="boxTitle">Ultimate Offers</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>

              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/secure-payment.png" alt="img" />
                </div>
                <h5 class="boxTitle">Secure Payment</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>
              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/transaction.png" alt="img" />
                </div>
                <h5 class="boxTitle">Easy Online Transaction</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>
              <article class="icon-box">
                <div class="imageBox">
                  <img src="images/icon/whyUs/review.png" alt="img" />
                </div>
                <h5 class="boxTitle">Reviews & Ratings</h5>
                <p class="boxSubTitle">
                  Lorem Ipsum is simply dumy typesetting industry.
                </p>
              </article>
            </div>
          </div>
        </div>
        <!-- *** Component :: Card Pallet End ***** -->
      </div>
    </section>
    <!-- ********** Component :: Info Section ********** -->

    <!-- ********** Component :: Destination Ideas Section ********** -->
    <div class="c-container with-map">
      <div class="container">
        <div class="container-heading">
          AMAZING TRAVEL SERVICES FOR YOUR END CUSTOMERS
        </div>

        <div class="row">
          <div class="col">
            <div class="overflow-hidden">
              <div class="cardPalletBox column-5-no-margin type-03">
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-users-group icon"></i>
                  </div>
                  <h4 class="boxTitle">Group Tours</h4>
                </article>

                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-airplane icon"></i>
                  </div>
                  <h4 class="boxTitle">Flights</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-hotel icon"></i>
                  </div>
                  <h4 class="boxTitle">Hotels</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-car icon"></i>
                  </div>
                  <h4 class="boxTitle">Transfer</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-hot-air-balloon icon"></i>
                  </div>
                  <h4 class="boxTitle">Activities</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-passport icon"></i>
                  </div>
                  <h4 class="boxTitle">Visa</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-bus icon"></i>
                  </div>
                  <h4 class="boxTitle">Bus</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-train icon"></i>
                  </div>
                  <h4 class="boxTitle">Train</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-ship icon"></i>
                  </div>
                  <h4 class="boxTitle">Cruise</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-change icon"></i>
                  </div>
                  <h4 class="boxTitle">Forex</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-travel-insurance icon"></i>
                  </div>
                  <h4 class="boxTitle">Insurance</h4>
                </article>
                <article class="icon-box">
                  <div class="imageBox">
                    <i class="itours-b2b-guide icon"></i>
                  </div>
                  <h4 class="boxTitle">Guide</h4>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ********** Component :: Destination Ideas Section End ********** -->

    <!-- ********** Component :: Trending ********** -->
    <div class="c-container with-gray-background">
      <div class="container">
        <h2 class="container-heading">Trending Destinations</h2>

        <div class="c-popularDestinations">
          <div class="grid-section">
            <div
              class="grid"
              style="
                background-image: url('./images/Luggage-Factory-The-Travel-Experts-Destinations-Miami-Flordia-Beach-3-700x466.jpg');
              "
            >
              <span>India</span>
            </div>
            <div
              class="grid"
              style="background-image: url('./images/santorini_1-700x466.jpg')"
            >
              <span>Miami</span>
            </div>
            <div class="grid"><span>Rome</span></div>
            <div class="grid"><span>Tokyo</span></div>
            <div
              class="grid"
              style="
                background-image: url('./images/Luggage-Factory-The-Travel-Experts-Destinations-Miami-Flordia-Beach-3-700x466.jpg');
              "
            >
              <span>India</span>
            </div>
            <div
              class="grid"
              style="background-image: url('./images/santorini_1-700x466.jpg')"
            >
              <span>Miami</span>
            </div>
            <div class="grid"><span>Rome</span></div>
            <div class="grid"><span>Tokyo</span></div>
          </div>
        </div>
      </div>
    </div>
    <!-- ********** Component :: Trending End ********** -->

<?php
include_once "../../../Tours_B2B/layouts/login_footer.php";
?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
$('#currency').select2();
$('#city').select2({minimumInputLength:1});

upload_logo_proof();
function upload_logo_proof(){
    var btnUpload=$('#logo_upload_btn1');
    $(btnUpload).find('span').text('Company Logo');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_logo.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(png|jpg|jpeg)$/.test(ext))){ 
         error_msg_alert('Only PNG,JPG or JPEG files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },
      onComplete: function(file, response){
       // alert(response);
        if(response=="error1"){
            $(btnUpload).find('span').text('Company Logo');
            error_msg_alert('Maximum size exceeds');
            return false;
        }
        else if(response==="error"){
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#logo_upload_url").val(response);
        }
      }
    });
}

upload_address_proof();
function upload_address_proof(){
    var btnUpload=$('#address_upload_btn1');
    $(btnUpload).find('span').text('Address Proof');    

    new AjaxUpload(btnUpload, {
      action: '../inc/upload_address_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  

        if (! (ext && /^(jpg|png|jpeg|pdf)$/.test(ext))){ 
         error_msg_alert('Only PDF,JPG, PNG files are allowed');
         return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },

      onComplete: function(file, response){

        if(response==="error"){          
          error_msg_alert("File is not uploaded.");           
          $(btnUpload).find('span').text('Upload');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#address_upload_url").val(response);
        }
      }
    });
}

upload_id_proof();
function upload_id_proof(){

    var btnUpload=$('#photo_upload_btn_p');
    $(btnUpload).find('span').text('ID Proof');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_photo_proof.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){  
        if (! (ext && /^(pdf|jpg|png|jpeg)$/.test(ext))){ 
          error_msg_alert('Only PDF,JPG, PNG files are allowed');
          return false;
        }
        $(btnUpload).find('span').text('Uploading...');
      },

      onComplete: function(file, response){

        if(response==="error"){          
          error_msg_alert("File is not uploaded.");
          $(btnUpload).find('span').text('Upload');
        }
        else{
          $(btnUpload).find('span').text('Uploaded');
          $("#photo_upload_url").val(response);
        }
      }
    });
}

$(function(){
$('#frm_tab1').validate({
	rules:{
	},
	submitHandler:function(form){
  
  var base_url = $('#base_url').val();
  var company_logo = $("#logo_upload_url").val();
  if(company_logo==''){
    error_msg_alert('Company logo required!'); return false;
  }
  //Basic Details
  var company_name = $("#company_name").val();
  var acc_name = $("#acc_name").val();
  var iata_status = $("#iata_status").val();
  var iata_reg = $("#iata_reg").val();
  var nature = $("#nature").val();
  var currency = $("#currency").val();
  var telephone = $('#telephone').val(); 
  var latitude = $("#latitude").val();
  var turnover_slab = $("#turnover_slab").val();
  var skype_id = $("#skype_id").val();
  var website = $("#website").val(); 

  //Address Details
  var city = $("#city").val();
  var address1 = $("#address1").val(); 
  var address2 = $("#address2").val(); 
  var pincode = $("#pincode").val();
  // var country = $('#country').val();
  var cust_state = $('#cust_state').val();
  var timezone = $('#timezone').val(); 
  var address_upload_url = $('#address_upload_url').val();

  //Contact Person Details
  var contact_personf = $('#contact_personf').val();
  var contact_personl = $('#contact_personl').val();
  var email_id = $('#email_id').val();
  var mobile_no = $('#mobile_no').val();
  var whatsapp_no = $('#whatsapp_no').val();
  var designation = $('#designation').val();
  var pan_card = $('#pan_card').val();
  var photo_upload_url = $('#photo_upload_url').val();

  $('#btn_save').button('loading');
  $.ajax({
      type:'post',
      url: '../../../controller/b2b_customer/reg_customer_save.php',
      data:{ company_name : company_name, acc_name : acc_name, iata_status : iata_status, iata_reg : iata_reg, nature : nature, currency : currency, telephone : telephone, latitude : latitude, turnover_slab : turnover_slab, skype_id : skype_id, website : website, 
      address1 : address1,address2 : address2, city : city , pincode : pincode , state:cust_state, timezone : timezone, address_upload_url : address_upload_url,
      contact_personf : contact_personf , contact_personl : contact_personl,email_id:email_id, mobile_no : mobile_no, whatsapp_no : whatsapp_no, designation : designation, pan_card : pan_card, photo_upload_url : photo_upload_url,company_logo:company_logo},
      success: function(message){
        var data = message.split('--');
        if(data[0] == 'error'){
          error_msg_alert(data[1]); 
          $('#btn_save').button('reset');
          return false;
        }
        else{
          success_msg_alert(message);
          $('#save_modal').modal('hide');
          setInterval(() => {
            window.location.replace('../../../Tours_B2B/login.php');
          },1000);
        }
      }
      });
  }
});
});
</script>
