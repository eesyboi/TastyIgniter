<div class="content">
  <h2>Edit your address(es)</h2>
  	<table width="50%">
		<?php if ($addresses) { ?>
		<?php foreach ($addresses as $address) { ?>
  		<tr>
  			<td><?php echo $address['address_1']; ?><br /> 
  				<?php echo $address['address_2']; ?><br />
  				<?php echo $address['city']; ?><br />
  				<?php echo $address['postcode']; ?><br />
  				<?php echo $address['country']; ?>
  			</td>
  			<td>(<a href="<?php echo $address['delete']; ?>">Delete</a>)</td>
  			<td>(<a href="<?php echo $address['edit']; ?>">Edit</a>)</td>
  		</tr>
		<?php } ?>
  		<tr>
  			<td colspan="3" align="right">(<a id="add-address">Add New</a>)</td>
  		</tr>
		<?php } else { ?>
  		<tr>
  			<td colspan="2"><?php echo $no_address; ?></td>
  		</tr>
		<?php } ?>
  	</table>  

    <div id="new-address" style="display:none;">
 	 <h2>Fill in the form to add a new Address</h2>
    	<table border="0" cellpadding="2" width="50%">	
	    <tr>
            <td align="right"><b>Address 1:</b></td>
            <td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" /></td>
    	</tr>
        <tr>
            <td align="right"><b>Address 2:</b></td>
            <td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" /></td>
    	</tr>
        <tr>
            <td align="right"><b>City:</b></td>
            <td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" /></td>
    	</tr>
        <tr>
            <td align="right"><b>Postcode:</b></td>
            <td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" /></td>
    	</tr>
        <tr>
            <td align="right"><b>Country:</b></td>
            <td><input type="text" name="address[country]" value="<?php echo set_value('address[country]'); ?>" /></td>
    	</tr>    	
        <tr>
        	<td></td>
			<td align="right"><input type="submit" name="submit" value="Add New Address" /></td>
    	</tr>
		</table>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {

  	$('#add-address').on('click', function() {
  	
  	if($('#new-address').is(':visible')){
     	$('#new-address').fadeOut();
	}else{
   		$('#new-address').fadeIn();
	}
	});	



});
//--></script> 
