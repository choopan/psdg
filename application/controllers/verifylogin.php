<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('url');
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|callback_required_username');
   $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|callback_required_password|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.&nbsp; User redirected to login page
	 
		$data['base'] = $this->config->item('base_url');
		$data['title'] = "MFA - Login";
		$data['system'] = $this->input->post('system');
		$data['system_name'] = $this->input->post('system_name');
		$this->load->view('login_view',$data);
   }
   else
   {
     //Go to private area
     redirect('main', 'refresh');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.&nbsp; Validate against database
   $system = $this->input->post('system');
   $username = $this->input->post('username');
   //query the database
   $result=array();
   $result = $this->user->login($username, $password);
   $result2=array();
   
   if($result){
		if($result[0]->admin_min != 1){
		$result2 = $this->user->login2($username, $password);
		}
	}else if(!$result){
		$result2 = $this->user->login2($username, $password);
	}
	//===================================   

	/* echo '<pre>';
	echo "==========> 1";
	print_r($result);
	echo "==========> 2";
	print_r($result2);
	echo '</pre>'; */
	
   if($result AND  $username)
   {	
		switch($system) {
   			case 1:		//minister indicator system
     			$sess_array = array();
				
				if($result[0]->admin_min == 1){
					foreach($result as $row) {
			
						//Check executive Priviledge	
						$userID = $row->USERID;
						$execDep = $this->user->getExecDep($userID);
						$execDiv = $this->user->getExecDiv($userID);
			
			
						$sess_array = array(
							'sessid' => $row->USERID,
							'sessusername' => $row->PWUSERNAME,
							'sessfirstname' => $row->PWEFNAME,
							'sesslastname' => $row->PWELNAME,
							'sessadmin_min' => $row->admin_min,
							'sessadmin_dep' => 0,
							'sessapprove_dep' => 0,
							'sessapprove_div' => 0,
							'sessset_div' => 0,
							'sessreport_div' => 0,
							'sessdep' => $row->department,
							'sessdiv' => $row->division,		 
							'sessexecdep' => $execDep,
							'sessexecdiv' => $execDiv,
							'sessyear' => date("Y")+543,
							'sess_system' => 1       				
						);
						$this->session->set_userdata($sess_array);
					}
				}
				else if($result[0]->admin_min != 1 AND !$result2){
						$this->form_validation->set_message('check_database', '<div class="alert alert-danger">ไม่มีสิทธิ์ใช้งานในหน้านี้</div>');
						return false;
				}
				else if($result2[0]->set_div == 1 && $result[0]->admin_min == 0){
					foreach($result2 as $row) {
			
						//Check executive Priviledge	
						$userID = $row->USERID;
						$execDep = $this->user->getExecDep($userID);
						$execDiv = $this->user->getExecDiv($userID);
			
			
						$sess_array = array(
							'sessid' => $row->USERID,
							'sessusername' => $row->PWUSERNAME,
							'sessfirstname' => $row->PWEFNAME,
							'sesslastname' => $row->PWELNAME,
							'sessadmin_min' => 0,
							'sessadmin_dep' => $row->admin_dep,
							'sessapprove_dep' => $row->approve_dep,
							'sessapprove_div' => $row->approve_div,
							'sessset_div' => $row->set_div,
							'sessreport_div' => $row->report_div,
							'sessdep' => $row->department,
							'sessdiv' => $row->division,		 
							'sessexecdep' => $execDep,
							'sessexecdiv' => $execDiv,
							'sessyear' => date("Y")+543,
							'sess_system' => 1       				
						);
						$this->session->set_userdata($sess_array);
					}
				}else if($result[0]->admin_min == 0 && $result2[0]->set_div == 0){
					foreach($result2 as $row) {
			
						//Check executive Priviledge	
						$userID = $row->USERID;
						$execDep = $this->user->getExecDep($userID);
						$execDiv = $this->user->getExecDiv($userID);
			
			
						$sess_array = array(
							'sessid' => $row->USERID,
							'sessusername' => $row->PWUSERNAME,
							'sessfirstname' => $row->PWEFNAME,
							'sesslastname' => $row->PWELNAME,
							'sessadmin_min' => 0,
							'sessadmin_dep' => $row->admin_dep,
							'sessapprove_dep' => $row->approve_dep,
							'sessapprove_div' => $row->approve_div,
							'sessset_div' => $row->set_div,
							'sessreport_div' => $row->report_div,
							'sessdep' => $row->department,
							'sessdiv' => $row->division,		 
							'sessexecdep' => $execDep,
							'sessexecdiv' => $execDiv,
							'sessyear' => date("Y")+543,
							'sess_system' => 1       				
						);
						$this->session->set_userdata($sess_array);
					}
				}else{
				     $this->form_validation->set_message('check_database', '<div class="alert alert-danger">คุณไม่มีสิทธิ์ผู้ดูแลระบบระดับกระทรวง</div>');
     				return false;					
				}
   				break;
			case 2:		//person evaluation system
				$sess_array = array();
     			//Check executive Priviledge
					$userID = $result[0]->USERID;
					$execDep = $this->user->getExecDep($userID);
					$execDiv = $this->user->getExecDiv($userID);
			
			
					$sess_array = array(
							'sessid' => $result[0]->USERID,
							'sessusername' => $result[0]->PWUSERNAME,
							'sessfirstname' => $result[0]->PWEFNAME,
							'sesslastname' => $result[0]->PWELNAME,
							'sessadmin_min' => $result[0]->admin_min,
							'sessdep' => $result[0]->department,
							'sessdiv' => $result[0]->division,		 
							'sessexecdep' => $execDep,
							'sessexecdiv' => $execDiv,
							'sess_system' => 2
							//'sessyear' => date("Y")+543       				
						);
						$this->session->set_userdata($sess_array);   			
						break;
					
			case 3:		//admin system
			$sess_array = array();
				if($result[0]->admin_min != 1) {
				     $this->form_validation->set_message('check_database', '<div class="alert alert-danger">คุณไม่มีสิทธิ์ผู้ดูแลระบบระดับกระทรวง</div>');
     				return false;					
				}
     			foreach($result as $row) {
     	
					//Check executive Priviledge	
					$userID = $row->USERID;
					$execDep = $this->user->getExecDep($userID);
					$execDiv = $this->user->getExecDiv($userID);
		
		
       				$sess_array = array(
         				'sessid' => $row->USERID,
         				'sessusername' => $row->PWUSERNAME,
		 				'sessfirstname' => $row->PWEFNAME,
		 				'sesslastname' => $row->PWELNAME,
		 				'sessadmin_min' => $row->admin_min,
		 				'sessdep' => $row->department,
		 				'sessdiv' => $row->division,		 
		 				'sessexecdep' => $execDep,
		 				'sessexecdiv' => $execDiv,
         				'sessyear' => date("Y")+543,
         				'sess_system' => 3       				
					);
       				$this->session->set_userdata($sess_array);
     			}
   					
					break;
			default : echo "ERROR!!"; die(); break;
			
   		}
     	return TRUE;
   }
   else if($result2 AND $username AND !$result AND $system==1)
   {
		$sess_array = array();
		foreach($result2 as $row) {
			
						//Check executive Priviledge	
						$userID = $row->USERID;
						$execDep = $this->user->getExecDep($userID);
						$execDiv = $this->user->getExecDiv($userID);
			
			
						$sess_array = array(
							'sessid' => $row->USERID,
							'sessusername' => $row->PWUSERNAME,
							'sessfirstname' => $row->PWEFNAME,
							'sesslastname' => $row->PWELNAME,
							'sessadmin_min' => 0,
							'sessadmin_dep' => $row->admin_dep,
							'sessapprove_dep' => $row->approve_dep,
							'sessapprove_div' => $row->approve_div,
							'sessset_div' => $row->set_div,
							'sessreport_div' => $row->report_div,
							'sessdep' => $row->department,
							'sessdiv' => $row->division,		 
							'sessexecdep' => $execDep,
							'sessexecdiv' => $execDiv,
							'sessyear' => date("Y")+543,
							'sess_system' => 1       				
						);
						$this->session->set_userdata($sess_array);
		}
		
		return TRUE;
   }
   else if(!$result AND !$result2)
   {
		$this->form_validation->set_message('check_database', '<div class="alert alert-danger">Username หรือ Password ไม่สามารถเข้าสู่ระบบได้</div>');
     				return false;
   }
   else if (!$username)
   {
			$this->form_validation->set_message('check_database', '');
            return FALSE;
   }
   else 
   {
     $this->form_validation->set_message('check_database', '<div class="alert alert-danger">Username หรือ Password ไม่สามารถเข้าสู่ระบบได้</div>');
     return false;
   }
   
   if(!$result){
	 $this->form_validation->set_message('check_database', '<div class="alert alert-danger">Username หรือ Password ไม่สามารถเข้าสู่ระบบได้</div>');
     				return false;
   }
 }
 
 function required_username()
    {
        if( ! $this->input->post('username'))
        {
            $this->form_validation->set_message('required_username', '<div class="alert alert-danger">กรุณาป้อน Username</div>');
            return FALSE;
        }
		
        return TRUE;
    }
 function required_password()
    {
        if ($this->input->post('username') AND ! $this->input->post('password'))
        {
            $this->form_validation->set_message('required_password', '<div class="alert alert-danger">กรุณาป้อน Password</div>');
            return FALSE;
        }
		
        return TRUE;
    }
}