<<<<<<< HEAD
<div class="content">
	<div class="wrap">
	<table width="100%" align="center" class="list">
		<tr>
			<th><?php echo $column_date; ?></th>
			<th><?php echo $column_time; ?></th>
			<th><?php echo $column_subject; ?></th>
			<th><?php echo $column_action; ?></th>
		</tr>
		<?php if ($messages) {?>
		<?php foreach ($messages as $message) { ?>
		<tr align="center">
			<td><?php echo $message['date']; ?></td>
			<td><?php echo $message['time']; ?></td>
			<td><?php echo $message['subject']; ?><br /><font size="1"><?php echo $message['body']; ?></font></td>
			<td><a class="edit" href="<?php echo $message['edit']; ?>"><?php echo $text_view; ?></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
=======
<div class="content">
  
  

<div style="text-align: center">
  <h2> Select your nearest restaurant. </h2>
  	<select name="locations">

  		<option value="0"> - select nearest restaurant - </option>
		<?php foreach ($locations as $location) { ?>
  		<option value="<?php echo $location['location_id']; ?>"> - <?php echo $location['location_name']; ?> - </option>  	

		<?php } ?>
  	</select>

	<input type="submit" name="submit" value="Go" /> 
   	<div>
		<?php foreach ($locations as $location) { ?>
  		<div><?php echo $location['location_name']; ?><br />	

  		<?php echo $location['location_address']; ?><br />	

  		<?php echo $location['location_region']; ?>, <?php echo $location['location_postcode']; ?><br />	

  		<?php echo $location['location_phone_number']; ?></div>	

		<?php } ?>  
		<br />		
  	</div>
  </div>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
</div>