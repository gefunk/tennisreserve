<link href="<?php echo base_url();?>assets/css/calendar.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/reservation-info.css" rel="stylesheet">
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
				'<?php echo site_url("reserve/get/$facility_id"); ?>',
				 selected_year+'-'+parseInt(selected_month+1)+'-'+selected_day,
				$("#reservations")
		);
	
		
	});
	
	// attach click handler to any div with booking class
	$(document).on("click","div.booking", function(e){
		e.stopPropagation();
		$(this).addClass('booking-clicked');
		var div_value = $(this).text();
		var position = $(this).offset();
		var width = $(this).width();
		var height = $(this).height();
		console.log("Title Div",$("#res-info").children('div.title'));
		var title_height = parseInt($("#res-info").children('div.title').height());
		console.log("title height", title_height);
		$('#res-info').hide().css(
			{
				left: position.left+width+15,
				top: position.top-title_height-13
			}
		).show();
	});
	
	// calendar on the right hand side
	initialize_time_table(
		'<?php echo site_url("facility/get_time_calendar/$facility_id"); ?>', 
		'<?php echo site_url("reserve/get/$facility_id"); ?>'
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
	
	$("#update_info")
		.hide()
		.ajaxStart(function() {
	        $(this).show();
	    })
	    .ajaxStop(function() {
	        $(this).hide();
	    });
	
	$("#res-info > div.title > button.close").click(function(e){
		$("#res-info").hide();
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

function check_update_reservation () {
    $.ajax({
        url: '<?php echo site_url("reserve/get/$facility_id"); ?>'+
			 "/"+selected_year+'-'+parseInt(selected_month+1)+'-'+selected_day+
			 "/"+last_update_timestamp,
        success: function(data){
			for(var key in data.reservations){
				if(data.reservations.hasOwnProperty(key)){
					// check if div already exists on page
					if($("div#"+key).length){
						var time = data.reservations[key].start_time;
						var court = data.reservations[key].court_id;
						var end_time = data.reservations[key].end_time;
						var $top_cell = $("#reservations > table > tbody > tr#"+time+" > td[court-id="+court+"]");
						var $bottom_cell = $("#reservations > table > tbody > tr#"+end_time+" > td[court-id="+court+"]");
						var go_left = $top_cell.position().left+1;
				        var go_top = $top_cell.position().top;
						$("div#"+key).animate({
				            left: go_left,
				            top: go_top
				        }).height(calculate_height_div($top_cell,$bottom_cell));
					}else{
						// put it on the calendar
						put_reservation_on_calendar (
						    key,
						    data.reservations[key].start_time, 
						    data.reservations[key].end_time, 
						    data.reservations[key].court_id
						);
					}
				}
			}
			
			last_update_timestamp = data.timestamp;
			
        },
        complete: function(){
            // Schedule the next request when the current one's complete
            setTimeout(check_update_reservation, 15000);
			$("#update_info").hide();
        },
		dataType: "json"
    });
}

</script>
<div id='update_info' class='alert alert-info'>Loading</div>

<div id="res-info">
	<div class="title">
		<button class="close">x</button>
		<h3>Reservation Info</h3>
	</div>
	<div id="left-arrow">
	</div>
	<div class="content">
		<label for="player_name">Player Name</label>
		<input type="text" name="player_name" value="" placeholder="type player name" id="player_name">
		<button class="btn btn-primary">Add Player</button>
		<table class="table table-condensed" cellspacing="5" cellpadding="5">
			<tr><td>Rahul Gokulnath</td><td><button class="btn btn-mini">Delete</button></tr>
			<tr><td>Mike Floyd</td><td><button class="btn btn-mini">Delete</button></tr>
		</table>
	</div>
	<div class="controls">
		<button class='btn btn-primary'>Delete</button>
	</div>
</div>

<div id="heading">
	
</div>
<div id="timings">
	
</div>
<div id="reservations">
	
</div>