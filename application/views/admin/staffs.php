<div id="content">
	<h2 align="center">ADD NEW STAFF</h2>
	<?php echo form_open('admin/staffs') ?>
	<table align="center">
		<tr>
    		<td>Staff Name:</td>
    		<td><input type="text" name="staff_name" value="<?php echo set_value('staff_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Staff Email:</td>
    		<td><input type="text" name="staff_email" value="<?php echo set_value('staff_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>User:</td>
    		<td><select name="users">
    		</selec></td>
		</tr>
		<tr>
    		<td>Staff Location:</td>
    		<td><select name="staff_location">
    			<option value="">- please select -</option>
			<?php foreach ($locations as $location) { ?>
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td>Status:</td>
    		<td><select name="staff_status">
    			<option value="0" <?php echo set_select('staff_status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('staff_status', '1'); ?> >Enabled</option>
    		</selec></td>
		</tr>
		<tr>
    		<td>Permission Level:</td>
    		<td><select name="permission">
    		</selec></td>
		</tr>
   	 	<tr>
    		<td><b>Action:</b></td>
    		<td><input type="submit" name="submit" value="Add" /></td>
	    </tr>
	</table>
	</form>

  	<hr>
	<h2 align="center">STAFFS LIST</h2>
  	<hr>

	<table border="0" width="100%" align="center" class="list">
	<tr>
		<th>Staff ID</th>
		<th>Staff Name</th>
		<th>Staff Email</th>
		<th>Staff Location</th>
		<th>Status</th>
		<th>Permission Level</th>
		<th>Action(s)</th>
	</tr>
	<?php if ($staffs) { ?>
	<?php foreach ($staffs as $staff) { ?>
  	<tr>
  		<td><?php echo $staff['staff_id']; ?></td>
  		<td><?php echo $staff['staff_name']; ?></td>
  		<td><?php echo $staff['staff_email']; ?></td>
  		<td><?php echo $staff['staff_location']; ?></td>
  		<td><?php echo ($staff['staff_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
  		<td><?php echo $staff['permission_level']; ?></td>
		<td>(<a class="edit" href="<?php echo $staff['edit']; ?>">View/Edit</a>)</td>
  	</tr>
	<?php } ?>
	<?php } else {?>
  	<tr>
  		<td colspan="4" align="center"><?php echo $text_no_staffs; ?></td>
  	</tr>
	<?php } ?>
	</table>

</div>
