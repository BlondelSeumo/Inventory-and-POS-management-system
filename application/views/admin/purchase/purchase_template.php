<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">    
<table class="table" align="center" width="100%">    
    <tr>
        <td width="30%">
            <?php
    		 if (is_file(APPPATH . '../public/' . $company[0]['file_company_logo']) && file_exists(APPPATH . '../public/' . $company[0]['file_company_logo'])) {
            ?>
			  <img src="<?php echo base_url().'public/'.$company[0]['file_company_logo']?>" class="picture_100x100">
			  <?php
             } else {
             ?>
            <img src="<?php echo base_url()?>public/uploads/no_image.jpg" class="picture_100x100">
            <?php
			}
			?>	
        </td>
        <td align="center">      
          <h3><?=html_entity_decode($company[0]['company_name'])?></h3>
          <?=html_entity_decode($company[0]['address'])?><br>
          <?=html_entity_decode($company[0]['city'])?>,<?=html_entity_decode($company[0]['state'])?>,<?=html_entity_decode($company[0]['zip'])?>,<?=html_entity_decode($company[0]['country'])?><br>
        </td>
        <td  width="30%">
        </td>
    </tr>
</table>

<br><br><br>
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

<div class="panel-heading">
   <h3 class="purchase"><strong>Purchase</strong></h3>
   <b>Purchase NO: <?=$purchase['purchase_no']?></b>
 </div>
<br>
PAY TO 
<hr> 
<table  cellspacing="3" cellpadding="3" class="table" align="left">
      <tr><td><?=html_entity_decode($supplier['company'])?></td></tr>  
      <tr><td><?=html_entity_decode($supplier['supplier_name'])?></td></tr>
      <tr><td><?=html_entity_decode($supplier['address'])?>
           <br>
          <?=html_entity_decode($supplier['zip'])?>,<?=html_entity_decode($supplier['city'])?>,<?=html_entity_decode($supplier['state'])?></td></tr>
      <tr><td><?=html_entity_decode($supplier['phone_no'])?></td></tr>
      <tr><td><?=html_entity_decode($supplier['email'])?></td></tr>
</table>        
     
<br>                     
ITEMS  
<hr>                 
<!--Data display of purchase-->
<table class="table" align="center" width="100%">    
    <tr>
        <th>Product</th>
        <th>Item Cost</th>
        <th>Item Quantity</th>
        <th>Item Total</th>
    </tr>
   <?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $result = $this->db->get_where('item_purchase', array('purchase_id' => $purchase['id']))->result_array();
    for ($i = 0; $i < count($result); $i ++) {
    ?>
       <tr>
        <td align="center">
            <?php
                $this->CI = & get_instance();
                $this->CI->load->database();
                $this->CI->load->model('Product_model');
                $product = $this->CI->Product_model->get_product($result[$i]['product_id']);
                echo $product['product_name'];
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
<!--End of Data display of purchase//-->

<br><br>
GENERAL INFO
<hr>
<table  cellspacing="3" cellpadding="3" class="table" align="center">
    <tr><td>Date of purchase</td><td><?=html_entity_decode($purchase['date_of_purchase'])?></td></tr>
    <tr><td>Description</td><td><?=html_entity_decode($purchase['description'])?></td></tr>
    <tr><td>Total cost</td><td><?=html_entity_decode($purchase['total_cost'])?></td></tr>
    <tr><td>Amount paid</td><td><?=html_entity_decode($purchase['amount_paid'])?></td></tr>		
</table>
