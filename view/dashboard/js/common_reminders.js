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