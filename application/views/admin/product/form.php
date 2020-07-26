<a href="<?php echo site_url('admin/product/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"> <?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Product'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/product/save/'.$product['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Product Name" class="col-md-4 control-label">Product Name</label>
			<div class="col-md-8">
				<input type="text" name="product_name"
					value="<?php echo ($this->input->post('product_name') ? $this->input->post('product_name') : $product['product_name']); ?>"
					class="form-control" id="product_name" />
			</div>
		</div>
		<div class="form-group">
			<label for="Category" class="col-md-4 control-label">Category</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Category_model');
        $dataArr = $this->CI->Category_model->get_all_category();
        ?> 
          <select name="category_id" id="category_id"
					class="form-control" onChange="fillUpSubCategory(this.value);" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($product['category_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Sub Category" class="col-md-4 control-label">Sub Category</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Sub_category_model');
        $dataArr = $this->CI->Sub_category_model->get_all_sub_category();
        ?> 
          <div id="spinner"></div>
				<select name="sub_category_id" id="sub_category_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($product['sub_category_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Buying Price" class="col-md-4 control-label">Buying Price</label>
			<div class="col-md-8">
				<input type="text" name="buying_price"
					value="<?php echo ($this->input->post('buying_price') ? $this->input->post('buying_price') : $product['buying_price']); ?>"
					class="form-control" id="buying_price" />
			</div>
		</div>
		<div class="form-group">
			<label for="Selling Price" class="col-md-4 control-label">Selling
				Price</label>
			<div class="col-md-8">
				<input type="text" name="selling_price"
					value="<?php echo ($this->input->post('selling_price') ? $this->input->post('selling_price') : $product['selling_price']); ?>"
					class="form-control" id="selling_price" />
			</div>
		</div>
		<div class="form-group">
			<label for="Brand" class="col-md-4 control-label">Brand</label>
			<div class="col-md-8">
				<input type="text" name="brand"
					value="<?php echo ($this->input->post('brand') ? $this->input->post('brand') : $product['brand']); ?>"
					class="form-control" id="brand" />
			</div>
		</div>
		<div class="form-group">
			<label for="Specification" class="col-md-4 control-label">Specification</label>
			<div class="col-md-8">
				<input type="text" name="specification"
					value="<?php echo ($this->input->post('specification') ? $this->input->post('specification') : $product['specification']); ?>"
					class="form-control" id="specification" />
			</div>
		</div>
		<div class="form-group">
			<label for="PurchaseType" class="col-md-4 control-label">PurchaseType</label>
			<div class="col-md-8">
				<input type="text" name="purchaseType"
					value="<?php echo ($this->input->post('purchaseType') ? $this->input->post('purchaseType') : $product['purchaseType']); ?>"
					class="form-control" id="purchaseType" />
			</div>
		</div>
		<div class="form-group">
			<label for="AssetType" class="col-md-4 control-label">AssetType</label>
			<div class="col-md-8">
				<input type="text" name="assetType"
					value="<?php echo ($this->input->post('assetType') ? $this->input->post('assetType') : $product['assetType']); ?>"
					class="form-control" id="assetType" />
			</div>
		</div>
		<div class="form-group">
			<label for="Serial Number" class="col-md-4 control-label">Serial
				Number</label>
			<div class="col-md-8">
				<input type="text" name="serial_number"
					value="<?php echo ($this->input->post('serial_number') ? $this->input->post('serial_number') : $product['serial_number']); ?>"
					class="form-control" id="serial_number" />
			</div>
		</div>
		<div class="form-group">
			<label for="BarcodeNumber" class="col-md-4 control-label">BarcodeNumber</label>
			<div class="col-md-8">
				<input type="text" name="barcodeNumber"
					value="<?php echo ($this->input->post('barcodeNumber') ? $this->input->post('barcodeNumber') : $product['barcodeNumber']); ?>"
					class="form-control" id="barcodeNumber" />
			</div>
		</div>
		<div class="form-group">
			<label for="Description" class="col-md-4 control-label">Description</label>
			<div class="col-md-8">
				<input type="text" name="description"
					value="<?php echo ($this->input->post('description') ? $this->input->post('description') : $product['description']); ?>"
					class="form-control" id="description" />
			</div>
		</div>
		<div class="form-group">
			<label for="Weight Per Product" class="col-md-4 control-label">Weight
				Per Product</label>
			<div class="col-md-8">
				<input type="text" name="weight_per_product"
					value="<?php echo ($this->input->post('weight_per_product') ? $this->input->post('weight_per_product') : $product['weight_per_product']); ?>"
					class="form-control" id="weight_per_product" />
			</div>
		</div>
		<div class="form-group">
			<label for="Size Per Product" class="col-md-4 control-label">Size Per
				Product</label>
			<div class="col-md-8">
				<input type="text" name="size_per_product"
					value="<?php echo ($this->input->post('size_per_product') ? $this->input->post('size_per_product') : $product['size_per_product']); ?>"
					class="form-control" id="size_per_product" />
			</div>
		</div>
		<div class="form-group">
			<label for="File Picture" class="col-md-4 control-label">File Picture</label>
			<div class="col-md-8">
				<input type="file" name="file_picture" id="file_picture"
					value="<?php echo ($this->input->post('file_picture') ? $this->input->post('file_picture') : $product['file_picture']); ?>"
					class="form-control-file" />
			</div>
		</div>
		<div class="form-group">
			<label for="Status" class="col-md-4 control-label">Status</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('product', 'status');
        ?> 
           <select name="status" id="status" class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($product['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php
            }
            ?> 
           </select>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($product['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
<script language="javascript">
 function fillUpSubCategory(category_id)
	{
		var select = document.getElementById('sub_category_id');
		select.options.length = 0; 	  
		$("#spinner").html('<img src="<?php echo base_url(); ?>public/uploads/indicator.gif" alt="Wait" />');		
		$.ajax({  
		  url: '<?php echo site_url('admin/product/get_sub_category/'); ?>'+category_id,
		  success: function(data) {
			if(data=="")
			{
			   $("#spinner").html('');
			}
			else
			{
				var myObject = eval(data);
				var select = document.getElementById('sub_category_id');
				select.options.length = 0; 	 
				select.options.add(new Option('--Select--', ''));	 
				  for (var i = 1; i <= myObject.length; i++) 
				  {
					  var d = myObject[i-1];
					  select.options.add(new Option(d.name, d.id));
				  }
				$("#spinner").html('');
			}
		  }
		});
	}
</script>
