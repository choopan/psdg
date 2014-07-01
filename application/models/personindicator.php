<?php
Class PersonIndicator extends CI_Model
{
	function getIndicatorStatus($userID, $year) {
		$result = $this -> db	-> select('status')
								-> get_where('person_indicator', array('userID' => $userID, 'year' => $year))
								-> result_array();
		if(count($result) == 0) {
			return 0;
		} else {
			return $result[0]['status'];
		}								
	}
	
	function setIndicatorStatus($userID, $year, $status_no) {
		$this -> db -> where(array('userID' => $userID, 'year' => $year))
					-> set('status', $status_no)
					-> update('person_indicator');	
	}	
	
	function deleteandAddIndicator($userID, $year, $orders, $names, $weights) {
		$r = $this-> db -> get_where('person_indicator', array('userID' => $userID, 'year' => $year))->result_array();
		//Person Indicator Set is not exist, just create one
		if(count($r) == 0) {
			$this-> db 
					-> set('userID', $userID)
					-> set('year', $year)
					-> set('status', 0)
					-> insert('person_indicator');
			$pid = $this->db->insert_id();				
		} else {
			$pid = $r[0]['id'];
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
	
	
	function listIndicator($userID, $year) {
		$result = $this	-> db
						-> select('ID')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year))
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