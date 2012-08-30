<?php

class Facility extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('facilities');
	}
	
	function signup()
	{
		$data['title'] = 'Sign Up';
		$this->load->view('templates/header', $data);
		$this->load->view('facility/signup', $data);
		$this->load->view('templates/footer', $data);
	}
	
	/*
		get facility info from the screen and pass it to the model
		send the user to a successfully saved view
	*/
	function add()
	{
		// get the facility information and save to database
		$facility_name = $this->input->post('facility_name');
		$facility_url = $this->input->post('facility_url');
		$url = $this->input->post('url');
		$hard_courts = $this->input->post('hard_courts');
		$clay_courts = $this->input->post('clay_courts');		
		$this->facilities->add($facility_name, $facility_url, $url, $hard_courts, $clay_courts);
		
		// send the data back to the next view
		$data['title'] = 'Successful Save';
		$facility_data['facility_name'] = $facility_name;
		$facility_data['facility_url'] = $facility_url;
		$facility_data['url'] = $url;
		
		$this->load->view('templates/header', $data);
		$this->load->view('facility/success', $facility_data);
		$this->load->view('templates/footer');		
	}
	
	function courts()
	{
		$data['title'] = 'Court Management';
		$this->load->view('templates/header', $data);
		$this->load->view('facility/courts');
		$this->load->view('templates/footer');
	}
	
}