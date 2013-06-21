    <h2></h2>
<div id="main">
 	<h1>CHOOSE YOUR FOOD</h1>
 	<hr>
 	<h3>Note: limit the food zone by selecting a category below:</h3>

	<?php echo validation_errors(); ?>
	<?php echo form_open('foods') ?>
	<label for="food_category">Select Category</label> 
	<select name="food_category" id="food_category">
        <option value="0">- select category - </option>
		<?php foreach ($categories as $category) { ?>
        <option value="<?php echo $category['category_id']; ?>">- <?php echo $category['category_name']; ?> - </option>
		<?php } ?>
	</select>
	<input type="submit" name="submit" value="Show foods" /> 
 </form>

	<div class="food_list">
    <table>
        <thead>
            <th>Food Photo</th>
            <th>Food Name</th>
            <th>Food Description</th>
            <th>Food Category</th>
            <th>Food Price</th>
            <th>Action(s)</th>
        </thead>
		<tbody>
			<?php foreach ($foods as $food) { ?>
			<tr>
				<td><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $food['food_photo']; ?>" width="80" height="70"></a></td>
				<td><?php echo $food['food_name']; ?></td>
				<td><?php echo $food['food_description']; ?></td>
				<td><?php echo $food['category_name']; ?></td>
				<td><?php echo $food['food_price']; ?></td>
				<td><a href="<?php echo $food['food_id']; ?>">Add To Cart</a></td>
			</tr>
			<?php } ?>
		</tbody>
    </table>
    </div>
</div>
  <?php echo print_r($foods) ?>
