<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicator_admin extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->library('form_validation');
	   $this->load->helper('url');
	}
	
	function index()
	{
		if($this->session->userdata('sessusername'))
		{

			$data['title'] = "MFA - Indicator";
			$this->load->view('indicator/addindicator_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	}
    
    function minister_view()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_min");
        $data['admin_level'] = "<strong>แสดงรายชื่อผู้ดูแลตัวชี้วัด <u>ระดับกระทรวง</u></strong>";
        
        $data['title'] = "MFA - Minister Admin Management";
        $this->load->view('indicator/admin_view',$data);
    }
    
    function department_view()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_dep");
        $data['admin_level'] = "<strong>แสดงรายชื่อผู้ดูแลตัวชี้วัด <u>ระดับกรม</u></strong>";
        
        $data['title'] = "MFA - Department Admin Management";
        $this->load->view('indicator/admin_view',$data);
    }
    
    function division_view()
    {
        $data['admin_array'] = $this->user->getAllAdminMinister("admin_div");
        $data['admin_level'] = "<strong>แสดงรายชื่อผู้ดูแลตัวชี้วัด <u>ระดับกอง</u></strong>";
        
        $data['title'] = "MFA - Division Admin Management";
        $this->load->view('indicator/admin_view',$data);
    }
}