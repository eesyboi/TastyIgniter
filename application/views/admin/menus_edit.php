<div class="box">
	<div id="update-box" class="content">
	<h2>MENU UPDATE: <?php echo $menu_name; ?></h2>
	<form enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
	<tr>
		<td><b>Name:</b></td>
    	<td><input type="text" name="menu_name" value="<?php echo set_value('menu_name', $menu_name); ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Description:</b></td>
		<td><textarea name="menu_description" rows="5" cols="45"><?php echo set_value('menu_description', $menu_description); ?></textarea></td>
	</tr>
    <tr>
    	<td><b>Price:</b></td>
	    <td><input type="text" name="menu_price" value="<?php echo set_value('menu_price', $menu_price); ?>" id="price" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
    	<td><b>Category:</b></td>
    	<td><select name="menu_category" id="category">
    		<option value=""> - please select - </option>
		<?php foreach ($categories as $category) { ?>
		<?php if ($menu_category === $category['category_id']) { ?>
    		<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id'], TRUE); ?> >- <?php echo $category['category_name']; ?> - </option>
		<?php } else { ?>
    		<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id']); ?> >- <?php echo $category['category_name']; ?> - </option>
		<?php } ?>
		<?php } ?>
		</select></td>
		<td></td>
	</tr>
	<tr>
    	<td><b>Photo:</b><br />
    	<font size="1" color="red">(select a file to update menu photo, otherwise leave blank)</font></td>
    	<td><div class="selectbox" style="height:100px">
    	<table width="390">
			<tr>
				<th><b>Existing</b></th>
				<th><b>New</b></th>
			</tr>
			<tr>
				<td><img src="<?php echo $menu_photo; ?>" width="80" height="70"></td>
    			<td><input type="file" name="menu_photo" value="" id="photo"/></td>
			</tr>
		</table>
		</div></td>
    </tr>
	<tr>
    	<td><b>Stock Quantity:</b></td>
	    <td><input type="text" name="stock_qty" value="<?php echo set_value('stock_qty', $stock_qty); ?>" id="stock" class="textfield" /></td>
    </tr>
	<tr>
    	<td><b>Minimum Quantity:</b></td>
	    <td><input type="text" name="minimum_qty" value="<?php echo set_value('minimum_qty', $minimum_qty); ?>" id="minimum" class="textfield" /></td>
    </tr>
	<tr>
		<td><b>Status:</b></td>
		<td><select name="menu_status">
			<option value="0" <?php echo set_select('menu_status', '0'); ?> >Disabled</option>
		<?php if ($menu_status === '1') { ?>
			<option value="1" <?php echo set_select('menu_status', '1', TRUE); ?> >Enabled</option>
		<?php } else { ?>  
			<option value="1" <?php echo set_select('menu_status', '1'); ?> >Enabled</option>
		<?php } ?>  
		</select></td>
	</tr>
	</table>

	<div class="wrap-heading">
		<h3>MENU OPTIONS</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
	<tr>
    	<td><b>Menu Options:</b></td>
    	<td><input type="text" name="menu_option" value="" class="textfield" /></td>
    </tr>
    <tr>
    	<td></td>
    	<td><div id="menu-option" class="selectbox">
    	<table>
		<?php foreach ($menu_options as $menu_option) { ?>
		<?php if (in_array($menu_option['option_id'], $has_options)) { ?>
			<tr id="menu-option<?php echo $menu_option['option_id']; ?>">
				<td class="name"><?php echo $menu_option['option_name']; ?></td>
				<td><?php echo $menu_option['option_price']; ?></td>
				<td class="img"><img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" /><input type="hidden" name="menu_options[]" value="<?php echo $menu_option['option_id']; ?>" /></td>
			</tr>
		<?php } ?>
		<?php } ?>
		</table>
		</div></td>
	</tr>
	</table>
	</div>
	
	<div class="wrap-heading">
		<h3>SPECIAL</h3>
	</div>

	<div class="wrap-content">
	<table width="400" class="list">
		<tr>
			<th><b></b></th>
			<th><b>Start Date</b></th>
			<th><b>End Date</b></th>
			<th><b>Special Price</b></th>
			<th><b></b></th>
		</tr>
		<tr>
			<th><b>Special:</b></th>
			<td><input type="text" name="start_date" id="start-date" value="<?php echo set_value('start_date', $start_date); ?>" class="textfield" /></td>
			<td><input type="text" name="end_date" id="end-date" value="<?php echo set_value('end_date', $end_date); ?>" class="textfield" /></td>
			<td><input type="text" name="special_price" value="<?php echo set_value('special_price', $special_price); ?>" class="textfield" /></td>
			<td><select name="menu_special">
			<?php if ($start_date) { ?>
				<option value="0" <?php echo set_select('menu_special', '0'); ?> >Disabled</option>
				<option value="1" selected="selected" <?php echo set_select('menu_special', '1'); ?> >Enabled</option>
			<?php } else { ?>
				<option value="0" <?php echo set_select('menu_special', '0'); ?> >Disabled</option>
				<option value="1" <?php echo set_select('menu_special', '1'); ?> >Enabled</option>
			<?php } ?>
			</select></td>
		</tr>
	</table>
	</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'menu_option\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menu_options/autocomplete"); ?>?option_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.option_name,
						value: item.option_id,
						price: item.option_price
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#menu-option' + ui.item.value).remove();
		$('#menu-option table').append('<tr id="menu-option' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.price + '</td><td class="img">' + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" />' + '<input type="hidden" name="menu_options[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>