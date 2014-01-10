<div class="left-section">
	<ul id="sub_nav">
		<li><h3><a href="<?php echo site_url('menus'); ?>"><?php echo $text_order_now; ?></a></h3></li>
		<li><a href="<?php echo site_url('account/details'); ?>"><?php echo $text_edit_details; ?></a></li>
		<li><a class="active" href="<?php echo site_url('account/address'); ?>"><?php echo $text_address; ?></a></li>
		<li><a href="<?php echo site_url('account/orders'); ?>"><?php echo $text_orders; ?></a></li>
		<li><a href="<?php echo site_url('account/reservations'); ?>"><?php echo $text_reservations; ?></a></li>
		<li><a href="<?php echo site_url('account/inbox'); ?>"><?php echo $text_inbox; ?></a></li>
		<li><a href="<?php echo site_url('account/logout'); ?>"><?php echo $text_logout; ?></a></li>
	</ul>
</div>
<div class="content">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
	<div class="wrap border_all">
	<?php if ($address) { ?>
  	<h2><?php echo $text_edit_address; ?></h2>
  		<table width="50%" class="form">
	    <tr>
            <td align="right"><b><?php echo $entry_address_1; ?></b></td>
            <td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]', $address['address_1']); ?>" /><br />
    			<?php echo form_error('address[address_1]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_address_2; ?></b></td>
            <td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]', $address['address_2']); ?>" /><br />
    			<?php echo form_error('address[address_2]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_city; ?></b></td>
            <td><input type="text" name="address[city]" value="<?php echo set_value('address[city]', $address['city']); ?>" /><br />
    			<?php echo form_error('address[city]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_postcode; ?></b></td>
            <td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]', $address['postcode']); ?>" /><br />
    			<?php echo form_error('address[postcode]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
		<tr>
			<td align="right"><b><?php echo $entry_country; ?></b></td>
			<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $address['country_id']) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select><br />
    			<?php echo form_error('address[country]', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
 		</table>
	<?php } else { ?>

    <div id="new-address">
 	<h2><?php echo $text_new_address; ?></h2>
    	<table border="0" cellpadding="2" width="50%" class="form">	
	    <tr>
            <td align="right"><b><?php echo $entry_address_1; ?></b></td>
            <td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" /><br />
    			<?php echo form_error('address[address_1]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_address_2; ?></b></td>
            <td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" /><br />
    			<?php echo form_error('address[address_2]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_city; ?></b></td>
            <td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" /><br />
    			<?php echo form_error('address[city]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_postcode; ?></b></td>
            <td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" /><br />
    			<?php echo form_error('address[postcode]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
		<tr>
			<td align="right"><b><?php echo $entry_country; ?></b></td>
			<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select><br />
    			<?php echo form_error('address[country]', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
		</table>
	</div>
	<?php } ?>
	</div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_address; ?></a></div>
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_update; ?>" /></div>
	</div>
  	</form>
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
