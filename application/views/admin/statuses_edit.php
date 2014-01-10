<div class="box">
	<div id="update-box" class="content">
	<h2>STATUS UPDATE: <?php echo $status_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
	<tr>
		<td><b>Name:</b></td>
    	<td><input type="text" name="status_name" value="<?php echo set_value('status_name', $status_name); ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Comment:</b></td>
    	<td><textarea name="status_comment" cols="50" rows="7"><?php echo set_value('status_comment', $status_comment); ?> </textarea></td>
		<td></td>
    </tr>
	</table>
	</div>
	
</div>