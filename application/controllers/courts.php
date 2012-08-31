<?php

class Courts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('courts_model');
		$this->load->model('facilities');
		//$this->output->enable_profiler(TRUE);
	}
	
	function view($court_id){
		$court_data = $this->courts_model->get_court($court_id);
		echo json_encode($court_data);
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

		$courts = $this->courts_model->get_courts($facility_id);
	
        $courts_data['courts'] = $courts;

        $data['title'] = 'Court Management';
        $this->load->view('templates/header', $data);
        $this->load->view('court/facilitycourts', $courts_data );
        $this->load->view('templates/footer');
	}

	
	
}