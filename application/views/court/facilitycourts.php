
<link href="<?php echo base_url();?>assets/css/court_management.css" rel="stylesheet">
<script language="javascript" src="<?php echo base_url();?>assets/js/reservations.js"></script>

<script language="javascript">

    $(document).ready(function(){
<<<<<<< HEAD
	
        
		$("table#time").droppable({
			hoverClass: 'ui-state-active',
			drop: change_reservation
		});

		$("#courts > li").click(function(e){
=======
        $("#courts > li").click(function(e){
			//hide the save success or failure message if it's showing on the screen
			$("#court_info_alert").fadeOut();
>>>>>>> Minor display stuff
            $(this).addClass('active').siblings('li').removeClass('active');
            var courtId = this.id;
            $.post('<?php echo site_url("courts/view");?>' + '/' + courtId, function(data){
                $('#court-info-tabs a[href="#court-information"]').tab('show');
                $("#court_name").val(data.name);
				$("#court_id").val(data.id);
				$("#court_type_" + data.court_type).button('toggle');
				$("#lights_" + data.lights).button('toggle');
            },'json');
        });

		// calendar on the right hand side
		initialize_calendar('<?php echo site_url("courts/get_calendar"); ?>', '<?php echo site_url("courts/get_reservations"); ?>');
		// gray out times which are closed
		gray_out_closed_times('<?php echo site_url("courts/get_facility_times/10") ?>');
		
		/**
			handle any clicks on the month-calendar div
			this can be clicks on the next / prev month button
			or a day within the month
		**/
		$("#month-calendar").on('click', function(e){

			var nodeName = e.target.nodeName.toLowerCase();
			// check if user clicked on a next or previous month button
			if(nodeName == 'button'){
				var url = $(e.target).attr('get_url');
				$.get(
					url,
					function(data){
						$("#month-calendar > table").remove();
						$(data.calendar).hide().appendTo("#month-calendar").fadeIn();
						selected_month = data.month;
						selected_year = data.year;
					},
					"json"
				);
			}
			// user clicked within a month inside the calendar
			else if(nodeName == 'td'){
				// remove selected class from old td
				if(clicked_day)
					$(clicked_day).removeClass('selected');
				// add selected to new td
				$(e.target).addClass('selected');
				clicked_day = e.target;
				//change the date on the headings

				var click_date = new Date(selected_year, parseInt(selected_month,10)-1, $(e.target).html(), 0, 0, 0);
				var day_header = monthNames[parseInt(selected_month,10)-1] +' '+$(e.target).html();
				$("#calendar-title").hide()
					.html("<h1>"+day_header+"</h1><h4>"+weekday[click_date.getDay()]+"</h4>")
					.fadeIn();
				selected_day = click_date.getDate();
			}
		});
		
		/*
			Handles user adding a reservation to the time table
			When a row is clicked it adds a div to the clicked row
			when the a second row is clicked it extends the div to that row
		*/
		$("table#time tr").dblclick(function(e){
			/*
				check if this is a valid time
			*/
			if(!$(this).hasClass('not-available') && !($(this).is(':first-child'))){
				new_reservation($(e.target), this, '<?php echo site_url("courts/start_reservation"); ?>');
			}
		});// end click time calendar tr click
		
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
<<<<<<< HEAD
			).fadeIn();
		});
		
		$("#res-info > div.title > button.close").click(function(e){
			$("#res-info").fadeOut();
		});



<<<<<<< HEAD
=======
			},
			function(e){
				$(this).children('td:eq(1)').css('background-color','');
			}
		);
		
		//if the close button on the success/failure message is selected, fade the message out
		$("#close_alert").click(function(e){
			$("#court_info_alert").fadeOut();
		});
		
		//ajax save of the court information
>>>>>>> Minor display stuff
		$("#court_info_form").submit(function(event) {
			//prevent the default form submit
			event.preventDefault(); 
			$.post('<?php echo site_url("courts/update");?>', {
				//set the post values from the court information form
					court_id : $("#court_id").val(),
					court_name : $("#court_name").val(),
					court_type : $("#court_type_buttons > button.active").attr('court_type'),
					lights : $("#lights_avail_buttons > button.active").attr('lights')
					
				}, 
				function(data){
				 	$("#court_name_" + $("#court_id").val()).text(data);
					$("#court_info_alert").fadeIn();
			}, "json");
		});

    });
=======
>>>>>>> Updated bunches of stuff - calendar most important

    });// document .ready


	

	
	
</script>


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

<h2>Court Management</h2>

<div class="row">
<div class="span3">
    <ul id="courts" class="nav nav-pills nav-stacked">
        <?php foreach ($courts as $court):?>
			
            <li id="<?php echo $court['id'];?>">
            <a href="#">
                <img src="<?php echo base_url(); ?>assets/img/<?php echo $court['court_type_name'];?>_court.png" />
                <span class="court-text"><?php echo $court['number']; ?></span>
				<br/>
				<small id="court_name_<?php echo $court['id'];?>"><?php echo $court['name'];?></small>
            </a>
        </li>
        <?php endforeach?>
    </ul>
</div><!-- end left column -->
<div class="span9">

<ul class="nav nav-tabs" id="court-info-tabs">
    <li><a href="#court-information" data-toggle="tab">Information</a></li>
    <li class="active"><a href="#court-calendar" data-toggle="tab">Calendar</a></li>
</ul>
<div class="tab-content">

<div id="court-information" class="tab-pane">

	<form action="<?php echo site_url('courts/update'); ?>" id="court_info_form" method="post" accept-charset="utf-8">
		<fieldset>
			<legend>Court Information</legend>
			<div id="court_info_alert" class="alert success hide fade in">
				<button class="close" id="close_alert" type="button">×</button>
				<strong>Success.</strong>
				Your changes to the court information were saved!
			</div>
			<div class="control-group">
				<label class="control-label" for="court_name">Court Name</label>
				<div class="controls">
					<input type="text" name="court_name" value="court_name" id="court_name" placeholder="Court Name">
					<input type="hidden" name="court_id" value="court_id" id="court_id"/>
				</div>
			</div>
			<div class="control-group">
				<label>Court Type</label>
				<div class="controls">
					<div id="court_type_buttons" class="btn-group" data-toggle="buttons-radio">
						<button id="court_type_1" court_type="1" type="button" class="btn">Hard</button>
						<button id="court_type_2" court_type="2" type="button" class="btn">Clay</button>
						<button id="court_type_3" court_type="3" type="button" class="btn">Grass</button>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label>Lights</label>
				<div class="controls">
					<div id="lights_avail_buttons" class="btn-group" data-toggle="buttons-radio">
						<button id="lights_1" lights="1" type="button" class="btn">Available</button>
						<button id="lights_0" lights="0" type="button" class="btn">Not Available</button>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Update</button>
				<button id="cancel" class="btn">Cancel</button>
		    </div>
		</fieldset>
	</form>
</div>
<!-- end court information -->
<div id="court-calendar" class="tab-pane active">

		<table id="time" class="table table-hover table-bordered" cellspacing="5" cellpadding="5">
			<tr>
				<th></th>
				<th>Court 1</th>
				<th>Court 2</th>
			</tr>
			<tr id="00_00">
				<td>12 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="00_30">
				<td>12:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="01_00">
				<td>1 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="01_30">
				<td>1:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="02_00">
				<td>2 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="02_30">
				<td>2:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="03_00">
				<td>3 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="03_30">
				<td>3:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="04_00">
				<td>4 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="04_30">
				<td>4:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="05_00">
				<td>5 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="05_30">
				<td>5:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="06_00">
				<td>6 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="06_30">
				<td>6:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="07_00">
				<td>7 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="07_30">
				<td>7:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="08_00">
				<td>8 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="08_30">
				<td>8:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="09_00">
				<td>9 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="09_30">
				<td>9:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="10_00">
				<td>10 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="10_30">
				<td>10:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="11_00">
				<td>11 AM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="11_30">
				<td>11:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="12_00">
				<td>12 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="12_30">
				<td>12:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="13_00">
				<td>1 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="13_30">
				<td>1:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="14_00">
				<td>2 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="14_30">
				<td>2:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="15_00">
				<td>3 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="15_30">
				<td>3:30</td>
				<td></td>
				<td></td>
			</tr>
			
			<tr id="16_00">
				<td>4 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="16_30">
				<td>4:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="17_00">
				<td>5 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="17_30">
				<td>5:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="18_00">
				<td>6 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="18_30">
				<td>6:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="19_00">
				<td>7 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="19_30">
				<td>7:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="20_00">
				<td>8 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="20_30">
				<td>8:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="21_00">
				<td>9 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="21_30">
				<td>9:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="22_00">
				<td>10 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="22_30">
				<td>10:30</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="23_00">
				<td>11 PM</td>
				<td></td>
				<td></td>
			</tr>
			<tr id="23_30">
				<td>11:30</td>
				<td></td>
				<td></td>
			</tr>
	</table>
	<div id="month-calendar">
		<div id="calendar-title">
			<h1>Aug 30</h1>
			<h4>Thursday</h4>
		</div>
		
	</div>
	
</div><!-- end court calendar tab -->
</div><!-- end tab content -->

</div><!-- end span 9 -->
</div>




