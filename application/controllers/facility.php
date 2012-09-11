<?php

class Facility extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('facilities');
		//$this->output->enable_profiler(TRUE);
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
	
	function calendar($year=null, $month=null)
	{
		if(!isset($year)){
			$year = date('Y',strtotime('now'));
		}
		if(!isset($month)){
			$month = date('m',strtotime('now'));
		}
		
		$prefs = array (
		               'show_next_prev'  => TRUE,
		               'next_prev_url'   => site_url('facility/calendar')
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
		
		$data['title'] = 'Calendar';
		$data["month"] = $month;
		$data["year"] = $year;
		//$data['time_table'] = $this->get_time_calendar(2);
		$this->load->view('templates/header', $data);
		$this->load->view('facility/calendar', $data);
		$this->load->view('templates/footer');
	}
	
	function get_time_calendar($facility_id)
	{
		// get open and close time for facility
		$open_time = 0;
		$close_time = 24;
		foreach($this->facilities->get_timings($facility_id) as $row){
			$open_time = intval(substr($row->open_time,0,2));
			$close_time = intval(substr($row->close_time,0,2));
		}
		
		// generate header and columns for courts
		$courts = $this->facilities->get_courts($facility_id);
		$court_cols = '';

		$heading = '<table><tr>';
		foreach($courts as $court){
			$heading .= '<th>'.$court->name.'</th>';
			$court_cols .= '<td court-id="'.$court->id.'"></td>';
		}
		$heading .= "</tr></table>";
		// timings table to keep the timing information
		$timings = '<table>';
		// this is the actual table that we hold reservations in
		$html = '<table>';
		for($hour = $open_time; $hour < $close_time; $hour++){
			$hour_str = date("H", mktime($hour, 0, 0, 7, 1, 2000));
			
			$timings .= "<tr>";
			$timings .= '<td>'.date("h A", mktime($hour, 0, 0, 7, 1, 2000)).'</td>';
			$timings .= "</tr>";
			$timings .= "<tr>";
			$timings .= '<td>'.date("h:i", mktime($hour, 30, 0, 7, 1, 2000)).'</td>';			
			$timings .= "</tr>";

			$html .= '<tr id='.$hour_str."_00".'>';
			$html .= $court_cols;
			$html .= '</tr>';
			$html .= '<tr id='.$hour_str."_30".'>';
			$html .= $court_cols;
			$html .= '</tr>';
		}
		$html .= "</table>";
		$timings .= "</table>";
		echo json_encode(array('reservations' => $html, 'timings' => $timings, 'heading' => $heading));

		
	}
	
	function get_facility_times($facility_id)
	{
		$timings = null;
		foreach($this->facilities-> get_timings($facility_id) as $row){
			$timings = array('open_time' => intval(substr($row->open_time,0,2)), 'close_time' => $row->close_time);
		} 
		echo json_encode($timings);
	}
	
}