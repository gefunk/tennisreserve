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
		update a reservation
		court_id and start_time may be null
	**/
	function update($id, $court_id, $start_time, $end_time)
	{
		$res_data['end_time'] = $end_time;
		if(isset($court_id) && intval($court_id) > 0)
			$res_data['court_id'] = $court_id;
		if(isset($start_time))
			$res_data['start_time'] = $start_time;
		$this->db->where('id', $id);
		$this->db->update('reservations', $res_data);
	}
	
	/**
		given a date, return all the reservations for this date
	**/
	function get_reservations_for_date($facility_id, $date, $timestamp=null){
		// get the id of all the courts for this facility
		$this->db->select("id");
		$this->db->from("courts");
		$this->db->where("facility_id", $facility_id);
		$query = $this->db->get();
		
		$court_ids = array();
		
		foreach($query->result() as $row){
			$court_ids[] = $row->id;
		}
		
		$this->db->where('date', $date); 
		$this->db->where_in('court_id', $court_ids);  
		if(isset($timestamp)){
			$this->db->where('last_update >',$timestamp);
		}
		$query = $this->db->get('reservations');
		return $query->result();
	}
	

}