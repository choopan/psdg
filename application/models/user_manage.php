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
	$query=$this->db->order_by('PWFNAME')
					->where('enabled',1)
					->select('USERID, PWFNAME, PWLNAME, department, division, PWPOSITION,PWEMAIL')
					->get('pwemployee')
					->result_array();
	return $query;
 }
 
 function getUserandCoreSet()
 {
	$query=$this->db
			->select('pwemployee.userID AS userID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, core_competency_set.id AS coresetID, core_competency_set.name AS coreset_name')
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
 	$query=$this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWEMAIL')
 					->where('pwemployee.enabled',1)
					->from('PWEMPLOYEE')
					->join('department', 'pwemployee.department = department.id', 'left')
					->join('division', 'pwemployee.division = division.id', 'left' )
					->join('pwposition', 'pwemployee.PWPOSITION = pwposition.PWPOSITION', 'left')
					->get($start, $limit)
					->result_array();
	return $query;
 }
 
 function addUser_save($username,$password,$fname,$lname,$efname,$elname,$gender,$email,$tel,$mobile,$department,$division,$level,$admin_min,$admin_dep,$admin_div,$position_ty,$position,$position_lv)
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
			 ->set('PWLEVEL',$level)
			 ->set('admin_min',$admin_min)
			 ->set('admin_dep',$admin_dep)
			 ->set('admin_div',$admin_div)
			 ->set('position_type',$position_ty)
			 ->set('PWPOSITION',$position)
			 ->set('position',$position)
			 ->set('position_level',$position_lv)
			 ->insert('pwemployee');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function editUser_save($id,$fname,$lname,$efname,$elname,$email,$tel,$mobile,$department,$division,$position_ty,$position,$position_lv,$admin_min,$admin_dep,$admin_div)
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
			 ->set('position_type',$position_ty)
			 ->set('PWPOSITION',$position)
			 ->set('position',$position)
			 ->set('position_level',$position_lv)
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
	$query=$this->db->query('SELECT pwemployee.USERID as USERID,PWUSERNAME,PWFNAME,PWLNAME,PWEFNAME,PWELNAME,PWSEX,PWEMAIL,PWTELOFFICE,mobile,department,department.name as dep_name,division,division.name as div_name,position_type,position_type.name as pos_t_name ,position,pwposition.PWNAME as pos_name,position_level,position_level.name as pos_lv_name,admin_min,admin_dep,admin_div

								from pwemployee left join division
								on pwemployee.division = division.id
								left join department
								on pwemployee.department = department.id

								left join position_type
								on pwemployee.position_type = position_type.id
								left join pwposition
								on pwemployee.position = pwposition.PWPOSITION
								left join position_level
								on pwemployee.position_level = position_level.id

								where pwemployee.USERID ='.$id)
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
 
 function get_position_1($id)
 {
	$query=$this->db->distinct()
					->where('enabled',1)
					->where('position_type_id',$id)
					->select('PWPOSITION,PWNAME')
					->order_by('PWNAME','ASC')
					->get('pwposition')
					->result_array();
	return $query;
 }
 
 function get_position_2($id)
 {
	$query=$this->db->distinct()
					->where('enabled',1)
					->where('position_type_id',$id)
					->order_by('name','ASC')
					->get('position_level')
					->result_array();
	return $query;
 }
 
 function get_position()
 {
	$query=$this->db->distinct()
					->where('enabled',1)
					->select('PWPOSITION,PWNAME')
					->order_by('PWNAME')
					->get('pwposition')
					->result_array();
	return $query;
 }
 
 function get_search($where)
 {
	$query=$this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, PWEFNAME, PWELNAME, department.name AS dep_name, division.name AS div_name,PWEMAIL')
					->from('pwemployee')
					->join('department','pwemployee.department = department.id','LEFT')
					->join('division','pwemployee.division = division.id','LEFT')
					->join('position_type','pwemployee.position_type = position_type.id','LEFT')
					->join('pwposition','pwemployee.position = pwposition.PWPOSITION','LEFT')
					->join('position_level','pwemployee.position_level = position_level.id','LEFT')
					->where($where)
					->get()
					->result_array();
	return $query;
 }
 
 //============================================================= Department =====================================
 function addDepartmaent_save($department_name)
 {
	$query=$this->db->set('name',$department_name)
			 ->set('enabled',1)
			 ->insert('department');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function addDepartmaent_user($id,$user,$status)
 {
	$query=$this->db->set('dep_id',$id)
					 ->set('userID',$user)
					 ->set('status',$status)
					 ->insert('department_executive');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_department()
 {
	$query=$this->db->query('SELECT DISTINCT department.id as id,name,k.dep_ex_id as dep_id,k.PWFNAME as PWFNAME,k.PWLNAME as PWLNAME FROM department LEFT JOIN
							(select  department_executive.id as dep_ex_id,department_executive.dep_id as dep_id,pwemployee.PWFNAME as PWFNAME,pwemployee.PWLNAME as PWLNAME
							 from department_executive inner join pwemployee
							 on department_executive.userID = pwemployee.USERID
							 where department_executive.status=1)k
							 ON department.id = k.dep_id
							WHERE department.enabled = 1')
					->result_array();
	return $query;
 }
 
  function get_department_user($id)
 {
	$query=$this->db->query('SELECT DISTINCT department.id as id,name,k.dep_ex_id as dep_id,k.PWFNAME as PWFNAME,k.PWLNAME as PWLNAME,k.status as status 
							 FROM department LEFT JOIN
							(select  department_executive.id as dep_ex_id,department_executive.dep_id as dep_id,pwemployee.PWFNAME as PWFNAME,pwemployee.PWLNAME as PWLNAME,department_executive.status as status
							 from department_executive inner join pwemployee
							 on department_executive.userID = pwemployee.USERID
							)k 
							 ON department.id = k.dep_id
							WHERE department.enabled = 1
							AND department.id ='.$id.'
							ORDER BY k.status ASC')
					->result_array();
	return $query;
 }
 
 function get_department_1()
 {
	$query=$this->db->query('SELECT DISTINCT id,name FROM department WHERE department.enabled = 1 ORDER BY name')
					->result_array();
	return $query;
 }
 
 function dep_edit_name($id)
 {
	$query=$this->db->query('SELECT id,name FROM department WHERE id = '.$id)
					->result_array();
	return $query;
 }
 
 function dep_edit_info($id)
 {
	$query=$this->db->query('SELECT id,name,PWFNAME,PWLNAME FROM department LEFT JOIN pwemployee
							 ON department.id = pwemployee.department WHERE id = '.$id)
					->result_array();
	return $query;
 }
 
 function updateDepartmaent_save($id,$department)
 {
	$query=$this->db->where('id',$id)
			 ->set('name',$department)
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
 
 function dep_del_user($id)
 {
	$query=$this->db->where('id',$id)
			 ->delete('department_executive');
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
 
 function addPosition_type_save($tposition)
 {
	$query=$this->db->set('name',$tposition)
					->insert('position_type');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function addPosition_save($tposition,$nposition)
 {
	$query=$this->db->set('position_type_id',$tposition)
					->set('PWNAME',$nposition)
					->set('enabled',1)
					->insert('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function addPosition_level_save($tposition,$eposition_level)
 {
	$query=$this->db->set('position_type_id',$tposition)
					->set('name',$eposition_level)
					->set('enabled',1)
					->insert('position_level');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_position_type()
 {
	$query=$this->db->distinct()
					->where('enabled',1)
					->order_by('name')
					->get('position_type')
					->result_array();
	return $query;
 }
 
 function get_postition()
 {
	$query=$this->db->query('SELECT DISTINCT position_type.id as id,position_type.name as name,pwposition.PWPOSITION as pos_id,pwposition.PWNAME as pwname
							 FROM position_type inner join pwposition
							 ON position_type.id = pwposition.position_type_id
							 WHERE pwposition.enabled = 1
							 ORDER BY position_type.id')
					->result_array();
	return $query;
 }
 
 function get_position_level()
 {
	$query=$this->db->query('SELECT DISTINCT position_type.id as id,position_type.name as name,position_level.id as pos_id,position_level.name as pos_lv
							 FROM position_type inner join position_level
							 ON position_type.id = position_level.position_type_id
							 WHERE position_level.enabled=1 
							 ORDER BY position_type.id')
					->result_array();
	return $query;
 }
 
 function get_edit_position_type($id)
 {
	$query=$this->db->distinct()
					->order_by('name')
					->where('id',$id)
					->get('position_type')
					->result_array();
	return $query;
 }
 
 function updatePosition_type_save($id,$name)
 {
	$query=$this->db->where('id',$id)
			 ->set('name',$name)
			 ->update('position_type');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_edit_position($id)
 {
	$query=$this->db->query('SELECT DISTINCT position_type.id as id,position_type.name as name,pwposition.PWPOSITION as pos_id,pwposition.PWNAME as pos_name
							 FROM position_type inner join pwposition
                             ON  position_type.id = pwposition.position_type_id
							 WHERE pwposition.PWPOSITION = '.$id.'
							 ORDER BY pwposition.PWNAME ASC')
					->result_array();
	return $query;
 }
 
 function updatePosition_save($id,$tposition,$nposition)
 {
	$query=$this->db->where('PWPOSITION',$id)
			 ->set('position_type_id',$tposition)
			 ->set('PWNAME',$nposition)
			 ->update('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deletePosition($id)
 {
	$query=$this->db->where('PWPOSITION',$id)
					->set('enabled',0)
					->update('pwposition');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deletePosition_level($id)
 {
	$query=$this->db->where('id',$id)
					->set('enabled',0)
					->update('position_level');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function get_edit_position_lv($id)
 {
	$query=$this->db->query('SELECT DISTINCT position_type.id as id,position_type.name as name,position_level.id as lv_id,position_level.name as lv_name
							 FROM position_type inner join position_level
                             ON  position_type.id = position_level.position_type_id
							 WHERE position_level.id = '.$id.'
							 ORDER BY position_level.name ASC')
					->result_array();
	return $query;
 }
 
 function updatePosition_lv_save($id,$tposition,$name)
 {
	$query=$this->db->where('id',$id)
			 ->set('position_type_id',$tposition)
			 ->set('name',$name)
			 ->update('position_level');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 function deletePosition_type($id)
 {
	$query=$this->db->where('id',$id)
					->set('enabled',0)
					->update('position_type');
	if($query){
		return 1;
	}else{
		return 0;}
 }
 
 
 function getAllPotionTypeandLevel() {
 	$result = $this->db	->select("position_level.id AS position_level_id, position_type.name as position_type_name, position_level.name as position_level_name, core_competency_set.id as coresetID, core_competency_set.name as coreset_name")
						->from('position_type')
						->join('position_level', 'position_type.id = position_level.position_type_id')
						->join('core_competency_set', 'position_level.coreset_id = core_competency_set.id', 'left')
						->where(array('position_level.enabled' => 1, 'position_type.enabled' => 1))
						->order_by('position_level.id', 'asc')
						->get() -> result_array();
	return $result;						
 }
}
?>