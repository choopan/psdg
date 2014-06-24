<?php
Class User_manage extends CI_Model
{
  
 function __construc()
	{
	parent::__construct();	
	}
//------------------------------------------------------------ User --------------------------------------------
 function get_user()
 {
	$query=$this->db->select('USERID, PWFNAME, PWLNAME')->get('pwemployee')
			 ->result_array();
	return $query;
 }
 
 function get_num_user() {
 	return $this->db->count_all('pwemployee');
 }
 
 function get_user_limit($start, $limit) {
 	$query=$this->db->select('USERID, PWFNAME, PWLNAME')->get('pwemployee', $limit, $start)->result_array();
	return $query;
 }
 
 function addUser_save($username,$password,$fname,$lname,$email,$tel,$mobile,$department,$division,$admin_min,$admin_dep,$admin_div,$position2)
 {
	$this->db->set('PWUSERNAME',$username)
			 ->set('PWPASSWORD',$password)
			 ->set('PWFNAME',$fname)
			 ->set('PWLNAME',$lname)
			 ->set('PWEMAIL',$email)
			 ->set('PWTELOFFICE',$tel)
			 ->set('mobile',$mobile)
			 ->set('department',$department)
			 ->set('division',$division)
			 ->set('admin_min',$admin_min)
			 ->set('admin_dep',$admin_dep)
			 ->set('admin_div',$admin_div)
			 ->set('PWPOSITION2',$position2)
			 ->insert('pwemployee');
 }
 
 function user_view_info($id)
 {
	$query=$this->db->where('USERID',$id)
					->get('pwemployee')
					->result_array();
	return $query;
 }
 
 function user_del_info($user_id)
 {
	$this->db->where('USERID',$user_id)
			 ->set('PWSTATUS','7')
			 ->update('pwemployee');
 }
 
 //============================================================= Department =====================================
 function addDepartmaent_save($department_name)
 {
	$this->db->set('name',$department_name)
			 ->set('fid',0)
			 ->insert('department');
 }
 
 function get_department()
 {
	$query=$this->db->get('department')
					->result_array();
	return $query;
 }
 
 function dep_edit_info($id)
 {
	$query=$this->db->where('id',$id)
					->get('department')
					->result_array();
	return $query;
 }
 
 function updateDepartmaent_save($id,$department)
 {
	$this->db->where('id',$id)
			 ->set('name',$department)
			 ->update('department');
 }
 
 function deleteDepartment($id)
 {
	$this->db->where('id',$id)
			 ->delete('department');
 }
 
 //============================================================= Division =======================================
 function get_division($dep_id)
 {
	$query=$this->db->where('dep_id',$dep_id)
					->get('division')
					->result_array();
	return $query;
 }
 
  function get_division_show()
 {
	$query=$this->db->get('division')
					->result_array();
	return $query;
 }
 
 function addDivision_save($department_id,$division_name)
 {
	$this->db->set('dep_id',$department_id)
			 ->set('name',$division_name)
			 ->insert('division');
 }

 function div_edit_info($id)
 {
	$query=$this->db->where('id',$id)
					->get('division')
					->result_array();
	return $query;
 }
 
 function updateDivision_save($id,$dep_id,$division)
 {
	$this->db->where('id',$id)
			 ->set('dep_id',$dep_id)
			 ->set('name',$division)
			 ->update('division');
 }
 
 function deleteDivision($id)
 {
	$this->db->where('id',$id)
			 ->delete('division');
 }
}
?>