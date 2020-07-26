<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">    
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Item_purchase'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of item_purchase-->
<table cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
		<th>Purchase</th>
		<th>Product</th>
		<th>Item Cost</th>
		<th>Item Quantity</th>
		<th>Item Total</th>
	</tr>
	<?php foreach($item_purchase as $c){ ?>
    <tr>
		<td><?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$this->CI->load->model('Purchase_model');
				$dataArr = $this->CI->Purchase_model->get_purchase($c['purchase_id']);
				echo html_entity_decode($dataArr['purchase_no']);
			?>
		</td>
		<td><?php
				$this->CI = & get_instance();
				$this->CI->load->database();
				$this->CI->load->model('Product_model');
				$dataArr = $this->CI->Product_model->get_product($c['product_id']);
				echo html_entity_decode($dataArr['product_name']);
			?>
		</td>
		<td><?php echo html_entity_decode($c['item_cost']); ?></td>
		<td><?php echo html_entity_decode($c['item_quantity']); ?></td>
		<td><?php echo html_entity_decode($c['item_total']); ?></td>
	</tr>
	<?php } ?>
</table>
<!--End of Data display of item_purchase//-->
