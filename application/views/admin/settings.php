<div class="content">
<div class="left-section">
	<ul id="sub_nav">
    	<li><a href="<?php echo site_url('admin/settings'); ?>">General Settings</a></li>
    	<li><a href="<?php echo site_url('admin/map_settings'); ?>">Map Settings</a></li>
    	<li><a href="<?php echo site_url('admin/locations'); ?>">Restaurant Locations</a></li>
    	<li><a href="<?php echo site_url('admin/manage_tables'); ?>">Manage Tables</a></li>
    	<li><a href="<?php echo site_url('admin/manage_ratings'); ?>">Manage Ratings</a></li>
    	<li><a href="<?php echo site_url('admin/manage_quantities'); ?>">Manage Quantities</a></li>
    	<li><a href="<?php echo site_url('admin/manage_questions'); ?>">Security Questions</a></li>
    	<li><a href="<?php echo site_url('admin/manage_users'); ?>">Users</a></li>
    	<li><a href="<?php echo site_url('admin/manage_users'); ?>">Order Statuses</a></li>
    	<li><a href="<?php echo site_url('admin/manage_users'); ?>">Payment Methods</a></li>
	</ul>
</div>
	<h2 align="">GENERAL SETTINGS</h2>
	<table align="">
		<tr>
    		<td><b>Restaurant Name:</b></td>
    		<td><input type="text" name="restaurant_name" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Set Default Location:</b><br />
    		<font size="1">The restaurant main location</font></td>
    		<td><select name="locations">
			<?php foreach ($locations as $location) { ?>
  				<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td><b>Set Default Timezone:</b><br />
    		<font size="1">Default:</font></td>
    		<td><?php echo timezone_menu(); ?></td>
		</tr>
		<tr>
    		<td><b>Set Default Currency:</b><br />
    		<font size="1">Default:</font></td>
    		<td><select name="config_currency">
			<?php foreach ($currencies as $currency) { ?>
  				<option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['currency_code']; ?></option>
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td><b>Set Default Radius:</b><br />
    		<font size="1">(For locations distance calculation)</font></td>
    		<td><input type="text" name="config_radius" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Default Limit Per Page:</b><br />
    		<font size="1">(Limit how many items are shown per page)</font></td>
    		<td><input type="text" name="config_page_limit" value="" size="3" class="textfield" /></td>
		</tr>
	</table>
</div>