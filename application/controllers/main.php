<?php

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	function index($page='')
	{
		$current_url = current_url();
		echo $current_url;
		$no_http = substr($current_url, strpos($current_url, '://')+3);
		$sub_url = substr($no_http,0,strpos($no_http, '.'));
		if(!strpos($sub_url, '/')){
			echo $sub_url;
		}else{
			echo "FALSE";
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