<?php
class Coupons extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Coupons_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {

		if ( !file_exists('application/views/admin/coupons.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/coupons')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Coupons';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new coupon</a></li>';
		$data['text_empty'] 		= 'There are no coupons, please add!.';

		$data['coupons'] = array();
		$results = $this->Coupons_model->getList($filter);
		foreach ($results as $result) {					
			$data['coupons'][] = array(
				'coupon_id'		=>	$result['coupon_id'],
				'name'			=>	$result['name'],
				'code'			=>	$result['code'],
				'type'			=>	$result['type'],
				'discount'		=>	$result['discount'],
				'min_total'		=>	$result['min_total'],
				'description'	=>	$result['description'],
				'status'		=>	$result['status'],
				'edit' 			=> $this->config->site_url('admin/coupons/edit/' . $result['coupon_id'])
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/coupons');
		$config['total_rows'] 		= $this->Coupons_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post() && $this->_addCoupon() === TRUE) {
		
			redirect('admin/coupons');  			
		}

		//check if POST submit then remove food_id
		if ($this->input->post('delete') && $this->_deleteCoupon() === TRUE) {
			
			redirect('admin/coupons');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/coupons', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {

		if ( !file_exists('application/views/admin/coupons_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/coupons')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$coupon_id = $this->uri->segment(4);
		} else {
		    redirect('admin/coupons');
		}
		
		$result = $this->Coupons_model->getCoupon($coupon_id);
		
		if ($result) {
			$data['heading'] 			= 'Coupons';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/coupons');

			$data['coupon_id'] 			= $result['coupon_id'];
			$data['name'] 				= $result['name'];
			$data['code'] 				= $result['code'];
			$data['type'] 				= $result['type'];
			$data['discount'] 			= $result['discount'];
			$data['min_total'] 			= $result['min_total'];
			$data['description'] 		= $result['description'];
			$data['start_date'] 		= $result['start_date'];
			$data['end_date'] 			= $result['end_date'];
			$data['date_added'] 		= $result['date_added'];
			$data['status'] 			= $result['status'];

			//check if POST add_Ratings, validate fields and add Ratings to model
			if ($this->input->post() && $this->_updateCoupon($coupon_id) === TRUE) {
						
				redirect('admin/coupons');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/coupons_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addCoupon() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			$time_format = '%h:%i';
			$current_date_time = time();

			$this->form_validation->set_rules('name', 'Coupon Name', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|min_length[2]|max_length[10]');
			$this->form_validation->set_rules('type', 'Coupon Type', 'trim|required|exact_length[1]');
			$this->form_validation->set_rules('discount', 'Coupon Discount', 'trim|required|numeric');
			$this->form_validation->set_rules('min_total', 'Minimum Total', 'trim|numeric');
			$this->form_validation->set_rules('description', 'Coupon Description', 'trim|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['name'] 			= $this->input->post('name');
				$add['code'] 			= $this->input->post('code');
				$add['type'] 			= $this->input->post('type');
				$add['discount'] 		= $this->input->post('discount');
				$add['min_total'] 		= $this->input->post('min_total');
				$add['description'] 	= $this->input->post('description');
				$add['start_date'] 		= $this->input->post('start_date');
				$add['end_date'] 		= $this->input->post('end_date');
				$add['date_added'] 		= mdate($time_format, $current_date_time);
				$add['status'] 			= $this->input->post('status');
	
				if ($this->Coupons_model->addCoupon($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Coupon Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
	
	public function _updateCoupon($coupon_id) {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			$this->form_validation->set_rules('name', 'Coupon Name', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|min_length[2]|max_length[10]');
			$this->form_validation->set_rules('type', 'Coupon Type', 'trim|required|exact_length[1]');
			$this->form_validation->set_rules('discount', 'Coupon Discount', 'trim|required|numeric');
			$this->form_validation->set_rules('min_total', 'Minimum Total', 'trim|numeric');
			$this->form_validation->set_rules('description', 'Coupon Description', 'trim|min_length[2]|max_length[1028]');
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|callback_handle_date');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['coupon_id'] 		= $coupon_id;
				$update['name'] 			= $this->input->post('name');
				$update['code'] 			= $this->input->post('code');
				$update['type'] 			= $this->input->post('type');
				$update['discount'] 		= $this->input->post('discount');
				$update['min_total'] 		= $this->input->post('min_total');
				$update['description'] 		= $this->input->post('description');
				$update['start_date'] 		= $this->input->post('start_date');
				$update['end_date'] 		= $this->input->post('end_date');
				$update['status'] 			= $this->input->post('status');	
	
				if ($this->Coupons_model->updateCoupon($update)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Coupon Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}		
	}	
	
	public function _deleteCoupon($country_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/coupons')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$coupon_id = $value;
				
					$this->Coupons_model->deleteCoupon($coupon_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Coupon(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}

 	public function handle_date($date) {
      		
     	$human_to_unix = human_to_unix($date);
		if ( ! isset($human_to_unix)) {
        	$this->form_validation->set_message('handle_date', 'The %s field is not a valid date/time.');
      		return FALSE;
    	} else {
        	return TRUE;        
      	}
    }
	
}