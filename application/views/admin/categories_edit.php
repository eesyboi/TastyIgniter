<<<<<<< HEAD
<div class="box">
	<div id="update-box" class="content">
	<h2>CATEGORY UPDATE: <?php echo $category_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="category_name" class="textfield" value="<?php echo set_value('category_name', $category_name); ?>"/>
    		</td>
   		</tr>
		<tr>
			<td><b>Description:</b></td>
			<td><textarea name="category_description" rows="7" cols="50"><?php echo set_value('category_description', $category_description); ?></textarea></td>
		</tr>
	</form>
	</table>
	</div>
=======
<div id="content">
	<hr>
	<h2 align="center">UPDATE CATEGORY INFO (<?php echo $category_name; ?>)</h2>
	<hr>

	<table align="center">
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
		<tr>
    		<td>Category Name:</td>
    		<td><input type="text" name="category_name" class="textfield" value="<?php echo $val_category_name; ?>"/>
    			<input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
    		</td>
   		</tr>
   		<tr>
    		<td>Delete Category:</td>
			<td><input type="checkbox" name="delete_category" value="Yes" /></td>
   		</tr>
   		<tr>
   			<td colspan="2" align="right"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</form>
	</table>
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
</div>
