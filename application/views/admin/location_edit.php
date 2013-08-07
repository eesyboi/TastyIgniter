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
