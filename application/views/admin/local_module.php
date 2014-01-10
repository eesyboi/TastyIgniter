<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table align=""class="list">
		<tr>
    		<th><b>URI Route:</b></th>
    		<th><b>Position:</b></th>
    		<th><b>Priority:</b></th>
    		<th><b>Status:</b></th>
    		<th><b>Action:</b></th>
		</tr>
        <?php $module_row = 0; ?>
     	<?php foreach ($modules as $module) { ?>
		<tr id="module-row<?php echo $module_row; ?>">
            <td><input type="text" name="modules[<?php echo $module_row; ?>][uri_route]" value="<?php echo $module['uri_route']; ?>" /></td>
            <td><input type="text" name="modules[<?php echo $module_row; ?>][position]" value="<?php echo $module['position']; ?>" /></td>
            <td><input type="text" name="modules[<?php echo $module_row; ?>][priority]" value="<?php echo $module['priority']; ?>" size="5" /></td>
    		<td><select name="modules[<?php echo $module_row; ?>][status]">
	   			<option value="0" >Disabled</option>
     		<?php if ($module['status'] === '1') { ?>
    			<option value="1" selected="selected">Enabled</option>
			<?php } else { ?>  
    			<option value="1" >Enabled</option>
			<?php } ?>  
    		</select></td>
			<td class="left"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>
		</tr>
        <?php $module_row++; ?>
		<?php } ?>  
		<tr id="tfoot">
		  	<td colspan="4"></td>
		  	<td class="left"><img src="<?php echo base_url('assets/img/add.png'); ?>" onclick="addModule();" /></td>
		</tr>		 
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tr id="module-row' + module_row + '">';
	html += '	<td><input type="text" name="modules[' + module_row + '][uri_route]" value="" /></td>';
	html += '	<td><input type="text" name="modules[' + module_row + '][position]" value="" /></td>';
	html += '	<td><input type="text" name="modules[' + module_row + '][priority]" value="" size="5" /></td>';
	html += '   <td><select name="modules[' + module_row + '][status]">';
    html += '      <option value="1">Enabled</option>';
    html += '      <option value="0">Disabled</option>';
    html += '   </select></td>';
	html += '	<td class="left"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	module_row++;
}
//--></script> 