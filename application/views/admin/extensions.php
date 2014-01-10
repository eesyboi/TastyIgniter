<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" align="center" class="list">
		<tr>
			<th>Module Name</th>
			<th class="right" width="20%" colspan="2">Action</th>
		</tr>
		<?php foreach ($extensions as $extension) { ?>
		<tr>
			<td><?php echo $extension['name']; ?></td>
			<td class="right" width="20%">
			<?php if (isset($extension['edit'])) {?>
				(<a class="edit" href="<?php echo $extension['edit']; ?>">Edit</a>)
			<?php } ?>
			</td>
			<td class="right" width="20%">
			<?php if (isset($extension['uninstall'])) {?>
				(<a class="edit" href="<?php echo $extension['uninstall']; ?>">Uninstall</a>)
			<?php } ?>
			<?php if (isset($extension['install'])) {?>
				(<a class="edit" href="<?php echo $extension['install']; ?>">Install</a>)
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
