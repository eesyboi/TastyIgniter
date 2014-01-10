<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW SECURITY QUESTION</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Question:</b></td>
			<td><input type="text" name="question_text" value="<?php echo set_value('question_text'); ?>" class="textfield" /></td>
		</tr>
  	</table>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Question</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($questions) {?>
		<?php foreach ($questions as $question) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $question['question_id']; ?>" name="delete[]" /></td>
			<td><?php echo $question['question_text']; ?></td>
			<td class="right">(<a class="edit" href="<?php echo $question['edit']; ?>">Edit</a>)</td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="4"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
