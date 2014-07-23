<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('USERID, PWUSERNAME, PWPASSWORD, PWEFNAME, PWELNAME, admin_min, division, department');
   $this -> db -> from('pwemployee');
   $this -> db -> where('PWUSERNAME', $username);
   $this -> db -> where('PWPASSWORD', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function login2($username, $password)
 {
   $this -> db -> select('pwemployee.USERID as USERID, PWUSERNAME, PWPASSWORD, PWEFNAME, PWELNAME, user_indicator.division as division, user_indicator.department as department, user_indicator.admin_dep as admin_dep,approve_dep, approve_div, set_div, report_div');
   $this -> db -> from('user_indicator');
   $this -> db -> join('pwemployee','user_indicator.userid = pwemployee.USERID','left');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function checkpass($id, $password)
 {
   $this -> db -> select('PWUSERNAME');
   $this -> db -> from('pwemployee');
   $this -> db -> where('USERID', $id);
   $this -> db -> where('PWPASSWORD', $password);
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }
 
 public function getUsers()
 {
	$this->db->select("PWUSERNAME");
	$this->db->order_by("USERID", "asc");
	$this->db->from('pwemployee');				
	$query = $this->db->get();		
	return $query->result();
 }
 
 function editUser($user=NULL)
 {
	$this->db->where('USERID', $user['id']);
	unset($user['id']);
	$query = $this->db->update('pwemployee', $user); 	
	return $query;
 }
 
 function searchName($term)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("pwemployee.userid, CONCAT(pwfname,' ', pwlname) as pwname, pwposition.PWNAME as poname, PWTELOFFICE as pwtelephone, pwemployee.PWPOSITION as positionid, department.name as depname");
	$this->db->from('pwemployee');	
	$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition','left');	
	$this->db->join('department', 'pwemployee.department = department.id','left');
	$this->db->like('pwfname', $term,'after');
	$query = $this->db->get();
	return $query->result();
 }
    
 function searchReportName($term)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("user_indicator.userid, CONCAT(pwfname,' ', pwlname) as pwname, pwposition.PWNAME as poname, PWTELOFFICE as pwtelephone, pwemployee.PWPOSITION as positionid, department.name as depname");
	$this->db->from('user_indicator');	
    $this->db->join('pwemployee', 'pwemployee.userid = user_indicator.userid','left');	
	$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition','left');	
	$this->db->join('department', 'pwemployee.department = department.id','left');
	$this->db->like('pwfname', $term,'after');
    $this->db->where('report_div',1);
	$query = $this->db->get();
	return $query->result();
 }
 
 function getProfile($id=null)
 {
  $this->db->_protect_identifiers=false;
	$this->db->select("PWUSERNAME, CONCAT(pwfname,' ', pwlname) as fullname, PWFNAME, PWLNAME, PWEFNAME, PWELNAME, PWEMAIL, PWTELOFFICE, pwposition.PWNAME as poname, pwposition.PWENAME as poename, pwemployee.PWPOSITION as ponumber");
	$this->db->from('pwemployee');	
	$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition');	
	$this->db->where('USERID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 
 
 
 function getUserFromDiv($userID, $divID, $year, $round) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, department as depID, division as divID')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
 						->where(array('pwemployee.division' => $divID, 'pwemployee.userID !=' => $userID, 
 									  'pwemployee.enabled' => 1))
 						->get() -> result_array();						
	return $result;
 }
 
 //// Old code
 function getMinProfile($id=null) {
 	$result = $this->db->select("pwemployee.USERID as user_id, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, department.name as depname, division.name as divname, department.id as depID, division.id as divID")
			-> from('pwemployee')
			-> join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
			-> join('department', 'pwemployee.department = department.id', 'left')
			-> join('division', 'pwemployee.division = division.id', 'left')
			-> where(array('pwemployee.userid'=> $id, 'division.enabled' => 1, 'department.enabled' => 1))
			-> get() ->result_array();
	return $result;
 }

  function getAllProfileExceptDepExec() {
  	$depexec_ids = $this->getExecFromDep();
  	
 	$result = $this->db->select("pwemployee.USERID as user_id, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, department.id as dep_id, division.id as div_id, department.name as depname, division.name as divname")
			-> from('pwemployee')
			-> join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
			-> join('department', 'pwemployee.department = department.id', 'left')
			-> join('division', 'pwemployee.division = division.id', 'left')
			-> where_not_in('pwemployee.USERID', $depexec_ids)
			-> where(array('division.enabled' => 1, 'department.enabled' => 1))
			-> get() ->result_array();
	return $result;
 }
 function getAllProfile() {
 	$result = $this->db->select("pwemployee.USERID as user_id, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, department.id as dep_id, division.id as div_id, department.name as depname, division.name as divname")
			-> from('pwemployee')
			-> join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
			-> join('department', 'pwemployee.department = department.id', 'left')
			-> join('division', 'pwemployee.division = division.id', 'left')
			-> where(array('division.enabled' => 1, 'department.enabled' => 1))
			-> get() ->result_array();
	return $result;
 }
 
 function getExecDiv($userID) {
 	$result = $this->db->get_where('division', array('userID'=> $userID))->result_array();
	if(count($result) == 0) {
		return false;
	} else {
		return true;
	}			
 }

 function getExecDep($userID) {
 	$result = $this->db->from('department')
					   ->join('department_executive', 'department.id = department_executive.dep_id', 'left')
					   ->where(array('userID'=> $userID, 'status' => 1, 'enabled' => 1))
					   ->get() -> result_array();
 	if(count($result) == 0) {
		return false;
	} else {
		return true;
	}			
 }


 
 function getDepUnderControl($userID) {
 	$result = $this -> db -> select("dep_id")
 						  -> where(array('userID' => $userID, 'status' => 1))
						  -> get('department_executive') -> result_array();
	return $result;   						  	
 }

 function getUserFromDep($userID, $depIDs) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, division.name as divname, pwemployee.department as depID, pwemployee.division as divID')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
 						->where(array('pwemployee.department' => $depID, 'pwemployee.userID !=' => $userID, 'division.enabled' => 1, 'pwemployee.enabled' => 1))
 						->get() -> result_array();
	return $result;
 }

 function getExecFromDep() {
 	$r	 = $this -> db -> select('userID')
					   -> from('department')
					   -> join('department_executive', 'department.id = department_executive.dep_id')
					   -> where(array('enabled' => 1, 'status' => 1))
					   -> get() -> result_array();
	$result = array();
	for($i = 0; $i < count($r); $i++) {
		$result[$i] = $r[$i]['userID'];
	}				
			  
	return $result; 	
 }

 function getDivExecUnderControl($depIDs) {
 	$r	 = $this -> db -> select('userID')
						  -> where_in('dep_id', $depIDs)
						  -> where(array('userID !=' => 0, 'enabled' => 1))
						  -> get('division') -> result_array();
	$result = array();
	for($i = 0; $i < count($r); $i++) {
		$result[$i] = $r[$i]['userID'];
	}				
			  
	return $result;
 }
 
 function getDepExecUnderControl($depIDs) {
 	$r	 = $this -> db -> select('userID')
						  -> where_in('dep_id', $depIDs)
						  -> where(array('userID !=' => 0, 'status !=' => 1))
						  -> get('department_executive') -> result_array();
	$result = array();
	for($i = 0; $i < count($r); $i++) {
		$result[$i] = $r[$i]['userID'];
	}				
			  
	return $result;
 }
 
 function getUserInfo($execUserID) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, division.name as divname, pwemployee.department as depID, pwemployee.division as divID, department.name as depname')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.position', 'left')
						->join('department', 'pwemployee.department = department.id', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
						->where_in('pwemployee.USERID', $execUserID)
 						->where(array('department.enabled' => 1, 'division.enabled' => 1, 'pwemployee.enabled' => 1))
 						->get() -> result_array();
	return $result;
 }
 
 function getUserInfoUnderControlExceptExec($execUserID, $depIDs) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, division.name as divname, pwemployee.department as depID, pwemployee.division as divID, department.name as depname')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.position', 'left')
						->join('department', 'pwemployee.department = department.id', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
						->where_not_in('pwemployee.USERID', $execUserID)
						->where_in('pwemployee.department', $depIDs)
 						->where(array('department.enabled' => 1, 'division.enabled' => 1, 'pwemployee.enabled' => 1))
 						->get() -> result_array();
	return $result;
 }
    
 function getAllAdminMinister($admin=NULL) {
     $result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, division.name as divname, pwemployee.department as depID, pwemployee.division as divID, department.name as depname')
                        ->from('pwemployee')
                        ->join('pwposition', 'pwposition.pwposition = pwemployee.position', 'left')
						->join('department', 'pwemployee.department = department.id', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
                        ->where($admin, 1)
                        ->get()->result();
     return $result;
 }
    
 function getAllAdminDep($admin=NULL,$depIDs=NULL) {
     $result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, division.name as divname, pwemployee.department as depID, pwemployee.division as divID, department.name as depname')
                        ->from('pwemployee')
                        ->join('pwposition', 'pwposition.pwposition = pwemployee.position', 'left')
						->join('department', 'pwemployee.department = department.id', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
                        ->where_in('pwemployee.department', $depIDs)
                        ->where($admin, 1)
                        ->get()->result();
     return $result;
 }
    
 function getAllAdminDiv($admin=NULL,$divIDs=NULL) {
     $result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, division.name as divname, pwemployee.department as depID, pwemployee.division as divID, department.name as depname')
                        ->from('pwemployee')
                        ->join('pwposition', 'pwposition.pwposition = pwemployee.position', 'left')
						->join('department', 'pwemployee.department = department.id', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
                        ->where_in('pwemployee.division', $divIDs)
                        ->where($admin, 1)
                        ->get()->result();
     return $result;
 }
    
 function getThaiName($userid)
 {
    $result = $this->db->select("pwfname, pwlname")
                       ->from("pwemployee")
                       ->where("userid", $userid)
                       ->get()->result();
    return $result;
 }
 
 //==================== indicator user manage =========================
 function user_indicator_view()
 {
	$result = $this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department.name as dep_name, division.name as div_name, pwemployee.PWEMAIL as email,user_indicator.admin_dep as admin_dep,user_indicator.approve_dep as approve_dep,user_indicator.approve_div as approve_div,user_indicator.set_div as set_div,user_indicator.report_div as report_div')
					   ->from('user_indicator')
					   ->join('pwemployee','user_indicator.userid = pwemployee.USERID','left')
					   ->join('department','pwemployee.department = department.id','left')
					   ->join('division','pwemployee.division = division.id','left')
					   ->where('pwemployee.enabled',1)
					   ->get()
					   ->result_array();
    return $result;
 }
 
 function user_indicator_view2()
 {
	$result = $this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department.name as dep_name, division.name as div_name, pwemployee.PWEMAIL as email')
					   ->from('user_indicator')
					   ->join('pwemployee','user_indicator.userid = pwemployee.USERID','left')
					   ->join('department','pwemployee.department = department.id','left')
					   ->join('division','pwemployee.division = division.id','left')
					   ->where('user_indicator.report_div',1)
					   ->where('pwemployee.enabled',1)
					   ->get()
					   ->result_array();
    return $result;
 }
 
 function get_user_name()
 {
	$result = $this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department, division')
					   ->from('pwemployee')
					   ->order_by('PWFNAME','ASC')
					   ->get()
					   ->result_array();
	return $result;
 }
 
 function get_user_name2()
 {
	$result = $this->db->select('pwemployee.USERID as USERID, PWFNAME, PWLNAME, department, division')
					   ->from('pwemployee')
					   ->order_by('PWFNAME','ASC')
					   ->get()
					   ->result_array();
	return $result;
 }
 
 function deleteAll_user()
 {
	$query=$this->db->query('DELETE from user_indicator');
			 
	return $query;
 }
 
 function user_del_info($id)
 {
	$query=$this->db->where('userid',$id)
					->delete('user_indicator');
			 
	return $query;
 }
 
 function autocompleteResponse($term)
 {
		$this->db->_protect_identifiers=false;
		$this->db->select("pwemployee.userid, CONCAT(pwfname,' ', pwlname) as pwname, department, division");
		$this->db->from('pwemployee');
		$this->db->like('pwfname', $term,'after');
		$query = $this->db->get();
		return $query->result_array();
 }
	
 function indicatorUser_save($user_id,$username,$password,$department,$division,$damin_dep,$approve_dep,$approve_div,$set_div)
 {
		$query=$this->db->set('userid',$user_id)
				 ->set('username',$username)
				 ->set('password',md5($password))
				 ->set('department',$department)
				 ->set('division',$division)
				 ->set('admin_dep',$damin_dep)
				 ->set('approve_dep',$approve_dep)
				 ->set('approve_div',$approve_div)
				 ->set('set_div',$set_div)
				 ->set('report_div',0)
				 ->insert('user_indicator');
		return $query;		 
 }
 
 function indicatorUser_save2($user_id,$username,$password,$department,$division,$damin_dep,$approve_dep,$approve_div,$set_div,$report_div)
 {
		$query=$this->db->set('userid',$user_id)
				 ->set('username',$username)
				 ->set('password',md5($password))
				 ->set('department',$department)
				 ->set('division',$division)
				 ->set('admin_dep',$damin_dep)
				 ->set('approve_dep',$approve_dep)
				 ->set('approve_div',$approve_div)
				 ->set('set_div',$set_div)
				 ->set('report_div',$report_div)
				 ->insert('user_indicator');
		return $query;		 
 }
}
?>