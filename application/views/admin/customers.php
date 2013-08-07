<div id="content">
	<h2 align="center">ADD NEW CUSTOMER</h2>
	<?php echo form_open('admin/customers') ?>
	<table align="center">
		<tr>
    		<td>First Name:</td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Last Name:</td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Email:</td>
    		<td><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Password:</td>
    		<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Confirm Password:</td>
    		<td><input type="password" name="password_confirm" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Telephone:</td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td>Security Question:</td>
    		<td><select name="security_question">
    			<option value=""> - please select - </option>
			<?php foreach ($security_questions as $security_question) { ?>
    			<option value="<?php echo $security_question['question_id']; ?>"><?php echo $security_question['question_text']; ?></option>
			<?php } ?>
			</select></td>
		</tr>
		<tr>
    		<td>Security Answer:</td>
    		<td><input type="text" name="security_answer" value="" class="textfield" /></td>
		</tr>
		<tr>
   			<td colspan="2" align="right"><input type="submit" name="submit" value="Add" /></td>
		</tr>
	</table>
	</form>

  	<hr>
	<h2 align="center">CUSTOMERS LIST</h2>
  	<hr>

	<?php echo form_open('admin/customers') ?>
	<table border="0" width="100%" align="center" class="list">
	<tr>
		<th>Customer ID</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Telephone</th>
		<th>Security Question</th>
		<th>Security Answer</th>
		<th>Delete</th>
		<th>Action(s)</th>
	</tr>
	<?php if ($customers) { ?>
	<?php foreach ($customers as $customer) { ?>
  	<tr>
  		<td><?php echo $customer['customer_id']; ?></td>
  		<td><?php echo $customer['first_name']; ?></td>
  		<td><?php echo $customer['last_name']; ?></td>
  		<td><?php echo $customer['email']; ?></td>
  		<td><?php echo $customer['telephone']; ?></td>
  		<td>
		<?php foreach ($security_questions as $security_question) { ?>
  		<?php if ($customer['security_question'] === $security_question['question_id']) { ?>
  			<?php echo $security_question['question_text']; ?>
		<?php } ?>
		<?php } ?>
  		</td>
  		<td><?php echo $customer['security_answer']; ?></td>
		<td><input type="checkbox" value="Delete" name="delete[<?php echo $customer['customer_id']; ?>]" /></td>
		<td>( <a class="edit" href="<?php echo $customer['edit']; ?>">Edit</a> )</td>
  	</tr>
	<?php } ?>
	<tr>
		<td colspan="8" align="right"><input type="submit" name="submit" value="Delete" /></td>
		<td></td>
	</tr>
	<?php } else { ?>
	<tr>
  		<td colspan="6" align="center"><?php echo $text_no_customers; ?></td>
	</tr>	
	<?php } ?>
	</table>
	</form>
	
	<p><?php echo $pagination['info']; ?><br /> 
	<?php echo $pagination['links']; ?></p>
</div>
