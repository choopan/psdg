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
	
	function get_data_where($select,$tbl,$where)
	{
		$query=$this->db->select($select)
						->from($tbl)
						->where($where)
						->get()
						->result_array();
		return $query;
	}
	
	function get_warranty($where)
	{
		$query=$this->db->select("warranty.warranty_id as war_id,department.name as depname")
						->from('warranty')
						->join('department','department.id = warranty.department_id','inner')
						->where($where)
						->get()
						->result_array();
		return $query;
	}
	
	function get_data_warranty_dep($warranty_id)
	{
		$query=$this->db->select("department.name as depname,pwemployee.pwfname,pwemployee.pwlname,warranty_data.position_name as poname,warranty_data.status")
						->from('warranty')
						->join('warranty_data','warranty.warranty_id = warranty_data.warranty_id','inner')
						->join('department','department.id = warranty.department_id','inner')
						->join('pwemployee','pwemployee.userid = warranty_data.user_id','inner')
						->where('warranty.warranty_id',$warranty_id)
						->get()
						->result_array();
		return $query;
	}
	
	function get_data_warranty_div($warranty_id)
	{
		$query=$this->db->select("division.name as divname,pwemployee.pwfname,pwemployee.pwlname,warranty_data.position_name as poname,warranty_data.status")
						->from('warranty')
						->join('warranty_data','warranty.warranty_id = warranty_data.warranty_id','inner')
						->join('division','division.id = warranty.division_id','inner')
						->join('pwemployee','pwemployee.userid = warranty_data.user_id','inner')
						->where('warranty.warranty_id',$warranty_id)
						->get()
						->result_array();
		return $query;
	}
	
	function get_data_edit_warranty_dep($where)
	{
		$query=$this->db->select('*')
						->from('warranty')
						->join('warranty_data','warranty.warranty_id = warranty_data.warranty_id','inner')
						->join('department','department.id = warranty.department_id','inner')
						->join('pwemployee','pwemployee.userid = warranty_data.user_id','inner')
						->where($where)
						->get()
						->result_array();
		return $query;
	}
	
	function get_data_edit_warranty_div($where)
	{
		$query=$this->db->select('*')
						->from('warranty')
						->join('warranty_data','warranty.warranty_id = warranty_data.warranty_id','inner')
						->join('division','division.id = warranty.division_id','inner')
						->join('pwemployee','pwemployee.userid = warranty_data.user_id','inner')
						->where($where)
						->get()
						->result_array();
		return $query;
	}
	
	function searchName($term)
	{
		$this->db->_protect_identifiers=false;
		$this->db->select("pwemployee.userid, CONCAT(pwfname,' ', pwlname) as pwname, pwposition.PWNAME as poname, pwemployee.PWPOSITION as positionid, department.name as depname, department.id as depid");
		$this->db->from('pwemployee');	
		$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.position');	
		$this->db->join('department', 'pwemployee.department = department.id');
		$this->db->like('pwfname', $term,'after');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function save_warranty($warranty)
	{
		$this->db->trans_begin();
		$this->db->insert('warranty',$warranty);
		$query=$this->db->select('warranty_id')
						->order_by('warranty_id','desc')
						->get('warranty',1)
						->result_array();
		$this->db->trans_complete();
		if($this->db->trans_status()){
			return $query;
		}else{
			return false;
		}
	}
	
	function update_warranty($warranty)
	{
		return $this->db->update_batch('warranty',$warranty,'warranty_id') ? TRUE:FALSE;
	}
	
	function save_warranty_data($data)
	{
		$this->db->trans_begin();
		$this->db->insert_batch('warranty_data',$data);
		$this->db->trans_complete();
		if($this->db->trans_status()){
			return true;
		}else{
			return false;
		}
	}
	
	function delete_data_where($tbl,$where)
	{
		$result=$this->db->where($where)
						 ->delete($tbl);
		return $result;
	}
	
	function get_division($where)
	{
		$query=$this->db->select("warranty.warranty_id as war_id,division.name as divname")
						->from('warranty')
						->join('division','division.id = warranty.division_id','inner')
						->where($where)
						->get()
						->result_array();
		return $query;
	}
}