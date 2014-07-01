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
	$this->db->select("userid, CONCAT(pwfname,' ', pwlname) as pwname, pwposition.PWNAME as poname, PWTELOFFICE as pwtelephone, pwemployee.PWPOSITION as positionid");
	$this->db->from('pwemployee');	
	$this->db->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition');	
	$this->db->like('pwfname', $term,'after');
	//$this->db->or_like('PWFNAME', $options['keyword'],'after');
	//$this->db->or_like('PWLNAME', $options['keyword'],'after');
	//$this->db->or_like('PWELNAME', $options['keyword'],'after');
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
/*
 function getUserFromDiv($userID, $divID, $year) {
 	$result = $this->db->select('PWFNAME, PWLNAME, PWPOSITION, PWLEVEL, person_indicator.ID AS PID')
 						->from('pwemployee')
 						->join('pwposition', 'pwposition.pwposition = pwemployee.pwposition', 'left')
 						->join('person_indicator', 'pwemployee.USERID = person_indicator.userID')
 						->where(array('person_indicator.year' => $year, 'division' => $divID, 'userID !=' => $userID))->result_array();
	return $result;
 }
 */
}
?>