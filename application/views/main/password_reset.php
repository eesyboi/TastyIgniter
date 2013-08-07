<div class="content">
	<?php echo form_open('main/password_reset') ?>
    <table border="0" cellpadding="2" width="" align="center" id="email-check">
     	<tr>
        	<td align="right"><b>Email:</b></td>
        	<td><input name="email" type="text" value="<?php echo set_value('email'); ?>" class="textfield" id="email" /></td>
    	</tr>
     	<tr>
            <td align="right"><b>Your Security Question:</b></td>
    		<td><select name="security_question">
    		<?php foreach ($questions as $question) { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		</select></td>
     	</tr>
     	<tr>
            <td align="right"><b>Your Security Answer:</b></td>
        	<td><input type="text" name="security_answer" class="textfield" id="security-answer" /></td>
     	</tr>
     	<tr>
            <td align="right"><b>New Password:</b></td>
        	<td><input type="password" name="new_password" class="textfield" id="new-password" /></td>
     	</tr>
     	<tr>
            <td align="right"><b>Confirm New Password:</b></td>
        	<td><input type="password" name="confirm_new_password" class="textfield" id="confirm-new-password" /></td>
     	</tr>
	    <tr>
        	<td colspan="2" align="right"><input type="submit" name="submit" value="Reset Password" /></td>
    	</tr>
    </table>
	</form>
</div>