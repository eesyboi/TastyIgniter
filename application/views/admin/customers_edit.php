<div id="content">
	<hr>
	<h2 align="center">EDIT CUSTOMER INFO (<?php echo $first_name; ?> <?php echo $last_name; ?>)</h2>
	<hr>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<table align="center">
		<tr>
    		<td>First Name:</td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Last Name:</td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Email:</td>
    		<td><?php echo $email; ?></td>
		</tr>
		<tr>
    		<td>Telephone:</td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Security Question:</td>
    		<td><select name="security_question">
    		<option value=""> please select </option>
    		<?php foreach ($questions as $question) { ?>
    		<?php if ($question['id'] === $security_question) { ?>
    			<option value="<?php echo $question['id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select></td>
		</tr>
		<tr>
    		<td>Security Answer:</td>
    		<td><input type="text" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" class="textfield" /></td>
		</tr>
  		<tr>
  			<td>Reset Password:</td>
    		<td><input type="checkbox" name="reset_password" value="1" /></td>
  		</tr>
    	<tr>
	    	<td><b>Delete:</b></td>
    		<td><input type="checkbox" name="delete" value="1" /></td>
			<td></td>
	    </tr>
		<tr>
   			<td colspan="2" align="right"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</form>
</div>
