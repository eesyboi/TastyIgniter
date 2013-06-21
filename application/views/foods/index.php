    <h2></h2>
<div id="main">
 	<h1>CHOOSE YOUR FOOD</h1>
 	<hr>
 	<h3>Note: limit the food zone by selecting a category below:</h3>

	<?php echo validation_errors(); ?>
	<?php echo form_open('foods') ?>
	<label for="category">Select Category</label> 
	<select name="category" id="category">
        <option value="">- select category - </option>
		<?php foreach ($categories as $category) { ?>
        <option value="<?php echo $category['id']; ?>">- <?php echo $category['name']; ?> - </option>
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
				<td><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $food['photo']; ?>" width="80" height="70"></a></td>
				<td><?php echo $food['name']; ?></td>
				<td><?php echo $food['description']; ?></td>
				<td>Category Name</td>
				<td><?php echo $food['price']; ?></td>
				<td><a href="<?php echo $food['id']; ?>">Add To Cart</a></td>
			</tr>
			<?php } ?>
		</tbody>
    </table>
    </div>
</div>