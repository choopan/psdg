<?php
Class Ministerindicator extends CI_Model
{
 function getIndicator()
 {
	$this->db->select("number, name, id");
	$this->db->order_by("number", "asc");
	$this->db->from('min_indicator');				
	$query = $this->db->get();		
	return $query->result();
 }
 
 //    get only name from indicator or goal
 function getNameFromMinister($table, $id, $value)
 {
	$result = $this->db->select("name")
					   ->from($table)
			           ->where($id, $value)
					   ->get()->result_array();
	return $result;
 }

 function getIndicatorGroupDepartment($year)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("number, min_indicator.name, GROUP_CONCAT( DISTINCT(department.name) SEPARATOR ' <br> ' ) AS TDepName, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, min_indicator.id as mid");
	$this->db->order_by("number*1", "asc");
	$this->db->from('min_indicator');		
	$this->db->join('minIndicatorResponse','minIndicatorResponse.minIndicatorID=min_indicator.id', 'left');	
	$this->db->join('pwemployee','pwemployee.userid=minIndicatorResponse.userID', 'left');	
	$this->db->join('department','department.id=pwemployee.department', 'left');	
	//$this->db->group_by('minIndicatorResponse.resDepartmentID');
	$this->db->group_by('min_indicator.name');
	$this->db->where('year', $year);
	$query = $this->db->get();	
	return $query->result();
 }
 
 function getIndicatorMin($year=NULL)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("min_indicator.id as id, number, name");
	$this->db->order_by("number*1", "asc");
	$this->db->from('min_indicator');
	//$this->db->join('minIndicatorResponse','minIndicatorResponse.minIndicatorID=min_indicator.id');	
	//$this->db->join('pwdepartment','pwdepartment.DepID=minIndicatorResponse.resDepartmentID');	
	$this->db->where('year', $year);
	$query = $this->db->get();	
	return $query;
 }
 
 function getIndicatorMinGoal($id=NULL, $year=NULL)
 {
	$this->db->select("indicatorID as id, min_goal.number, min_goal.name, min_goal.id as goalid");
	$this->db->order_by("number", "asc");
	$this->db->from('min_goal');
	$this->db->join('min_indicator','min_goal.indicatorID=min_indicator.id','left');	
	$this->db->where('indicatorID', $id);
	$this->db->where('year', $year);
	$query = $this->db->get();
	return $query;
 }
 
 function getIndicatorDep($dep=null,$ismin=null,$min=null,$isgoal=null,$goal=null,$userid=null)
 {
	$this->db->select("number, name, id, depID, isMinister, isGoalmin, weight,goal");
	$this->db->order_by("number", "asc");
	$this->db->from('dep_indicator');	
	$this->db->where('depID', $dep);
    $this->db->where($ismin, $min);
    $this->db->where($isgoal, $goal);	
    $this->db->where('editorID', $userid);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getAllIndicatorDep($dep=null)
 {
	$this->db->select("number, name, id, depID, isMinister, isGoalmin, weight,goal, criteria1, criteria2, criteria3, criteria4, criteria5");
	$this->db->order_by("number", "asc");
	$this->db->from('dep_indicator');	
	$this->db->where('depID', $dep);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getIndicatorOneDep($id=NULL, $year=NULL)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("id, number, name");
	$this->db->order_by("number*1", "asc");
	$this->db->from('dep_indicator');
    $this->db->where('depid', $id);
	$this->db->where('year', $year);
	$query = $this->db->get();	
	return $query;
 }
 
 function getIndicatorOneDepGoal($id=NULL, $year=NULL)
 {
	$this->db->select("indicatorID as id, dep_goal.number, dep_goal.name, dep_goal.id as goalid");
	$this->db->order_by("number", "asc");
	$this->db->from('dep_goal');
	$this->db->join('dep_indicator','dep_goal.indicatorID=dep_indicator.id','left');	
	$this->db->where('indicatorID', $id);
	$this->db->where('year', $year);
	$query = $this->db->get();
	return $query;
 }
    
 function getIndicatorDiv($div=null,$isdep=null,$dep=null,$isgoal=null,$goal=null,$userid=null)
 {
	$this->db->select("number, name, id, divisionID, isDep, isGoalDep, weight,goal");
	$this->db->order_by("number", "asc");
	$this->db->from('division_indicator');	
	$this->db->where('divisionID', $div);
    $this->db->where($isdep, $dep);
    $this->db->where($isgoal, $goal);	
    $this->db->where('editorID', $userid);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getIndicatorOneDiv($id=NULL, $year=NULL)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("id, number, name");
	$this->db->order_by("number*1", "asc");
	$this->db->from('division_indicator');
    $this->db->where('divisionID', $id);
	$this->db->where('year', $year);
	$query = $this->db->get();	
	return $query;
 }
 
 function getIndicatorOneDivGoal($id=NULL, $year=NULL)
 {
	$this->db->select("indicatorID as id, dep_goal.number, dep_goal.name, dep_goal.id as goalid");
	$this->db->order_by("number", "asc");
	$this->db->from('division_goal');
	$this->db->join('division_indicator','division_goal.indicatorID=division_indicator.id','left');	
	$this->db->where('indicatorID', $id);
	$this->db->where('year', $year);
	$query = $this->db->get();
	return $query;
 }
 
 function getIndicatorDivision($div=null)
 {
	$this->db->select("number, name, id, divisionID, isDep, weight,goal, criteria1, criteria2, criteria3, criteria4, criteria5");
	$this->db->order_by("number", "asc");
	$this->db->from('division_indicator');	
	$this->db->where('divisionID', $div);	
	$query = $this->db->get();		
	return $query->result();
 }

 function getIndicatorOneDepAdmin($dep=null)
 {
	$this->db->select("adminName, userID, adminPosition, adminTelephone");
	$this->db->from('depIndicatorAdmin');	
	$this->db->where('depID', $dep);	
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getIndicatorOneDivisionAdmin($div=null)
 {
	$this->db->select("adminName, userID, adminPosition, adminTelephone");
	$this->db->from('divisionIndicatorAdmin');	
	$this->db->where('divisionID', $div);	
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getIndicatorPerson($person=null)
 {
	$this->db->select("number, name, id, divIndicatorID, goal, weight");
	$this->db->order_by("number", "asc");
	$this->db->from('person_indicator');	
	$this->db->where('userID', $person);	
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getIndicatorPersonNoRound($person=null)
 {
	$this->db->select("number, name, id, divIndicatorID, goal, weight");
	$this->db->order_by("number", "asc");
	$this->db->from('person_indicator');	
	$this->db->where('userID', $person);	
	$this->db->where('evaluateRound', 0);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicator($id=NULL)
 {
	$this->db->select("id, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote");
	$this->db->order_by("id", "asc");
	$this->db->from('min_indicator');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorPerson($id=NULL)
 {
	$this->db->select("userID, evaluateRound, person_indicator.year as pyear, person_indicator.number as pnumber, person_indicator.name as pname, division_indicator.number as indivnumber, division_indicator.name as indivname, thdepname, person_indicator.weight as pweight,person_indicator.goal as pgoal, person_indicator.criteria1 as pcriteria1, person_indicator.criteria2 as pcriteria2, person_indicator.criteria3 as pcriteria3, person_indicator.criteria4 as pcriteria4, person_indicator.criteria5 as pcriteria5, person_indicator.technicalnote as ptechnicalnote");
	$this->db->order_by("person_indicator.id", "asc");
	$this->db->from('person_indicator');
	$this->db->join('division_indicator','division_indicator.id=person_indicator.divIndicatorID');
	$this->db->join('pwdepartment','pwdepartment.DepID=division_indicator.divisionID');
	$this->db->where('person_indicator.id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorPersonByUserid($userid=NULL, $year=NULL, $round=NULL)
 {
	$this->db->select("userID, evaluateRound, person_indicator.year as pyear, person_indicator.number as pnumber, person_indicator.name as pname, division_indicator.number as indivnumber, division_indicator.name as indivname, thdepname, person_indicator.weight as pweight,person_indicator.goal as pgoal, person_indicator.criteria1 as pcriteria1, person_indicator.criteria2 as pcriteria2, person_indicator.criteria3 as pcriteria3, person_indicator.criteria4 as pcriteria4, person_indicator.criteria5 as pcriteria5, person_indicator.technicalnote as ptechnicalnote, isEditor");
	$this->db->order_by("person_indicator.number", "asc");
	$this->db->from('person_indicator');
	$this->db->join('division_indicator','division_indicator.id=person_indicator.divIndicatorID');
	$this->db->join('pwdepartment','pwdepartment.DepID=division_indicator.divisionID');
	$this->db->where('person_indicator.userID', $userid);
	$this->db->where('person_indicator.year', $year);
	$this->db->where('person_indicator.evaluateRound', $round);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getWorkatIndicatorPerson($userid=NULL, $year=NULL, $round=NULL)
 {
	$this->db->select("person_evaluate_workat.startdate as pstartdate, person_evaluate_workat.enddate as penddate, thdepname , evaluateRound, person_evaluate_workat.year as pyear");
	$this->db->order_by("startdate", "asc");
	$this->db->from('person_evaluate_workat');
	$this->db->join('pwdepartment','pwdepartment.DepID=person_evaluate_workat.depID');
	$this->db->where('userID', $userid);
	$this->db->where('year', $year);
	$this->db->where('evaluateRound', $round);
	$query = $this->db->get();		
	return $query->result();
 }
 
  function getOneIndicatorPersonLast($userid=NULL)
 {
	$this->db->select_max("year", 'maxyear');
	$this->db->from("person_indicator");
	$this->db->where('userID', $userid);
	$query = $this->db->get();
	foreach ($query->result() as $row) { $maxyear = $row->maxyear; }
	
	$this->db->select_max("evaluateRound", 'maxround');
	$this->db->from("person_indicator");
	$this->db->where('userID', $userid);
	$this->db->where('year', $maxyear);
	$this->db->where('evaluateRound > 0');
	$query = $this->db->get();
	foreach ($query->result() as $row) { $maxround = $row->maxround; }
 
	//$this->db->select("id, userID, evaluateRound, year, number, name, weight, goal, criteria1, criteria2, criteria3, criteria4, criteria5, technicalnote, divIndicatorID");
	$this->db->select("id, userID, name");
	$this->db->order_by("number", "asc");
	$this->db->from('person_indicator');
	$this->db->where('userID', $userid);
	$this->db->where('year', $maxyear);
	$this->db->where('evaluateRound', $maxround);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorPersonOnlyOneTable($id=NULL)
 {	
	$this->db->select("id, userID, evaluateRound, year, number, name, weight, goal, criteria1, criteria2, criteria3, criteria4, criteria5, technicalnote, divIndicatorID");
	$this->db->from('person_indicator');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorPerson2($id=NULL)
 {
	$this->db->select("person_indicator.resID as rID, person_indicator.number as pnumber, person_indicator.name as pname,dep_indicator.name as indepname, pwsection.pwname as depname, person_indicator.resName as presName, person_indicator.resPosition as presPosition,person_indicator.resTelephone as presTelephone, person_indicator.weight as pweight,person_indicator.goal as pgoal");
	$this->db->order_by("person_indicator.id", "asc");
	$this->db->from('person_indicator');
	$this->db->join('dep_indicator','dep_indicator.id=person_indicator.depIndicatorID');
	$this->db->join('pwsection','pwsection.pwsection=dep_indicator.depID');
	$this->db->where('person_indicator.resID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorDep($id=NULL)
 {
	$this->db->select("id, depID, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote, pwfname, pwlname");
	$this->db->from('dep_indicator');
    $this->db->join('pwemployee','pwemployee.userid = dep_indicator.editorID','left');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorDivision($id=NULL)
 {
	$this->db->select("id, divisionID, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote, pwfname, pwlname");
	$this->db->from('division_indicator');
    $this->db->join('pwemployee','pwemployee.userid = division_indicator.editorID','left');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 
 function getOneIndicatorGoal($id=NULL)
 {
	$this->db->select("indicatorID, number, name");
	$this->db->order_by("number", "asc");
	$this->db->from('min_goal');
	$this->db->where('indicatorID', $id);
	$query = $this->db->get();
	return $query->result();
 }
 
 function getOneIndicatorResponse($id=NULL)
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("minIndicatorResponse.userID, CONCAT(pwfname,' ', pwlname) as resName, pwposition.pwname as poname, pwemployee.pwteloffice as resTelephone, department.name as ThDepName, isControl");
	$this->db->order_by("minIndicatorResponse.id", "asc");
	$this->db->from('minIndicatorResponse');
	$this->db->join('pwemployee','pwemployee.userid=minIndicatorResponse.userID');	
	$this->db->join('department','department.id=pwemployee.department');	
	$this->db->join('pwposition','pwposition.pwposition=pwemployee.pwposition');	
	$this->db->where('minIndicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }

 function getOneIndicatorResponseDep($id=NULL)
 {
	$this->db->select("userID, resName, pwposition.pwname as poname, resTelephone, ThDepName");
	$this->db->order_by("id", "asc");
	$this->db->from('depIndicatorResponse');
	$this->db->join('pwdepartment','pwdepartment.DepID=depIndicatorResponse.resDepartmentID');	
	$this->db->join('pwposition','pwposition.pwposition=depIndicatorResponse.resPosition');	
	$this->db->where('depIndicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorResponseDivision($id=NULL)
 {
	$this->db->select("userID, resName, pwposition.pwname as poname, resTelephone, ThDepName");
	$this->db->order_by("id", "asc");
	$this->db->from('divisionIndicatorResponse');
	$this->db->join('pwdepartment','pwdepartment.DepID=divisionIndicatorResponse.resDepartmentID');	
	$this->db->join('pwposition','pwposition.pwposition=divisionIndicatorResponse.resPosition');	
	$this->db->where('divisionIndicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorGoalDep($id=NULL)
 {
	$this->db->select("number, name, pwfname, pwlname");
	$this->db->order_by("number", "asc");
	$this->db->from('dep_goal');
    $this->db->join('pwemployee', 'pwemployee.userid=dep_goal.responseID', 'left');
	$this->db->where('indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorGoalDivision($id=NULL)
 {
	$this->db->select("number, name, pwfname, pwlname");
	$this->db->order_by("number", "asc");
	$this->db->from('division_goal');
     $this->db->join('pwemployee', 'pwemployee.userid=division_goal.responseID', 'left');
	$this->db->where('indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }

 function getOneIndicatorGoalPerson($id=NULL)
 {
	$this->db->select("number, name");
	$this->db->order_by("number", "asc");
	$this->db->from('person_goal');
	$this->db->where('indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function addIndicator($in=NULL)
 {		
	$this->db->insert('min_indicator', $in);
	return $this->db->insert_id();			
 }

 function addIndicatorResponse($in=NULL)
 {		
	$this->db->insert('minIndicatorResponse', $in);
	return $this->db->insert_id();			
 }
 
 
 function addIndicatorGoal($in=NULL)
 {		
	$this->db->insert('min_goal', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorDep($in=NULL)
 {		
	$this->db->insert('dep_indicator', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorDivision($in=NULL)
 {		
	$this->db->insert('division_indicator', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorPerson($in=NULL)
 {		
	$this->db->insert('person_indicator', $in);
	return $this->db->insert_id();			
 }
 
 function addEvaluatePersonWorkat($workat=NULL)
 {		
	$this->db->insert('person_evaluate_workat', $workat);
	return $this->db->insert_id();			
 }
 
 function editIndicatorDep($in=NULL)
 {		
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('dep_indicator', $in); 	
	return $query;
 }
 
 function editIndicatorDivision($in=NULL)
 {		
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('division_indicator', $in); 	
	return $query;
 }
 
 function editIndicatorPerson($in=NULL)
 {		
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('person_indicator', $in); 	
	return $query;
 }
 
 function addIndicatorGoalDep($in=NULL)
 {		
	$this->db->insert('dep_goal', $in);
	return $this->db->insert_id();			
 }
 
  function addIndicatorGoalDivision($in=NULL)
 {		
	$this->db->insert('division_goal', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorGoalPerson($in=NULL)
 {		
	$this->db->insert('person_goal', $in);
	return $this->db->insert_id();			
 }

 function addIndicatorResponseDep($in=NULL)
 {		
	$this->db->insert('depIndicatorResponse', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorResponseDivision($in=NULL)
 {		
	$this->db->insert('divisionIndicatorResponse', $in);
	return $this->db->insert_id();			
 }

 function addIndicatorAdminDep($in=NULL)
 {		
	$this->db->insert('depIndicatorAdmin', $in);
	return $this->db->insert_id();			
 }
 
 function addIndicatorAdminDivision($in=NULL)
 {		
	$this->db->insert('divisionIndicatorAdmin', $in);
	return $this->db->insert_id();			
 }
 
 function delIndicator($id=NULL)
 {
	$this->db->where('id', $id);
	$this->db->delete('min_indicator'); 
 }

 function delResponsebyIndicator($in=NULL)
 {		
	$this->db->where('minIndicatorID', $in);
	$this->db->delete('minIndicatorResponse'); 
 }

 function delGoalbyIndicator($id=NULL)
 {
	$this->db->where('indicatorID', $id);
	$this->db->delete('min_goal'); 
 }
 
 function delIndicatorDep($id=NULL)
 {
	$this->db->where('id', $id);
	$this->db->delete('dep_indicator'); 
 }
 
 function delIndicatorDivision($id=NULL)
 {
	$this->db->where('id', $id);
	$this->db->delete('division_indicator'); 
 }

 function delGoalbyIndicatorDep($id=NULL)
 {
	$this->db->where('indicatorID', $id);
	$this->db->delete('dep_goal'); 
 }
 
 function delGoalbyIndicatorDivision($id=NULL)
 {
	$this->db->where('indicatorID', $id);
	$this->db->delete('divison_goal'); 
 }
 
 function delIndicatorPerson($id=NULL, $year=NULL)
 {
	$this->db->where('userID', $id);
	$this->db->where('year', $year);
	$this->db->delete('person_indicator'); 
 }
 
 function delIndicatorPersonGoal($id=NULL)
 {
	$this->db->where('userID', $id);
	$this->db->delete('person_goal'); 
 }
    
 function delDepIndicatorTemp($id=NULL)
 {
    // delete dep_indicator depid=0 temp
    $this->db->where('id', $id);
	$this->db->delete('dep_indicator');
    
    // delete dep_goal temp
    $this->db->where('indicatorID', $id);
	$this->db->delete('dep_goal');
     
 }
    
 function delDivIndicatorTemp($id=NULL)
 {
    // delete dep_indicator depid=0 temp
    $this->db->where('id', $id);
	$this->db->delete('division_indicator');
    
    // delete dep_goal temp
    $this->db->where('indicatorID', $id);
	$this->db->delete('division_goal');
     
 }
 
 function editNumber($in=NULL)
 {
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('min_indicator', $in); 	
	return $query;
 }
    
 function editNumberDep($in=NULL)
 {
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('dep_indicator', $in); 	
	return $query;
 }
    
 function editNumberDiv($in=NULL)
 {
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update('division_indicator', $in); 	
	return $query;
 }

}
?>