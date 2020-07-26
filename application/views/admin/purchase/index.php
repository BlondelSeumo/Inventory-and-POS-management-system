<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Purchase'); ?></h5>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/purchase/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type" class="select"
			onChange="window.location='<?php echo site_url('admin/purchase/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div  class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/purchase/search/',array("class"=>"form-horizontal")); ?>
                    <input name="key" type="text"
				value="<?php echo isset($key)?$key:'';?>" placeholder="Search..."
				class="form-control">
				<button type="submit" class="mr-0">
					<i class="fa fa-search"></i>
				</button>
                <?php echo form_close(); ?>
            </li>
		</ul>
	</div>
</div>
<!--End of Action//-->

<!--Data display of purchase-->
<table class="table table-striped table-bordered">
	<tr>
		<th>Purchase No</th>
		<th>Supplier</th>
		<th>Date Of Purchase</th>
		<th>Items</th>
		<th>Total Cost</th>
		<th>Amount Paid</th>
		<th>Actions</th>
	</tr>
	<?php foreach($purchase as $c){ ?>
    <tr>
		<td><?php echo $c['purchase_no']; ?></td>
		<td><?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$this->CI->load->model('Supplier_model');
				$dataArr = $this->CI->Supplier_model->get_supplier($c['supplier_id']);
				echo html_entity_decode($dataArr['company']);
			?>
		</td>
		<td><?php echo html_entity_decode($c['date_of_purchase']); ?></td>
		<td valign="top">
			<table>
				<tr>
					<th>Product</th>
					<th>Item Cost</th>
					<th>Item Quantity</th>
					<th>Item Total</th>
				</tr>
               <?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$result = $this->db->get_where('item_purchase', array('purchase_id' => $c['id']))->result_array();
				for ($i = 0; $i < count($result); $i ++) {
				?>
                   <tr>
					<td>
						<?php
							$this->CI = & get_instance();
							$this->CI->load->database();
							$this->CI->load->model('Product_model');
							$product = $this->CI->Product_model->get_product($result[$i]['product_id']);
							echo $product['product_name'];
						?>
                    </td>
					<td><?=html_entity_decode($result[$i]['item_cost'])?></td>
					<td><?=html_entity_decode($result[$i]['item_quantity'])?></td>
					<td><?=html_entity_decode($result[$i]['item_total'])?></td>
				</tr>
                <?php
				}
				?>
            </table>
		</td>
		<td><?php echo html_entity_decode($c['total_cost']); ?></td>
		<td><?php echo html_entity_decode($c['amount_paid']); ?></td>
		<td><a
			href="<?php echo site_url('admin/purchase/details/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-eye"></i></a> <a
			href="<?php echo site_url('admin/purchase/save/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-edit"></i></a> <a
			href="<?php echo site_url('admin/purchase/remove/'.$c['id']); ?>"
			onClick="return confirm('Are you sure to delete this item?');"
			class="action-icon"> <i class="zmdi zmdi-delete"></i></a>
            <a
			href="<?php echo site_url('admin/purchase/download/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-print"></i></a>
         </td>
	</tr>
	<?php } ?>
</table>
<!--End of Data display of purchase//-->

<!--No data-->
<?php
if (count($purchase) == 0) {
    ?>
<div align="center">
	<h3>Data is not exists</h3>
</div>
<?php
}
?>
<!--End of No data//-->

<!--Pagination-->
<?php
echo $link;
?>
<!--End of Pagination//-->
