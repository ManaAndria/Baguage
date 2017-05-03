jQuery(document).ready(function(){	
	jQuery('#closing-new').click(function(e){
		jQuery(this).button('loading');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_new,
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#closing').html(response);
		    }
		);
	});

	// edit
	jQuery('button.edit-closing').click(function(e){
		jQuery(this).button('loading');
		var dataId = jQuery(this).data('id');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_edit,
		        'data': dataId
		    }, 
		    function(response){
				jQuery('.alert').alert('close');
		        jQuery('#closing').html(response);
		    }
		);
	});

	// delete
	jQuery('button.delete-closing').click(function(e){
		var dataId = jQuery(this).data('id');
		jQuery('#closing_id').val(dataId);
	});
	jQuery('button#confirm-delete').click(function(e){
		var id = jQuery('#closing_id').val();
		jQuery('#confirmDelete').modal('hide');
		jQuery.post(
		    closingObject.ajaxurl, 
		    {
		        'action': closingObject.action_delete,
		        'data': id
		    }, 
		    function(response){
		    	if (response == "1")
		        	jQuery('#'+id).remove();
		        else
		        	alert('Erreur suppression');
				
				jQuery('#closing_id').val('');
		    }
		);
	});
});