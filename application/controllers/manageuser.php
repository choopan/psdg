<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageuser extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->model('user_manage','',TRUE);
	}
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			//$data['username'] = $session_data['username'];
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			//$data['status'] = $session_data['status'];
			if ($session_data['status'] == 1) {
				$query = $this->user->getUsers();
				if($query){
					$data['user_array'] =  $query;
				}

				$data['title'] = "MFA - User Management";
				$this->load->view('manageuser_view',$data);
			}else{
				//redirect('login', 'refresh');
			}
		}
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	}
	//--------------------------------------------------------- User --------------------------------------------------
	function user_view()
	{
		$data['data']=$this->user_manage->get_user();
		$data['title'] = "MFA - User Management";
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position();
		$data['numuser'] = $this->user_manage->get_num_user();				
		$limit = 15;
		$data['limit'] = $limit;
		
		
		if(empty($this->input->get('pagenum'))) { 
			$data['data2']=$this->user_manage->get_user_limit(0, $limit);
			$data['currentPage'] = 1;
		} else {
			$data['data2']=$this->user_manage->get_user_limit(($this->input->get('pagenum') - 1) * $limit, $limit);
			$data['currentPage'] = $this->input->get('pagenum'); 			
		}
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */

		$this->load->view('manageUser_view',$data);
	}
	
	function adduser()
	{
		$data['data']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position();
		$data['title'] = "MFA - User Management";
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('indicator/addUser',$data);
	}
	
	function addUser_save()
	{
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$retry_password=$this->input->post('retry_password');
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$efname=$this->input->post('efname');
		$elname=$this->input->post('elname');
		$gender=$this->input->post('gender');
		$email=$this->input->post('email');
		$tel=$this->input->post('tel');
		$mobile=$this->input->post('mobile');
		$department=$this->input->post('department');
		$division=$this->input->post('division');
		$position1=$this->input->post('position1');
		$level=$this->input->post('level');
		$admin_min_0=$this->input->post('admin');
		$execode=$this->input->post('execode');
		
		if($admin_min_0=="admin_min"){
			$admin_min=1;
		}else{
			$admin_min=0;
		}
		
		if($admin_min_0=="admin_dep"){
			$admin_dep=1;
		}else{
			$admin_dep=0;
		}
		
		if($admin_min_0=="admin_div"){
			$admin_div=1;
		}else{
			$admin_div=0;
		}
		
		if($password==$retry_password)
		{
			$this->user_manage->addUser_save($username,md5($password),$fname,$lname,$efname,$elname,$gender,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div,$execode);
			redirect('manageuser/user_view');
		}else{
			echo "Can't insert data";
		}
	}
	
	function user_view_info($id)
	{
		$data['title'] = "MFA - User Management";
		$data['data']=$this->user_manage->user_view_info($id);
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('indicator/showUser',$data);
	}
	
	function user_edit_info($id)
	{
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position();
		$data['title'] = "MFA - User Management";
		$data['data']=$this->user_manage->user_view_info($id);
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('indicator/editUser',$data);
	}
	
	function editUser_save()
	{
		$id=$this->input->post('id');
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$efname=$this->input->post('efname');
		$elname=$this->input->post('elname');
		$email=$this->input->post('email');
		$tel=$this->input->post('tel');
		$mobile=$this->input->post('mobile');
		$department=$this->input->post('department');
		$division=$this->input->post('division');
		$position1=$this->input->post('position1');
		$level=$this->input->post('level');
		$admin_min_0=$this->input->post('admin');
		$execode=$this->input->post('execode');
		
		if($admin_min_0=="admin_min"){
			$admin_min=1;
		}else{
			$admin_min=0;
		}
		
		if($admin_min_0=="admin_dep"){
			$admin_dep=1;
		}else{
			$admin_dep=0;
		}
		
		if($admin_min_0=="admin_div"){
			$admin_div=1;
		}else{
			$admin_div=0;
		}
		
		$this->user_manage->editUser_save($id,$fname,$lname,$efname,$elname,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div,$execode);
		redirect('manageuser/user_view');

	}
	
	function user_del_info($user_id)
	{
		echo $user_id;
		$this->user_manage->user_del_info($user_id);
		redirect('manageuser/user_view');
	}
	
	function get_search()
	{
		$username = $this->input->get('username');
		$fname = $this->input->get('fname');
		$lname = $this->input->get('lname');
		$department = $this->input->get('department');
		$division = $this->input->get('division');
		$position = $this->input->get('position');
		$admin_mdd = $this->input->get('admin_mdd');
		$execode = $this->input->get('execode');
		
		if($admin_mdd!=-1){
			if($admin_mdd=="admin_min"){
				$admin_min = 1;
				$admin_dep = null;
				$admin_div = null;
			}else if($admin_mdd=="admin_dep"){
				$admin_min = null;
				$admin_dep = 1;
				$admin_div = null;
			}else if($admin_mdd=="admin_div"){
				$admin_min = null;
				$admin_dep = null;
				$admin_div = 1;
			}
		}else{
				$admin_min = null;
				$admin_dep = null;
				$admin_div = null;
		}
		
		if($username!=null){$username="WHERE PWUSERNAME='".$username."'";}
		if($fname!=null){$fname="AND PWFNAME='".$fname."'";}
		if($lname!=null){$lname="AND PWLNAME='".$lname."'";}
		if($department==-1){$department=" ";}else{$department="AND department=".$department;}
		if($division==-1){$division=" ";}else{$division="AND division=".$division;}
		if($position==-1){$position=" ";}else{$position="AND PWPOSITION=".$position;}
		if($admin_min!=null){$admin_min="AND admin_min=".$admin_min;}
		if($admin_dep!=null){$admin_dep="AND admin_dep=".$admin_dep;}
		if($admin_div!=null){$admin_div="AND admin_div=".$admin_div;}
		if($execode==-1){$execode=" ";}else{$execode="AND execode=".$execode.")";}
		
		$sql="SELECT USERID, PWFNAME, PWLNAME, PWEFNAME, PWELNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL   
			  FROM pwemployee  INNER JOIN division INNER JOIN department INNER JOIN pwposition
			  ON pwemployee.department = department.id
			  AND pwemployee.division = division.id
			  AND pwemployee.PWPOSITION = pwposition.PWPOSITION 
			  ".$username.' '.$fname.' '.$lname.' '.$department.' '.$division.' '.$position.' '.$admin_min.' '.$admin_dep.' '.$admin_div.' '.$execode;
		$dta['sql']=$sql;
		$data2['data2']=$this->user_manage->get_search($sql);
		/* echo "<pre>";
		print_r($data2);
		print_r($dta);
		echo "</pre>"; */
		//echo json_encode($data);
		$this->load->view('indicator/showUser_search',$data2);
	}
	
	
	//---------------------------------------------------------------------- Department -----------------------------------------
	
	function department_view()
	{
		$data['data']=$this->user_manage->get_department();
		$data['title'] = "MFA - Department Management";
		$this->load->view('manageDepartment_view',$data);
	}
	
	function addDepartment()
	{
		$data['title'] = "MFA - Department Management";
		$this->load->view('indicator/addDepartment',$data);
	}
	
	function addDepartmaent_save()
	{
		$department_name=$this->input->post('department');
		$this->user_manage->addDepartmaent_save($department_name);
		redirect('manageuser/department_view');
	}
	
	function dep_edit_info($id)
	{
		$data['data']=$this->user_manage->dep_edit_info($id);
		$data['title'] = "MFA - Department Management";
		$this->load->view('indicator/editDepartment',$data);
	}
	
	function updateDepartmaent_save()
	{
		$id=$this->input->post('id');
		$department=$this->input->post('department');
		$this->user_manage->updateDepartmaent_save($id,$department);
		redirect('manageuser/department_view');
	}
	
	function dep_del_info($id)
	{
		$this->user_manage->deleteDepartment($id);
		redirect('manageuser/department_view');
	}
	
	//---------------------------------------------------------------------- Division -------------------------------------------
	function division_view()
	{
		$data['data']=$this->user_manage->get_division_show();
		$data['title'] = "MFA - Division Management";
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manageDivision_view',$data);
	}
	
	function addDivision()
	{
		$data['title'] = "MFA - Department Management";
		$data['data']=$this->user_manage->get_department();
		$this->load->view('indicator/addDivision',$data);
	}
	
	function addDivision_save()
	{	
		echo $department_id=$this->input->post('department');
		echo $division_name=$this->input->post('division');
		$this->user_manage->addDivision_save($department_id,$division_name);
		redirect('manageuser/division_view');
	}
	
	function get_division($dep_id)
	{
		$data=$this->user_manage->get_division($dep_id);
		echo json_encode($data);
	}
	
	function div_edit_info($id)
	{
		$data['title'] = "MFA - Department Management";
		$data['div']=$this->user_manage->div_edit_info($id);
		$dep_id=$data['div'][0]['dep_id'];
		$data['dep']=$this->user_manage->dep_edit_info($dep_id);
		$data['data']=$this->user_manage->get_department();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('indicator/editDivision',$data);
	}
	
	function updateDivision_save()
	{
		$id=$this->input->post('id');
		$dep_id=$this->input->post('department');
		$division=$this->input->post('division');
		$this->user_manage->updateDivision_save($id,$dep_id,$division);
		redirect('manageuser/division_view');
	}
	
	function div_del_info($id)
	{
		$this->user_manage->deleteDivision($id);
		redirect('manageuser/division_view');
	}
	

}