<div id="local-box">
	<h3><?php echo $text_local; ?></h3>	
	<div class="display-local" style="display: <?php echo ($local_location ? 'block' : 'none'); ?>">
		<font size="3"><?php echo $local_location['location_name']; ?></font><br />  	
		<address><?php echo $local_location['location_address_1']; ?>, <?php echo $local_location['location_city']; ?>, <?php echo $local_location['location_postcode']; ?></address> 	
		<?php echo $local_location['location_telephone']; ?><br /><br />
		
		<span class="is-open"><?php echo $text_open_or_close; ?></span><br />
		<span class=""><?php echo $text_delivery; ?></span><br />
		<span class=""><?php echo $text_collection; ?></span><br />
		<span class=""><?php echo $text_delivery_charge; ?>: <?php echo $delivery_charge; ?></span><br />
		<span class=""><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span>
	
		<span id="check-postcode"><a><?php echo $button_check_postcode; ?></a></span>

	</div>
	<div class="check-local" style="display: <?php echo ($local_location ? 'none' : 'block'); ?>">
	<form id="location-form" method="POST" action="<?php echo site_url('module/local_mod/distance'); ?>">
		<font size="1"><?php echo $text_postcode_warning; ?></font><br />
		<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
		<input type="text" id="postcodeInput" name="postcode" size="20" />
		<input type="button" onclick="$('#location-form').submit();" value="<?php echo $text_find; ?>"/>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').show();
		$('.display-local').hide();
	});	
});
//--></script> 