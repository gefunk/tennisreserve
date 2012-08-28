<?php

class Courts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('courts_model');
	}
	
	function view($court_id){
		$court_data['court'] = $this->courts_model->get_court($court_id);
		$data['title'] = 'Court Information';
		
		$this->load->view('templates/header', $data);
		$this->load->view('court/view', $court_data);
		$this->load->view('templates/footer');
	}
	
	/*
		get court info from the screen and pass it to the model		
	*/
	function update()
	{
		// save the court information to the database
		$court_id = $this->input->post('court_id');
		$court_name = $this->input->post('court_name');
		
		$this->courts_model->update($court_id, $court_name);
		
		$data['title'] = 'You updated the court';
	
		$this->load->view('templates/header', $data);
		$this->load->view('court/success', $data);
		$this->load->view('templates/footer');		
	}
	
	function facilitycourts($facility_id){
		$courts_data['courts'] = $this->courts_model->get_courts($facility_id);
		$courts_data['facility_name'] = 'Placeholder Name';
		
		$data['title'] = 'All Courts';
		
		$this->load->view('templates/header', $data);
		$this->load->view('court/facilitycourts', $courts_data);
		$this->load->view('templates/footer');
	}

	
	
}