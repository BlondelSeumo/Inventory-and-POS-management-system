<a href="<?php echo site_url('admin/invoice/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1">
<?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Invoice'); ?></h5>
<!--*****************************************************
  Reuse item tempalte to make product item
******************************************************-->
<!--Item Form Template-->
<div id="item_form_template" class="row hide">
	<div class="row item  index0">
		<div class="form-group">
			<label for="Product" class="col-md-12 control-label">Product</label>
			<div class="col-md-12">
				<select type="text" name="product_id[]" id="product_id_0"
					class="form-control" onChange="setCost(this.value,0);" />
				<option>Select</option>
                    <?php
                    for ($i = 0; $i < count($product); $i ++) {
                        ?>
                      <option value="<?=$product[$i]['id']?>"><?=$product[$i]['product_name']?></option>
                    <?php
                    }
                    ?>
                </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Item Cost" class="col-md-12 control-label">Item Cost</label>
			<div class="col-md-12">
				<input type="text" name="item_cost[]" id="item_cost_0" value=""
					class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="Item Quantity" class="col-md-12 control-label">Item
				Quantity</label>
			<div class="col-md-12">
				<input type="text" name="item_quantity[]" id="item_quantity_0"
					value="1" onBlur="setItemTotal(this.value,this.id);"
					class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="Item Total" class="col-md-12 control-label">Item Total</label>
			<div class="col-md-12">
				<input type="text" name="item_total[]" id="item_total_0" value=""
					class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="removeitem" onClick="removeItem(0);">
				<a href="javascript:void();" class="action-icon"> <i
					class="zmdi zmdi-delete"></i></a>
			</div>
		</div>
	</div>
</div>
<!--End of Item Form Template//-->

<!--Form to save data-->
<?php echo form_open_multipart('admin/invoice/save/'.$invoice['id'],array("class"=>"form-horizontal")); ?>
<!--Item Form-->
<h4 class="card-title mb-0">Items</h4>
<div class="card">
	<div class="card-body">		
		<div id="item_more" class="row"></div>
		<button type="button" onClick="addMore(event);" class="btn btn-danger">
			<i class="zmdi zmdi-plus"></i>Add more Item
		</button>
	</div>
</div>

<script language="javascript">
var current = 0;
 /**
 *addMore
 *@param e - events
 */ 
function addMore(e)
 {	
	e.preventDefault();
	var item = $("#item_form_template").html();
	
	current = parseInt(current) + 1;
	item = item.replace(/product_id_0/gi, "product_id_"+current);
	item = item.replace(/item_quantity_0/gi, "item_quantity_"+current);
	item = item.replace(/item_cost_0/gi, "item_cost_"+current);
	item = item.replace(/item_total_0/gi, "item_total_"+current);
	item = item.replace(/index_0/gi, "index_"+current);
	item = item.replace(/0/gi,current);
	$("#item_more").append(item);
	
	 return false;
 }	
 /**
 *removeItem
 *@param index - index indicator of the div
 */ 
function removeItem(index){
   var result = confirm("Are you sure to remove this item?");
   if(result==true){
    $(".index"+index ).remove();
   }
   //////////update cost/////////////
	update_cost();
}
/**
*setCost
*@param product_id
*/
function setCost(product_id,counter)
{
	$.ajax({  
		  url: '<?php echo site_url('admin/invoice/product/'); ?>'+product_id,
		  success: function(data) {
				  var obj = JSON.parse(data);  
				  $("#item_cost_"+counter).val(obj.selling_price);
				  $("#item_total_"+counter).val(obj.selling_price);
				  //////////update cost/////////////
	              update_cost();		
			  }
			});
	
}
/*
   setItemTotal
*/
function setItemTotal(value,id)
{
	index = id.replace("item_quantity_","");
	
	cost = $("#item_cost_"+index).val();
	quantity = $("#item_quantity_"+index).val();
	$("#item_total_"+index).val(parseFloat(cost)*parseFloat(quantity));
	
	//////////update cost/////////////
	update_cost();
			 
}
//////////update cost/////////////
function update_cost()
{
   total_cost = 0.0;	
   for(i=0;i<=current;i++)
   {
	   if($("#item_cost_"+i).val()=='' || $("#item_cost_"+i).val()==undefined)
	   {
		   continue;
	   }
	   total_cost = parseFloat(total_cost) + parseFloat($("#item_cost_"+i).val())*parseFloat($("#item_quantity_"+i).val());
   
			  
	  $("#total_cost").val(total_cost);
	  $("#amount_paid").val(total_cost);
  }
}
</script>
<?php
if ($id < 0) {
    ?>
<script language="javascript"> 
  $(document).ready(function() {  
   addMore(event);
   });	 
</script>
<?php
} else {
    for ($i = 0; $i < count($item_invoice); $i ++) {
        ?>
<script language="javascript"> 
  $(document).ready(function() {  
    addMore(event);
	$("#product_id_<?=$i+1?>").val(<?=$item_invoice[$i]['product_id']?>);
	$("#item_cost_<?=$i+1?>").val(<?=$item_invoice[$i]['item_cost']?>);
	$("#item_quantity_<?=$i+1?>").val(<?=$item_invoice[$i]['item_quantity']?>);
	$("#item_total_<?=$i+1?>").val(<?=$item_invoice[$i]['item_total']?>);
   });	 
</script>
<?php
    }
}
?>
<!--End of Item Form//-->
<h4 class="card-title mb-0">Customer Info</h4>
<div class="card">
  <div class="card-body">
  <div class="row">
    <div class="col-md-4">
        <label for="Customers" class="col-md-4 control-label">Customer</label>
        <div class="col-md-8">
            <input name="customers_id" id="customers_id"
                value="<?php echo ($this->input->post('customers_id') ? $this->input->post('customers_id') : $invoice['customers_id']); ?>" />
        </div>
   </div>
    <div class="col-md-4">
    <label for="Email" class="col-md-4 control-label">Email</label>
    <div class="col-md-8">
        <input type="text" name="email"
            value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $customers['email']); ?>"
            class="form-control" id="email" />
    </div>
    </div>
    <div class="col-md-4">
        <label for="Address" class="col-md-4 control-label">Address</label>
        <div class="col-md-8">
            <textarea name="address" id="address" class="form-control" rows="4" /><?php echo ($this->input->post('address') ? $this->input->post('address') : $customers['address']); ?></textarea>
        </div>
    </div>
    <div class="col-md-4">
        <label for="City" class="col-md-4 control-label">City</label>
        <div class="col-md-8">
            <input type="text" name="city"
                value="<?php echo ($this->input->post('city') ? $this->input->post('city') : $customers['city']); ?>"
                class="form-control" id="city" />
        </div>
    </div>
    <div class="col-md-4">
        <label for="State" class="col-md-4 control-label">State</label>
        <div class="col-md-8">
            <input type="text" name="state"
                value="<?php echo ($this->input->post('state') ? $this->input->post('state') : $customers['state']); ?>"
                class="form-control" id="state" />
        </div>
    </div>
    <div class="col-md-4">
        <label for="Zip" class="col-md-4 control-label">Zip</label>
        <div class="col-md-8">
            <input type="text" name="zip"
                value="<?php echo ($this->input->post('zip') ? $this->input->post('zip') : $customers['zip']); ?>"
                class="form-control" id="zip" />
        </div>
    </div>
    <div class="col-md-4">
        <label for="Phone No" class="col-md-4 control-label">Phone No</label>
        <div class="col-md-8">
            <input type="text" name="phone_no"
                value="<?php echo ($this->input->post('phone_no') ? $this->input->post('phone_no') : $customers['phone_no']); ?>"
                class="form-control" id="phone_no" />
        </div>
    </div>
 </div>
 </div>
</div>

<input type="hidden" name="track_customers_id" id="track_customers_id"
                value="<?php echo ($this->input->post('customers_id') ? $this->input->post('customers_id') : $invoice['customers_id']); ?>" />


<h4 class="card-title mb-0">Invoice Info</h4>
<div class="card">
	<div class="card-body">	
		<div class="form-group">
			<label for="Date Of Invoice" class="col-md-4 control-label">Date Of
				Invoice</label>
			<div class="col-md-8">
				<input type="text" name="date_of_invoice" id="date_of_invoice"
					value="<?php echo ($this->input->post('date_of_invoice') ? $this->input->post('date_of_invoice') : $invoice['date_of_invoice']); ?>"
					class="form-control datepicker" />
			</div>
		</div>
		<div class="form-group">
			<label for="Description" class="col-md-4 control-label">Description</label>
			<div class="col-md-8">
				<textarea name="description" id="description" class="form-control"
					rows="4" /><?php echo ($this->input->post('description') ? $this->input->post('description') : $invoice['description']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="Internal Notes" class="col-md-4 control-label">Internal
				Notes</label>
			<div class="col-md-8">
				<textarea name="internal_notes" id="internal_notes"
					class="form-control" rows="4" /><?php echo ($this->input->post('internal_notes') ? $this->input->post('internal_notes') : $invoice['internal_notes']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="Total Cost" class="col-md-4 control-label">Total Cost</label>
			<div class="col-md-8">
				<input type="text" name="total_cost"
					value="<?php echo ($this->input->post('total_cost') ? $this->input->post('total_cost') : $invoice['total_cost']); ?>"
					class="form-control" id="total_cost" />
			</div>
		</div>
		<div class="form-group">
			<label for="Amount P" class="col-md-4 control-label">Amount Paid</label>
			<div class="col-md-8">
				<input type="text" name="amount_paid"
					value="<?php echo ($this->input->post('amount_paid') ? $this->input->post('amount_paid') : $invoice['amount_paid']); ?>"
					class="form-control" id="amount_paid" />
			</div>
		</div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($invoice['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
	//submit on pressing submit button  
	$('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});
</script>
<!--selectize-->
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/selectize/js/selectize.js"></script>
<link rel='stylesheet'
	href='<?php echo base_url(); ?>public/selectize/css/selectize.css'>
<link rel='stylesheet'
	href='<?php echo base_url(); ?>public/selectize/css/selectize.default.css'>
<style type="text/css">
.selectize-input {
	width: 100% !important;
	height: 62px !important;
}
</style>
<script language="javascript">
	  jQuery.noConflict();
		(function( $ ) {
						
				  $(document).ready(function() {
					$('#customers_id')
						.selectize({
								plugins: ['remove_button'],
								persist: false,
								create: true,
								maxItems: 1,
								valueField: 'id',
								placeholder: 'Customer Name ...',
								labelField: 'title',
								searchField: 'title',
								onInitialize: function() {
									this.trigger('change', this.getValue(), true);
								},
								onChange: function(value, isOnInitialize) {
										if(value=="")
										{
											$("#email").val('');
											$("#address").val('');
											$("#city").val('');
											$("#state").val('');
											$("#zip").val('');
											$("#phone_no").val('');
											$("#track_customers_id").val('');
								
											return;
										}
										else
										{
										  $("#email").focus();	
										}
										//retrive customer info
										$.ajax({  
										  url: '<?php echo site_url('admin/invoice/customer_detail'); ?>/'+value,
										  success: function(data) {
												  var obj = JSON.parse(data);  
												  if(data.length>0)
												  {
													  $("#email").val(obj.email);
													  $("#address").val(obj.address);
													  $("#city").val(obj.city);
													  $("#state").val(obj.state);
													  $("#zip").val(obj.zip);
													  $("#phone_no").val(obj.phone_no);
													  $("#track_customers_id").val(obj.id);
													  
												  }
											  }
											});
								},	
								options: [
											<?php
											if (count($customers_all) > 0) {
												for ($i = 0; $i < count($customers_all); $i ++) {
											?> 
											 {id: '<?=$customers_all[$i]['id']?>', title: '<?=$customers_all[$i]['customer_name']?>', url: ''},
											<?php
												}
											}
											?> 													  
										],
										create: true
									});
						 });
					
			})(jQuery); 
</script>
