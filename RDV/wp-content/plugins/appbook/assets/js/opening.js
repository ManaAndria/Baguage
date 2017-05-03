jQuery(document).ready(function(){
	jQuery('body').on('click', '.add-service', function(e){
		var vis = jQuery(this);
		jQuery(this).button('loading');
		jQuery('#add-service').modal('hide');
		var day = jQuery(this).data('day');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_new,
		        'day': day
		    }, 
		    function(response){
				vis.button('reset');
				jQuery('.alert').alert('close');
				jQuery('#add-edit-title').text('Ajouter un service');
		        jQuery('#add-service .modal-body').html(response);
		        jQuery('#add-service').modal('show');
		    }
		);
	});
	jQuery('#add-service').on('hide.bs.modal', function(e){
		jQuery('#add-service .modal-body').html('');
	});

	// edit
	jQuery('body').on('click', '.edit-service', function(e){
		var vis = jQuery(this);
		jQuery(this).button('loading');
		jQuery('#add-service').modal('hide');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
		    	vis.button('reset');
				jQuery('.alert').alert('close');
		    	jQuery('#add-edit-title').text('Modifier un service');
		        jQuery('#add-service .modal-body').html(response);
		        jQuery('#add-service').modal('show');
		    }
		);
	});

	// delete
	jQuery('body').on('click', '.delete-service', function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#opening_id').val(dataId);
	});

	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#opening_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    openingObject.ajaxurl, 
		    {
		        'action': openingObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	console.log(response);
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#opening_id').val('');
		    }
		);
	});
	jQuery('#confirmDelete').on('hide.bs.modal', function(e){
		jQuery('#opening_id').val('');
	});

	// submit
	jQuery('body').on('click', '#confirm-add', function(){
		var format = formatDate();
		if(format)
		{
			if (jQuery('#edit-service').length)
				jQuery('#edit-service').submit();
			else if(jQuery('#new-service').length)
				jQuery('#new-service').submit();
		}
	});
	function formatDate()
	{
		var startHour = jQuery('#start-hour').val();
		var newStartHour = startHour.split('');
		if(newStartHour.length == 1)
			jQuery('#start-hour').val('0'+startHour);

		var startMinute = jQuery('#start-minute').val();
		var newStartMinute = startMinute.split('');
		if (newStartMinute.length == 1)
			jQuery('#start-minute').val('0'+startMinute);

		var endHour = jQuery('#end-hour').val();
		var newEndHour = endHour.split('');
		if(newEndHour.length == 1)
			jQuery('#end-hour').val('0'+endHour);

		var endMinute = jQuery('#end-minute').val();
		var newEndMinute = endMinute.split('');
		if (newEndMinute.length == 1)
			jQuery('#end-minute').val('0'+endMinute);
		
		return true;
	}
});