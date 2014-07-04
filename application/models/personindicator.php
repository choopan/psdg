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
}
?>