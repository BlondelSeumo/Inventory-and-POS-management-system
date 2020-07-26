<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">    
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Product'); ?></h3>
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
<!--Data display of product-->
<table cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
		<th>Product Name</th>
		<th>Category</th>
		<th>Sub Category</th>
		<th>Buying Price</th>
		<th>Selling Price</th>
		<th>Brand</th>
		<th>Specification</th>
		<th>File Picture</th>
		<th>Status</th>
	</tr>
	<?php foreach($product as $c){ ?>
    <tr>
		<td><?php echo html_entity_decode($c['product_name']); ?></td>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Category_model');
    $dataArr = $this->CI->Category_model->get_category($c['category_id']);
    echo html_entity_decode($dataArr['name']);
    ?>
									</td>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Sub_category_model');
    $dataArr = $this->CI->Sub_category_model->get_sub_category($c['sub_category_id']);
    echo html_entity_decode($dataArr['name']);
    ?>
									</td>
		<td><?php echo html_entity_decode($c['buying_price']); ?></td>
		<td><?php echo html_entity_decode($c['selling_price']); ?></td>
		<td><?php echo html_entity_decode($c['brand']); ?></td>
		<td><?php echo html_entity_decode($c['specification']); ?></td>
		<td><?php
    if (is_file(APPPATH . '../public/' . $c['file_picture']) && file_exists(APPPATH . '../public/' . $c['file_picture'])) {
        ?>
										  <img
			src="<?php echo base_url().'public/'.$c['file_picture']?>" class="picture_50x50">
										  <?php
    } else {
        ?>
										<img src="<?php echo base_url()?>public/uploads/no_image.jpg" class="picture_50x50">
										<?php
    }
    ?>	
										</td>
		<td><?php echo html_entity_decode($c['status']); ?></td>

	</tr>
	<?php } ?>
</table>
<!--End of Data display of product//-->
