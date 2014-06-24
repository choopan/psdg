<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageprofile extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->model('position','',TRUE);
	   $this->load->library('form_validation');
	   if (empty($this->session->userdata('sessusername'))) redirect('login', 'refresh');
	}
	function index()
	{

	}
	
	function showprofile()
	{
		$query = $this->user->getProfile($this->session->userdata('sessid'));
		if($query){
			$data['profile_array'] =  $query;
		}else{
			$data['profile_array'] = array();
		}
		
		$data['title'] = "MFA - Profile";
		$this->load->view('profile_view',$data);
	}
	
	function editprofile()
	{
		$this->load->helper(array('form'));
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}
		
		$query = $this->user->getProfile($this->session->userdata('sessid'));
		if($query){
			$data['profile_array'] =  $query;
		}else{
			$data['profile_array'] = array();
		}
		
		$data['title'] = "MFA - Profile";
		$this->load->view('editprofile_view',$data);
	}
	
	function update()
	{
		
		$this->form_validation->set_rules('email', 'email', 'trim|xss_clean|required|valid_email');
		$this->form_validation->set_rules('telephone', 'telephone', 'trim|xss_clean|required');
		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('valid_email', 'กรุณาใส่ Email ให้ถูกต้อง');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		$id = $this->session->userdata('sessid');
		
		if($this->form_validation->run() == TRUE) {
			$position= ($this->input->post('position'));
			$email= ($this->input->post('email'));
			$telephone= ($this->input->post('telephone'));

			$user = array(
				'id' => $id,
				'PWPOSITION' => $position,
				'PWEMAIL' => $email,
				'PWTELOFFICE' => $telephone
			);

			$result = $this->user->editUser($user);
			if ($result)
				$this->session->set_flashdata('showresult', 'success');
			else
				$this->session->set_flashdata('showresult', 'fail');
			redirect(current_url());
		}
			$query = $this->position->getPosition();
			if($query){
				$data['position_array'] =  $query;
			}else{
				$data['position_array'] = array();
			}
			
			$query = $this->user->getProfile($this->session->userdata('sessid'));
			if($query){
				$data['profile_array'] =  $query;
			}else{
				$data['profile_array'] = array();
			}
			$data['title'] = "MFA - Profile";
			$this->load->view('editprofile_view',$data);
	}

	

}