<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservations extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


	/**
		add a court reservation 
	**/
	function add($user_id, $court_id,  $date, $start_time)
	{
		// insert facility information
		$res_data = array(
			'user_id' => $user_id, 
			'court_id' => $court_id, 
			'start_time' => $start_time,
			'date' => $date 
		);
		$this->db->insert('reservations', $res_data);
		return $this->db->insert_id();
	}
	
	/**
		update end time for a reservation
	**/
	function update_end_time($id, $end_time)
	{
		$res_data = array('end_time' => $end_time);
		$this->db->where('id', $id);
		$this->db->update('reservations', $res_data);
	}
	
	/**
		given a date, return all the reservations for this date
	**/
	function get_reservations_for_date($date){
		$query = $this->db->get_where('reservations', "date = '$date'");  
		return $query->result();
	}
	

}