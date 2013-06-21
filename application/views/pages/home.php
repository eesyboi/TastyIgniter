<h1><TastyIgnite - Restaurant Management System!</h1>
<div class="content">
  
  

<div style="text-align: center">
  <h2>Select your nearest restaurant.</h2>
	<?php echo validation_errors(); ?>
	<?php echo form_open('home') ?>  
  	<select name="locations">

  		<option value="0"> - select nearest restaurant - </option>
		<?php foreach ($locations as $location) { ?>
  		<option value="<?php echo $location['id']; ?>"> - <?php echo $location['name']; ?> - </option>  	

		<?php } ?>
  	</select>

	<input type="submit" name="submit" value="Go" /> 
 </form>
   	<div>
		<?php foreach ($locations as $location) { ?>
  		<div><?php echo $location['name']; ?><br />	

  		<?php echo $location['address']; ?><br />	

  		<?php echo $location['region']; ?>, <?php echo $location['postcode']; ?><br />	

  		<?php echo $location['phone_number']; ?></div>	

		<?php } ?>  		
  	</div>
  </div>
</div>