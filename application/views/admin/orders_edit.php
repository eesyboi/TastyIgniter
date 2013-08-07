<div id="content">
	<hr>
	<h2 align="center">UPDATE ORDER INFO (#<?php echo $order_id; ?>)</h2>
	<hr>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<table border="0" width="50%" align="center">
		<tr>
    		<td><b>Restaurant Name:</b></td>
    		<td><?php echo $location_name; ?></td>
		</tr>
		<tr>
    		<td><b>Restaurant Address:</b></td>
    		<td><address><?php echo $location_address; ?>, <?php echo $location_region; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?></address></td>
		</tr>
		<tr>
    		<td><b>Customer Name:</b></td>
    		<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
		</tr>
		<tr>
    		<td><b>Customer Email:</b></td>
    		<td><?php echo $email; ?></td>
		</tr>
		<tr>
    		<td><b>Customer Telephone:</b></td>
    		<td><?php echo $telephone; ?></td>
		</tr>
		<?php if ($order_type === 'Delivery') { ?>
	    <tr>
            <td><b>Customer Address:</b></td>
            <td><address><?php echo $address_1; ?>, <?php echo $address_2; ?>, <?php echo $city; ?> <?php echo $postcode; ?> <?php echo $country; ?></address></td>
    	</tr>    	
		<?php } ?>
        <tr>
            <td><b>Order Type:</b></td>
            <td><?php echo $order_type; ?></td>
    	</tr>    	
        <tr>
            <td><b>Order Date:</b></td>
            <td><?php echo $order_date; ?></td>
    	</tr>    	
        <tr>
            <td><b>Delivery/Collection Time:</b></td>
            <td><?php echo $order_time; ?></td>
    	</tr>    	
        <tr>
            <td><b>Order Total:</b></td>
            <td><?php echo $order_total; ?></td>
    	</tr>    	
        <tr>
            <td><b>Payment Method:</b></td>
            <td><?php echo $payment_method; ?></td>
    	</tr>    	
    	<tr>
    		<td><b>Order Comment:</b></td>
    		<td><?php echo $comment; ?></td>
	    </tr>
        <tr>
            <td><b>Order Status:</b></td>
    		<td><select name="order_status">
    		<?php foreach ($order_statuses as $order_status) { ?>
    		<?php if ($order_status['order_status_id'] === $order_status_id) { ?>
    			<option value="<?php echo $order_status['order_status_id']; ?>" <?php echo set_select('order_status', $order_status['order_status_id'], TRUE); ?> ><?php echo $order_status['order_status_name']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $order_status['order_status_id']; ?>" <?php echo set_select('order_status', $order_status['order_status_id']); ?> ><?php echo $order_status['order_status_name']; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select></td>
    	</tr>    	
        <tr>
            <td><b>Assigned Staff:</b></td>
    		<td><select name="assigned_staff">
    		<option value=""> - please select - </option>
    		<?php foreach ($staffs as $staff) { ?>
    		<?php if ($staff['staff_id'] === $staff_id) { ?>
    			<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assigned_staff', $staff['staff_id'], TRUE); ?> ><?php echo $staff['staff_name']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assigned_staff', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select></td>
    	</tr>    	
    	<tr>
    		<td><b>Notify Customer:</b></td>
    		<td>
    		<?php if ($notify === '1') { ?>
    			<input type="checkbox" name="notify" checked="checked" value="1" <?php echo set_value('notify', $notify); ?> /></td>
    		<?php } else { ?>
	    		<input type="checkbox" name="notify" value="1" <?php echo set_value('notify', $notify); ?> /></td>
    		<?php } ?>
	    </tr>
    	<tr>
    		<td><b>Delete Order:</b></td>
    		<td><input type="checkbox" name="delete" value="1" /></td>
	    </tr>
		<tr>
   			<td colspan="2" align="center"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</form>
	<br /><br /><br />

	<hr>
	<h3 align="center">ORDER ITEMS</h3>
	<hr>
    <table width="100%" height="auto" class="list" align="center">
        <tr>
			<th class="food_name">Food Name/Options</th>
			<th>Food Price</th>
			<th>Food Quantity</th>
			<th>Food Total</th>
        </tr>
		<?php foreach ($cart_items as $cart_item) { ?>
		<tr id="<?php echo $cart_item['rowid']; ?>">
			<td class="food_name"><?php echo $cart_item['name']; ?><br />
			<?php foreach ($cart_item['options'] as $option_name => $option_value) { ?>
				<div><font size="1"><strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?> </font></div>
			<?php } ?>
			</td>
			<td><?php echo $this->currency->symbol(); ?><?php echo $cart_item['price']; ?></td>
			<td><?php echo $cart_item['qty']; ?></td>
			<td><?php echo $this->currency->symbol(); ?><?php echo number_format($cart_item['subtotal'], 2); ?></td>
		</tr>
		<?php } ?>
	</table>
</div>