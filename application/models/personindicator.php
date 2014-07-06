<?php
Class PersonIndicator extends CI_Model
{
	function getAllEvalRound() {
		$result = $this -> db -> order_by('ID', 'desc') -> get('eval_round') -> result_array();
		return $result;	
	}
	
	function getActiveEvalRound() {
		$result = $this -> db -> get_where('eval_round', array('active' => 1)) -> result_array();
		return $result;
	}
	
	function insertEvalRound($year, $round) {
		$this -> db -> set('year', $year)
					-> set('round', $round)
					-> set('active', 0)
					-> insert('eval_round');
	}
	
	function delEvalRound($id) {
		$this->db->where('id', $id)->delete('eval_round');
	}
	
	function setEvalRound($id) {
		$this -> db -> set('active', 0) -> update('eval_round');
		$this -> db -> set('active', 1) -> where('ID', $id) -> update('eval_round');
	}
	
	function getIndicatorStatus($userID, $year, $round, $dep_id, $div_id) {
		$result = $this -> db	-> select('status')
								-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
								-> result_array();
		if(count($result) == 0) {
			return 0;
		} else {
			return $result[0]['status'];
		}								
	}
	
	function setIndicatorStatus($userID, $year, $round, $dep_id, $div_id, $status_no) {
		$this -> db -> where(array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
					-> set('status', $status_no)
					-> update('person_indicator');	
	}	
	
	function deleteandAddIndicator($userID, $year, $round, $dep_id, $div_id, $orders, $names, $weights) {
		$r = $this -> db -> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round))
						 -> result_array();
						 
		$numberofevalinround = count($r);
		
		$r = $this-> db -> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
						-> result_array();
		//Person Indicator Set is not exist, just create one
		if(count($r) == 0) {
			$this-> db 
					-> set('userID', $userID)
					-> set('year', $year)
					-> set('round', $round)
					-> set('dep_id', $dep_id)
					-> set('div_id', $div_id)
					-> set('last_update', date('Y-m-d'))
					-> set('order', $numberofevalinround+1)
					-> set('status', 0)
					-> insert('person_indicator');
			$pid = $this->db->insert_id();				
		} else {
			$pid = $r[0]['id'];
			$this -> db -> set('last_update', date('Y-m-d')) -> update('person_indicator');
			$this -> db -> delete('person_indicator_detail', array('PID' => $pid));
		}
				
		$numrow = count($orders); 		
		for($i = 0; $i < $numrow; $i++) {
			$this->db	-> set('PID', $pid)
						-> set('order', $orders[$i])
						-> set('name', $names[$i])
						-> set('weight', $weights[$i])
						-> insert('person_indicator_detail');
		}		
	}

	function setPIStatus($pid, $status) {
	 	$this -> db -> set('status', $status)
					-> where('ID', $pid)
					-> update('person_indicator');
	}					

	function getCoreName($userID, $year, $round, $depID, $divID) {
		//Check if user already add score on core competency	
		$result = $this -> db -> select('id, coreSkillName as name, expectVal, selfscore')
							  -> get_where('core_competency_score', 
								 array('userID' => $userID, 'year' => $year, 'evalRound' => $round,
								       'depID' => $depID, 'divID' => $divID))
							  -> result_array();
							  
		if(count($result) == 0) {			
			$coreID = $this -> db
						-> select('coresetID')
						-> from('pwemployee')
						-> where('USERID', $userID)
						-> get()
						-> result_array();	
		
			$result = $this -> db
						-> select('name, expectVal')
						-> from('core_competency_expect')
						-> join('core_competency_skill', 'core_competency_expect.coreskillID = core_competency_skill.ID')
						-> where('coresetID', $coreID[0]['coresetID'])
						-> get() -> result_array();
		}						
		return $result;
	}
	
	function evalAddScore($userID, $year, $round, $dep_id, $div_id, $score) {
		$personIndicatorRes = $this -> db
													-> select('id')
													-> get_where('person_indicator', 
														array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
													-> result_array();
													
		$personIndicatorDetailRes = $this -> db
													-> select('ID')
													-> order_by('order', 'asc')
													-> get_where('person_indicator_detail', 
														array('PID' => $personIndicatorRes[0]['id']))
													-> result_array();
															
		$numrow = count($score); 		
		for($i = 0; $i < $numrow; $i++) {
			$this -> db -> where('id', $personIndicatorDetailRes[$i]['ID'])
					-> set('score', $score[$i])
					-> update('person_indicator_detail');
		}
	}
	
	function coreAddScore($userID, $year ,$evalRound, $depID, $divID, $coreSkillName ,$expectVal, $selfscore, $res){
		//Check if already exists
		$result = $this -> db -> get_where('core_competency_score',
						array('userID' => $userID, 'year' => $year, 'evalRound' => $evalRound, 'depID' => $depID,
							  'divID' => $divID))
					-> result_array();
							
		if(count($result) == 0) {
			//insert
			$numrow = count($res); 		
			for($i = 0; $i < $numrow; $i++) {
				$this -> db 
						-> set('userID', $userID)
						-> set('year', $year)
						-> set('evalRound', $evalRound)
						-> set('coreSkillName', $res[$i]['name'])
						-> set('expectVal', (int)$res[$i]['expectVal'])
						-> set('selfscore', (int)$selfscore[$i])
						-> set('depID', $depID)
						-> set('divID', $divID)
						-> insert('core_competency_score');
			}
		} else {
			//update
			$numrow = count($res); 		
			for($i = 0; $i < $numrow; $i++) {
				$this -> db -> where('id', $res[$i]['id']) 
						-> set('selfscore', $selfscore[$i])
						-> update('core_competency_score');
			}
			
		}		
	}
	
	function activityAddScore($activityID, $indicatorID, $indicatorVal){
		
		$numrow = count($indicatorID); 		
		for($i = 0; $i < $numrow; $i++) {
			$this -> db 
					-> set('activity_id', $activityID)
					-> set('pid', $indicatorID[$i]['ID'])
					-> set('score', (int)$indicatorVal[$i])
					-> insert('person_indicator_activity_score');
		}
	}
	
	function getPInumber($userID, $year, $round, $dep_id, $div_id) {
		$result = $this	-> db
						-> select('ID')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
				 		-> result_array();
		return $result;
	}

	function listIndicator($userID, $year, $round, $dep_id, $div_id) {
		$result = $this	-> db
						-> select('ID')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
				 		-> result_array();
		if(count($result) > 0) {
			$result = $this -> db -> order_by('order', 'asc') 
							-> get_where('person_indicator_detail', array('PID' => $result[0]['ID']))
							-> result_array();			
		}
		
		return $result;
	}
	
	function getPIStatus($userID, $dep_id, $div_id, $year, $round) {
		$result = $this	-> db
						-> select('status')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'div_id' => $div_id, 'dep_id' => $dep_id))
				 		-> result_array();
		if(count($result) == 0) {
			$status = 0;
		} else {
			$status = $result[0]['status'];
		}
		return $status;
	}
	
	function getSavedActivities($userID, $year, $round, $dep_id, $div_id) {
		/*$result = $this -> db	-> from('person_indicator_activity')
								-> join('person_indicator_detail', 'person_indicator_detail.id = person_indicator_activity.indicatorID', 'left')
								-> join('person_indicator', 'person_indicator.id = person_indicator_detail.PID')
								-> where(array('person_indicator.userID' => $userID, 'person_indicator.year' => $year, 'person_indicator.round' => $round, 'person_indicator.dep_id' => $dep_id, 'person_indicator.div_id' => $div_id))
								-> get() -> result_array();*/

		$result = $this -> db -> get_where('person_indicator_activity'
											,array('userID' => $userID, 'year' => $year, 
												   'round' => $round, 'dep_id' => $dep_id, 
												   'div_id' => $div_id)
										  )
							  -> result_array(); 										  
		return $result;
	}
	
	function addActivity($userID, $dep_id, $div_id, $year, $round, $activityDate, $activityName, $documentName) {
		$this -> db ->	set('userID', $userID)
					->	set('dep_id', $dep_id)
					-> 	set('div_id', $div_id)
					->	set('year', $year)
					->	set('round', $round)
					->	set('activityName', $activityName)
					->	set('documentName', $documentName)
					-> 	set('date', $activityDate)
					->	insert('person_indicator_activity');
		return $this->db->insert_id();					
	}
	
	function getActivityScore($activity_id) {
		$result = $this -> db -> get_where('person_indicator_activity_score', array('activity_id' => $activity_id))
							  -> result_array();
		return $result;							  
	}
	
	function deleteActivity($activity_id) {
		$this -> db -> where('ID', $activity_id)
					-> delete('person_indicator_activity');
	}
	function deleteActivityScore($activity_id) {
		$this -> db -> where('activity_id', $activity_id)
					-> delete('person_indicator_activity_score');
	}
}
?>