<<<<<<< HEAD
<div class="box">
	<div id="update-box" class="content">
	<h2>ORDER UPDATE: <?php echo $order_id; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Order ID:</b></td>
    		<td>#<?php echo $order_id; ?></td>
		</tr>
        <tr>
            <td><b>Order Type:</b></td>
            <td><?php echo $order_type; ?></td>
    	</tr>    	
        <tr>
            <td><b>Delivery/Collection Time:</b></td>
            <td><?php echo $order_time; ?></td>
    	</tr>    	
        <tr>
            <td><b>Total:</b></td>
    	    <td><?php echo $order_total; ?></td>
    	</tr>    	
        <tr>
            <td><b>Date Added:</b></td>
            <td><?php echo $date_added; ?></td>
    	</tr>    	
        <tr>
            <td><b>Date Modified:</b></td>
            <td><?php echo $date_modified; ?></td>
    	</tr>    	
	</table>

	<div class="wrap-heading">
		<h3>RESTAURANT</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><?php echo $location_name; ?></td>
		</tr>
		<tr>
    		<td><b>Address:</b></td>
    		<td><address><?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?>, <?php echo $location_country; ?></address></td>
		</tr>
	</table>
	</div>
	
	<div class="wrap-heading">
		<h3>CUSTOMER</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><?php echo $email; ?></td>
		</tr>
		<tr>
    		<td><b>Telephone:</b></td>
    		<td><?php echo $telephone; ?></td>
		</tr>
    	<tr>
    		<td><b>Comment:</b></td>
    		<td><?php echo $comment; ?></td>
	    </tr>
	</table>
	</div>

	<?php if ($order_type === '1') { ?>
	<div class="wrap-heading">
		<h3>DELIVERY</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
	    <tr>
            <td><b>Address:</b></td>
            <td><address><?php echo $address_1; ?>, <?php echo $address_2; ?>, <?php echo $city; ?> <?php echo $postcode; ?> <?php echo $country; ?></address></td>
    	</tr>    	
	</table>
	</div>
	<?php } ?>
	
	<div class="wrap-heading">
		<h3>PAYMENT</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
        <tr>
            <td><b>Payment Method:</b></td>
            <td><?php echo $payment; ?>
            <?php if ($paypal_details) { ?>
            <a class="view_details">View Transaction Details</a><br />
            <div class="paypal_details" style="display:none"><table>
            <?php foreach ($paypal_details as $key => $value) { ?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><?php echo $value; ?></td>
			</tr>
            <?php } ?>
            </table></div>
            <?php } ?>
            </td>
    	</tr>    	
	</table>
	</div>

	<div class="wrap-heading">
		<h3>STATUS & ASSIGN</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
        <tr>
            <td><b>Order Status:</b></td>
    		<td><select name="order_status">
    		<?php foreach ($statuses as $status) { ?>
    		<?php if ($status['status_id'] === $status_id) { ?>
    			<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('order_status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
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
<<<<<<< HEAD
	</table>
	</div>

	<div class="wrap-heading">
		<h3>MENUS (<?php echo $total_items; ?>)</h3>
    </div>

	<div class="wrap-content">
    <table height="auto" class="list">
        <tr>
			<th class="food_name" width="25%">Name/Options</th>
			<th width="25%">Price</th>
			<th width="25%">Quantity</th>
			<th width="25%">Sub Total</th>
        </tr>
		<?php foreach ($cart_items as $cart_item) { ?>
		<tr id="<?php echo $cart_item['id']; ?>">
			<td class="food_name"><?php echo $cart_item['name']; ?><br />
			<?php if (!empty($cart_item['options'])) { ?>
			<?php foreach ($cart_item['options'] as $option_name => $option_value) { ?>
				<div><font size="1"><strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?> </font></div>
			<?php } ?>
			<?php } ?>
			</td>
			<td><?php echo $cart_item['price']; ?></td>
			<td><?php echo $cart_item['qty']; ?></td>
			<td><?php echo $cart_item['subtotal']; ?></td>
		</tr>
		<?php } ?>
        <tr>
            <td><b>TOTAL</b></td>
            <td></td>
            <td></td>
            <td><b><?php echo $order_total; ?></b></td>
    	</tr>    	
	</table>
	</div>

	<div class="wrap-heading">
		<h3></h3>
	</div>

	<div class="wrap-content">
	<table class="form">
    	<tr>
    		<td><b>Notify Customer:</b></td>
    		<td>
    		<?php if ($notify === '1') { ?>
    			Order Confirmation Email SENT
    		<?php } else { ?>
    			Order Confirmation Email not SENT
    		<?php } ?>
	    </tr>
        <tr>
            <td><b>IP Address:</b></td>
            <td><?php echo $ip_address; ?></td>
    	</tr>    	
        <tr>
            <td><b>User Agent:</b></td>
            <td><?php echo $user_agent; ?></td>
    	</tr>    	
	</table>
	</div>
	</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.view_details').on('click', function(){
  		if($('.paypal_details').is(':visible')){
     		$('.paypal_details').fadeOut();
   			$('.view_details').attr('class', '');
		} else {
   			$('.paypal_details').fadeIn();
   			$('.view_details').attr('class', 'active');
		}
	});	
});	
</script>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
