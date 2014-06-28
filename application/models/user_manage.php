<?php
Class User_manage extends CI_Model
{
  
 function __construc()
	{
	parent::__construct();	
	}
//------------------------------------------------------------ User --------------------------------------------
 function get_user_()
 {
	$query=$this->db->select('USERID, PWFNAME, PWLNAME, department, division, PWPOSITION, PWLEVEL, PWPOSITION2, PWEMAIL')
					->get('pwemployee')
					->result_array();
	return $query;
 }
 
 function get_user()
 {
	$query=$this->db->query('SELECT USERID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME, PWLEVEL, PWEMAIL
							 FROM  pwemployee  INNER JOIN division INNER JOIN department INNER JOIN pwposition 
							 ON pwemployee.department = department.id
							 AND pwemployee.division = division.id
							 AND pwemployee.PWPOSITION = pwposition.PWPOSITION')
					->result_array();
	return $query;
 }
 
 function get_num_user() {
 	return $this->db->count_all('pwemployee');
 }
 
 function get_user_limit($start, $limit) {
 	$query=$this->db->query('SELECT USERID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL
							 FROM  pwemployee  INNER JOIN division INNER JOIN department INNER JOIN pwposition 
							 ON pwemployee.department = department.id
							 AND pwemployee.division = division.id
							 AND pwemployee.PWPOSITION = pwposition.PWPOSITION 
							 LIMIT '.$start.','.$limit)
					->result_array();
	return $query;
 }
 
 function addUser_save($username,$password,$fname,$lname,$efname,$elname,$gender,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div,$execode)
 {
	$this->db->set('PWUSERNAME',$username)
			 ->set('PWPASSWORD',$password)
			 ->set('PWFNAME',$fname)
			 ->set('PWLNAME',$lname)
			 ->set('PWEFNAME',$efname)
			 ->set('PWELNAME',$elname)
			 ->set('PWSEX',$gender)
			 ->set('PWEMAIL',$email)
			 ->set('PWTELOFFICE',$tel)
			 ->set('mobile',$mobile)
			 ->set('department',$department)
			 ->set('division',$division)
			 ->set('PWPOSITION',$position1)
			 ->set('PWLEVEL',$level)
			 ->set('admin_min',$admin_min)
			 ->set('admin_dep',$admin_dep)
			 ->set('admin_div',$admin_div)
			 ->set('execode',$execode)
			 ->insert('pwemployee');
 }
 
 function editUser_save($id,$fname,$lname,$efname,$elname,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div,$execode)
 {
	$this->db->where('USERID',$id)
			 ->set('PWFNAME',$fname)
			 ->set('PWLNAME',$lname)
			 ->set('PWEFNAME',$efname)
			 ->set('PWELNAME',$elname)
			 ->set('PWEMAIL',$email)
			 ->set('PWTELOFFICE',$tel)
			 ->set('mobile',$mobile)
			 ->set('department',$department)
			 ->set('division',$division)
			 ->set('PWPOSITION',$position1)
			 ->set('PWLEVEL',$level)
			 ->set('admin_min',$admin_min)
			 ->set('admin_dep',$admin_dep)
			 ->set('admin_div',$admin_div)
			 ->set('execode',$execode)
			 ->update('pwemployee');
 }
 
 function user_view_info($id)
 {
	$query=$this->db->query('SELECT USERID, PWUSERNAME,PWFNAME, PWLNAME,PWEFNAME, PWELNAME, PWSEX, PWTELOFFICE, mobile, department.name AS dep_name,
							 division.name AS div_name, pwemployee.PWPOSITION AS position, pwemployee.department AS dep_id, 
							 pwemployee.division AS div_id, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL,admin_min, admin_dep, admin_div, 
							 execode
							 FROM  pwemployee  INNER JOIN division INNER JOIN department INNER JOIN pwposition 
							 ON pwemployee.department = department.id
							 AND pwemployee.division = division.id
							 AND pwemployee.PWPOSITION = pwposition.PWPOSITION
							 WHERE pwemployee.USERID='.$id)
					->result_array();
	return $query;
 }
 
 function user_del_info($user_id)
 {
	$this->db->where('USERID',$user_id)
			 ->set('enabled','0')
			 ->update('pwemployee');
 }
 
 function get_position()
 {
	$query=$this->db->distinct()
					->select('PWPOSITION,PWNAME')
					->get('pwposition')
					->result_array();
	return $query;
 }
 
 function get_search($sql)
 {
	$query=$this->db->query($sql)
					->result_array();
	return $query;
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
	$query=$this->db->distinct()
					->get('department')
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
			 ->set('enabled',0)
			 ->delete('department');
 }
 
 //============================================================= Division =======================================
 function get_division($dep_id)
 {
	$query=$this->db->distinct()
					->where('dep_id',$dep_id)
					->get('division')
					->result_array();
	return $query;
 }
 
  function get_division_show()
 {
	$query=$this->db->query('select division.id AS id,department.name AS dep_name,division.name AS div_name 
							 from department inner join division 
							 on department.id = division.dep_id')
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
			 ->set('enabled',0)
			 ->update('division');
 }
}
?>