<?php
Class Year extends CI_Model
{
 function getYear()
 {
	$this->db->select("id");
	$this->db->order_by("id", "desc");
	$this->db->from('year');
	$query = $this->db->get();		
	return $query->result();
 }

}
?>