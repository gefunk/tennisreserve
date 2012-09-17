<?php

class Courts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('courts_model');
		$this->load->model('facilities');
		$this->load->model('reservations');
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
	
	/**
		returns courts for a facility based on id
	**/
	function facilitycourts($facility_id){

		$courts = $this->courts_model->get_courts($facility_id);
	
        $courts_data['courts'] = $courts;

        $data['title'] = 'Court Management';
        $this->load->view('templates/header', $data);
        $this->load->view('court/facilitycourts', $courts_data );
        $this->load->view('templates/footer');
	}
	
	/**
		initializes a reservation in the database
	**/
	function start_reservation()
	{
		$user_id = $this->input->post('user_id');
		$court_id = $this->input->post('court_id');
		$start_time = $this->input->post('start_time');
		// format the start for mysql time format
		$start_time = str_replace('_', ':',$start_time).":00";
		$date = $this->input->post('date');
		// return the id of the reservation to the UI
		echo json_encode(array("id" => $this->reservations->add($user_id, $court_id,  $date, $start_time)));
	}
	
	/**
		update reservation end time
	**/
	function update_reservation(){
		$id = $this->input->post('id', TRUE);
		$end_time = $this->input->post('end_time');
		$end_time = str_replace('_', ':',$end_time).":00";
		$this->reservations->update_end_time($id, $end_time);
	}
	
	
	
	function get_reservations($facility_id, $date)
	{
		$reservations = $this->reservations->get_reservations_for_date($facility_id, $date);
		$result = array();
		foreach($reservations as $reservation){
			$result[$reservation->id] = array(
				'court_id' => $reservation->court_id,
				'start_time' => $this->format_time($reservation->start_time),
				'end_time' => $this->format_time($reservation->end_time)
				);
		}
		echo json_encode($result);
	}
	
	function get_facility_times($facility_id)
	{
		$timings = null;
		foreach($this->facilities-> get_timings($facility_id) as $row){
			$timings = array('open_time' => $row->open_time, 'close_time' => $row->close_time);
		} 
		echo json_encode($timings);
	}
	
	/**
		format time string for UI
		will cut off seconds and replace ':' with '_'
	**/
	function format_time($time)
	{
		return str_replace(':', '_', substr($time, 0, -3));
	}
	
	/**
		returns a codeigniter calendar via json to the UI
		The calendar module on the right of the courts pages uses this
	**/
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
	
	
	function get_time_calendar($num_courts = 1)
	{
		// generate columns for courts
		$court_cols = '';
		for($court = 0; $court < $num_courts; $court++){
			$court_cols .= '<td></td>';
		}

		$html = '<table id="time" class="table table-hover table-bordered" cellspacing="5" cellpadding="5">';
		for($hour = 0; $hour < 24; $hour++){
			$hour_str = date("H", mktime($hour, 0, 0, 7, 1, 2000));
			$html .= '<tr id='.$hour_str."_00".'>';
			$html .= '<td>'.date("h A", mktime($hour, 0, 0, 7, 1, 2000)).'</td>';
			$html .= $court_cols;
			$html .= '</tr>';
			$html .= '<tr id='.$hour_str."_30".'>';
			$html .= '<td>'.date("h:i", mktime($hour, 30, 0, 7, 1, 2000)).'</td>';			
			$html .= $court_cols;
			$html .= '</tr>';
		}
		$html .= "</table>";
		echo $html;

		
	}
	
	
}