<form action="<?php echo site_url('courts/update'); ?>" method="post" class="form-horizontal" accept-charset="utf-8">
	<fieldset>
		<legend>Court Information for <?php echo $court['facility_id'];?></legend>
		<div class="control-group">
			<label class="control-label" for="court_name">Court Name</label>
			<div class="controls">
				<input type="text" name="court_name" value="<?php echo $court['name'];?>" id="court_name" placeholder="Court Name">
				<input type="hidden" name="court_id" value="<?php echo $court['id'];?>" id="court_id"/>
				<p class="help-block">Name by which you identify this court.</p>
			</div>
		</div>	
		
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Update</button>
			<button id="cancel" class="btn">Cancel</button>
	    </div>
	</fieldset>


</form>