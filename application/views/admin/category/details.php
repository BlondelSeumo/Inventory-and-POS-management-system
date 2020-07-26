<a href="<?php echo site_url('admin/category/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Category'); ?></h5>
<!--Data display of category with id-->
<?php
	$c = $category;
?> 
<table class="table table-striped table-bordered">       
	<tr>
		<td>Name</td>
		<td><?php echo html_entity_decode($c['name']); ?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?php echo html_entity_decode($c['description']); ?></td>
	</tr>
	<tr>
		<td>Status</td>
		<td><?php echo html_entity_decode($c['status']); ?></td>
	</tr>
	<tr>
		<td>Created At</td>
		<td><?php echo html_entity_decode($c['created_at']); ?></td>
	</tr>
	<tr>
		<td>Updated At</td>
		<td><?php echo html_entity_decode($c['updated_at']); ?></td>
	</tr>
</table>
<!--End of Data display of category with id//-->
