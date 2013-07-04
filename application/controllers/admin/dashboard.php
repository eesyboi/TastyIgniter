<?php
class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('admin');
		$this->load->model('Dashboard_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		//check if file exists in views
		if ( !file_exists('application/views/admin/dashboard.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		//$logged = $this->session->userdata('SESS_ADMIN_ID');
		$data['title'] = 'Adminstrator Dashboard';

		if (!$this->admin->islogged()) {  
  			redirect('admin/login');
		}

		//Showing Summaries
		$results = $this->Dashboard_model->getSummaries();
		//check if sql query was successful and create variables
		if ($results) {
			foreach ($results as $result) {
				$foods_data	=	$result['foods_query'];
				$members	=	$result['members_query'];
				$orders		=	$result['orders_query'];
				$orders_processed	=	$result['orders_processed_query'];
				$tables_reserved	=	$result['tables_reserved_query'];
				$tables_allocated	=	$result['tables_allocated_query'];
				$partyhalls_reserved	=	$result['partyhalls_reserved_query'];
				$partyhalls_allocated	=	$result['partyhalls_allocated_query'];
			}
			
			//if ($foods->num_rows())	{
				//$food_row = $foods->row(); 
				$data['foods'] = $foods_data->result_array();
			//}
	
			$data['total_foods'] = $foods_data->num_rows();
			$data['total_members'] = $members->num_rows();
			$data['total_orders'] = $orders->num_rows();
			$data['total_orders_processed'] = $orders_processed->num_rows();
			$data['total_orders_pending'] = $data['total_orders']-$data['total_orders_processed'];
			$data['total_tables_reserved'] = $tables_reserved->num_rows();
			$data['total_tables_allocated'] = $tables_allocated->num_rows();
			$data['total_tables_pending']	= $data['total_tables_reserved']-$data['total_tables_allocated'];
			$data['total_partyhalls_reserved'] = $partyhalls_reserved->num_rows();
			$data['total_partyhalls_allocated'] = $partyhalls_allocated->num_rows();
			$data['total_partyhalls_pending']	= $data['total_partyhalls_reserved']-$data['total_partyhalls_allocated'];
		}

		//check and store food_id in variable
		$food_id = $this->input->post('food');

		//retrieve database query based on food_id
		$ratings_results = $this->Dashboard_model->getRatings($food_id);
		//check if sql query was successful and create variables
		if ($ratings_results) {
			foreach ($ratings_results as $ratings_result) {
				$ratings_data		=	$ratings_result['ratings'];
				$excellent_data		=	$ratings_result['excellent_query'];
				$good_data	=	$ratings_result['good_query'];
				$average_data	=	$ratings_result['average_query'];
				$bad_data	=	$ratings_result['bad_query'];
				$worse_data	=	$ratings_result['worse_query'];
				//$partyhalls_allocated	=	$result['partyhalls_allocated_query'];
			}
        }			
        	$data['excellent_value'] = $excellent_data->num_rows();
        	$data['good_value'] = $good_data->num_rows();
        	$data['average_value'] = $average_data->num_rows();
        	$data['bad_value'] = $bad_data->num_rows();
        	$data['worse_value'] = $worse_data->num_rows();

		    if($ratings_data->num_rows() > 0){
	       		$rating_value = $ratings_data->num_rows();
				$rating_row = $ratings_data->row(); 
				$data['rating_food_name'] = $rating_row->food_name;
        		
        		$data['excellent_rate'] = $data['excellent_value']/$rating_value*100;
            	$data['good_rate'] = $data['good_value']/$rating_value*100;
            	$data['average_rate'] = $data['average_value']/$rating_value*100;
            	$data['bad_rate'] = $data['bad_value']/$rating_value*100;
        		$data['worse_rate'] = $data['worse_value']/$rating_value*100;
 			//}
         } else {
				// Else no ratings
		        $data['rating_food_name'] = '';		        	
    		    $data['excellent_rate'] = 0;
        	    $data['good_rate'] = 0;
        		$data['average_rate'] = 0;
    	        $data['bad_rate'] = 0;
	    	    $data['worse_rate'] = 0;
        }


		//$data['ratings_results'] = $this->Dashboard_model->getRatings();

		//if ($ratings_results) {
			//foreach ($ratings_results as $ratings_result) {

			//}
		//}
		//}
		//$this->session->set_userdata('SESS_ADMIN_ID', '');
		//$this->session->set_userdata('SESS_ADMIN_NAME', '');
		
		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/footer', $data);
	}
}