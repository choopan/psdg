<?php
Class evaluation_models extends CI_Model
{
 function getIndicator()
 {
	$this->db->select("id");
	$this->db->order_by("divIndicatorID", "desc");
	$this->db->from('person_indicator');
	$this->db->where("  ");
	$query = $this->db->get();		
	return $query->result();
 }
}
?>