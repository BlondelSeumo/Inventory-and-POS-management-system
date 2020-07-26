<h5 class="font-20 mt-15 mb-1">Report Product</h5>
<!--Form of products Paramaters-->
<?php echo form_open_multipart('admin/report_product/report/',array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<code>To get full report of a selected product keep date range empty</code>
			<div class="col-md-8">
				<label for="Date From" class="col-md-4 control-label">Date From</label>
				<div class="col-md-4">
					<input type="text" name="date_from" id="date_from"
						value="<?php echo ($this->input->post('date_from') ? $this->input->post('date_from') : ''); ?>"
						class="form-control-static datepicker" />
				</div>

				<label for="Date To" class="col-md-4 control-label">Date To</label>
				<div class="col-md-4">
					<input type="text" name="date_to" id="date_to"
						value="<?php echo ($this->input->post('date_to') ? $this->input->post('date_to') : ''); ?>"
						class="form-control-static datepicker" />
				</div>
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
					class="form-control" onChange="fillUpSubCategory(this.value);"
					required />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($this->input->post('category_id')==$dataArr[$i]['id']){echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
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
					class="form-control" onChange="fillUpProduct(this.value);" required />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($this->input->post('sub_category_id')==$dataArr[$i]['id']){echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="product" class="col-md-4 control-label">Product</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Product_model');
        $dataArr = $this->CI->Product_model->get_all_product();
        ?> 
          <div id="spinner2"></div>
				<select name="product_id" id="product_id" class="form-control"
					required />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($this->input->post('product_id')==$dataArr[$i]['id']){echo "selected";} ?>><?=$dataArr[$i]['product_name']?></option> 
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
		<button type="submit" class="btn btn-success">Report</button>
	</div>
</div>
<?php echo form_close(); ?>

<!--Display report data-->
<?php
if (isset($_POST) && count($_POST) > 0) {
    ?>
<div class="card">
	<div class="card-body">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-xl-3">
					<div class="card">
						<div class="card-body">
							<h5 class="font-16">Purchase quantity</h5>
							<h2 class="text-green font-24">
								<i class="fa fa-play fa-rotate-270"></i> Up
							</h2>
							<p class="mb-0 font-13"><?php echo $purchase_item_quantity;?></p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="card">
						<div class="card-body ">
							<h5 class="font-16">Purchase total</h5>
							<h2 class="text-green font-24">
								<i class="fa fa-play fa-rotate-270"></i> Up
							</h2>
							<p class="mb-0 font-13"><?php echo $purchase_item_total;?></p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-xl-3">
					<div class="card">
						<div class="card-body">
							<h5 class="font-16">Sold quantity</h5>
							<h2 class="text-green font-24">
								<i class="fa fa-play fa-rotate-270"></i> Up
							</h2>
							<p class="mb-0 font-13"><?php echo $invoice_item_quantity;?></p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="card">
						<div class="card-body ">
							<h5 class="font-16">Sold total</h5>
							<h2 class="text-green font-24">
								<i class="fa fa-play fa-rotate-270"></i> Up
							</h2>
							<p class="mb-0 font-13"><?php echo $invoice_item_total;?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<!--#//Display report data-->

<!--End of Form to save data//-->
<script language="javascript">
  $( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
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
	
	function fillUpProduct(sub_category_id)
	{
		
		var category_id = $("#category_id").val();
		var select = document.getElementById('product_id');
		select.options.length = 0; 	 
		$("#spinner2").html('<img src="<?php echo base_url(); ?>public/uploads/indicator.gif" alt="Wait" />');		
		$.ajax({  
		  url: '<?php echo site_url('admin/report_product/get_product/'); ?>'+category_id+'/'+sub_category_id,
		  success: function(data) {
			if(data=="")
			{
			   $("#spinner").html('');
			}
			else
			{
				var myObject = eval(data);
				var select = document.getElementById('product_id');
				select.options.length = 0; 	 
				select.options.add(new Option('--Select--', ''));	 
				  for (var i = 1; i <= myObject.length; i++) 
				  {
					  var d = myObject[i-1];
					  select.options.add(new Option(d.product_name, d.id));
				  }
				$("#spinner2").html('');
			}
		  }
		});
	}
</script>
<!--End of Form//-->
