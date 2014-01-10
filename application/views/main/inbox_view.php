<div class="left-section">
	<ul id="sub_nav">
		<li><h3><a href="<?php echo site_url('menus'); ?>"><?php echo $text_order_now; ?></a></h3></li>
		<li><a href="<?php echo site_url('account/details'); ?>"><?php echo $text_edit_details; ?></a></li>
		<li><a href="<?php echo site_url('account/address'); ?>"><?php echo $text_address; ?></a></li>
		<li><a href="<?php echo site_url('account/orders'); ?>"><?php echo $text_orders; ?></a></li>
		<li><a href="<?php echo site_url('account/reservations'); ?>"><?php echo $text_reservations; ?></a></li>
		<li><a class="active" href="<?php echo site_url('account/inbox'); ?>"><?php echo $text_inbox; ?></a></li>
		<li><a href="<?php echo site_url('account/logout'); ?>"><?php echo $text_logout; ?></a></li>
	</ul>
</div>
<div class="content">
	<div class="wrap">
	<table width="100%" align="center">
		<tr>
			<td width="20%"><b><?php echo $column_date; ?>:</b></td>
			<td><?php echo $date; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_time; ?>:</b></td>
			<td><?php echo $time; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_subject; ?>:</b></td>
			<td><?php echo $subject; ?></td>
		</tr>
		<tr>
			<td colspan="2"><div class="msg_body"><?php echo $body; ?></div></td>
		</tr>
	</table>
	</div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
</div>