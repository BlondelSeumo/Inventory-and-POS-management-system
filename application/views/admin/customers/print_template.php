<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">    
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Customers'); ?></h3>
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
<!--Data display of customers-->
<table cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
		<th>Customer Name</th>
		<th>Email</th>
		<th>Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Phone No</th>
	</tr>
	<?php foreach($customers as $c){ ?>
    <tr>
		<td><?php echo html_entity_decode($c['customer_name']); ?></td>
		<td><?php echo html_entity_decode($c['email']); ?></td>
		<td><?php echo html_entity_decode($c['address']); ?></td>
		<td><?php echo html_entity_decode($c['city']); ?></td>
		<td><?php echo html_entity_decode($c['state']); ?></td>
		<td><?php echo html_entity_decode($c['zip']); ?></td>
		<td><?php echo html_entity_decode($c['phone_no']); ?></td>

	</tr>
	<?php } ?>
</table>
<!--End of Data display of customers//-->
