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
    
	function user_indicator_view()
	{
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=0;
		$data['data'] = $this->user->user_indicator_view();
		
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';  */
		$this->load->view('indicator/viewUser_view',$data);
	}
	
	function user_indicator_view2()
	{
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=0;
		$data['data'] = $this->user->user_indicator_view2();
		
		/* echo '<pre>';
		print_r($data);
		echo '</pre>'; */
		$this->load->view('indicator/viewUser_view2',$data);
	}
	
	function addUser_indicator()
	{
		$data['title']="MFA - Minister Admin Management";
		$data['result']=0;
		
		/* echo '<pre>';
		print_r($data);
		echo '</pre>'; */
		$this->load->view('indicator/addUser_indicator',$data);
	}
	
	function addUser_indicator2()
	{
		$data['title']="MFA - Minister Admin Management";
		$data['result']=0;
		
		/* echo '<pre>';
		print_r($data);
		echo '</pre>'; */
		$this->load->view('indicator/addUser_indicator2',$data);
	}
	
	function autocompleteResponse()
	{
		$term = $this->input->get('term', TRUE);
		$pwemployee = $this->user->autocompleteResponse($term);
		echo  json_encode($pwemployee);
	}
	
	function indicatorUser_save()
	{
		$user_id = $this->input->post('userid');
		$username =  $this->input->post('username');
		$password =  $this->input->post('password');
		$department = $this->input->post('dep_id');
		$division = $this->input->post('div_id');
		$admin = $this->input->post('admin');
		
		$admin_dep = 0;
		$approve_dep = 0;
		$approve_div = 0;
		$set_div = 0;
		
		if($admin=='admin_dep'){
			$admin_dep = 1;
			$approve_dep = 0;
			$approve_div = 0;
			$set_div = 0;
		}else if($admin=='approve_dep'){
			$admin_dep = 0;
			$approve_dep = 1;
			$approve_div = 0;
			$set_div = 0;
		}else if($admin=='approve_div'){
			$admin_dep = 0;
			$approve_dep = 0;
			$approve_div = 1;
			$set_div = 0;
		}else if($admin=='set_div'){
			$admin_dep = 0;
			$approve_dep = 0;
			$approve_div = 0;
			$set_div = 1;
		}
		
		$result=$this->user->indicatorUser_save($user_id,$username,$password,$department,$division,$admin_dep,$approve_dep,$approve_div,$set_div);
		
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=$result;
		$this->load->view('indicator/addUser_indicator',$data);
	}
	
	function indicatorUser_save2()
	{
		$user_id = $this->input->post('userid');
		$username =  $this->input->post('username');
		$password =  $this->input->post('password');
		$department = $this->input->post('dep_id');
		$division = $this->input->post('div_id');
		$admin = $this->input->post('admin');

		$result=$this->user->indicatorUser_save2($user_id,$username,$password,$department,$division,0,0,0,0,1);
		
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=$result;
		$this->load->view('indicator/addUser_indicator2',$data);
	}
	
	function deleteAll_user()
	{
		$result=$this->user->deleteAll_user();
		$data['data'] = $this->user->user_indicator_view();
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=$result+1;
		
		$this->load->view('indicator/viewUser_view',$data);
	}
	
	function user_del_info($id,$page)
	{
		$result=$this->user->user_del_info($id);
		$data['title'] = "MFA - Minister Admin Management";
		$data['result']=$result+1;
		
		if($page==1){
			$data['data'] = $this->user->user_indicator_view();
			$this->load->view('indicator/viewUser_view',$data);
		}else if($page==2){
			$data['data'] = $this->user->user_indicator_view2();
			$this->load->view('indicator/viewUser_view2',$data);
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