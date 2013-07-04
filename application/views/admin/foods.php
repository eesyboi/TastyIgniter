<div class="content">
	<h3>ADD A NEW FOOD</h3>
	<?php echo $upload_error; ?>
	<?php echo form_open_multipart('admin/foods') ?>
	<table width="760">
	<tr>
		<td>Name</td>
    	<td><input type="text" name="food_name" id="name" class="textfield" /></td>
    </tr>
    <tr>
    	<td>Description</td>
    	<td><textarea name="food_description" id="description" class="textfield" rows="4" cols="55"></textarea></td>
    </tr>
    <tr>
    	<td>Price</td>
	    <td><input type="text" name="food_price" id="price" class="textfield" /></td>
    </tr>
	<tr>
    	<td>Category</td>
    	<td><select name="food_category" id="category">
		<?php foreach ($categories as $category) { ?>
    		<option value="<?php echo $category['category_id']; ?>">- <?php echo $category['category_name']; ?> - </option>
		<?php } ?>
		</select>
		</td>
	</tr>
	<tr>
    	<td>Photo</td>
    	<td><input type="file" name="userfile" id="photo"/></td>
    </tr>
    <tr>
    	<td>Action</td>
    	<td><input type="submit" name="add_food" value="Add" /></td>
    </tr>
	</table>
	</form>
<hr>
	<table width="950" align="center">
	<CAPTION><h3>AVAILABLE FOODS</h3></CAPTION>
		<tr>
            <th>Food ID</th>
			<th>Food Photo</th>
			<th>Food Name</th>
			<th>Food Description</th>
			<th>Food Price</th>
			<th>Food Category</th>
			<th>Action(s)</th>
		</tr>
		<?php if ($foods) {?>
		<?php foreach ($foods as $food) { ?>
		<tr>
			<td><?php echo $food['food_id']; ?></td>
			<td><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $food['food_photo']; ?>" width="80" height="70"></a></td>
			<td><?php echo $food['food_name']; ?></td>
			<td><?php echo $food['food_description']; ?></td>
			<td><?php echo $food['food_price']; ?></td>
			<td><?php echo $food['category_name']; ?></td>
			<td><a class="cart" onclick="removeFood('<?php echo $food['food_id']; ?>');">Remove Food</a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7"><?php echo $text_no_foods; ?></td>
		</tr>
		<?php } ?>
	</table>
</div>