<div class="content">
 	<h2>Almost there, Please login or register.</h2>
 	<p><a href="<?php echo site_url('checkout/login'); ?>">Login (if existing customer)</a></p>
	<hr>
    <h3>Register (if new customer)</h3>
        
    <p><?php echo validation_errors('<span class="error">', '</span>'); ?></p>
	
	<?php echo form_open('checkout/register') ?>
	<table cellpadding="2" border="0" width="400px" align="center">
    	<tr>
        	<td colspan="2" align="center"><font size="1">*** All Required fields.</font></td>
        </tr>
  		<tr>
    		<td align="right"><label for="first_name">First Name:</label></td>
    		<td><input type="text" value="<?php echo set_value('first_name'); ?>" class="textfield" name="first_name"></td>
		</tr>
	  	<tr>
    		<td align="right"><label for="last_name">Last Name:</label></td>
    		<td><input type="text" value="<?php echo set_value('last_name'); ?>" class="textfield" name="last_name"></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="email">Email Address:</label></td>
    		<td><input type="text" value="<?php echo set_value('email'); ?>" class="textfield" name="email"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="password">Password:</label></td>
    		<td><input type="password" value="<?php echo set_value('password'); ?>" class="textfield" name="password"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="password_confirm">Password Confirm:</label></td>
    		<td><input type="password" class="textfield" name="password_confirm"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="telephone">Telephone:</label></td>
    		<td><input type="text" value="<?php echo set_value('telephone'); ?>" class="textfield" name="telephone"></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="security_question">Security Question:</label></td>
    		<td><select name="security_question">
    		<?php foreach ($questions as $question) { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		</select></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="security_answer">Security Answer:</label></td>
    		<td><input type="text" class="textfield" name="security_answer"></td>
	 	</tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" name="submit" value="Register" /></td>
        </tr>
	</table>
	</form>
</div>