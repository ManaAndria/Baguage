jQuery(function(){
	jQuery('#start').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#end').datepicker('option', 'minDate', value);
		}
	});
	jQuery('#end').datepicker({
		dateFormat: 'dd-mm-yy',
		changeYear: true,
		changeMonth: true,
		onClose: function(value){
			jQuery('#start').datepicker('option', 'maxDate',value);
		}
	});
	jQuery(document).ready(function() {
        jQuery('#services').multiselect({
        	allSelectedText: 'Tous',
        	numberDisplayed: 1,
        	nSelectedText: 'selectionnés',
        	nonSelectedText: 'Aucun'
        });
    });
});

var ctx = document.getElementById("canvas-stats");
var myChart = new Chart(ctx, {
		type: 'line',
		data: JSON.parse(statsObject.data),
		options: {
            responsive: true,
        }
});