<div id="content">
	<h2 align="center">ADD NEW TABLE RESERVATION</h2>
	<table border="0" width="970" align="center">
	<?php echo form_open('admin/customers') ?>
	<table align="center">
		<tr>
    		<td>Full Name:</td>
    		<td><input type="text" name="full_name" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Email:</td>
    		<td><input type="text" name="email" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Telephone:</td>
    		<td><input type="password" name="telephone" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Location:</td>
    		<td><select name="locations">
			<?php foreach ($locations as $location) { ?>
  				<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td>Tables:</td>
    		<td><select name="tables">
    		</selec></td>
		</tr>
		<tr>
    		<td>Date/Time:</td>
    		<td><input type="text" name="datetime" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Security Answer:</td>
    		<td><input type="text" name="security_answer" value="" class="textfield" /></td>
		</tr>
		<tr>
   			<td colspan="2" align="right"><input type="submit" name="reserve_table" value="Reserve Table" /></td>
		</tr>
	</table>
	</form>

  	<hr>
	<h2 align="center">TABLE RESERVATIONS LIST</h2>
  	<hr>

	<table border="0" width="100%" align="center" class="list">
	<tr>
		<th>Reservation ID</th>
		<th>Full Name</th>
		<th>Email</th>
		<th>Telephone</th>
		<th>Location</th>
		<th>Status</th>
		<th>Assigned Staff</th>
		<th>Reserved Table</th>
		<th>Reserved Date/Time</th>
		<th>Action(s)</th>
	</tr>
  	<?php if ($reservations) { ?>
  	<tr>
  		<td><?php echo $reservation['reservation_id']; ?></td>
  		<td><?php echo $reservation['full_name']; ?></td>
  		<td><?php echo $reservation['email']; ?></td>
  		<td><?php echo $reservation['telephone']; ?></td>
  		<td><?php echo $reservation['location']; ?></td>
  		<td><select name="status" id="status">
  		</select></td>
  		<td><?php echo $reservation['reserved_table']; ?></td>
  		<td><?php echo $reservation['reservation_date_time']; ?></td>
		<td>( <a class="edit" href="<?php echo $reservation['edit']; ?>">Edit</a> )</td>
  	</tr>
  	<?php } else { ?>
  	<tr>
  		<td colspan="10" align="center"><?php echo $text_no_reservations; ?></td>
  	</tr>
  	<?php } ?>
	</table>

</div>
