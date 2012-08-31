
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courts_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
		
    }

	function get_courts($facility_id)
	{
        $this->db->select('courts.id as id, courts.name, courts.number, courts.lights, court_type.name court_type_name, court_type.id as court_type_id, ');
        $this->db->from('courts');
        $this->db->join('court_type', 'courts.court_type = court_type.id');
	    $this->db->where("courts.facility_id = $facility_id");
        $query = $this->db->get();
		return $query->result_array();
	
	}

	
	function get_court_type($id){
        $query = $this->db->get_where('court_type', array('id' => $id));
        $row = $query->row();
        return $row->name;
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
