<link href="<?php echo base_url();?>assets/css/court_management.css" rel="stylesheet">

<script language="javascript">
	$(document).ready(function(){
		$("#courts > li").click(function(e){
			$(this).addClass('active').siblings('li').removeClass('active');
		})
		
	});

</script>

<h2>Court Management</h2>

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
				<div id="calendar-title">
					<h2>Thursday, Aug 30</h2>
				</div>
				<div id="calendar-container">
					<table id="calendar" class="table table-bordered table-hover" cellspacing="5" cellpadding="5">
						<tr>
							<td>12 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>12:30</td>
							<td></td>
						</tr>
						<tr>
							<td>1 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>1:30</td>
							<td></td>
						</tr>
						<tr>
							<td>2 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>2:30</td>
							<td></td>
						</tr>
						<tr>
							<td>3 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>3:30</td>
							<td></td>
						</tr>
						<tr>
							<td>4 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>4:30</td>
							<td></td>
						</tr>
						<tr>
							<td>5 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>5:30</td>
							<td></td>
						</tr>
						<tr>
							<td>6 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>6:30</td>
							<td></td>
						</tr>
						<tr>
							<td>7 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>7:30</td>
							<td></td>
						</tr>
						<tr>
							<td>8 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>8:30</td>
							<td></td>
						</tr>
						<tr>
							<td>9 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>9:30</td>
							<td></td>
						</tr>
						<tr>
							<td>10 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>10:30</td>
							<td></td>
						</tr>
						<tr>
							<td>11 AM</td>
							<td></td>
						</tr>
						<tr>
							<td>11:30</td>
							<td></td>
						</tr>
						<tr>
							<td>12 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>12:30</td>
							<td></td>
						</tr>
						<tr>
							<td>1 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>1:30</td>
							<td></td>
						</tr>
						<tr>
							<td>2 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>2:30</td>
							<td></td>
						</tr>
						<tr>
							<td>3 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>3:30</td>
							<td></td>
						</tr>
						<tr>
							<td>4 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>4:30</td>
							<td></td>
						</tr>
						<tr>
							<td>5 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>5:30</td>
							<td></td>
						</tr>
						<tr>
							<td>6 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>6:30</td>
							<td></td>
						</tr>
						<tr>
							<td>7 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>7:30</td>
							<td></td>
						</tr>
						<tr>
							<td>8 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>8:30</td>
							<td></td>
						</tr>
						<tr>
							<td>9 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>9:30</td>
							<td></td>
						</tr>
						<tr>
							<td>10 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>10:30</td>
							<td></td>
						</tr>
						<tr>
							<td>11 PM</td>
							<td></td>
						</tr>
						<tr>
							<td>11:30</td>
							<td></td>
						</tr>
					</table>
				</div>
				
			</div><!-- end court calendar tab -->
		</div><!-- end tab content -->
		
	</div><!-- end span 9 -->
</div>