<?php
Class Report_goal extends CI_Model
{

 
 function getDepGoalResponse($userid)
 {
    $result = $this->db->select("dep_goal.id as goalid, dep_goal.number, dep_goal.name as goalname, department.name as depname")
                       ->from("dep_goal")
                       ->join("dep_indicator","dep_indicator.id = dep_goal.indicatorID","left")
                       ->join("department","department.id = dep_indicator.depID","left")
                       ->where("responseID", $userid)
                       ->get()->result();
     return $result;
 }

 function getDivGoalResponse($userid)
 {
    $result = $this->db->select("division_goal.number, division_goal.name as goalname, division.name as divname")
                       ->from("division_goal")
                       ->join("division_indicator","division_indicator.id = division_goal.indicatorID","left")
                       ->join("division","division.id = division_indicator.divisionID","left")
                       ->where("responseID", $userid)
                       ->get()->result();
     return $result;
 }
    
 function getOneDepGoal($id)
 {
    $result = $this->db->select("dep_goal.number,dep_goal.name, dep_indicator.number as innumber, dep_indicator.name as inname")
                       ->from("dep_goal")
                       ->join("dep_indicator","dep_indicator.id = dep_goal.indicatorID","left")
                       ->where("dep_goal.id", $id)
                       ->get()->result();
    return $result;
 }
    
}
?>