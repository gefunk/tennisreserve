
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courts_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
		
    }

	function get_courts($facility_id)
	{
		$query = $this->db->get_where('courts', "facility_id = $facility_id");  
		return $query->result_array();
	
	}
	
	function update($court_id, $court_name)
	{
		
		$data = array(
		   'name' => $court_name
		  );

		$this->db->where('id', $court_id);
		$this->db->update('courts', $data); 
	}
	
	/*
		Get a court by its court id 
	*/
	function get_court($court_id){
		$query = $this->db->get_where('courts', array('id' => $court_id));
		return $query->row_array();
	}
	
		
}
