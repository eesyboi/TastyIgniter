<div class="content">
 	<h2>Almost there, Please login or register.</h2>
    <p><?php echo validation_errors('<span class="error">', '</span>'); ?></p>
	<?php echo form_open('checkout/login') ?>
    <h3>Login (if existing customer)</h3>
	<?php if (!empty($errmsg)) { ?>
		<p><?php echo $errmsg; ?></p>
	<?php } ?>
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
    <p><a href="<?php echo site_url('checkout/register'); ?>">Register (if new customer)</a></p>
</div>