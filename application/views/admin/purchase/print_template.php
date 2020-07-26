<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">    
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Purchase'); ?></h3>
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
<!--Data display of purchase-->
<table  cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
        <th>Sl No</th>
		<th>purchase No</th>
		<th>Customers</th>
		<th>Date Of purchase</th>
		<th>Description</th>
		<th>Total Cost</th>
		<th>Amount Paid</th>
	</tr>
	<?php 
	   $sl_no=0;
	   foreach($purchase as $c){ 
	   $sl_no = $sl_no+1;
	?>
    <tr>
        <td><?php echo $sl_no; ?>.</td>
		<td><?php echo $c['purchase_no']; ?></td>
		<td><?php
			$this->CI = & get_instance();
			$this->CI->load->database();
			$this->CI->load->model('Supplier_model');
			$dataArr = $this->CI->Supplier_model->get_Supplier($c['supplier_id']);
			echo html_entity_decode($dataArr['supplier_name']);
           ?>
		</td>
		<td><?php echo html_entity_decode($c['date_of_purchase']); ?></td>
		<td><?php echo html_entity_decode($c['description']); ?></td>
		<td><?php echo html_entity_decode($c['total_cost']); ?></td>
		<td><?php echo html_entity_decode($c['amount_paid']); ?></td>

	</tr>
	<tr>
        <td></td>
		<td valign="top">Items</td>
		<td colspan="5">
			<table border="1" class="table" align="center" width="100%">
				<tr>
					<td>Product</td>
					<td>Item Cost</v>
					<td>Item Quantity</v>
					<td>Item Total</v>
				</tr>
   <?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $result = $this->db->get_where('item_purchase', array(
        'purchase_id' => $c['id']
    ))->result_array();
    for ($i = 0; $i < count($result); $i ++) {
        ?>
       <tr>
            <td align="center">
            <?php
                $this->CI = & get_instance();
                $this->CI->load->database();
                $this->CI->load->model('Product_model');
                $product = $this->CI->Product_model->get_product($result[$i]['product_id']);
                echo html_entity_decode($product['product_name']);
            ?>
            </td>
            <td align="center"><?=html_entity_decode($result[$i]['item_cost'])?></td>
            <td align="center"><?=html_entity_decode($result[$i]['item_quantity'])?></td>
            <td align="center"><?=html_entity_decode($result[$i]['item_total'])?></td>
        </tr>
    <?php
    }
    ?>
</table>
		</td>
	</tr>
	<?php } ?>
</table>
<!--End of Data display of purchase//-->
