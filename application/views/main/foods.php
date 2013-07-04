<div class="content">
 	<h2>Note: limit the food menu by selecting a category below:</h2>

	<!--<?php echo validation_errors(); ?>
	<?php echo form_open('foods') ?>
	<label for="food_category">Select Category</label> -->
	<ul id="category_list">
	<?php foreach ($categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['category_name']; ?></a></li>
	<?php } ?>
	</ul>
	<!--<input type="submit" name="submit" value="Show foods" /> -->
	<hr>
	<div class="food_list">
	<?php if ($foods) {?>
    <table width="90%" align="center" cellspacing="10">
        <thead>
            <th>Food Photo</th>
            <th align="left">Food</th>
            <th>Food Quantity</th>
            <th>Food Price</th>
            <th>Action(s)</th>
        </thead>
		<tbody>
			<?php foreach ($foods as $food) { ?>
			<tr>
				<td align="center"><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $food['food_photo']; ?>" width="80" height="70"></a></td>
				<td width="50%"><?php echo $food['food_name']; ?><br />
					<?php echo $food['food_description']; ?><br />
					Food Category: <?php echo $food['category_name']; ?><br />
					<font size="1">Rating: (2 reviews) / Write a review</font>
				</td>
				<td align="center"><?php echo $food['food_price']; ?></td>
				<td align="center"><select name="quantity">
					<!--<option value="<?php echo $food['quantity_value']; ?>"><?php echo $food['quantity_value']; ?></option>-->
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select></td>
				<td align="center"><a class="cart" onclick="addToCart('<?php echo $food['food_id']; ?>');">Add to Order</a></td>
			</tr>
			<?php } ?>
		</tbody>
    </table>
	<?php } else { ?>
		<p><?php echo $text_no_foods; ?></p>
	<?php } ?>
    </div>
</div>
  <!--<?php echo print_r($foods) ?>
  <br /><br /><br /><br /><br />
  <?php echo print_r($categories) ?>
  <br /><br /><br /><br /><br />
  <?php echo print_r($quantity_data) ?>-->
