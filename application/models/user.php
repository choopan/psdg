<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('USERID, PWUSERNAME, PWPASSWORD, PWEFNAME, PWELNAME, admin_min, admin_dep, admin_div, division, department');
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
	$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition');	
	$this->db->join('department', 'pwemployee.department = department.id');
	$this->db->like('pwfname', $term,'after');
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
 	$result = $this->db->get_where('department', array('userID'=> $userID))->result_array();
	if(count($result) == 0) {
		return false;
	} else {
		return true;
	}			
 }

 function getUserFromDiv($userID, $divID) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, department as depID, division as divID')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
 						->where(array('pwemployee.division' => $divID, 'pwemployee.userID !=' => $userID))
 						->get() -> result_array();
	return $result;
 }


 function getUserFromDep($userID, $depID) {
 	$result = $this->db->select('pwemployee.USERID as userID, PWFNAME, PWLNAME, PWPOSITION.PWNAME as position, PWLEVEL, division.name as divname, pwemployee.department as depID, pwemployee.division as divID')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
						->join('division', 'pwemployee.division = division.id', 'left')
 						->where(array('pwemployee.department' => $depID, 'pwemployee.userID !=' => $userID, 'division.enabled' => 1))
 						->get() -> result_array();
	return $result;
 }
}
?>