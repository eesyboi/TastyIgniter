<div id="content">
	<hr>
	<h2 align="center">EDIT STAFF INFO (<?php echo $staff_name; ?>)</h2>
	<hr>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<table align="center">
		<tr>
    		<td>Staff Email:</td>
    		<td><?php echo $staff_email; ?></td>
		</tr>
		<tr>
    		<td>User:</td>
    		<td><?php echo $staff_email; ?></td>
		</tr>
		<tr>
    		<td>Staff Name:</td>
    		<td><input type="text" name="staff_name" value="<?php echo set_value('staff_name', $staff_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Staff Location:</td>
    		<td><select name="staff_location">
    			<option value="">- please select -</option>
			<?php foreach ($locations as $location) { ?>
    		<?php if ($location['location_id'] === $staff_location) { ?>
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td>Status:</td>
    		<td><select name="staff_status">
	   			<option value="0" <?php echo set_select('staff_status', '0'); ?> >Disabled</option>
     		<?php if ($staff_status === '1') { ?>
    			<option value="1" <?php echo set_select('staff_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('staff_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td>Permission Level:</td>
    		<td><select name="permission">
    		</selec></td>
		</tr>
    	<tr>
	    	<td><b>Delete:</b></td>
    		<td><input type="checkbox" name="delete" value="1" /></td>
			<td></td>
	    </tr>
		<tr>
   			<td colspan="2" align="right"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</form>
</div>
