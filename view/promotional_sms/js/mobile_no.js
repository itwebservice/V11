function mobile_no_edit_modal(mobile_no_id){
	
	$('#edit-'+mobile_no_id).prop('disabled',true);
	$('#edit-'+mobile_no_id).button('loading');
	$.post('mobile_no/mobile_no_edit_modal.php', { mobile_no_id : mobile_no_id }, function(data){
		$('#div_mobile_no_edit_content').html(data);
		$('#edit-'+mobile_no_id).prop('disabled',false);
		$('#edit-'+mobile_no_id).button('reset');
	});

}
