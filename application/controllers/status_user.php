<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_user extends CI_Controller {

 public function __construct()
 {
   parent::__construct();
 }

 public function is_logged_in()
 {
	$user = $this->session->userdata('logged_in');
    return isset($user);
 }
 
 public function is_admin()
 {
    if ($this->is_logged_in())
	{
		$session_data = $this->session->userdata('logged_in');
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
		$session_data = $this->session->userdata('logged_in');
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
		$session_data = $this->session->userdata('logged_in');
		if ($session_data['status'] == 3) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
 }
 

}