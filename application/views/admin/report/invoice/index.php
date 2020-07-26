<h5 class="font-20 mt-15 mb-1">Report Invoice</h5>
<!--Form of products Paramaters-->
<?php echo form_open_multipart('admin/report_invoice/report/',array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<code>To get full report keep date range empty</code>
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
            <div class="col-md-8">
               <select name="report_type">
                 <option value="summary" <?php if($this->input->post('report_type')=='summary') {echo "selected";}; ?>>Summary</option>
                 <option value="details" <?php if($this->input->post('report_type')=='details') {echo "selected";}; ?>>Details</option>
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
							<h5 class="font-16">Invoice quantity</h5>
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
							<h5 class="font-16">Invoice total</h5>
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
