<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class Main extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->model('user_manage','',TRUE);
	   $this->load->model('personindicator', '', TRUE);
	   $this->load->helper('url');
	}
	function index()
	{
		if($this->session->userdata('sessusername'))
		{
			$data['title'] = "MFA - Main";
			switch($this->session->userdata('sess_system')) {
				case 1: $this->load->view('main_view',$data); break;
				case 2: $this->load->view('mainperson_view',$data); break;
				case 3: $this->load->view('mainadmin_view',$data); break;
				default: redirect('login', 'refresh'); break;
			}			
		}
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	}
	

	
	 function logout()
	 {
	   $this->session->unset_userdata('sessid');
	   $this->session->unset_userdata('sessusername');
	   $this->session->unset_userdata('sessfirstname');
	   $this->session->unset_userdata('sesslastname');
	   $this->session->unset_userdata('sessyear');
	   
	   $this->session->unset_userdata('sessadmin_min');
	   $this->session->unset_userdata('sessadmin_dep');
	   $this->session->unset_userdata('sessadmin_div');
	   $this->session->unset_userdata('sessdep');
	   $this->session->unset_userdata('sessdiv');
	   $this->session->unset_userdata('sessexecdep');
	   $this->session->unset_userdata('sessexecdiv');
	    
	   session_destroy();
	   redirect('main', 'refresh');
	 }
	 
	function changepass()
	{
		$this->load->helper(array('form'));

		$data['id'] = $this->session->userdata('sessid');

		
		$data['title'] = "MFA - Change Password";
		
		$this->load->view('changepass_view',$data);
	}
	
	function changeyear()
	{
		$this->load->helper(array('form'));
		$this->load->model('year','',TRUE);
		
		$query = $this->year->getYear();
		if($query){
			$data['year_array'] =  $query;
		}else{
			$data['year_array'] = array();
		}
		$data['title'] = "MFA - Change Year";
		
		$this->load->view('changeyear_view',$data);
	}
	
	function updateyear()
	{
		
		//$data['newyear'] = $newyear;
		$newyear= ($this->input->post('year'));
		$this->session->set_userdata('sessyear',$newyear);
		$data['showresult']= 'success';
		$data['title'] = "MFA - Change Year";
		$this->load->view('changeyear_view',$data);
	}
	
	function updatepass()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('opassword', 'old password', 'trim|xss_clean|required|md5');
		$this->form_validation->set_rules('npassword', 'new password', 'trim|xss_clean|required|md5');
		$this->form_validation->set_rules('passconf', 'Password confirmation', 'trim|xss_clean|required|matches[npassword]');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('matches', 'กรุณาใส่รหัสให้ตรงกัน');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$newpass= ($this->input->post('npassword'));
			$oldpass= ($this->input->post('opassword'));
			$id= ($this->input->post('id'));

			if ($this->user->checkpass($id,$oldpass)) {
					
				$user = array(
					'id' => $id,
					'PWPASSWORD' => $newpass
				);

				$result = $this->user->editUser($user);
				if ($result)
					$this->session->set_flashdata('showresult', 'success');
				else
					$this->session->set_flashdata('showresult', 'fail');

			}else{
				$this->session->set_flashdata('showresult', 'failpass');
			}
			redirect(current_url());
		}
			$data['id'] = $this->session->userdata('sessid');
			$data['title'] = "MFA - Change Password";
			
			$this->load->view('changepass_view',$data);
	}
}