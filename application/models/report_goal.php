<?php
Class Report_goal extends CI_Model
{

 function getDivGoalResponse($userid,$year)
 {
    $result = $this->db->select("division_goal.number as gnumber, division_goal.name as gname, division.name as divname, division_goal.id as goalid")
                       ->from("division_goal")
                       ->join("division_indicator","division_indicator.id = division_goal.indicatorID","left")
                       ->join("division","division.id = division_indicator.divisionID","left")
                       ->where("responseID", $userid)
                       ->where("division_indicator.year",$year)
                       ->get()->result();
     return $result;
 }
    
 function getIndicatorDivDetail($id=NULL)   
 {
	$this->db->select("division_indicator.number as inumber, division_indicator.name as iname, division_goal.number as gnumber,division_goal.name as gname, division_goal.isGoalDep, division_goal.id as goalid")
	         ->from('division_indicator')
             ->join('division_goal','division_indicator.id=division_goal.indicatorID', 'left')
	         ->where('division_goal.id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getOneGoalDiv($id=NULL)
 {
	$this->db->select("division_goal.number as gnumber,division_goal.name as gname,division_plan.number as pnumber,division_plan.name as pname, division_target.number as tnumber, division_target.name as tname, division_target.id as targetid")
	         ->order_by("division_goal.number", "asc")
             ->order_by("division_plan.number", "asc")
             ->order_by("division_target.number", "asc")
	         ->from('division_goal')
             ->join('division_plan','division_plan.division_goal_id=division_goal.id','left')
             ->join('division_target','division_target.division_plan_id=division_plan.id','left')
	         ->where('division_goal.id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getRowSpan($id=NULL)
 {
     $this->db->select("division_plan.number as pnumber, count(division_target.number) as planrow")
	         ->from('division_goal')
             ->join('division_plan','division_plan.division_goal_id=division_goal.id','left')
             ->join('division_target','division_target.division_plan_id=division_plan.id','left')
	         ->where('division_goal.id', $id)
             ->group_by('division_plan.number');
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getOneGoalDivFromDep($id=null)
 {
     $this->db->select("division_goal.number as gnumber,division_goal.name as gname,dep_plan.number as pnumber,dep_plan.name as pname, dep_target.number as tnumber, dep_target.name as tname, dep_target.id as targetid")
	         ->order_by("division_goal.number", "asc")
             ->order_by("dep_plan.number", "asc")
             ->order_by("dep_target.number", "asc")
	         ->from('division_goal')
             ->join('dep_goal', 'dep_goal.id = division_goal.isGoalDep','left')
             ->join('dep_plan','dep_plan.dep_goal_id=dep_goal.id','left')
             ->join('dep_target','dep_target.dep_plan_id=dep_plan.id','left')
	         ->where('division_goal.id', $id);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getRowSpanFromDep($id=NULL)
 {
     $this->db->select("dep_plan.number as pnumber, count(dep_target.number) as planrow")
	         ->from('division_goal')
             ->join('dep_goal', 'dep_goal.id = division_goal.isGoalDep','left')
             ->join('dep_plan','dep_plan.dep_goal_id=dep_goal.id','left')
             ->join('dep_target','dep_target.dep_plan_id=dep_plan.id','left')
	         ->where('division_goal.id', $id)
             ->group_by('dep_plan.number');
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getName($table,$id) {
     $result = $this->db->select("name")->from($table)->where("id",$id)->get()->result_array();
     return $result;
 }
    
 function addDivTargetReport($report=null)
 {
     $this->db->insert('div_target_report', $report);
     return $this->db->insert_id();	
 }
    
 function addDivGoalReport($report=null)
 {
     $this->db->insert('div_goal_report', $report);
     return $this->db->insert_id();	
 }
    
}
?>