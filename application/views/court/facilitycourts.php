<table class="table table-striped">
	<thead>
	<tr>
		<th>View/Edit</th>
		<th>ID</th>
		<th>Facility ID</th>
		<th>Court Type</th>
		<th>Name</th>
		<th>Number</th>
	</tr>
	</thead>
<?php foreach ($courts as $court): ?>
	<tr>
			<td>
				<a href="<?php echo base_url() . 'courts/view/' . $court['id']?>">View/Edit Details</a>
			</td>
		<td>
			<?php echo $court['id']?>
		</td>
		<td>
			<?php echo $court['facility_id']?>
		</td>
		<td>
			<?php echo $court['court_type']?>
		</td>
		<td>
			<?php echo $court['name']?>
		</td>
		<td>
			<?php echo $court['number']?>
		</td>
	</tr>
<?php endforeach ?>	
</table>
