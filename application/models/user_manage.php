<?php
Class User_manage extends CI_Model
{
  
 function __construc()
	{
	parent::__construct();	
	}
//------------------------------------------------------------ User --------------------------------------------
 function get_user_1()
 {
	$query=$this->db->select('USERID, PWFNAME, PWLNAME, department, division, PWPOSITION, PWLEVEL, PWPOSITION2, PWEMAIL')
					->get('pwemployee')
					->result_array();
	return $query;
 }
 
 function getUserandCoreSet()
 {
	$query=$this->db
			->select('pwemployee.userID AS userID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWLEVEL, core_competency_set.id AS coresetID, core_competency_set.name AS coreset_name')
			->from('PWEMPLOYEE')
			->join('division', 'pwemployee.division = division.id', 'left')
			->join('department', 'pwemployee.department = department.id', 'left')
			->join('pwposition', 'pwemployee.pwposition = pwposition.pwposition', 'left')
			->join('core_competency_set', 'pwemployee.coresetID = core_competency_set.ID', 'left')
			->get() -> result_array();
	return $query;
 }
 
 function get_num_user() {
 	return $this->db->count_all('pwemployee');
 }
 
 function get_user_limit($start, $limit) {
 	$query=$this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL')
 					->where('pwemployee.enabled',1)
					->from('PWEMPLOYEE')
					->join('department', 'pwemployee.department = department.id', 'left')
					->join('division', 'pwemployee.division = division.id', 'left' )
					->join('pwposition', 'pwemployee.PWPOSITION = pwposition.PWPOSITION', 'left')
					->get($start, $limit)
					->result_array();
	return $query;
 }
 
 function addUser_save($username,$password,$fname,$lname,$efname,$elname,$gender,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div)
 {
	$query=$this->db->set('PWUSERNAME',$username)
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
			 ->insert('pwemployee');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function editUser_save($id,$fname,$lname,$efname,$elname,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div)
 {
	$query=$this->db->where('USERID',$id)
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
			 ->update('pwemployee');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function user_view_info($id)
 {
	$query=$this->db->query('SELECT pwemployee.USERID as USERID, PWUSERNAME,PWFNAME, PWLNAME,PWEFNAME, PWELNAME, PWSEX, PWTELOFFICE, mobile, department.name AS dep_name,
							 division.name AS div_name, pwemployee.PWPOSITION AS position, pwemployee.department AS dep_id, 
							 pwemployee.division AS div_id, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL,admin_min, admin_dep, admin_div 
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
	$query=$this->db->where('USERID',$user_id)
			 ->set('enabled','0')
			 ->update('pwemployee');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_position()
 {
	$query=$this->db->distinct()
					->select('PWPOSITION,PWNAME')
					->order_by('PWNAME')
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
 function addDepartmaent_save($department_name,$userid)
 {
	$query=$this->db->set('name',$department_name)
			 ->set('fid',0)
			 ->set('USERID',$userid)
			 ->set('enabled',1)
			 ->insert('department');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_department()
 {
	$query=$this->db->query('SELECT DISTINCT id,name,PWFNAME,PWLNAME FROM department LEFT JOIN pwemployee  
							 ON department.USERID = pwemployee.USERID WHERE department.enabled = 1')
					->result_array();
	return $query;
 }
 
 function get_department_1()
 {
	$query=$this->db->query('SELECT DISTINCT id,name FROM department WHERE department.enabled = 1 ORDER BY name')
					->result_array();
	return $query;
 }
 
 function dep_edit_info($id)
 {
	$query=$this->db->query('SELECT id,department.USERID AS USERID,name,PWFNAME,PWLNAME FROM department LEFT JOIN pwemployee
							 ON department.USERID = pwemployee.USERID WHERE id = '.$id)
					->result_array();
	return $query;
 }
 
 function updateDepartmaent_save($id,$department,$userid)
 {
	$query=$this->db->where('id',$id)
			 ->set('name',$department)
			 ->set('USERID',$userid)
			 ->update('department');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deleteDepartment($id)
 {
	$query=$this->db->where('id',$id)
			 ->set('enabled',0)
			 ->update('department');
	if($query){
		return 1;
	}else{
		return 0;}
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
	$query=$this->db->query('select k.id as div_id,k.dep_name as dep_name,k.div_name as div_name,pwemployee.PWFNAME as PWFNAME,pwemployee.PWLNAME as PWLNAME
							 from (select division.id AS id,department.name AS dep_name,division.name AS div_name,division.USERID as USERID 
							 from division inner join department 
							 on department.id = division.dep_id 
							 where division.enabled = 1 )k left join pwemployee
							 on k.USERID = pwemployee.USERID')
					->result_array();
	return $query;
 }
 
 function addDivision_save($department_id,$division_name,$userid)
 {
	$query=$this->db->set('dep_id',$department_id)
			 ->set('name',$division_name)
			 ->set('USERID',$userid)
			 ->set('enabled',1)
			 ->insert('division');
	if($query){
		return 1;
	}else{
		return 0;}
 }

 function div_edit_info($id)
 {
	$query=$this->db->query('select k.div_id as div_id,k.div_name as div_name,k.dep_id as dep_id,k.dep_name as dep_name,pwemployee.USERID as USERID,pwemployee.PWFNAME as PWFNAME,pwemployee.PWLNAME as PWLNAME
							 from
							 (select division.id as div_id,division.name as div_name,department.id as dep_id,department.name as dep_name,division.USERID as USERID
							 from division inner join department
							 on division.dep_id = department.id
							 where division.id = '.$id.')k left join pwemployee
							 on k.USERID = pwemployee.USERID')
					->result_array();
	return $query;
 }
 
 function updateDivision_save($id,$dep_id,$division,$userid)
 {
	$query=$this->db->where('id',$id)
			 ->set('dep_id',$dep_id)
			 ->set('name',$division)
			 ->set('USERID',$userid)
			 ->update('division');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deleteDivision($id)
 {
	$query=$this->db->where('id',$id)
			 ->set('enabled',0)
			 ->update('division');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 //====================== Position =======================
 function position_view()
 {
	$query=$this->db->distinct()
			 ->order_by('PWNAME')
			 ->get('pwposition')
			 ->result_array();
	return $query;
 }
 
 function addPosition_save($tposition,$eposition)
 {
	$query=$this->db->set('PWNAME',$tposition)
			 ->set('PWENAME',$eposition)
			 ->set('PWSTATUS',1)
			 ->set('ISDELETE',0)
			 ->insert('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_edit_position($id)
 {
	$query=$this->db->distinct()
					->where('PWPOSITION',$id)
					->get('pwposition')
					->result_array();
	return $query;
 }
 
 function updatePosition_save($id,$tposition,$eposition)
 {
	$query=$this->db->where('PWPOSITION',$id)
			 ->set('PWNAME',$tposition)
			 ->set('PWENAME',$eposition)
			 ->update('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deletePosition($id)
 {
	$query=$this->db->where('PWPOSITION',$id)
			 ->delete('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
}
?>