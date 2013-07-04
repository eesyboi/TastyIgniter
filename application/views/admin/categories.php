<div id="content">
	<?php echo $error; ?>
	<table>
	<CAPTION><h3>ADD NEW CATEGORY</h3></CAPTION>
	<?php echo form_open('admin/categories') ?>
		<tr>
    		<td>Name:</td>
    		<td><input type="text" name="category_name" class="textfield" /></td>
    	</tr>
    	<?php if ($category_options) { ?>
		<tr>
    		<td>Food Option:</td>
    		<td><select name="option_name">
				<option value="">None</option>
    		<?php foreach ($category_options as $category_option) { ?>
    			<option value="<?php echo $category_option['option_name']; ?>"><?php echo $category_option['option_name']; ?></option>
    		<?php } ?>
    		</select></td>
    	</tr>
    	<?php } ?>
    	<tr>
   			<td colspan="2" align="right"><input type="submit" name="category" value="Add" /></td>
		</tr>
	</form>
	</table>
	<hr>
	<!--<div style="float:right"">
	<table>
	<?php echo form_open('admin/categories') ?>
	<CAPTION><h3>ADD NEW CATEGORY OPTIONS</h3></CAPTION>
		<tr>
    		<td>Option Name:</td>
    		<td><input type="text" name="option_name" class="textfield" /></td>
    		<td>Option Value:</td>
    		<td><input type="text" name="option_value" class="textfield" /></td>
    		<td>Option Price:</td>
    		<td><input type="text" name="option_price" class="textfield" /></td>
    	</tr>
    	<tr>
   			<td><input type="submit" name="category_option" value="Add" /></td>
		</tr>
	</form>
	</table>
	</div>-->
  	<hr>
	<table width="480" align="center">
	<CAPTION><h3>AVAILABLE CATEGORIES</h3></CAPTION>
		<tr>
			<th>Category ID</th>
			<th>Category Name</th>
			<th>Option Name</th>			
			<th>Action(s)</th>			
		</tr>
		<?php foreach ($categories as $category) { ?>
  		<tr>
  			<td><?php echo $category['category_id']; ?></td>
  			<td><?php echo $category['category_name']; ?></td>
  			<td><?php echo $category['option_name']; ?></td>
  			<td><input type="radio" onclick="removeCategory('<?php echo $category['category_id']; ?>');" /> REMOVE |  
  				<a>EDIT</a>
  			</td>
  		</tr>

		<?php } ?>
		<tr>
			<td colspan="4" align="right"><a href="<?php echo base_url('admin/categories'); ?>">REFRESH PAGE</a></td>
		</tr>
	</table>
	<hr>
</div>
