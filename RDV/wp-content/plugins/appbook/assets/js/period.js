jQuery(document).ready(function(){
	jQuery('.period-new').click(function(e){
		jQuery(this).button('loading');
		var employee = jQuery(this).data('employee');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_new,
		        'data': employee
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#period').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-period').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#period').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-period').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#period_id').val(dataId);
	});

	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#period_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    periodObject.ajaxurl, 
		    {
		        'action': periodObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#period_id').val('');
		    }
		);
	});

	// submit
	jQuery('body').on('submit', '#appbook_app_period_edit', function(){
		var res = formatPeriod();
		if($res == true)
			return true;
	});
	jQuery('body').on('submit', '#appbook_app_period_new', function(){
		return formatPeriod();
	});
	function formatPeriod()
	{
		var hour = jQuery('#hour').val();
		var minute = jQuery('#minute').val()
		var newHour = hour.split('');
		if(newHour.length == 1)
			jQuery('#hour').val('0'+hour);
		var newMinute = minute.split('');
		if (newMinute.length == 1)
			jQuery('#minute').val('0'+minute);
		return true;
	}
});