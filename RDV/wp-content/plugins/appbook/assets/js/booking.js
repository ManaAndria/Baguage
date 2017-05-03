jQuery(document).ready(function(){
	jQuery('#booking').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		navLinks: true, 
		editable: false,
		eventLimit: true,
		defaultDate: bookingObject.defaultDate,
		events: JSON.parse(bookingObject.events)
	});
});