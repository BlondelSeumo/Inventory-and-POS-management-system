<a href="<?php echo site_url('admin/customers/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Customer'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/customers/save/'.$customers['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Customer Name" class="col-md-4 control-label">Customer
				Name</label>
			<div class="col-md-8">
				<input type="text" name="customer_name"
					value="<?php echo ($this->input->post('customer_name') ? $this->input->post('customer_name') : $customers['customer_name']); ?>"
					class="form-control" id="customer_name" />
			</div>
		</div>
		<div class="form-group">
			<label for="Email" class="col-md-4 control-label">Email</label>
			<div class="col-md-8">
				<input type="text" name="email"
					value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $customers['email']); ?>"
					class="form-control" id="email" />
			</div>
		</div>
		<div class="form-group">
			<label for="Address" class="col-md-4 control-label">Address</label>
			<div class="col-md-8">
				<textarea name="address" id="address" class="form-control" rows="4" /><?php echo ($this->input->post('address') ? $this->input->post('address') : $customers['address']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="City" class="col-md-4 control-label">City</label>
			<div class="col-md-8">
				<input type="text" name="city"
					value="<?php echo ($this->input->post('city') ? $this->input->post('city') : $customers['city']); ?>"
					class="form-control" id="city" />
			</div>
		</div>
		<div class="form-group">
			<label for="State" class="col-md-4 control-label">State</label>
			<div class="col-md-8">
				<input type="text" name="state"
					value="<?php echo ($this->input->post('state') ? $this->input->post('state') : $customers['state']); ?>"
					class="form-control" id="state" />
			</div>
		</div>
		<div class="form-group">
			<label for="Zip" class="col-md-4 control-label">Zip</label>
			<div class="col-md-8">
				<input type="text" name="zip"
					value="<?php echo ($this->input->post('zip') ? $this->input->post('zip') : $customers['zip']); ?>"
					class="form-control" id="zip" />
			</div>
		</div>
		<div class="form-group">
			<label for="Phone No" class="col-md-4 control-label">Phone No</label>
			<div class="col-md-8">
				<input type="text" name="phone_no"
					value="<?php echo ($this->input->post('phone_no') ? $this->input->post('phone_no') : $customers['phone_no']); ?>"
					class="form-control" id="phone_no" />
			</div>
		</div>		
	</div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($customers['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
