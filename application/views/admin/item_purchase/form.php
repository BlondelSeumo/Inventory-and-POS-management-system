<a href="<?php echo site_url('admin/item_purchase/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Item_purchase'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/item_purchase/save/'.$item_purchase['id'],array("class"=>"form-horizontal")); ?>
<div class="form-group">
	<label for="Purchase" class="col-md-4 control-label">Purchase</label>
	<div class="col-md-8"> 
        <?php
			$this->CI = & get_instance();
			$this->CI->load->database();
			$this->CI->load->model('Purchase_model');
			$dataArr = $this->CI->Purchase_model->get_all_purchase();
        ?> 
          <select name="purchase_id" id="purchase_id"
			class="form-control" />
                <option value="">--Select--</option> 
				<?php
                    for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
                    <option value="<?=$dataArr[$i]['id']?>"
                    <?php if($item_purchase['purchase_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['purchase_no']?></option> 
                <?php
                }
                ?> 
          </select>
	</div>
</div>
<div class="form-group">
	<label for="Product" class="col-md-4 control-label">Product</label>
	<div class="col-md-8"> 
          <?php
			$this->CI = & get_instance();
			$this->CI->load->database();
			$this->CI->load->model('Product_model');
			$dataArr = $this->CI->Product_model->get_all_product();
          ?> 
          <select name="product_id" id="product_id" class="form-control" />
		   <option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
			<?php if($item_purchase['product_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['product_name']?></option> 
            <?php
            }
            ?> 
          </select>
	</div>
</div>
<div class="form-group">
	<label for="Item Cost" class="col-md-4 control-label">Item Cost</label>
	<div class="col-md-8">
		<input type="text" name="item_cost"
			value="<?php echo ($this->input->post('item_cost') ? $this->input->post('item_cost') : $item_purchase['item_cost']); ?>"
			class="form-control" id="item_cost" />
	</div>
</div>
<div class="form-group">
	<label for="Item Quantity" class="col-md-4 control-label">Item Quantity</label>
	<div class="col-md-8">
		<input type="text" name="item_quantity"
			value="<?php echo ($this->input->post('item_quantity') ? $this->input->post('item_quantity') : $item_purchase['item_quantity']); ?>"
			class="form-control" id="item_quantity" />
	</div>
</div>
<div class="form-group">
	<label for="Item Total" class="col-md-4 control-label">Item Total</label>
	<div class="col-md-8">
		<input type="text" name="item_total"
			value="<?php echo ($this->input->post('item_total') ? $this->input->post('item_total') : $item_purchase['item_total']); ?>"
			class="form-control" id="item_total" />
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($item_purchase['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
