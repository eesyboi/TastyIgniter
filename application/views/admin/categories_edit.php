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
</div>
