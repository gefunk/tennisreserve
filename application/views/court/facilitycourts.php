
<link href="<?php echo base_url();?>assets/css/court_management.css" rel="stylesheet">

<script language="javascript">



var clicked_row = null;
var row_index = null;

var clicked_day = null;
// month lookup 
var monthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];
// day of week lookup
var weekday=new Array(7);
weekday[0]="Sunday";
weekday[1]="Monday";
weekday[2]="Tuesday";
weekday[3]="Wednesday";
weekday[4]="Thursday";
weekday[5]="Friday";
weekday[6]="Saturday";


    $(document).ready(function(){
        $("#courts > li").click(function(e){
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

		
		// keep track of the month selected on the page
		var selected_month = null;
		var selected_year = null;
		
		/**
			get the month calendar on page load
		**/
		$.get(
			'<?php echo site_url("courts/get_calendar"); ?>',
			function(data){
				$("#month-calendar").append(data.calendar);
				selected_month = data.month;
				selected_year = data.year;
			},
			"json"
		);
		
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
			}
		});
		
		/*
			Handles user adding a reservation to the time table
			When a row is clicked it adds a div to the clicked row
			when the a second row is clicked it extends the div to that row
		*/
		$("table#calendar tr").click(function(e){
			// check if there already been a row clicked
			if(!clicked_row){
				/* 
					there hasn't been a table row clicked, 
					set the clicked_row variable to equal the currently clicked row
				*/
				clicked_row = this;
				// get the table cell, position
				var tdcell = $(this).children('td:eq(1)');
				var col_position = $(tdcell).position();
				// get the table position so we can calcuate the relative position
				var table_calendar_position = $("table#calendar").position();
				// calculate the top location of where the iv should be added
				var top = Math.abs(table_calendar_position.top-col_position.top)+3;
				// add the div to the page on top of the table
				$("#calendar-container > table").before('<div id="booking_example" class="booking" rel="popover" style="top:'+top+'px;left:'+(col_position.left+5)+'px;height:'+$(tdcell).css('height')+';width:'+($(tdcell).width()-10)+'px"><p>Rahul Gokulnath and Pritesh Parekh</p></div>');
			}else{
				// get the cell where the div should end on
				var tdcell = $(this).children('td:eq(1)');
				// calculate the position of the cell
				var col_position = $(tdcell).position();

				// get the div and the position of the div
				var booking_div = $("#booking_example");
				var booking_position = $(booking_div).position();
				// set the div height to the end div
				$(booking_div).height(Math.abs((col_position.top+$(tdcell).height()) - booking_position.top));
				// clear the clicked_row variable
				clicked_row = null;
			}
		}).hover(
			function(e){
				if(clicked_row){
					$(this).children('td:eq(1)').css('background-color','LightSkyBlue');
				}
			},
			function(e){
				$(this).children('td:eq(1)').css('background-color','');
			}
		);

    });

</script>

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
				<small><?php echo $court['name'];?></small>
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
	<form action="<?php echo site_url('courts/update'); ?>" method="post" accept-charset="utf-8">
		<fieldset>
			<legend>Court Information</legend>
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
					<div class="btn-group" data-toggle="buttons-radio">
						<button id="court_type_1" type="button" class="btn">Hard</button>
						<button id="court_type_2"  type="button" class="btn">Clay</button>
						<button id="court_type_3"   type="button" class="btn">Grass</button>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label>Lights</label>
				<div class="controls">
					<div class="btn-group" data-toggle="buttons-radio">
						<button id="lights_1" type="button" class="btn">Available</button>
						<button id="lights_0" type="button" class="btn">Not Available</button>
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

	<div id="calendar-container">
		<table id="calendar" class="table table-hover" cellspacing="5" cellpadding="5">
			<tr id="00_00">
				<td>12 AM</td>
				<td></td>
			</tr>
			<tr id="00_30">
				<td>12:30</td>
				<td></td>
			</tr>
			<tr id="01_00">
				<td>1 AM</td>
				<td></td>
			</tr>
			<tr id="01_30">
				<td>1:30</td>
				<td></td>
			</tr>
			<tr id="02_00">
				<td>2 AM</td>
				<td></td>
			</tr>
			<tr id="02_30">
				<td>2:30</td>
				<td></td>
			</tr>
			<tr id="03_00">
				<td>3 AM</td>
				<td></td>
			</tr>
			<tr id="03_30">
				<td>3:30</td>
				<td></td>
			</tr>
			<tr id="04_00">
				<td>4 AM</td>
				<td></td>
			</tr>
			<tr id="04_30">
				<td>4:30</td>
				<td></td>
			</tr>
			<tr id="05_00">
				<td>5 AM</td>
				<td></td>
			</tr>
			<tr id="05_30">
				<td>5:30</td>
				<td></td>
			</tr>
			<tr id="06_00">
				<td>6 AM</td>
				<td></td>
			</tr>
			<tr id="06_30">
				<td>6:30</td>
				<td></td>
			</tr>
			<tr id="07_00">
				<td>7 AM</td>
				<td></td>
			</tr>
			<tr id="07_30">
				<td>7:30</td>
				<td></td>
			</tr>
			<tr id="08_00">
				<td>8 AM</td>
				<td></td>
			</tr>
			<tr id="08_30">
				<td>8:30</td>
				<td></td>
			</tr>
			<tr id="09_00">
				<td>9 AM</td>
				<td></td>
			</tr>
			<tr id="09_30">
				<td>9:30</td>
				<td></td>
			</tr>
			<tr id="10_00">
				<td>10 AM</td>
				<td></td>
			</tr>
			<tr id="10_30">
				<td>10:30</td>
				<td></td>
			</tr>
			<tr id="11_00">
				<td>11 AM</td>
				<td></td>
			</tr>
			<tr id="11_30">
				<td>11:30</td>
				<td></td>
			</tr>
			<tr id="12_00">
				<td>12 PM</td>
				<td></td>
			</tr>
			<tr id="12_30">
				<td>12:30</td>
				<td></td>
			</tr>
			<tr id="13_00">
				<td>1 PM</td>
				<td></td>
			</tr>
			<tr id="13_30">
				<td>1:30</td>
				<td></td>
			</tr>
			<tr id="14_00">
				<td>2 PM</td>
				<td></td>
			</tr>
			<tr id="14_30">
				<td>2:30</td>
				<td></td>
			</tr>
			<tr id="15_00">
				<td>3 PM</td>
				<td></td>
			</tr>
			<tr id="15_30">
				<td>3:30</td>
				<td></td>
			</tr>
			<tr id="16_00">
				<td>4 PM</td>
				<td></td>
			</tr>
			<tr id="16_30">
				<td>4:30</td>
				<td></td>
			</tr>
			<tr id="17_00">
				<td>5 PM</td>
				<td></td>
			</tr>
			<tr id="17_30">
				<td>5:30</td>
				<td></td>
			</tr>
			<tr id="18_00">
				<td>6 PM</td>
				<td></td>
			</tr>
			<tr id="18_30">
				<td>6:30</td>
				<td></td>
			</tr>
			<tr id="19_00">
				<td>7 PM</td>
				<td></td>
			</tr>
			<tr id="19_30">
				<td>7:30</td>
				<td></td>
			</tr>
			<tr id="20_00">
				<td>8 PM</td>
				<td></td>
			</tr>
			<tr id="20_30">
				<td>8:30</td>
				<td></td>
			</tr>
			<tr id="21_00">
				<td>9 PM</td>
				<td></td>
			</tr>
			<tr id="21_30">
				<td>9:30</td>
				<td></td>
			</tr>
			<tr id="22_00">
				<td>10 PM</td>
				<td></td>
			</tr>
			<tr id="22_30">
				<td>10:30</td>
				<td></td>
			</tr>
			<tr id="23_00">
				<td>11 PM</td>
				<td></td>
			</tr>
			<tr id="23_30">
				<td>11:30</td>
				<td></td>
			</tr>
		</table>
	</div>
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




