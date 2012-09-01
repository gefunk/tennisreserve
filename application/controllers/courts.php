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
		$court_type = $this->input->post('court_type');
		$court_name = $this->input->post('court_name');		
		$lights = $this->input->post('lights');
		
		$this->courts_model->update($court_id, $court_name, $court_type, $lights);
		
		echo "success";

	}
	
	function facilitycourts($facility_id){

		$courts = $this->courts_model->get_courts($facility_id);
	
        $courts_data['courts'] = $courts;

        $data['title'] = 'Court Management';
        $this->load->view('templates/header', $data);
        $this->load->view('court/facilitycourts', $courts_data );
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
		               'next_prev_url'   => site_url('courts/get_calendar')
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
	
	

	
	
}