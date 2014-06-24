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
	$this->db->select("depid, thdepname");
	$this->db->order_by("thdepname", "asc");
	$this->db->from('pwdepartment');
	$this->db->like("thdepname","กรม","after");
	$query = $this->db->get();		
	return $query->result();
 }

 function getKong()
 {
	$this->db->select("depid, thdepname");
	$this->db->order_by("thdepname", "asc");
	$this->db->from('pwdepartment');
	$this->db->like("thdepname","กอง","after");
	$query = $this->db->get();		
	return $query->result();
 }
}
?>

