<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Status {

 public function __construct()
 {
	$this->_ci =& get_instance();
	$this->_ci->load->library('session');
 }

 public function is_logged_in()
 {
	$user = $this->_ci->session->userdata('logged_in');
    return isset($user);
 }
 
 public function is_admin()
 {
    if ($this->is_logged_in())
	{
		$session_data = $this->_ci->session->userdata('logged_in');
		if ($session_data['status'] == 1) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
 }
 
 public function is_stock()
 {
    if ($this->is_logged_in())
	{
		$session_data = $this->_ci->session->userdata('logged_in');
		if ($session_data['status'] == 2) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
 }
 
 public function is_owner()
 {
    if ($this->is_logged_in())
	{
		$session_data = $this->_ci->session->userdata('logged_in');
		if ($session_data['status'] == 3) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
 }
 

}

?>

