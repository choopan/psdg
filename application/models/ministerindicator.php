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
	$this->db->join('min_indicator_response','min_indicator_response.minIndicatorID=min_indicator.id', 'left');	
	$this->db->join('pwemployee','pwemployee.userid=min_indicator_response.userID', 'left');	
	$this->db->join('department','department.id=pwemployee.department', 'left');	
	//$this->db->group_by('min_indicator_response.resDepartmentID');
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
	//$this->db->join('min_indicator_response','min_indicator_response.minIndicatorID=min_indicator.id');	
	//$this->db->join('pwdepartment','pwdepartment.DepID=min_indicator_response.resDepartmentID');	
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
    
 function getGoalTemp($userid=null,$table=null)
 {
    if ($table == "division_goal") $this->db->select("indicatorID as id, number, name, id as goalid, pwfname,pwlname");
	else $this->db->select("indicatorID as id, number, name, id as goalid");
        
	$this->db->order_by("number", "asc");
	$this->db->from($table);	
     
    if ($table == "division_goal") $this->db->join('pwemployee','pwemployee.userid = '.$table.'.responseid','left');
     
	$this->db->where('indicatorID', 0);
    $this->db->where('editorID', $userid);
	$query = $this->db->get()->result();
	return $query;
 }
    
 function getOneGoal($id=null, $table)
 {
     $result = $this->db->select("number,name")
                        ->from($table."_goal")
                        ->where("id", $id)
                        ->get()->result();
     return $result;
 }
    
 function getPlanTarget($goalid=null,$table)
 {
     $result = $this->db->select($table."_plan.number as pnumber,".$table."_plan.name as pname,".$table."_target.number as tnumber,".$table."_target.name as tname")
                        ->order_by($table."_plan.number", "asc")
                        ->from($table."_target")
                        ->join($table."_plan",$table."_plan.id=".$table."_target.".$table."_plan_id","left")
                        ->where($table."_goal_id", $goalid)
                        ->get()->result();
     return $result;
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

 function getOneIndicator($id=NULL)
 {
	$this->db->select("id, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote");
	$this->db->order_by("id", "asc");
	$this->db->from('min_indicator');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorDep($id=NULL)
 {
	$this->db->select("id, depID, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote, pwfname, pwlname, isMinister, isGoalmin");
	$this->db->from('dep_indicator');
    $this->db->join('pwemployee','pwemployee.userid = dep_indicator.editorID','left');
	$this->db->where('id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorDivision($id=NULL)
 {
	$this->db->select("id, divisionID, number, name, criteria1, criteria2, criteria3, criteria4, criteria5, goal, weight, technicalnote, pwfname, pwlname, isDep, isGoalDep");
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
	$this->db->select("min_indicator_response.userID, user_indicator.name as resName, pwposition.pwname as poname, pwemployee.pwteloffice as resTelephone, department.name as ThDepName, isControl");
	$this->db->order_by("min_indicator_response.id", "asc");
	$this->db->from('min_indicator_response');
	$this->db->join('user_indicator','user_indicator.id=min_indicator_response.userID');	
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
	$this->db->select("division_goal.responseID, user_indicator.name as resName, department.name as depname, division.name as divname");
	//$this->db->order_by("id", "asc");
	$this->db->from('division_goal');
    $this->db->join('user_indicator', 'user_indicator.id = division_goal.responseID', 'left');
	$this->db->join('department','department.id=user_indicator.department', 'left');	
	$this->db->join('division','division.id=user_indicator.division');	
	$this->db->where('user_indicator.division', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorGoalDep($id=NULL)
 {
	$this->db->select("dep_goal.number as gnumber,dep_goal.name as gname,dep_plan.number as pnumber,dep_plan.name as pname, dep_target.number as tnumber, dep_target.name as tname, dep_goal.id as goalid")
	         ->order_by("dep_goal.number", "asc")
             ->order_by("dep_plan.number", "asc")
             ->order_by("dep_target.number", "asc")
	         ->from('dep_goal')
             ->join('dep_plan','dep_plan.dep_goal_id=dep_goal.id','left')
             ->join('dep_target','dep_target.dep_plan_id=dep_plan.id','left')
	         ->where('dep_goal.indicatorID', $id);
			 //->where('dep_goal.isGoalMin',0);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorGoalDepIsGoalMin($id=NULL)
 {
	$this->db->select("dep_goal.number as gnumber,dep_goal.name as gname,min_plan.number as pnumber,min_plan.name as pname, min_target.number as tnumber, min_target.name as tname, dep_goal.id as goalid")
	         ->order_by("dep_goal.number", "asc")
             ->order_by("min_plan.number", "asc")
             ->order_by("min_target.number", "asc")
	         ->from('dep_goal')
			 ->join('min_goal','dep_goal.isGoalMin=min_goal.id','left')
             ->join('min_plan','min_plan.min_goal_id=dep_goal.isGoalMin','left')
             ->join('min_target','min_target.min_plan_id=min_plan.id','left')
	         ->where('dep_goal.indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getOneIndicatorGoalDepFromMinIndicator($id=NULL)
 {
	$this->db->select("min_goal.number as gnumber,min_goal.name as gname,min_plan.number as pnumber,min_plan.name as pname, min_target.number as tnumber, min_target.name as tname")
	         ->order_by("min_goal.number", "asc")
             ->order_by("min_plan.number", "asc")
             ->order_by("min_target.number", "asc")
	         ->from('min_goal')
             ->join('min_plan','min_plan.min_goal_id=min_goal.id','left')
             ->join('min_target','min_target.min_plan_id=min_plan.id','left')
	         ->where('min_goal.indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }

 function getGoalDivFromDep($id=null)
 {
     $this->db->select("division_goal.number as gnumber,division_goal.name as gname,dep_plan.number as pnumber,dep_plan.name as pname, dep_target.number as tnumber, dep_target.name as tname, pwfname, pwlname")
	         ->order_by("division_goal.number", "asc")
             ->order_by("dep_plan.number", "asc")
             ->order_by("dep_target.number", "asc")
	         ->from('division_goal')
             ->join('user_indicator', 'user_indicator.id=division_goal.responseID', 'left')
             ->join('dep_goal', 'dep_goal.id = division_goal.isGoalDep','left')
             ->join('dep_plan','dep_plan.dep_goal_id=dep_goal.id','left')
             ->join('dep_target','dep_target.dep_plan_id=dep_plan.id','left')
	         ->where('dep_goal.indicatorID', $id);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getOneIndicatorGoalDivision($id=NULL)
 {
	$this->db->select("division_goal.number as gnumber,division_goal.name as gname,division_plan.number as pnumber,division_plan.name as pname, division_target.number as tnumber, division_target.name as tname, user_indicator.name as fullname")
	         ->order_by("division_goal.number", "asc")
             ->order_by("division_plan.number", "asc")
             ->order_by("division_target.number", "asc")
	         ->from('division_goal')
             ->join('user_indicator', 'user_indicator.id=division_goal.responseID', 'left')
             ->join('division_plan','division_plan.division_goal_id=division_goal.id','left')
             ->join('division_target','division_target.division_plan_id=division_plan.id','left')
             ->where('isGoalDep',0)
	         ->where('division_goal.indicatorID', $id);
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
	$this->db->insert('min_indicator_response', $in);
	return $this->db->insert_id();			
 }

 function addIndicatorGoal($in=NULL)
 {		
	$this->db->insert('min_goal', $in);
	return $this->db->insert_id();			
 }
    
 function addPlan($in=NULL,$table)
 {		
	$this->db->insert($table.'_plan', $in);
	return $this->db->insert_id();			
 }
    
 function addTarget($in=NULL,$table)
 {		
	$this->db->insert($table.'_target', $in);
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
	$this->db->delete('min_indicator_response'); 
 }

 function delGoalbyIndicator($id=NULL)
 {
	$this->db->where('indicatorID', $id);
	$this->db->delete('min_goal'); 
 }
    
 function delGoalTemp($id=NULL, $table=null)
 {
	$this->db->where('id', $id);
	$this->db->delete($table."_goal"); 
     
    $planid_array = $this->db->select("id")->from($table."_plan")->where($table."_goal_id",$id)->get()->result_array();
    for($i=0; $i<count($planid_array); $i++) {
        $this->db->where($table.'_plan_id', $planid_array[$i]['id']);
        $this->db->delete($table."_target"); 
    }
     
    $this->db->where($table.'_goal_id', $id);
	$this->db->delete($table."_plan"); 
     
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
    
 function delDepIndicatorTemp($id=NULL)
 {
    // delete dep_indicator depid=0 temp
    $this->db->where('id', $id);
	$this->db->delete('dep_indicator');
    
    // delete dep_goal temp
    $goalid_array = $this->db->select("id")->from("dep_goal")->where("indicatorID",$id)->get()->result_array();
    $this->db->where('indicatorID', $id);
	$this->db->delete('dep_goal');
    
    // delete dep_plan + dep_target temp
    for ($n=0; $n<count($goalid_array); $n++) {
        $planid_array = $this->db->select("id")->from("dep_plan")->where("dep_goal_id",$goalid_array[$n]['id'])->get()->result_array();
        for($i=0; $i<count($planid_array); $i++) {
            $this->db->where('dep_plan_id', $planid_array[$i]['id']);
            $this->db->delete("dep_target"); 
        }
        $this->db->where('dep_goal_id', $goalid_array[$n]['id']);
	    $this->db->delete("dep_plan"); 
    }
     
    
     
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
    
 function editNumberGoal($in=NULL,$table=null)
 {
	$this->db->where('id', $in['id']);
	unset($in['id']);
	$query = $this->db->update($table, $in); 	
	return $query;
 }

}
?>