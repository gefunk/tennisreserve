<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	
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