<a href="<?php echo site_url('admin/item_invoice/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Item_invoice'); ?></h5>

<!--Data display of item_invoice with id-->
<table class="table table-striped table-bordered">
         <?php
        $c = $item_invoice;
        ?> 
		<tr>
		<td>Invoice</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Invoice_model');
$dataArr = $this->CI->Invoice_model->get_invoice($c['invoice_id']);
echo html_entity_decode($dataArr['invoice_no']);
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
<!--End of Data display of item_invoice with id//-->
