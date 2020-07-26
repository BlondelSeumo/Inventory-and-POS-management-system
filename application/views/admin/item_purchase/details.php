<a href="<?php echo site_url('admin/item_purchase/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Item_purchase'); ?></h5>

<!--Data display of item_purchase with id-->
<?php
 $c = $item_purchase;
?> 
<table class="table table-striped table-bordered">
     <tr>
		<td>Purchase</td>
		<td><?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$this->CI->load->model('Purchase_model');
				$dataArr = $this->CI->Purchase_model->get_purchase($c['purchase_id']);
				echo html_entity_decode($dataArr['purchase_no']);
			?>
	    </td>
	</tr>
	<tr>
		<td>Product</td>
		<td><?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$this->CI->load->model('Product_model');
				$dataArr = $this->CI->Product_model->get_product($c['product_id']);
				echo html_entity_decode($dataArr['product_name']);
			?>
		</td>
	</tr>
	<tr>
		<td>Item Cost</td>
		<td><?php echo html_entity_decode($c['item_cost']); ?></td>
	</tr>
	<tr>
		<td>Item Quantity</td>
		<td><?php echo html_entity_decode($c['item_quantity']); ?></td>
	</tr>
	<tr>
		<td>Item Total</td>
		<td><?php echo html_entity_decode($c['item_total']); ?></td>
	</tr>
</table>
<!--End of Data display of item_purchase with id//-->
