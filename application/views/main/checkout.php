<div class="content">
 	<h2>Almost there, Please login or register.</h2>
	<?php echo form_open('checkout/login') ?>
    <h3>Login</h3>
	<?php if (!empty($errmsg)) { ?>
		<p><?php echo $errmsg; ?></p>
	<? } ?>
    <table border="0" cellpadding="2" width="400px" align="center">
        <tr>
            <td align="right"><b>Email</b></td>
            <td><input name="email" type="text" class="textfield" id="email" /></td>
    	</tr>
        <tr>
            <td align="right"><b>Password</b></td>
            <td><input name="password" type="password" class="textfield" id="password" /></td>
        </tr>
        <tr>
            <td align="right"><input name="remember" type="checkbox" class="" id="remember" value="1" /></td>
            <td>Remember me</td>
        </tr>
        <tr>
            <td align="right"></td>
            <td><a href="">Forgot password?</a></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" name="submit" value="Login" /></td>
        </tr>
    </table>
    </form>
 	<hr>
    <h3>Register</h3>
    <p>
    	<?php echo validation_errors('<span class="error">', '</span>'); ?>
    	<!--<?php echo form_error('first_name', '<li>', '</li>'); ?>
    	<?php echo form_error('last_name', '<li>', '</li>'); ?>
    	<?php echo form_error('email', '<li>', '</li>'); ?>
    	<?php echo form_error('password', '<li>', '</li>'); ?>
    	<?php echo form_error('password_confirm', '<li>', '</li>'); ?>
    	<?php echo form_error('telephone', '<li>', '</li>'); ?>
    	<?php echo form_error('security_question', '<li>', '</li>'); ?>
    	<?php echo form_error('security_answer', '<li>', '</li>'); ?>-->
    </p>
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
  		<!--<tr>
    		<td align="right"><label for="address">Address:</label></td>
    		<td colspan="2"><input type="text" id="address" class="textfield" name="address"></td>
 	 	</tr>
  		<tr>
    		<td align="right"><label for="city">City:</label></td>
   			<td width="140"><input type="text" id="city" class="textfield" name="city"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="postcode">Postcode:</label></td>
   			<td width="140"><input type="text" id="postcode" name="postcode"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="country">Country:</label></td>
   			<td width="140"><input type="text" id="country" name="country"></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="request">Any Special Delivery Request:</label></td>
    		<td colspan="2"><textarea rows="5" cols="32" id="request" name="request"></textarea><br>
    		<span class="minitext" id="sBann">100 characters left.</span></td>
	  	</tr>
  		<tr>
    		<td align="right">Payment Method:</td>
    		<td><input type="radio" value="cod" name="payment_method"><label for="payment_method">Cash On Delivery</label><br />
    		<input type="radio" value="cdcp" name="paymentmethod"><label for="paymentmethod">Credit/Debit Card Payment</label>
    		</td>
    	</tr>-->
        <tr>
        	<td colspan="2" align="center"><input type="submit" name="submit" value="Register" /></td>
        </tr>
	</table>
	</form>
</div>