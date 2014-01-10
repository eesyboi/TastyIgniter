<<<<<<< HEAD
<div class="box">
	<div id="update-box" class="content">
	<h2>LOCATION UPDATE: <?php echo $location_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="location_name" value="<?php echo set_value('location_name', $location_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Address 1:</b></td>
    		<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]', $location_address_1); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Address 2:</b></td>
    		<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]', $location_address_2); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>City:</b></td>
    		<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]', $location_city); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Postcode:</b></td>
    		<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Country:</b></td>
    		<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
  				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="email" value="<?php echo set_value('email', $location_email); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Telephone:</b></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $location_telephone); ?>" class="textfield" /></td>
		</tr>
	</table>

	<div class="wrap-heading">
		<h3>WORKING HOURS</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Day:</b></td>
    		<?php foreach ($hours['day'] as $key => $day) { ?>
	    		<td><b><?php echo $day; ?></b></td>
    		<?php } ?>
		</tr>
		<tr>
    		<td><b>Open Hour:</b></td>
    		<?php foreach ($hours['open'] as $key => $open) { ?>
				<td><input type="text" name="hours[open][]" value="<?php echo set_value('hours[open][]', $open); ?>" class="textfield hours" size="4" /></td>
    		<?php } ?>
		</tr>
		<tr>
    		<td><b>Close Hour:</b></td>
    		<?php foreach ($hours['close'] as $key => $close) { ?>
				<td><input type="text" name="hours[close][]" value="<?php echo set_value('hours[close][]', $close); ?>" class="textfield hours" size="4" /></td>
    		<?php } ?>
		</tr>
	</table>
	</div>

	<div class="wrap-heading">
		<h3>TABLES</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
			<td><b>Tables:</b></td>
			<td><input type="text" name="table" value="" class="textfield" size="10" /></td>
		</tr>
		<tr>
			<td></td>
			<td><div id="table-box" class="selectbox">
			<table>
			<?php foreach ($tables as $table) { ?>
			<?php if (in_array($table['table_id'], $location_tables)) {?>
				<tr id="table-box<?php echo $table['table_id']; ?>">
					<td><?php echo $table['table_name']; ?></td>
					<td><?php echo $table['min_capacity']; ?></td>
					<td><?php echo $table['max_capacity']; ?></td>
					<td class="img"><img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" /><input type="hidden" name="tables[]" value="<?php echo $table['table_id']; ?>" /></td>
				</tr>
			<?php } ?>
			<?php } ?>
			</table>
			</div></td>
		</tr>
	</table>
	</div>
	
	<div class="wrap-heading">
		<h3>DELIVERY</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Offer Delivery:</b></td>
    		<td><select name="offer_delivery">
     		<?php if ($offer_delivery === '1') { ?>
	   			<option value="0" <?php echo set_select('offer_delivery', '0'); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_delivery', '1', TRUE); ?> >Yes</option>
			<?php } else { ?>  
	   			<option value="0" <?php echo set_select('offer_delivery', '0', TRUE); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_delivery', '1'); ?> >Yes</option>
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Offer Collection:</b></td>
    		<td><select name="offer_collection">
     		<?php if ($offer_collection === '1') { ?>
	   			<option value="0" <?php echo set_select('offer_collection', '0'); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_collection', '1', TRUE); ?> >Yes</option>
			<?php } else { ?>  
	   			<option value="0" <?php echo set_select('offer_collection', '0', TRUE); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_collection', '1'); ?> >Yes</option>
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Delivery Radius:</b><br />
    		<font size="1">(For locations distance calculation)</font></td>
    		<td><input type="text" name="address[radius]" value="<?php echo set_value('address[radius]', $location_radius); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><b>Ready Time:</b><br />
    		<font size="1">(Set how many minutes before an order is delivered or ready for collection)</font></td>
    		<td><input type="text" name="ready_time" value="<?php echo set_value('ready_time', $ready_time); ?>" class="textfield" size="5" /> minutes</td>
		</tr>
		<tr>
    		<td><b>Delivery Charge:</b><br />
    		<font size="1">(Set to "0.00" for free delivery charge)</font></td>
    		<td><input type="text" name="delivery_charge" value="<?php echo set_value('delivery_charge', $delivery_charge); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><b>Min Delivery Charge:</b><br />
    		<font size="1">(Set to "0.00" for no minimum delivery charge)</font></td>
    		<td><input type="text" name="min_delivery_total" value="<?php echo set_value('min_delivery_total', $min_delivery_total); ?>" class="textfield" size="5" /></td>
		</tr>
		<!--<tr>
    		<td><b>Latitude:</b></td>
    		<td><?php echo $location_lat; ?></td>
		</tr>
		<tr>
    		<td><b>Longitude:</b></td>
    		<td><?php echo $location_lng; ?></td>
		</tr>-->
	</table>
	</div>
		
	<div class="wrap-heading">
		<h3>PAYMENT</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Coming Soon:</b></td>
    		<td>Option to select payment gateways for each location.</td>
		</tr>
	</table>
	</div>
		
	<div class="wrap-heading">
		<h3></h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="location_status">
	   			<option value="0" <?php echo set_select('location_status', '0'); ?> >Disabled</option>
     		<?php if ($location_status === '1') { ?>
    			<option value="1" <?php echo set_select('location_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('location_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	</div>
	</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'table\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/tables/autocomplete"); ?>?table_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						value: item.table_id,
						label: item.table_name,
						min: item.min_capacity,
						max: item.max_capacity
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#table-box' + ui.item.value).remove();
		$('#table-box table').append('<tr id="table-box' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.min + '</td><td>' + ui.item.max + '</td><td class="img">' + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" />' + '<input type="hidden" name="tables[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
=======
<div id="content">
	<hr>
	<h2 align="center">UPDATE LOCATION INFO (<?php echo $location_name; ?>)</h2>
	<hr>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<table border="0" width="50%" align="center">
		<tr>
    		<td>Location Name:</td>
    		<td><input type="text" name="location_name" value="<?php echo set_value('location_name', $location_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Address:</td>
    		<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]', $location_address); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Region/District:</td>
    		<td><input type="text" name="address[region]" value="<?php echo set_value('address[region]', $location_region); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location City:</td>
    		<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]', $location_city); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Postcode:</td>
    		<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]', $location_postcode); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Phone Number:</td>
    		<td><input type="text" name="location_phone_number" value="<?php echo set_value('location_phone_number', $location_phone_number); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Latitude:</td>
    		<td><?php echo $location_lat; ?></td>
		</tr>
		<tr>
    		<td>Location Longitude:</td>
    		<td><?php echo $location_lng; ?></td>
		</tr>
		<tr>
    		<td>Location Opening Time:</td>
    		<td><input type="text" name="location_opening_time" value="<?php echo set_value('location_opening_time'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Closing Time:</td>
    		<td><input type="text" name="location_closing_time" value="<?php echo set_value('location_closing_time'); ?>" class="textfield" /></td>
		</tr>
    	<tr>
    		<td><b>Set as Default:</b></td>
    		<td><input type="checkbox" name="default" value="SET" /></td>
	    </tr>
    	<tr>
    		<td><b>Remove:</b></td>
    		<td><input type="checkbox" name="remove" value="1" /></td>
	    </tr>
		<tr>
   			<td colspan="2" align="center"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</form>
</div>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
