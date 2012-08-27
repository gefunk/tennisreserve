<script language="javascript">
	$(document).ready(function(){
		console.log("jquery document ready");
		$("#cancel").click(function(e){
			console.log("I was fired ");
			window.location = "<?php echo base_url(); ?>";
		});
	});
</script>
<form action="<?php echo site_url('facility/add'); ?>" method="post" class="form-horizontal" accept-charset="utf-8">
	<fieldset>
		<legend>Enter Facility Information</legend>
		<div class="control-group">
			<label class="control-label" for="facility_name">Facility Name</label>
			<div class="controls">
				<input type="text" name="facility_name" value="" id="facility_name" placeholder="Facility Name">
				<p class="help-block">This will be the beginning of your URL</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="facility_url">Your URL</label>
			<div class="controls">
				<input type="text" name="facility_url" value="" id="facility_url" placeholder="Facility URL">
				<p class="help-block">This the URL for your facilities current website</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="url">Your Save Court URL</label>
			<div class="controls">
				<div class="input-append">
					<input type="text" id="url" name="url" placeholder="Your Save Court URL">
					<span class="add-on">.savecourt.com</span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="hard_courts">Hard Courts</label>
			<div class="controls">
				<input type="text" id="hard_courts" name="hard_courts" placeholder="e.g. 5">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="clay_courts">Clay Courts</label>
			<div class="controls">
				<input type="text" id="clay_courts" name="clay_courts" placeholder="e.g. 1">
			</div>
		</div>
		
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Create</button>
			<button id="cancel" class="btn">Cancel</button>
	    </div>
	</fieldset>


</form>
