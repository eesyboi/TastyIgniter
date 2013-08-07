<div class="content">
  <h2>Edit your details</h2>
	<?php echo form_open('account/details') ?>
  	<table>
  		<tr>
    		<td align="right"><label for="first_name">First Name:</label></td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" /></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="last_name">Last Name:</label></td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" /></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="email">Email Address:</label></td>
    		<td><?php echo $email; ?></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="telephone">Telephone:</label></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" /></td>
  		</tr>
   		<tr>
    		<td align="right"><label for="security_question">Security Question:</label></td>
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
    		<td align="right"><label for="security_answer">Security Answer:</label></td>
    		<td><input type="text" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" /></td>
  		</tr>
  	</table>
	<h3>Change Password</h3>
<hr>
  	<table>
  		<tr>
  			<td>Old Password:</td>
    		<td><input type="password" name="old_password" value="" /></td>
  		</tr>
  		<tr>
  			<td>New Password:</td>
    		<td><input type="password" name="new_password" value="" /></td>
  		</tr>
  		<tr>
  			<td>Confirm New Password:</td>
    		<td><input type="password" name="confirm_new_password" value="" /></td>
  		</tr>
  		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Save Details" /></td>
		</tr>
  	</table>
	</form>
</div>