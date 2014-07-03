<?php
class Managewarranty_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function get_data($select,$tbl)
	{
		$query=$this->db->select($select)
						->get($tbl)
						->result_array();
		return $query;
	}
	function searchName($term)
	{
		$this->db->_protect_identifiers=false;
		$this->db->select("pwemployee.userid, CONCAT(pwfname,' ', pwlname) as pwname, pwposition.PWNAME as poname, pwemployee.PWPOSITION as positionid, department.name as depname, department.id as depid");
		$this->db->from('pwemployee');	
		$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition');	
		$this->db->join('department', 'pwemployee.department = department.id');
		$this->db->like('pwfname', $term,'after');
		$query = $this->db->get();
		return $query->result_array();
	}
	
}