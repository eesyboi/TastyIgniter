<h1> TastyIgnite - Restaurant Management System! </h1>
<div class="content">
  
  

<div style="text-align: center">
  <h2> Select your nearest restaurant. </h2>
	<?php echo validation_errors(); ?>
	<?php echo form_open('home') ?>  
  	<select name="locations">

  		<option value="0"> - select nearest restaurant - </option>
		<?php foreach ($locations as $location) { ?>
  		<option value="<?php echo $location['location_id']; ?>"> - <?php echo $location['location_name']; ?> - </option>  	

		<?php } ?>
  	</select>

	<input type="submit" name="submit" value="Go" /> 
 </form>
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
</div>