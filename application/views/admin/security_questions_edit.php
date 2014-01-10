<div class="box">
	<div id="update-box" class="content">
	<h2>SECURITY QUESTION UPDATE: <?php echo $question_text; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
	<tr>
		<td><b>Question:</b></td>
    	<td><input type="text" name="question_text" value="<?php echo set_value('question_text', $question_text); ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
	</table>
	</div>
	
</div>