<<<<<<< HEAD
<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Order ID</th>
			<th>Location</th>
			<th>Customer Name</th>
			<th>Status</th>
			<th>Assigned Staff</th>
			<th>Type</th>
			<th>Ready Time</th>
			<th class="right">Date Added</th>
			<th class="right">Date Modified</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($orders) { ?>
		<?php foreach ($orders as $order) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" /></td>
			<td class="id"><?php echo $order['order_id']; ?></td>
			<td><?php echo $order['location_name']; ?></td>
			<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
			<td><?php echo $order['order_status']; ?></td>
			<td><?php echo $order['staff_name'] ? $order['staff_name'] : 'NONE'; ?></td>
			<td><?php echo $order['order_type']; ?></td>
			<td><?php echo $order['order_time']; ?></td>
			<td class="right"><?php echo $order['date_added']; ?></td>
			<td class="right"><?php echo $order['date_modified']; ?></td>
			<td class="right">(<a class="edit" href="<?php echo $order['edit']; ?>">Edit</a>)</td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="11" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	
	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
