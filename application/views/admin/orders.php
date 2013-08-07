<div id="content">
	<h2 align="center">ORDERS LIST</h2>
  	<hr>

	<table border="0" width="100%" align="center" class="list">
	<tr>
		<th>Order ID</th>
		<th>Customer Name</th>
		<th>Status</th>
		<th>Assigned Staff</th>
		<th>Total</th>
		<th>Order Date</th>
		<th>Restaurant Location</th>
		<th>Email Sent</th>
		<th>Actions(s)</th>
	</tr>
  	<?php if ($orders) { ?>
	<?php foreach ($orders as $order) { ?>
  	<tr>
  		<td><?php echo $order['order_id']; ?></td>
  		<td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
  		<td><?php echo $order['order_status']; ?></td>
  		<td><?php echo $order['staff_name'] ? $order['staff_name'] : 'NONE'; ?></td>
  		<td><?php echo $order['order_total']; ?></td>
  		<td><?php echo $order['order_date']; ?></td>
  		<td><?php echo $order['location_name']; ?></td>
  		<td><?php echo $order['notify'] ? 'YES' : '<b>NO</b>'; ?></td>
		<td>( <a class="edit" href="<?php echo $order['edit']; ?>">View/Edit</a> )</td>
  	</tr>
  	<?php } ?>
  	<?php } else { ?>
  	<tr>
  		<td colspan="10" align="center"><?php echo $text_no_orders; ?></td>
  	</tr>
  	<?php } ?>
	</table>
	<p><?php echo $pagination['info']; ?><br /> 
	<?php echo $pagination['links']; ?></p>
</div>
