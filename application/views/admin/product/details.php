<a href="<?php echo site_url('admin/product/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Product'); ?></h5>
<!--Data display of product with id-->
<?php
$c = $product;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['users_id']);
echo html_entity_decode($dataArr['email']);
?>
	 </td>
	</tr>
	<tr>
		<td>Product Name</td>
		<td><?php echo html_entity_decode($c['product_name']); ?></td>
	</tr>
	<tr>
		<td>Category</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Category_model');
$dataArr = $this->CI->Category_model->get_category($c['category_id']);
echo html_entity_decode($dataArr['name']);
?>
	</td>
	</tr>
	<tr>
		<td>Sub Category</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Sub_category_model');
$dataArr = $this->CI->Sub_category_model->get_sub_category($c['sub_category_id']);
echo html_entity_decode($dataArr['name']);
?>
	</td>
	</tr>
	<tr>
		<td>Buying Price</td>
		<td><?php echo html_entity_decode($c['buying_price']); ?></td>
	</tr>
	<tr>
		<td>Selling Price</td>
		<td><?php echo html_entity_decode($c['selling_price']); ?></td>
	</tr>
	<tr>
		<td>Brand</td>
		<td><?php echo html_entity_decode($c['brand']); ?></td>
	</tr>
	<tr>
		<td>Specification</td>
		<td><?php echo html_entity_decode($c['specification']); ?></td>
	</tr>
	<tr>
		<td>PurchaseType</td>
		<td><?php echo html_entity_decode($c['purchaseType']); ?></td>
	</tr>
	<tr>
		<td>AssetType</td>
		<td><?php echo html_entity_decode($c['assetType']); ?></td>
	</tr>
	<tr>
		<td>Serial Number</td>
		<td><?php echo html_entity_decode($c['serial_number']); ?></td>
	</tr>
	<tr>
		<td>BarcodeNumber</td>
		<td><?php echo html_entity_decode($c['barcodeNumber']); ?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?php echo html_entity_decode($c['description']); ?></td>
	</tr>
	<tr>
		<td>Weight Per Product</td>
		<td><?php echo html_entity_decode($c['weight_per_product']); ?></td>
	</tr>
	<tr>
		<td>Size Per Product</td>
		<td><?php echo html_entity_decode($c['size_per_product']); ?></td>
	</tr>
	<tr>
		<td>File Picture</td>
		<td><?php
if (is_file(APPPATH . '../public/' . $c['file_picture']) && file_exists(APPPATH . '../public/' . $c['file_picture'])) {
    ?>
										  <img
			src="<?php echo base_url().'public/'.$c['file_picture']?>" class="picture_100x100">
										  <?php
} else {
    ?>
										<img src="<?php echo base_url()?>public/uploads/no_image.jpg" class="picture_100x100">
										<?php
}
?>	
										</td>
	</tr>
	<tr>
		<td>Created At</td>
		<td><?php echo html_entity_decode($c['created_at']); ?></td>
	</tr>
	<tr>
		<td>Updated At</td>
		<td><?php echo html_entity_decode($c['updated_at']); ?></td>
	</tr>
	<tr>
		<td>Status</td>
		<td><?php echo html_entity_decode($c['status']); ?></td>
	</tr>
</table>
<!--End of Data display of product with id//-->
