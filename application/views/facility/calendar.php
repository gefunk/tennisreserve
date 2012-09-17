<link href="<?php echo base_url();?>assets/css/calendar.css" rel="stylesheet">
<script language="javascript" src="<?php echo base_url();?>assets/js/calendar.js"></script>

<script language="javascript">
$(window).load(function(){

	// attach handlers on next and previous buttons
	// attach handlers on click of the date cell
	$("#calendar").on("click","button", function(e){
		$.get(
			$(this).attr('href'),
			function(data){
				$("li#calendar").html(data.calendar);
				selected_year = data.year;
				selected_month = data.month-1;
			},
			'json'
		);
	}).on("click", "td", function(){
		//console.log("Should change the calendar and display reservations");
		selected_day = $(this).text();
		$("a#date").html(monthNames[selected_month]+" "+$(this).text()+'<b class="caret"></b>').parent('li').removeClass('open');
		// hide table
		//$("#reservations").hide();
		//clear reservations
		clear_reservations();
		// display reservations for date
		display_reservations(
				'<?php echo site_url("courts/get_reservations/$facility_id"); ?>',
				 selected_year+'-'+parseInt(selected_month+1)+'-'+selected_day,
				$("#reservations")
		);
	
		
	});
	
	// calendar on the right hand side
	initialize_time_table(
		'<?php echo site_url("facility/get_time_calendar/$facility_id"); ?>', 
		'<?php echo site_url("courts/get_reservations/$facility_id"); ?>'
	);
	
	// moves header and side bar along with user scroll
	attach_scroll_handler();
	
	/**
		user dbl clicks to create a reservation
		handler is registered on div
	**/
	$("#reservations").dblclick(function(e){
		// only act on table cells
		if(e.target.nodeName.toLowerCase() == 'td'){
			make_new_reservation(
				$(e.target), 
				'<?php echo site_url("reserve/make"); ?>', 
				'<?php echo $facility_id ?>'
			);
		}
	});
	

});


function change_reservation (reservation_id, court_id, start_time, end_time) {
    $.post(
		"<?php echo site_url('reserve/update'); ?>",
		{
			id: reservation_id,
			end_time: end_time,
			start_time: start_time,
			court_id: court_id
		}
	);
}

</script>

<div id="heading">
	
</div>
<div id="timings">
	
</div>
<div id="reservations">
	
</div>