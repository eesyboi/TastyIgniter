<<<<<<< HEAD
<div class="box">
	<div id="update-box" class="content">
	<h2>STAFF UPDATE: <?php echo $staff_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="staff_name" value="<?php echo set_value('staff_name', $staff_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="staff_email" value="<?php echo set_value('staff_email', $staff_email); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username" value="<?php echo set_value('username', $username); ?>" id="username" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" id="password" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
			<td><b>Password Confirm:</b></td>
			<td><input type="password" name="password_confirm" id="password_confirm" class="textfield" /></td>
			<td></td>
		</tr>
		<tr>
    		<td><b>Department:</b></td>
    		<td><select name="department">
    		<option value="">- please select -</option>
			<?php foreach ($departments as $department) { ?>
     		<?php if ($department['department_id'] === $staff_department) { ?>
 				<option value="<?php echo $department['department_id']; ?>" <?php echo set_select('department', $department['department_id'], TRUE); ?> ><?php echo $department['department_name']; ?></option>
			<?php } else { ?>  
 				<option value="<?php echo $department['department_id']; ?>" <?php echo set_select('department', $department['department_id']); ?> ><?php echo $department['department_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</select></td>
		</tr>
		<tr>
    		<td><b>Location:</b></td>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
    		<td><select name="staff_location">
    			<option value="">- please select -</option>
			<?php foreach ($locations as $location) { ?>
    		<?php if ($location['location_id'] === $staff_location) { ?>
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
			<?php } ?>  
			<?php } ?>  
<<<<<<< HEAD
    		</select></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
=======
    		</selec></td>
		</tr>
		<tr>
    		<td>Status:</td>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
    		<td><select name="staff_status">
	   			<option value="0" <?php echo set_select('staff_status', '0'); ?> >Disabled</option>
     		<?php if ($staff_status === '1') { ?>
    			<option value="1" <?php echo set_select('staff_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('staff_status', '1'); ?> >Enabled</option>
			<?php } ?>  
<<<<<<< HEAD
    		</select></td>
		</tr>
	</table>
	</form>
	</div>
	
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
</div>
