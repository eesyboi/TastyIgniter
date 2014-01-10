<<<<<<< HEAD
<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW CUSTOMER</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
    		<td><b>First Name:</b></td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Last Name:</b></td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Password:</b></td>
    		<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Confirm Password:</b></td>
    		<td><input type="password" name="password_confirm" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Telephone:</b></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Security Question:</b></td>
    		<td><select name="security_question">
    			<option value=""> - please select - </option>
			<?php foreach ($questions as $question) { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
			<?php } ?>
			</select></td>
		</tr>
		<tr>
<<<<<<< HEAD
    		<td><b>Security Answer:</b></td>
    		<td><input type="text" name="security_answer" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="status">
    			<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
    		</select></td>
		</tr>
	</table>
	<div class="wrap-heading">
		<h3>ADDRESS 1</h3>
	</div>

	<div class="wrap-content">
    <input type="hidden" name="address[address_id]" value="<?php echo set_value('address[address_id]'); ?>" />
	<table class="form">
		<tr>
			<td><b>Address 1:</b></td>
			<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Address 2:</b></td>
			<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>City:</b></td>
			<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Postcode:</b></td>
			<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Country:</b></td>
			<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select></td>
		</tr>
	</table>
	</div>	
	</form>
  	</div>
  	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Telephone</th>
			<th class="right">Date Added</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($customers) { ?>
		<?php foreach ($customers as $customer) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $customer['customer_id']; ?>" name="delete[]" /></td>
			<td><?php echo $customer['first_name']; ?></td>
			<td><?php echo $customer['last_name']; ?></td>
			<td><?php echo $customer['email']; ?></td>
			<td><?php echo $customer['telephone']; ?></td>
			<td class="right"><?php echo $customer['date_added']; ?></td>
			<td class="right"><?php echo $customer['status']; ?></td>
			<td class="right">(<a class="edit" href="<?php echo $customer['edit']; ?>">Edit</a>)</td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="6" align="center"><?php echo $text_no_customers; ?></td>
		</tr>	
		<?php } ?>
	</table>
	</form>
	
	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
</div>
