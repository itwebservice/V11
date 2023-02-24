<?php
include '../model/model.php';
global $app_name;
include_once "layouts/login_header.php";
?>

  <!-- ********** Component :: Login Page ********** -->
  <div class="clearfix">
    <div class="c-loginFullpage">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-lg-8 col-sm-12">
            <div class="m20-btm">
              <div class="creative-heading md">Welcome to</div>
              <div class="creative-heading lg uppercase">Summer season</div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-12">
            <form id="frm_login" method='post'>
              <div class="loginWindow">
                <h3 class="c-heading">Agent Login<pre> Discover a competitive pricing</pre></h3>
                <div class="form-group">
                  <div class="c-select2DD">
                    <input type="text" class="c-textbox rounded" placeholder="*Agent Code" id='agent_code'/>
                  </div>
                </div>
                <div class="form-group">
                  <div class="c-select2DD">
                    <input type="text" class="c-textbox rounded" placeholder="*User Name" id='user_name'/>
                  </div>
                </div>
                <div class="form-group">
                  <div class="c-select2DD">
                    <input type="password" class="c-textbox rounded" placeholder="*Password" id='password'/>
                      <label class="c-buttonLink" id='send_btn' onclick="show_password('password');">View Password?</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-group c-checkbox">
                      <!-- <input type="checkbox" class="form-check-input" id="remindCheckbox" /> -->
                      <!-- <label onclick="show_password('password')" class="form-check-label" for="remindCheckbox">View Password</label> -->
                    </div>
                  </div>
                  <div class="col text-right">
                    <button type="button" class="c-buttonLink" id='send_btn' onclick="open_modal();">Forgot Password?</button>
                  </div>
                </div>
                <div class="form-group type-1">
                  <button class="c-button lg rounded" id="sign_in">Login</button>
                </div>
              </div>
            </form>
            <div id='div_modal'></div>
            <div id="site_alert"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ********** Component :: Login Page End ********** -->
<?php
include_once "layouts/login_footer.php";
?>
<Script>
//(Local+Seesion)Storage Data clearance
window.onload = function () {
  if (typeof Storage !== 'undefined') {
    if (localStorage) {
      localStorage.clear();
    } if (sessionStorage) {
      sessionStorage.clear();
    }
  }
};
function show_password(password) {
	var x = document.getElementById(password);
	if (x.type === 'password') {
		x.type = 'text';
		x.placeholder = '*Enter password!';
	}
	else {
		x.type = 'password';
	}
}
function open_modal(){
  var base_url = $('#base_url').val();
	$.post(base_url+'view/b2b_customer/registration/forgot_password_link.php', { }, function(data){
			$('#div_modal').html(data);
	});
} 
$('#frm_login').validate({
  rules:{
  },
  submitHandler:function(form){
    
    $('#sign_in').prop('disabled',true);

    var base_url = $('#base_url').val();
    var agent_code = $('#agent_code').val();
    var username = $('#user_name').val();
    var password = $('#password').val();
    if(agent_code == ''){
      $('#sign_in').prop('disabled',false);
      $('#sign_in').button('reset');
      error_msg_alert("Enter Agent Code!");
      return false;
    }
    if(username == ''){
      $('#sign_in').prop('disabled',false);
      $('#sign_in').button('reset');
      error_msg_alert("Enter Username!");
      return false;
    }
    if(password == ''){
      $('#sign_in').prop('disabled',false);
      $('#sign_in').button('reset');
      error_msg_alert("Enter Password!");
      return false;
    }
    $('#sign_in').button('loading');
    $.post(base_url+'controller/b2b_customer/login/login_verify.php', { agent_code:agent_code,username : username, password : password }, function(data){
      $('#sign_in').prop('disabled',false);
      $('#sign_in').button('reset');
        var data1 = data.split('--');
        if(data1[0]=="valid"){
          var global_currency = $('#global_currency').val();
          if (typeof Storage !== 'undefined') {
            if (localStorage) {
              localStorage.setItem(
                'global_currency', global_currency
              );
            } else {
              window.sessionStorage.setItem(
                'global_currency', global_currency
              );
            }
          }
          if (typeof Storage !== 'undefined') {
            console.log(JSON.parse((data1[1])));
            if (localStorage) {
              var cart_list_arr = (JSON.parse(data1[1]) == "") ? JSON.stringify([]) : JSON.parse(data1[1]);
              localStorage.setItem('cart_list_arr',cart_list_arr);
              var cart_item_list = [];
              localStorage.setItem('cart_item_list',JSON.stringify(cart_item_list));
            }
          }
          window.location.href = "view/index.php";
        } 
        else{
          error_msg_alert(data1[0]);
        }
    });
  }
});
</script>
