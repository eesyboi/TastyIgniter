<div class="left-section">
<<<<<<< HEAD
	<h3><?php echo $text_categories; ?></h3>
=======
	<h3>Menu Categories</h3>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
	<ul id="sub_nav">
	<?php foreach ($categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['category_name']; ?></a></li>
	<?php } ?>
<<<<<<< HEAD
    <li><a href="<?php echo site_url('menus'); ?>" class="active"><?php echo $text_specials; ?> <small>[<?php echo $text_clear; ?>]</small></a></li>
	</ul>
</div>
<div class="right-section">
	<div id="local-box">
	<h3><?php echo $text_local; ?></h3>	
	<div class="display-local" style="display: <?php echo ($local_location ? 'block' : 'none'); ?>">
		<font size="3"><?php echo $local_location['location_name']; ?></font><br />  	
		<address><?php echo $local_location['location_address_1']; ?>, <?php echo $local_location['location_city']; ?>, <?php echo $local_location['location_postcode']; ?></address> 	
		<?php echo $local_location['location_telephone']; ?><br /><br />
		
		<span class="is-open"><?php echo $text_open_or_close; ?></span><br />
		<span class=""><?php echo $text_delivery; ?></span><br />
		<span class=""><?php echo $text_collection; ?></span><br />
		<span class=""><?php echo $text_delivery_charge; ?>: <?php echo $delivery_charge; ?></span>
	
		<span id="check-postcode"><a><?php echo $button_check_postcode; ?></a></span>

	</div>
	<div class="check-local" style="display: <?php echo ($local_location ? 'none' : 'block'); ?>">
	<form id="location-form" method="POST" action="<?php echo site_url('distance'); ?>">
		<font size="1"><?php echo $text_postcode_warning; ?></font><br />
		<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
		<input type="text" id="postcodeInput" name="postcode" size="20" />
		<input type="button" onclick="$('#location-form').submit();" value="<?php echo $text_find; ?>" />
	</form>
	</div>
	</div>
	<div id="cart-box"></div>
	<div class="buttons">
		<div class="right"><a class="button" href="<?php echo $checkout; ?>"><?php echo $button_checkout; ?></a></div>
	</div>
</div>
<div class="content">
<div class="wrap">
 	<h3><?php echo $text_filter; ?></h3>
	<div class="menu_list">
	<?php if ($specials) {?>
    <table width="100%" align="center" class="list">
        <thead>
            <th><?php echo $column_id; ?></th>
            <th><?php echo $column_photo; ?></th>
            <th align="left"><?php echo $column_menu; ?></th>
            <th><?php echo $column_price; ?></th>
            <th><?php echo $column_action; ?></th>
        </thead>
		<tbody>
			<?php foreach ($specials as $special) { ?>
			<tr id="<?php echo $special['menu_id']; ?>">
				<td align="center"><?php echo $special['menu_id']; ?></td>
				<td align="center"><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $special['menu_photo']; ?>" width="80" height="70"></a></td>
				<td class="menu_name"><?php echo $special['menu_name']; ?><br />
					<font size="1"><?php echo $special['menu_description']; ?></font>
				</td>
				<td align="center">
					<strike><?php echo $special['menu_price']; ?></strike><br /><br />
					<?php echo $special['special_price']; ?>
				</td>
				<td align="center">
					<select name="quantity" class="cart" onChange="addToCart('<?php echo $special['menu_id']; ?>');">
						<?php foreach ($quantities as $key => $value) { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php }?>
					</select><br />

					<font size="1"><?php echo $special['end_days']; ?><br />
					<?php echo $special['end_date']; ?><br />

					<a id="review" onclick="openReviewBox('<?php echo $special['menu_id']; ?>');"><?php echo $button_review; ?></a>
					<div id="total-review">
					<?php foreach ($menu_reviews as $menu_review) { ?>
					<?php if ($menu_review['menu_id'] === $special['menu_id']) {?>
					(<?php echo $menu_review['total_reviews']; ?> <?php echo $text_reviews; ?>)<br />
					<?php }?>
					<?php }?>
					</div>
					</font>
				</td>
=======
    <li><a href="<?php echo site_url('foods'); ?>" class="active">Special Deals  <small>[clear]</small></a></li>
	</ul>
</div>
<div class="right-section">
	<div>
		<h3>Your Nearest Restaurant</h3>
		<?php if ($nearest_location) { ?>
 			<?php echo $nearest_location['location_name']; ?><br />  	
 			<?php echo $nearest_location['location_address']; ?><br />  	
 			<?php echo $nearest_location['location_region']; ?><br />  	
 			<?php echo $nearest_location['location_postcode']; ?><br />  	
 			<?php echo $nearest_location['location_phone_number']; ?>
 			<input type="hidden" name="locations" value="<?php echo $nearest_location['location_id']; ?>" /> 	

		<?php } else { ?>
  		<select name="nearest_location">
  			<option value=""> - select nearest restaurant - </option>
			<?php foreach ($locations as $location) { ?>
 				<option value="<?php echo $location['location_id']; ?>"> - <?php echo $location['location_name']; ?> - </option>  	
			<?php } ?>
  		</select>
		<input type="submit" name="submit" value="Go" /> 
		<?php } ?>
	</div>
	<div id="cart-box"></div>
	<div class="buttons">
		<div class="right"><a href="<?php echo $checkout; ?>">Checkout</a></div>
	</div>
</div>
<div class="content">
 	<h3>Note: limit the food menu by selecting a category on the left:</h3>
	<hr>
	<div class="deal_list">
	<?php if ($deals) {?>
    <table width="100%" align="center" class="list">
        <thead>
            <th>Deal Photo</th>
            <th align="left">Deal</th>
            <th>Deal Price</th>
            <th>Action(s)</th>
        </thead>
		<tbody>
			<?php foreach ($deals as $deal) { ?>
			<tr id="<?php echo $deal['deal_id']; ?>">
				<td align="center"><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $deal['deal_photo']; ?>" width="80" height="70"></a></td>
				<td class="food_name"><?php echo $deal['deal_name']; ?><br />
				<font size="1"><?php echo $deal['deal_description']; ?>
					<div id="rating">
					<select name="rating" class="star-rating" style="cursor: pointer; width: 60px;"  onchange="foodReview('<?php echo $deal['deal_id']; ?>');">
  					<option value="">select rating</option>
					<?php foreach ($ratings as $rating) { ?>
						<option value="<?php echo $rating['rating_id']; ?>"><?php echo $rating['rating_name']; ?></option>
					<?php }?>
					</select>
					(2 reviews)
					</div>
				</font>
				</td>
				<td align="center"><?php echo $deal['deal_price']; ?></td>
				<td align="center"><button class="cart" onclick="addToCart('<?php echo $deal['deal_id']; ?>');">Add to Order</button></td>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
			</tr>
			<?php } ?>
		</tbody>
    </table>
	<?php } else { ?>
<<<<<<< HEAD
		<p><?php echo $text_empty; ?></p>
	<?php } ?>
    </div>
</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#cart-box').load('<?php echo site_url("cart"); ?> #cart > *');

  	$('#check-postcode').on('click', function() {
		$('.check-local').show();
		$('.display-local').hide();
	});	

});
//--></script> 
=======
		<p><?php echo $text_no_deals; ?></p>
	<?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#cart-box').load('<?php echo site_url("cart"); ?> #cart > *');
});
//--></script> 

  <!--<?php echo print_r($cart_items) ?>
  <br /><br /><br /><br /><br />
  <?php echo print_r($categories) ?>
  <br /><br /><br /><br /><br />
  <?php echo print_r($cart_contents) ?>-->
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
