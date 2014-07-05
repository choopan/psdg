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
	
	function evalAddScore($userID, $year,$score) {
		$personIndicatorRes = $this -> db
													-> select('id')
													-> get_where('person_indicator', array('userID' => $userID, 'year' => $year))
													-> result_array();
													
		$personIndicatorDetailRes = $this -> db
															-> select('ID')
															-> get_where('person_indicator_detail', array('PID' => (int)$personIndicatorRes[0]['id']))
															-> result_array();
															
		$numrow = count($score); 		
		for($i = 0; $i < $numrow; $i++) {
			$this -> db 
					-> set('userID', $userID)
					-> set('personIndicatorID', $personIndicatorDetailRes[$i]['ID'])
					-> set('score', (int)$score[$i])
					-> insert('personal_score');
		}
	}
	
	function coreAddScore($userID, $year ,$evalRound, $coreSkillName ,$expectVal, $selfscore){
	
		$xx = count($coreSkillName); 		

		print_r($expectVal);
		
		$numrow = count($expectVal); 		
		for($i = 0; $i < $numrow; $i++) {
			$this -> db 
					-> set('userID', $userID)
					-> set('year', $year)
					-> set('evalRound', $evalRound)
					-> set('coreSkillName', $coreSkillName[$i])
					-> set('expectVal', (int)$expectVal[$i])
					-> set('selfscore', (int)$selfscore[$i])
					-> insert('core_competency_score');
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
}
?>