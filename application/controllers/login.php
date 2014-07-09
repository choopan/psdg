<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
 }

 	function index() {
		$data['title'] = "MFA";		
		$this->load->view('selectSystem', $data);
 	}

	function login_minister() {
		$data['title'] = "MFA - Login";
		$data['system_name'] = "ระบบประเมินผลปฏิบัติราชการระดับส่วนงาน";
		$data['system'] = 1; 
    	$this->load->helper(array('form'));
    	$this->load->view('login_view',$data);
	}
	function login_person() {
		$data['title'] = "MFA - Login";
		$data['system_name'] = "ระบบประเมินผลปฏิบัติราชการระดับบุคคล";
		$data['system'] = 2; 
    	$this->load->helper(array('form'));
    	$this->load->view('login_view',$data);
	}
	function login_admin() {
		$data['title'] = "MFA - Login";
		$data['system_name'] = "ระบบบริหารจัดการข้อมูลพื้นฐาน";
		$data['system'] = 3; 
		$this->load->helper(array('form'));
    	$this->load->view('login_view',$data);
	}
	
}