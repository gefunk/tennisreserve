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
		$prefs = array (
		               'show_next_prev'  => TRUE,
		               'next_prev_url'   => 'http://example.com/index.php/calendar/show/'
		           	);
	
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="4" cellspacing="4">{/table_open}

		   {heading_row_start}<tr>{/heading_row_start}

		   {heading_previous_cell}<th><a id="calendar-previous" href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a id="calendar-next" href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

		   {heading_row_end}</tr>{/heading_row_end}

		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}

		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}

		   {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		   {cal_cell_blank}&nbsp;{/cal_cell_blank}

		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}

		   {table_close}</table>{/table_close}
		';
		
		
		$this->load->library('calendar', $prefs);

		$data['title'] = 'Court Management';
		$this->load->view('templates/header', $data);
		$this->load->view('facility/courts');
		$this->load->view('templates/footer');
		
	}
	
	function get_calendar($year=null, $month=null){
		
		if(!isset($year)){
			$year = date('Y',strtotime('now'));
		}
		if(!isset($month)){
			$month = date('m',strtotime('now'));
		}
		
		$prefs = array (
		               'show_next_prev'  => TRUE,
		               'next_prev_url'   => 'get_calendar'
		           	);
	
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="4" cellspacing="4">{/table_open}

		   {heading_row_start}<tr>{/heading_row_start}

		   {heading_previous_cell}<th><button class="month-link" get_url="{previous_url}">&lt;</button></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><button class="month-link" get_url="{next_url}">&gt;</button></th>{/heading_next_cell}

		   {heading_row_end}</tr>{/heading_row_end}

		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}

		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}

		   {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

		   {cal_cell_blank}&nbsp;{/cal_cell_blank}

		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}

		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar', $prefs);
		$data = array("calendar" => $this->calendar->generate($year, $month), "month" => $month, "year" => $year);
		echo json_encode($data);
	}
	
	function test_calendar()
	{
		$this->load->library('calendar');
		echo $this->calendar->generate();
	}
	
}