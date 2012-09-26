<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('facilities');
	}
	
	function index($page='home')
	{
		$subdomain = array_shift(explode(".",$_SERVER['HTTP_HOST'])); 
		if($subdomain && $subdomain != '' && $subdomain != 'www'){
			$facility_id = $this->facilities->get_facility_subdomain($subdomain);
			if($facility_id != null){
				// forward to facility page
				echo $facility_id;
			}else{
				view($page);
			}
		}else{
			view($page);
		}
	}
	
	public function view($page = 'home')
	{

		if ( ! file_exists('application/views/main/'.$page.'.php'))
			{
				// Whoops, we don't have a page for that!
				show_404();
			}

			$data['title'] = ucfirst($page); // Capitalize the first letter

			$this->load->view('templates/header', $data);
			$this->load->view('main/'.$page, $data);
			$this->load->view('templates/footer', $data);

	}
	
}

?>