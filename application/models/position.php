<?php
Class Position extends CI_Model
{
 function getPosition()
 {
	$this->db->_protect_identifiers=false;
	$this->db->select("pwposition, pwname, concat(pwname,' ',pwename) as poname");
	$this->db->order_by("pwposition", "desc");
	$this->db->from('pwposition');
	$query = $this->db->get();		
	return $query->result();
 }

}
?>