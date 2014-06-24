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
   $username = $this->input->post('username');

   //query the database
   $result = $this->user->login($username, $password);

   if($result AND  $username)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'sessid' => $row->USERID,
         'sessusername' => $row->PWUSERNAME,
		 'sessfirstname' => $row->PWEFNAME,
		 'sesslastname' => $row->PWELNAME,
         'sessyear' => date("Y")+543
       );
       $this->session->set_userdata($sess_array);
     }
     return TRUE;
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