<div class="content">
	<div class="wrap">
	<h4><?php echo $text_find_msg; ?></h4>
	<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="find-form">
    <table border="0" cellpadding="2" width="100%" class="form">
 	  	<tr>
    		<td align="right"><label for="location">Select Location</label></td>
    		<td><input type="text" name="location" value="<?php echo set_value('location', $location); ?>" class="textfield" size="20" />(<?php echo $entry_postcode; ?>)<br />
    			<?php echo form_error('postcode', '<span class="error">', '</span>'); ?>
    			<input type="hidden" name="location_id" value="<?php echo set_value('location_id', $location_id); ?>"/>
    		</td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="guest_num"><?php echo $entry_no_guest; ?></label></td>
    		<td>
			<?php if ($guest_nums) { ?>
				<select name="guest_num">
				<?php foreach ($guest_nums as $key => $value) { ?>
    			<?php if ($value === $guest_num) { ?>
					<option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value, TRUE); ?>><?php echo $value; ?></option>
				<?php } else { ?>
					<option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value); ?>><?php echo $value; ?></option>
				<?php } ?>
				<?php } ?>
				</select>
			<?php } else { ?>
				<span><?php echo $text_no_table; ?></span>
			<?php } ?><br />
    			<?php echo form_error('guest_num', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
 	  	<tr>
    		<td align="right"><label for="reserve_date"><?php echo $entry_date; ?></label></td>
    		<td><input type="text" name="reserve_date" id="date" value="<?php echo set_value('reserve_date', $date); ?>" class="textfield" size="10" /><br />
    			<?php echo form_error('reserve_date', '<span class="error">', '</span>'); ?>
    		</td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="reserve_time"><?php echo $entry_time; ?></label></td>
     		<td>
			<?php if ($reserve_times) { ?>
				<select name="reserve_time">
    			<option value=""><?php echo $entry_select; ?></option>
				<?php foreach ($reserve_times as $reserve_time) { ?>
    			<?php if ($reserve_time['24hr'] === $time) { ?>
					<option value="<?php echo $reserve_time['24hr']; ?>" <?php echo set_select('reserve_time', $reserve_time['24hr'], TRUE); ?>><?php echo $reserve_time['24hr']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $reserve_time['24hr']; ?>" <?php echo set_select('reserve_time', $reserve_time['24hr']); ?>><?php echo $reserve_time['24hr']; ?></option>
				<?php } ?>
				<?php } ?>
				</select>
			<?php } else { ?>
				<span><?php echo $text_no_opening; ?></span>
			<?php } ?><br />
    			<?php echo form_error('reserve_time', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
 		<tr>
    		<td align="right"><label for="occasion"><?php echo $entry_occassion; ?></label></td>
     		<td><select name="occasion">
				<?php foreach ($occasions as $key => $value) { ?>
    			<?php if ($key == $occasion) { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key, TRUE); ?>><?php echo $value; ?></option>
				<?php } else { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key); ?>><?php echo $value; ?></option>
				<?php } ?>
				<?php } ?>
    		</select><br />
    			<?php echo form_error('occasion', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
	</table>
	</form>
	</div>
	<div class="buttons">
		<div class="right"><a class="button" onclick="$('#find-form').submit();"><?php echo $button_find; ?></a></div>
	</div>
	<br /><br />

    <?php if ($select_times) { ?>
	<div class="wrap">
	<h4><?php echo $text_time_msg; ?></h4>
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reserve-form">
    <table border="0" cellpadding="2" width="100%" id="personal-details">
    	<tr>
		<?php foreach ($select_times as $key => $value) { ?>
    	<?php if ($value == $time) { ?>
			<td><input type="radio" name="select_time" value="<?php echo $value; ?>" checked="checked"/><?php echo $value; ?></td>
		<?php } else { ?>
			<td><input type="radio" name="select_time" value="<?php echo $value; ?>"/><?php echo $value; ?></td>
		<?php } ?>
		<?php } ?>
   	</tr>
	</table>
	</form>
	</div>
	<div class="buttons">
		<div class="right"><a class="button" onclick="$('#reserve-form').submit();">Reserve</a></div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').fadeIn();
		$('.display-local').fadeOut();
	});	

	$('#date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'location\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("home/autocomplete"); ?>?postcode=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.location_name,
						value: item.location_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'location\']').val(ui.item.label);
		$('input[name=\'location_id\']').val(ui.item.value);

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>