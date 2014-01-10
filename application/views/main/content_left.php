<?php 
	$route = $this->uri->segment(1, 0);

	$this->load->model('Extensions_model');
	
	$extensions = $this->Extensions_model->getExtensions();		
	
	$modules_data = array();
	foreach ($extensions as $extension) {
		if (file_exists('application/extensions/module/controllers/'. $extension['name'] .'_mod.php')) {
			$modules = unserialize($this->config->item($extension['name'] .'_module'));
		
			if ($modules) {
				foreach ($modules as $module) {
					if ($module['uri_route'] === $route && $module['position'] === 'left' && $module['status'] === '1') {
						$modules_data[] = array(
							'name' 		=> $extension['name'],
							'priority' 	=> $module['priority']
						);
					}
				}
			}
		}
	}

	$sort_modules = array();
	
	foreach ($modules_data as $key => $value) {	
		$sort_modules[$key] = $value['priority'];
	}
	
	array_multisort($sort_modules, SORT_ASC, $modules_data);
?>

<?php if (!empty($modules_data)) { ?>
	<div class="left-section">
	<?php foreach ($modules_data as $key => $value) { ?>
		<?php echo Modules::run('module/'. $value['name'] .'_mod/index'); ?>
	<?php } ?>
	</div>
<?php } ?>