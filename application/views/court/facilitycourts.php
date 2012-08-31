
<link href="<?php echo base_url();?>assets/css/court_management.css" rel="stylesheet">

<script language="javascript">
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
        })

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




