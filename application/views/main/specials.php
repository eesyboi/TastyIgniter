<div class="left-section">
	<h3>Menu Categories</h3>
	<ul id="sub_nav">
	<?php foreach ($categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['category_name']; ?></a></li>
	<?php } ?>
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
			</tr>
			<?php } ?>
		</tbody>
    </table>
	<?php } else { ?>
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
