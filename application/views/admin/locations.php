<div class="content">
	<h2 align="">ADD NEW RESTAURANT LOCATION</h2>
	<table border="0" width="50%" align="">
	<?php echo form_open('admin/locations') ?>
		<tr>
    		<td>Location Name:</td>
    		<td><input type="text" name="location_name" value="<?php echo set_value('location_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Address:</td>
    		<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Region/District:</td>
    		<td><input type="text" name="address[region]" value="<?php echo set_value('address[region]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location City:</td>
    		<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Postcode:</td>
    		<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location Phone Number:</td>
    		<td><input type="text" name="location_phone_number" value="<?php echo set_value('location_phone_number'); ?>" class="textfield" /></td>
		</tr>
		<tr>
   			<td colspan="2" align="center"><input type="submit" name="submit" value="Add" /></td>
		</tr>
	</table>
	</form>

  	<hr>
	<h2 align="center">RESTAURANT LOCATIONS LIST</h2>
  	<hr>

	<table border="0" width="100%" align="center" class="list">
	<tr>
		<th>Location ID</th>
		<th>Location Name</th>
		<th>Location Address</th>
		<th>Location Region</th>
		<th>Location City</th>
		<th>Location Postcode</th>
		<th>Location Telephone</th>
		<th>Location Longitude</th>
		<th>Location Latitude</th>
		<th>Action(s)</th>
	</tr>
  	<?php if ($locations) { ?>
  	<?php foreach ($locations as $location) { ?>
  	<tr>
  		<td><?php echo $location['location_id']; ?></td>
  		<td><?php echo $location['location_name']; ?></td>
  		<td><?php echo $location['location_address']; ?></td>
  		<td><?php echo $location['location_region']; ?></td>
  		<td><?php echo $location['location_city']; ?></td>
  		<td><?php echo $location['location_postcode']; ?></td>
  		<td><?php echo $location['location_phone_number']; ?></td>
  		<td><?php echo $location['location_lat']; ?></td>
  		<td><?php echo $location['location_lng']; ?></td>
		<td>(<a class="edit" href="<?php echo $location['edit']; ?>">View/Edit</a>)</td>
  	</tr>
  	<?php } ?>
  	<?php } else { ?>
  	<tr>
  		<td colspan="10" align="center"><?php echo $text_no_location; ?></td>
  	</tr>
  	<?php } ?>
	</table>
	<p><?php echo $pagination['info']; ?><br /> 
	<?php echo $pagination['links']; ?></p>
</div>