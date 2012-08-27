<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facilities extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function get_facilities()
	{
		# code...
	}
	
	function get_facility($id)
	{
		# code...
	}
	
	/*
		add a facility to the database
	*/
	function add($name, $facility_url, $save_court_url, $hard_courts, $clay_courts)
	{
		// insert facility information
		$facility_data = array('name' => $name, 'url' => $facility_url, 'save_court_url' => $save_court_url);
		$this->db->insert('facilities', $facility_data);
		// get the facility id after insert
		$facility_id = $this->db->insert_id();
		// get the hard court id type
		$query = $this->db->get_where('court_type', "name = 'hard'");  
		$row = $query->row();
		$hardcourt_id_type = $row->id;
		// keep count of courts to add court numbers
		$court_number = 1;
		// insert the hard courts for this facility
		for($court = 0; $court < $hard_courts; $court++){
			$court_data = array(
				'facility_id' => $facility_id, 
				'court_type' => $hardcourt_id_type, 
				'number' => $court_number
				);
			$court_number = $court_number + 1;
			$this->db->insert('courts', $court_data);
		}
		// get clay court id type
		$query = $this->db->get_where('court_type', "name = 'clay'");
		$row = $query->row();
		$claycourt_id_type = $row->id;
		// insert the hard courts for this facility
		for($court = 0; $court < $clay_courts; $court++){
			$court_data = array(
				'facility_id' => $facility_id, 
				'court_type' => $claycourt_id_type, 
				'number' => $court_number
				);
			$court_number = $court_number + 1;
			$this->db->insert('courts', $court_data);
		}

		
	}
}