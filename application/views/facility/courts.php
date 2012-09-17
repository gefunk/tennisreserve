<link href="<?php echo base_url();?>assets/css/court_management.css" rel="stylesheet">

<script language="javascript">
var clicked_row = null;
var row_index = null;

var clicked_day = null;

var monthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];

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
		});
		
		$('#calendar-container').on('click','div.booking', function(){
			var div_value = $(this).children('p').text();
			var options = {
				animation: true,
				html: true,
				trigger: 'click',
				placement: 'right',
				title: div_value,
				content: div_value,
				delay: { show: 500, hide: 100 }
			}
			$(this).popover(options);
		});
		
	});

</script>

<h2>Court Management</h2>
<div class="popover right">
	<div class="arrow"></div>
	<h3 class="popover-title">Popover right</h3>
	<div class="popover-content">
		<p>Sed posuere consectetur est at lobortis. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>
		<button>Cancel</button>
		<button>Save</button>
	</div>
</div>
<div class="row">
	<div class="span3">
		<ul id="courts" class="nav nav-pills nav-stacked">
			<li class="active">
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/clay_court.png" />
					<span class="court-text">Court 1</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/clay_court.png" />
					<span class="court-text">Court 2</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/clay_court.png" />
					<span class="court-text">Court 3</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/clay_court.png" />
					<span class="court-text">Court 4</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/hard_court.png" />
					<span class="court-text">Court 5</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/hard_court.png" />
					<span class="court-text">Court 6</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/hard_court.png" />
					<span class="court-text">Court 7</span>
				</a>
			</li>
			<li>
				<a href="#">
					<img src="<?php echo base_url(); ?>assets/img/hard_court.png" />
					<span class="court-text">Court 8</span>
				</a>
			</li>
		</ul>
	</div><!-- end left column -->
	<div class="span9">

		<ul class="nav nav-tabs">
			<li><a href="#court-information" data-toggle="tab">Information</a></li>
			<li class="active"><a href="#court-calendar" data-toggle="tab">Calendar</a></li>
		</ul>
		<div class="tab-content">
			<div id="court-information" class="tab-pane">
				<div class="control-group">
					<label class="control-label" for="court_name">Court Name</label>
					<div class="controls">
						<input type="text" name="court_name" value="" id="court_name" placeholder="Court Name">
					</div>
				</div>
				<div class="control-group">
					<label>Court Type</label>
					<div class="controls">
						<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn">Hard</button>
							<button type="button" class="btn">Clay</button>
							<button type="button" class="btn">Grass</button>
						</div>
					</div>
				</div>
				<div class="control-group">
				<label>Lights</label>
					<div class="controls">
						<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn">Available</button>
							<button type="button" class="btn">Not Available</button>
						</div>
					</div>
				</div>
			</div><!-- end court information -->
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