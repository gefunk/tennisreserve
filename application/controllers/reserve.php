<?php

class Reserve extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('facilities');
		$this->load->model('reservations');
		//$this->output->enable_profiler(TRUE);
	}
	
	/**
		get all reservations for facility id and date
	**/
	function get_all($facility_id, $date)
	{
		$reservations = $this->reservations->get_reservations_for_date($date);
		$result = array();
		foreach($reservations as $reservation){
			$result[$reservation->id] = array(
				'start_time' => $this->format_time($reservation->start_time),
				'end_time' => $this->format_time($reservation->end_time)
				);
		}
		echo json_encode($result);
	}


	/**
		initializes a reservation in the database
	**/
	function make()
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
		update reservation 
		start_time and court_id may be null
		this is when a user just drags the bottom of the div
		to update the reservation
		when a user moves a div to a different column (court)
		then all the parameters will be passed
	**/
	function update(){
		$id = $this->input->post('id', TRUE);
		
		$court_id = $this->input->post('court_id');
		if(isset($court_id) && intval($court_id) > 0){
			$court_id = null;
		}
		
		$start_time = $this->input->post('start_time');
		if(isset($start_time) && strlen($start_time) > 0)
			$start_time = str_replace('_', ':',$start_time).":00";
		else
			$start_time = null;
		
		$end_time = $this->input->post('end_time');
		$end_time = str_replace('_', ':',$end_time).":00";
		
		$this->reservations->update($id, $court_id, $start_time, $end_time);
		echo $id." End Time: ".$end_time. "Court ID". $court_id. " Int Length ".intval($court_id);
	}
	
	function get_reservations($facility_id, $date)
	{
		echo json_encode($this->reservations->get_reservations_for_date($facility_id, $date));
	}


}