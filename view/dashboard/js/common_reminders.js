function passport_renewal_reminder(contact_no,cust_name,pass_name,exp_date){
    
    var msg = encodeURI("Dear " + cust_name + ",\n\nTour passenger passport is expiring soon. Please renew before it gets expired.\n*Passenger Name* : "+pass_name+"\n*Expiry Date* : "+exp_date);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function customer_birthday_reminder(contact_no,cust_name){

    var msg = encodeURI("Dear " + cust_name + ",\n\nWe wish you a very *Happy Birthday*!\nMay you have a great day today and enjoy the day with endless happiness. Good luck to you!");
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function happy_journey_reminder(contact_no,cust_name,data){

    var msg = encodeURI("Dear " + cust_name + ",\n\nWe hope all your bags are packed.\nWishing you a very *Happy Journey* and May you create the most cherishing moments of your life on this trip.\n"+data);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function customer_feedback_reminder(type,id,customer_id,contact_no,cust_name,data){
    
    var base_url = $('#base_url').val();
    if(type == 'package'){
        var type = 'Package Booking';
    }else{
        var type = 'Group Booking';
    }
    var params = encodeURIComponent("customer_id="+customer_id+"&booking_id="+id+"&tour_name="+type);
    var link = base_url+"view/customer/other/customer_feedback/customer_feedback_form.php?"+params;

    var msg = encodeURI("Dear " + cust_name + ",\n\nWe would be very grateful to you if you take a couple of minutes to complete our online feedback form..\n"+data+"\n\n*Feedback Link* : "+link);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function task_reminder(contact_no,cust_name,data){

    var msg = encodeURI("Dear " + cust_name + ",\n\nThis is an assigned task reminder. Please check it in the system..\n"+data);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function user_anniversary_reminder(contact_no,cust_name){
    
    var msg = encodeURI("Dear " + cust_name + ",\n\nWe wish you a very *Happy Anniversary*!\nWe extend our best wishes to you on your anniversary. We thank you for your enduring loyalty and diligence.");
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function user_followup_reminder(contact_no,cust_name,data){
    
    var msg = encodeURI("Dear " + cust_name + ",\n\nPlease note todays leads follow-up reminder!\n\n*Enquiries* : "+data);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function daily_summary_reminder(contact_no,cust_name,today_date){
    
    var base_url = $('#base_url').val();
    var link = base_url+"model/remainders/weekly_summary_html.php?cur_date="+today_date;
    var msg = encodeURI("Dear " + cust_name + ",\n\nPlease find the Daily summary report!\n\n*Link* : "+link);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}
function tax_pay_reminder(contact_no,cust_name,today_date){
    
    var msg = encodeURI("Dear " + cust_name + ",\n\nYour tax pay due date is coming soon!\n\n*Tax Pay Date* : "+today_date);
	window.open('https://web.whatsapp.com/send?phone=' + contact_no + '&text=' + msg);
}