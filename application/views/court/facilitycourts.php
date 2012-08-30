<h2>Courts for </h2>
<table class="table table-striped table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>Facility ID</th>
		<th>Court Type</th>
		<th>Name</th>
		<th>Number</th>
		<th>View/Edit</th>
	</tr>
	</thead>
<?php foreach ($courts as $court): ?>
	<tr>
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
			<td>
				<a href="<?php echo site_url('courts/view') . '/' . $court['id']?>">View/Edit Details</a>
			</td>
	</tr>
<?php endforeach ?>	
</table>
