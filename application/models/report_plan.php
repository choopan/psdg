<?php
Class Report_plan extends CI_Model
{
    function getIndicatorDivision($div=null)
    {
        $this->db->select("number, name, id, divisionID, isDep, weight,goal, criteria1, criteria2, criteria3, criteria4, criteria5");
        $this->db->order_by("number", "asc");
        $this->db->from('division_indicator');	
        $this->db->where('divisionID', $div);	
        $query = $this->db->get();		
        return $query->result();
    }
}
?>