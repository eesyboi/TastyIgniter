<?php

class Contact extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	// calls the constructor
		$this->load->model('Locations_model'); 													// loads the location model
		$this->load->library('location'); 														// load the location library
		$this->output->enable_profiler(TRUE); 													// for debugging profiler... remove later
	}

	public function index() {
		$this->lang->load('main/contact');  													// loads home language file
					
		if ( !file_exists('application/views/main/home.php')) { 								//check if file exists in views
			show_404(); 																		// Whoops, we don't have a page for that!
		}
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert'); 								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if ($this->session->userdata('user_postcode')) {
			$data['postcode'] = $this->session->userdata('user_postcode'); 						// retrieve session userdata variable if available
		} else {
			$data['postcode'] = '';
		}
		
		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_local'] 			= $this->lang->line('text_local');
		$data['text_postcode'] 			= $this->lang->line('text_postcode');
		$data['text_find'] 				= $this->lang->line('text_find');
		$data['text_charges'] 			= $this->lang->line('text_charges');
		$data['text_reviews'] 			= $this->lang->line('text_reviews');
		$data['text_opening_hours'] 	= $this->lang->line('text_opening_hours');
		$data['text_close'] 			= $this->lang->line('text_close');
		$data['entry_subject'] 			= $this->lang->line('entry_subject');
		$data['entry_full_name'] 		= $this->lang->line('entry_full_name');
		$data['entry_email'] 			= $this->lang->line('entry_email');
		$data['entry_telephone'] 		= $this->lang->line('entry_telephone');
		$data['entry_comment'] 			= $this->lang->line('entry_comment');
		$data['button_send'] 			= $this->lang->line('button_send');
		// END of retrieving lines from language file to send to view.

		$data['local_location'] = $this->location->local(); 									//retrieve local location data from location library
		
		if ($data['local_location']) { 															//if local location data is available
			$data['location_name'] 			= $data['local_location']['location_name'];
			$data['location_address_1'] 	= $data['local_location']['location_address_1'];
			$data['location_city'] 			= $data['local_location']['location_city'];
			$data['location_postcode'] 		= $data['local_location']['location_postcode'];
			$data['location_telephone'] 	= $data['local_location']['location_telephone'];
			$data['distance'] 				= sprintf($this->lang->line('text_distance'), number_format($data['local_location']['distance'],2)); //format diatance to 2 decimal place
		}
		
		$data['opening_hours'] = $this->location->openingHours(); 								//retrieve local location opening hours from location library
		
		if ($this->location->isOpened()) { 														// check if local location is open
			$data['text_open_or_close'] = $this->lang->line('text_opened');						// display we are open
		} else {
			$data['text_open_or_close'] = $this->lang->line('text_closed');						// display we are closed
		}
		
		if ($this->location->offerDelivery()) { 														// checks if cart contents is empty  
			$data['text_delivery'] = $this->lang->line('text_delivery_y');						// display we are open
		} else {
			$data['text_delivery'] = $this->lang->line('text_delivery_n');						// display we are closed
		}

		if ($this->location->offerCollection()) { 														// checks if cart contents is empty  
			$data['text_collection'] = $this->lang->line('text_collection_y');						// display we are open
		} else {
			$data['text_collection'] = $this->lang->line('text_collection_n');						// display we are closed
		}

		if ($this->location->getDeliveryCharge() > 0) {
			$data['delivery_charge'] = $this->currency->format($this->location->getDeliveryCharge());
		} else {
			$data['delivery_charge'] = $this->lang->line('text_free');
		}
		
		$data['subjects'] = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view
			
		if ($this->input->post() && $this->_sendContact() === TRUE) {							// checks if $_POST data is set and if contact form validation was successful

			$this->session->set_flashdata('alert', $this->lang->line('text_contact_sent'));		// display success message and redirect to account login page
		
			redirect('contact');																// redirect to contact page
		}
		
		//load view files and pass $data array
		$this->load->view('main/header', $data);
		$this->load->view('main/contact', $data);
		$this->load->view('main/footer');
	}

	// method to validate contact form fields and email contact details to store email
	public function _sendContact() {
		
		// START of form validation rules
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|integer');
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[96]');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|numeric|max_length[20]');
		$this->form_validation->set_rules('comment', 'Comment', 'htmlspecialchars|required|max_length[1028]');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully

			$this->load->library('email');														//loading upload library

			//setting email preference
			$this->email->set_protocol($this->config->item('config_protocol'));
			$this->email->set_mailtype($this->config->item('config_mailtype'));
			$this->email->set_smtp_host($this->config->item('config_smtp_host'));
			$this->email->set_smtp_port($this->config->item('config_smtp_port'));
			$this->email->set_smtp_user($this->config->item('config_smtp_user'));
			$this->email->set_smtp_pass($this->config->item('config_smtp_pass'));
			$this->email->set_newline("\r\n");
			$this->email->initialize();

			$subjects = array('1' => 'General enquiry', '2' => 'Comment', '3' => 'Technical Issues');	// array of enquiry subject to pass to view

			$subject	= $subjects[$this->input->post('subject')];								// retreive subject based on subjects key value
			$full_name	= $this->input->post('full_name');
			$email		= $this->input->post('email');
			$telephone	= $this->input->post('telephone');
			$comment	= nl2br($this->input->post('comment'));									// retrieve $_POST comment value to include HTML line breaks <br /> or <br>
			
			// create variable to hold email body message.
			$message 	= sprintf($this->lang->line('text_contact_message'), $comment, $full_name, $telephone);

			$this->email->from(strtolower($email), $full_name);
			$this->email->to($this->location->getEmail());

			$this->email->subject($subject);
			
			$this->email->message($message);

			if ($this->email->send()) {															// checks if email was sent sucessfully and return TRUE
		
				return TRUE;
		
			}
		}
	}
}

/* End of file myfile.php */