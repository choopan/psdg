<?php
Class PersonIndicator extends CI_Model
{
	//Get current evaluation round
	// return: year, round	
	function getActiveEvalRound() {
		$result = $this -> db -> get_where('eval_round', array('active' => 1)) -> result_array();
		return $result;
	}
	
	function setIndicatorStatus($userID, $year, $round, $dep_id, $div_id, $status_no) {
		$this -> db -> where(array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
					-> set('status', $status_no)
					-> update('person_indicator');	
	}
	
	
	function setEvalModify($pid, $status_no) {
			$this -> db -> where(array('id' => $pid))
					-> set('eval_modified', $status_no)
					-> update('person_indicator');
	}
	
	
	function setEvalStatus($userID, $year, $round, $dep_id, $div_id, $status_no) {
		$this -> db -> where(array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
					-> set('eval_status', $status_no)
					-> update('person_indicator');	
	}
	
	
	
	function setEvalStatusByPID($pid, $status_no) {
		$this -> db -> where(array('id' => $pid))
					-> set('eval_status', $status_no)
					-> update('person_indicator');	
	}
		
	//return id of person_indicator
	function getPersonIndicatorID($userID, $depID, $divID, $year, $round) {
		$result = $this	-> db
						-> select('id')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $depID, 'div_id' => $divID))
				 		-> result_array();
		if(count($result) == 0) {
			return 0;
		} else {
			return $result[0]['id'];
		}
	}

	function getPersonIndicatorIDByDetailID($person_indicator_detail_id) {
		$result = $this->db->get_where('person_indicator_detail', array('ID' =>$person_indicator_detail_id))->result_array();
		$PID = $result[0]['PID'];
		return $PID;
	}
	
	function getPIByPID($pid) {
			$result = $this -> db  
							-> get_where('person_indicator', array('id' => $pid))
							-> result_array();			
			return $result;
	}
	
	function listIndicatorByPID($pid) {
			$result = $this -> db -> order_by('order', 'asc') 
							-> get_where('person_indicator_detail', array('PID' => $pid))
							-> result_array();			
			return $result;
	}
	
	function getPIStatus($userID, $depID, $divID, $year, $round) {
		$result = $this	-> db
						-> select('status')
					 	-> get_where('person_indicator', array('userID' => $userID, 
					 											'year' => $year,
					 											'round' => $round,
					 											'dep_id' => $depID,
					 											'div_id' => $divID))
				 		-> result_array();
		if(count($result) == 0) {
			$status = 0;
		} else {
			$status = $result[0]['status'];
		}
		return $status;
	}
	/*
	function getPIStatus($pid) {
		$result = $this	-> db
						-> select('status')
					 	-> get_where('person_indicator', array('ID' => $pid))
				 		-> result_array();
		if(count($result) == 0) {
			$status = 0;
		} else {
			$status = $result[0]['status'];
		}
		return $status;
	}
	*/
	function getIndicatorDetail($id) {
		$result = $this -> db -> where('ID', $id)
							  -> get('person_indicator_detail') -> result_array();
		return $result;
	}
	
	function addPersonIndicator($userID, $year, $round, $dep_id, $div_id, $order, $indicatorName, $weight,
								$ind1, $ind2, $ind3, $ind4, $ind5, 
								$ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5, $modified_by_executive=0) {
		
		$r = $this -> db -> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round))
						 -> result_array();
						 
		$numberofevalinround = count($r);

		$r = $this-> db -> order_by('order', 'desc') 
						-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
						-> result_array();
		//Person Indicator Set is not exist, just create one
		if(count($r) == 0) {
			$this-> db 
					-> set('userID', $userID)
					-> set('year', $year)
					-> set('round', $round)
					-> set('dep_id', $dep_id)
					-> set('div_id', $div_id)
					//-> set('last_update', date('Y-m-d'))
					-> set('order', $numberofevalinround+1)
					-> set('status', 0)
					-> set('modified', 0)
					-> insert('person_indicator');
			$pid = $this->db->insert_id();			
		} else {
			$pid = $r[0]['id'];
			$this -> db -> where('id', $pid) -> set('modified', $modified_by_executive) -> update('person_indicator');
		}
			
		$this->db -> set('PID', $pid)
				  -> set('order', $order)
				  -> set('name', $indicatorName)
				  -> set('weight', $weight)
				  -> set('indicator1', $ind1)
				  -> set('indicator2', $ind2)
				  -> set('indicator3', $ind3)
				  -> set('indicator4', $ind4)
				  -> set('indicator5', $ind5)
				  -> set('detail_indicator1', $ind_detail1)
				  -> set('detail_indicator2', $ind_detail2)
				  -> set('detail_indicator3', $ind_detail3)
				  -> set('detail_indicator4', $ind_detail4)
				  -> set('detail_indicator5', $ind_detail5)
				  -> insert('person_indicator_detail');								
	}
	
	
	function deletePersonIndicator($id, $modified_by_executive=0) {
		$PID = $this->getPersonIndicatorIDByDetailID($id);		
		$this->db	-> where('id', $PID)
					-> set('modified', $modified_by_executive)
					-> update('person_indicator');		
		 $this->db -> where('ID', $id)
		 			-> delete('person_indicator_detail');
	}
	
	
	
	
	
	///////////////////////// OLD CODE HERE //////////////////////////////
	function getAllEvalRound() {
		$result = $this -> db -> order_by('ID', 'desc') -> get('eval_round') -> result_array();
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
	
	/*
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
	*/
	function setEvaluationStatus($pid, $status_no) {
		$this -> db -> where(array('id' => $pid))
					-> set('eval_status', $status_no)
					-> update('person_indicator');	
	}	
	
	

	
	

	
	
	function updatePersonIndicator($id, $order, $indicatorName, $weight,
								$ind1, $ind2, $ind3, $ind4, $ind5, 
								$ind_detail1, $ind_detail2, $ind_detail3, $ind_detail4, $ind_detail5, $modified_by_executive=0) {
		//$PID = $this->getPID($id);
		$this->db	-> where('id', $id)
					-> set('modified', $modified_by_executive)
					-> update('person_indicator');
		
		$this->db -> where('ID', $id)
				  -> set('order', $order)
				  -> set('name', $indicatorName)
				  -> set('weight', $weight)
				  -> set('indicator1', $ind1)
				  -> set('indicator2', $ind2)
				  -> set('indicator3', $ind3)
				  -> set('indicator4', $ind4)
				  -> set('indicator5', $ind5)
				  -> set('detail_indicator1', $ind_detail1)
				  -> set('detail_indicator2', $ind_detail2)
				  -> set('detail_indicator3', $ind_detail3)
				  -> set('detail_indicator4', $ind_detail4)
				  -> set('detail_indicator5', $ind_detail5)
				  -> update('person_indicator_detail');		
	}
								
								
	
	/*
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
				
		if(isset($orders[0])) {				
			$numrow = count($orders); 		
			for($i = 0; $i < $numrow; $i++) {
				$this->db	-> set('PID', $pid)
							-> set('order', $orders[$i])
							-> set('name', $names[$i])
							-> set('weight', $weights[$i])
							-> insert('person_indicator_detail');
			}
		}		
	}
	*/
	
	function setPIStatus($pid, $status) {
	 	$this -> db -> set('status', $status)
					-> where('ID', $pid)
					-> update('person_indicator');
	}					

	function getCoreName($userID, $year, $round, $depID, $divID) {
		//Check if user already add score on core competency	
		$result = $this -> db -> select('id, coreSkillName as name, expectVal, selfscore, exescore')
							  -> get_where('core_competency_score', 
								 array('userID' => $userID, 'year' => $year, 'evalRound' => $round,
								       'depID' => $depID, 'divID' => $divID))
							  -> result_array();
							  
		if(count($result) == 0) {			
			$coreID = $this -> db
						-> select('coreset_id')
						-> from('pwemployee')
						-> join('position_level', 'pwemployee.position_level = position_level.id')
						-> where('USERID', $userID)
						-> get()
						-> result_array();	
		
			$result = $this -> db
						-> select('name, expectVal')
						-> from('core_competency_expect')
						-> join('core_competency_skill', 'core_competency_expect.coreskillID = core_competency_skill.ID')
						-> where('coresetID', $coreID[0]['coreset_id'])
						-> get() -> result_array();
		}						
		return $result;
	}
	
	function evalAddExecScore($userID, $year, $round, $dep_id, $div_id, $score) {
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
					-> set('exec_score', $score[$i])
					-> update('person_indicator_detail');
		}
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

	function coreAddExecScore($userID, $year ,$evalRound, $depID, $divID, $exec_score, $res){
		//Check if already exists
		$result = $this -> db -> get_where('core_competency_score',
						array('userID' => $userID, 'year' => $year, 'evalRound' => $evalRound, 'depID' => $depID,
							  'divID' => $divID))
					-> result_array();
							
			//update
			$numrow = count($res); 		
			for($i = 0; $i < $numrow; $i++) {
				$this -> db -> where('id', $res[$i]['id']) 
						-> set('exescore', $exec_score[$i])
						-> update('core_competency_score');
			}		
	}

	function divExecUpdateCoreSore($pid, $userID, $year ,$evalRound, $depID, $divID, $execscore) {
		$result = $this -> db -> get_where('core_competency_score',
						array('userID' => $userID, 'year' => $year, 'evalRound' => $evalRound, 'depID' => $depID,
							  'divID' => $divID))
					-> result_array();
					
		$numcore = count($execscore);
		$sum_score = 0;							
							
		for($i = 0; $i < $numcore; $i++) {
				$this -> db -> where('ID', $result[$i]['ID']) 
						-> set('exescore', $execscore[$i])
						-> update('core_competency_score');
				$sum_score += $execscore[$i];
				//echo "update core_compteency_score set exescore = ".$execscore[$i]. " WHERE ID = ".$result[$i]['ID']."<BR>";
		}			
		//die();
		//recalculate score in person_indicator	
		$avg_sum_score = round($sum_score / $numcore, 2) * 20;
		$this -> db -> where('ID', $pid)
					-> set('exec_core_score', $avg_sum_score)
					-> update('person_indicator');
		
	}
	
	function coreAddScore($pid, $userID, $year ,$evalRound, $depID, $divID, $coreSkillName ,$expectVal, $selfscore){
		//Check if already exists
		$result = $this -> db -> get_where('core_competency_score',
						array('userID' => $userID, 'year' => $year, 'evalRound' => $evalRound, 'depID' => $depID,
							  'divID' => $divID))
					-> result_array();

		$numcore = count($coreSkillName);
		$sum_score = 0;							
		if(count($result) == 0) {
			//insert
			for($i = 0; $i < $numcore; $i++) {
				$this -> db 
						-> set('userID', $userID)
						-> set('year', $year)
						-> set('evalRound', $evalRound)
						-> set('coreSkillName', $coreSkillName[$i])
						-> set('expectVal', $expectVal[$i])
						-> set('selfscore', $selfscore[$i])
						-> set('depID', $depID)
						-> set('divID', $divID)
						-> insert('core_competency_score');
				$sum_score += $selfscore[$i];
			}
			
		} else {
			//update
			for($i = 0; $i < $numcore; $i++) {
				$this -> db -> where('id', $result[$i]['ID']) 
						-> set('selfscore', $selfscore[$i])
						-> update('core_competency_score');
				$sum_score += $selfscore[$i];
			}			
		}	
		
		//recalculate score in person_indicator	
		$avg_sum_score = round($sum_score / $numcore, 2) * 20;
		$this -> db -> where('ID', $pid)
					-> set('core_score', $avg_sum_score)
					-> update('person_indicator');
		
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
	

	function getNumActivity($detail_id) {
		$result = $this -> db -> get_where('person_indicator_activity', array('person_indicator_detail_id' => $detail_id))
							  -> result_array();
		return count($result);
	}
	
	
	
	function listIndicator($userID, $year, $round, $dep_id, $div_id) {
		$result = $this	-> db
						-> select('ID')
						-> order_by('order', 'desc')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
				 		-> result_array();
		if(count($result) > 0) {
			$result = $this -> db -> order_by('order', 'asc') 
							-> get_where('person_indicator_detail', array('PID' => $result[0]['ID']))
							-> result_array();			
		}
		
		return $result;
	}
	

	
	function getPIEvalStatus($userID, $dep_id, $div_id, $year, $round) {
		$result = $this	-> db
						-> select('eval_status')
					 	-> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'div_id' => $div_id, 'dep_id' => $dep_id))
				 		-> result_array();
		if(count($result) == 0) {
			return 0;
		} else {
			return $result[0]['eval_status'];
		}
	}
	
	function getSavedActivitiesByPID($person_indicator_detail_id) {
		$result = $this -> db 	-> order_by('order', 'asc') 
								-> get_where('person_indicator_activity', array('person_indicator_detail_id'=>$person_indicator_detail_id))
								-> result_array();
		return $result;
	}
	/*
	function getSavedActivities($userID, $year, $round, $dep_id, $div_id) {
			$result = $this -> db -> get_where('person_indicator_activity'
											,array('userID' => $userID, 'year' => $year, 
												   'round' => $round, 'dep_id' => $dep_id, 
												   'div_id' => $div_id)
										  )
							  -> result_array(); 										  
		return $result;
	}
	*/
	
	function addActivity($indicator, $order, $act_date, $act_name, $selfscore, $document_name) {
		$this -> db ->	set('person_indicator_detail_id', $indicator)
					->	set('order', $order)
					-> 	set('activity_date', $act_date)
					->	set('activity_name', $act_name)
					->	set('selfscore', $selfscore)
					->  set('document_name', $document_name)
					-> 	insert('person_indicator_activity');		
	}
	
	function addActivityFromDiv($indicator, $order, $act_date, $act_name, $execscore, $document_name) {
		$this -> db ->	set('person_indicator_detail_id', $indicator)
					->	set('order', $order)
					-> 	set('activity_date', $act_date)
					->	set('activity_name', $act_name)
					->	set('execscore', $execscore)
					->  set('document_name', $document_name)
					-> 	insert('person_indicator_activity');		
	}
	
	function updateActivity($id, $indicator, $order, $act_date, $act_name, $selfscore, $document_name) {
		$this -> db ->	where('ID', $id)
					->  set('person_indicator_detail_id', $indicator)
					->	set('order', $order)
					-> 	set('activity_date', $act_date)
					->	set('activity_name', $act_name)
					->	set('selfscore', $selfscore)
					->  set('document_name', $document_name)
					-> 	update('person_indicator_activity');		
	}
	
	function updateActivityFromDiv($id, $indicator, $order, $act_date, $act_name, $execscore, $document_name) {
		$this -> db ->	where('ID', $id)
					->  set('person_indicator_detail_id', $indicator)
					->	set('order', $order)
					-> 	set('activity_date', $act_date)
					->	set('activity_name', $act_name)
					->	set('execscore', $execscore)
					->  set('document_name', $document_name)
					-> 	update('person_indicator_activity');		
	}
	
	
	/*
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
	}*/
	
	function getEvaluationScore($userID, $year, $round, $dep_id, $div_id) {
		$result = $this	-> db -> get_where('person_indicator', array('userID' => $userID, 'year' => $year, 'round' => $round, 'dep_id' => $dep_id, 'div_id' => $div_id))
				 		-> result_array();
		return $result;
	}

	function recalculateIndicatorExecScore($pid) {
			$result = $this -> db  -> get_where('person_indicator_detail', array('PID' => $pid))
									-> result_array();
									
			$ind_total = 0;
			for($i = 0; $i < count($result); $i++) {
				$score = $this -> db -> select_avg('execscore')
							-> where('person_indicator_detail_id', $result[$i]['ID'])
							-> get('person_indicator_activity') -> result_array();
						
				$ind_score = round($score[0]['execscore'], 2);
				
				//update score in person_indicator_detail table
				$this -> db -> set('exec_score', $ind_score)
							-> where('ID', $result[$i]['ID'])
							-> update('person_indicator_detail');
			
				$ind_total += round($ind_score * $result[$i]['weight'], 2);							
			}			

			//update score in person_indicator
			$this -> db -> set('exec_indicator_score', ($ind_total * 20)) //Hardcore here
						-> where('id', $pid)		
						-> update('person_indicator');	
	}

	
	
	function recalculateIndicatorSelfScore($pid) {
			$result = $this -> db  -> get_where('person_indicator_detail', array('PID' => $pid))
									-> result_array();
									
			$ind_total = 0;
			for($i = 0; $i < count($result); $i++) {
				$score = $this -> db -> select_avg('selfscore')
							-> where('person_indicator_detail_id', $result[$i]['ID'])
							-> get('person_indicator_activity') -> result_array();
						
				$ind_score = round($score[0]['selfscore'], 2);
				
				//update score in person_indicator_detail table
				$this -> db -> set('score', $ind_score)
							-> where('ID', $result[$i]['ID'])
							-> update('person_indicator_detail');
			
				$ind_total += round($ind_score * $result[$i]['weight'], 2);							
			}			

			//update score in person_indicator
			$this -> db -> set('indicator_score', ($ind_total * 20)) //Hardcore here
						-> where('id', $pid)		
						-> update('person_indicator');	
	}
	
	
	function getActivity($activity_id) {
		$result = $this -> db -> get_where('person_indicator_activity', array('ID' => $activity_id))
							  -> result_array();
		return $result;							  		
	}
	/*
	function getActivityScore($activity_id) {
		$result = $this -> db -> get_where('person_indicator_activity_score', array('activity_id' => $activity_id))
							  -> result_array();
		return $result;							  
	}
	*/
	function deleteActivity($activity_id) {
		$this -> db -> where('ID', $activity_id)
					-> delete('person_indicator_activity');
	}
	/*
	function deleteActivityScore($activity_id) {
		$this -> db -> where('activity_id', $activity_id)
					-> delete('person_indicator_activity_score');
	}
	*/
	function setExecActivityScore($activity_id, $exec_score) {
		$this -> db -> where('id', $activity_id)
					-> set('execscore', $exec_score)
					-> update('person_indicator_activity_score');
	}
	
	function getHistoryEval($userID) {
		$result = $this -> db 	-> select('year, round, person_indicator.id as pid, department.name as dep_name, division.name as div_name')
								-> order_by('year desc, round desc, order desc')
								-> from('person_indicator')
								-> join('department', 'department.id = person_indicator.dep_id', 'left')
								-> join('division', 'division.id = person_indicator.div_id', 'left')
								-> where(array('person_indicator.userID' => $userID, 'eval_status' => 3))								
								-> get() -> result_array();
		return $result;
	}
}
?>