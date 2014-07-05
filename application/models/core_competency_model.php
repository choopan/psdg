<?php
Class Core_competency_model extends CI_Model
{
	
	function listSkill() {
		$result = 	$this -> db -> get('core_competency_skill')
					-> result_array();
		return $result;
	}
	
	function addSkill($skillName) {
		$this -> db -> set('name', $skillName)
					-> insert('core_competency_skill');
	}
	
	function deleteSkill($id) {
		$this -> db -> delete('core_competency_skill', array('ID' => $id));
	}

	function getSkillName($id) {
		$result = 	$this -> db -> select('name') -> 
					get_where('core_competency_skill', array('ID' => $id))
					-> result_array();
		return $result; 					
	}
	
	function updateSkill($id, $skillname) {
		$this->db	-> where('id', $id)
					-> set('name', $skillname)
					-> update('core_competency_skill');
	}
	
	function listCoreSet() {
		$result = $this -> db -> get('core_competency_set') -> result_array();
		return $result;
	}
	
	function createCoreSet($coreSetName) {
		$this -> db -> set('name', $coreSetName) -> insert('core_competency_set');
		$id = $this->db->insert_id();
		return $id;
	}
	
	function addSkilltoCoreSet($coresetID, $skillID, $expectVal) {
		$this -> db -> set('coresetID', $coresetID)
					-> set('coreskillID', $skillID)
					-> set('expectVal', $expectVal)
					-> insert('core_competency_expect');
	}
	
	function getCoreSetName($id) {
		$result = $this -> db 
					-> select('name') 
					-> get_where('core_competency_set', array('ID' => $id))
					-> result_array();
		return $result;
	}
	
	function getSkillandExceptVal($id) {
		$result = $this -> db
					-> select('coreskillID, name, expectVal')
					-> from('core_competency_expect')
					-> join('core_competency_skill', 'core_competency_expect.coreskillID = core_competency_skill.ID')
					-> where('coresetID', $id)
					-> get() -> result_array();
		return $result;		
	}

	function deleteCoreSet($id) {
		$this -> db -> delete('core_competency_set', array('ID' => $id));
		$this -> db -> delete('core_competency_expect', array('coresetID' => $id));
	}
	
	function updateCoreSet($id, $coreSetName) {
		$this-> db	-> where ('ID', $id)
					-> set('name', $coreSetName) 
					-> update('core_competency_set');
	}
	
	function deleteAllSkillofCoreSet($id) {
		$this -> db -> delete('core_competency_expect', array('coresetID' => $id));
	}
	
	function updateUserCoreSet($userID, $coreSetID) {
		$this -> db -> set("coresetID", $coreSetID)
					-> where("userID", $userID)
					-> update('PWEMPLOYEE');
		$result = $this -> getCoreSetName($coreSetID);
		return $result;					
	}
	
	function getCoreName($userID) {
		
		$coreID = $this -> db
					-> select('coresetID')
					-> from('pwemployee')
					-> where('USERID', $userID)
					-> get()
					-> result_array('');
	
		$result = $this -> db
					-> select('name, expectVal')
					-> from('core_competency_expect')
					-> join('core_competency_skill', 'core_competency_expect.coreskillID = core_competency_skill.ID')
					-> where('coresetID', $coreID[0]['coresetID'])
					-> get() -> result_array();
		return $result;
	}
	
	
	
}
?>