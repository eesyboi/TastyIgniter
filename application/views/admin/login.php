<div class="content">
<?php if (!empty($errmsg_arr)) { ?>
	<p><?php echo $errmsg_arr; ?></p>
<? } ?>
<?php echo form_open('admin/login') ?>
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td width="112"><b>Username</b></td>
      <td width="188"><input name="login" type="text" class="textfield" id="login" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><input name="password" type="password" class="textfield" id="password" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Login" /></td>
    </tr>
  </table>
</form>
</div>
 <!--Results <?php echo print_r($errmsg_arr) ?>
  <br /><br /><br /><br /><br />
     ((((((<?php echo print_r($login_data) ?> ////////   <?php echo print_r($password_data) ?> )))))))
  <br /><br /><br /><br /><br />
  Error <?php echo print_r($errmsg_arr) ?>-->
