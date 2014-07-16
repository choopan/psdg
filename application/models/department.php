<?php
Class Department extends CI_Model
{

 
 function getName()
 {
	$this->db->select("pwsection, pwname");
	$this->db->order_by("pwname", "asc");
	$this->db->from('pwsection');
	$query = $this->db->get();		
	return $query->result();
 }

 function getDepName()
 {
	$this->db->select("depid, thdepname");
	$this->db->order_by("thdepname", "asc");
	$this->db->from('pwdepartment');
	$this->db->where("thdepname != ''");
	$query = $this->db->get();		
	return $query->result();
 }

 function getGom()
 {
	$this->db->select("id, name");
	$this->db->order_by("name", "asc");
	$this->db->from('department');
    $this->db->where('enabled',1);
	$query = $this->db->get();		
	return $query->result();
 }

 function getKong()
 {
	$this->db->select("id, name, dep_id");
	$this->db->order_by("name", "asc");
	$this->db->from('division');
	$this->db->where('enabled',1);
	$query = $this->db->get();		
	return $query->result();
 }
}
?>

