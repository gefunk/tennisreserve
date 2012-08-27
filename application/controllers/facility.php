<?php

class Facility extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	
	}
	
	function signup()
	{
		$data['title'] = 'Sign Up';
		$this->load->view('templates/header', $data);
		$this->load->view('facility/signup', $data);
		$this->load->view('templates/footer', $data);
	}
	
}