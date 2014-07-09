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
		$data['title'] = "MFA - User Management";
		$data['result'] = 0;
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position_type();
		$data['numuser'] = $this->user_manage->get_num_user();				
		$limit = 15;
		$data['limit'] = $limit;
		
		
		if($this->input->get('pagenum',true)==false) { 
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
		$data['data']=$this->user_manage->get_department_1();
		$data['position']=$this->user_manage->get_position_type();
		$data['title'] = "MFA - User Management";
		$data['result'] = 0;
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/addUser',$data);
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
		
		$position_ty=$this->input->post('position_ty');
		$position=$this->input->post('position');
		$position_lv=$this->input->post('position_lv');
		$level=$this->input->post('level');
		$admin_min_0=$this->input->post('admin');
		
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
			$result=$this->user_manage->addUser_save($username,md5($password),$fname,$lname,$efname,$elname,$gender,$email,$tel,$mobile,$department,$division,$level,$admin_min,$admin_dep,$admin_div,$position_ty,$position,$position_lv);
			
			$data['data']=$this->user_manage->get_department_1();
			$data['position']=$this->user_manage->get_position_type();
			$data['title'] = "MFA - User Management";
			$data['result'] = $result;
			
			$this->load->view('manage/addUser',$data);
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
		$this->load->view('manage/showUser',$data);
	}
	
	function user_edit_info($id)
	{
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position_type();
		$data['title'] = "MFA - User Management";
		$data['result'] = 0;
		$data['data']=$this->user_manage->user_view_info($id);
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/editUser',$data);
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
		
		$result=$this->user_manage->editUser_save($id,$fname,$lname,$efname,$elname,$email,$tel,$mobile,$department,$division,$position1,$level,$admin_min,$admin_dep,$admin_div,$execode);
		
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position_type();
		$data['title'] = "MFA - User Management";
		$data['result'] = $result;
		$data['data']=$this->user_manage->user_view_info($id);
		
		$this->load->view('manage/editUser',$data);

	}
	
	function user_del_info($user_id)
	{
		$result=$this->user_manage->user_del_info($user_id);
		
		$data['title'] = "MFA - User Management";
		$data['result'] = $result;
		$data['department']=$this->user_manage->get_department();
		$data['position']=$this->user_manage->get_position_type();
		$data['numuser'] = $this->user_manage->get_num_user();				
		$limit = 15;
		$data['limit'] = $limit;
		
		
		if($this->input->get('pagenum',true)==false) { 
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
	
	function get_search()
	{
		$username = $this->input->get('username');
		$fname = $this->input->get('fname');
		$lname = $this->input->get('lname');
		$department = $this->input->get('department');
		$division = $this->input->get('division');
		$position = $this->input->get('position');
		//$admin_mdd = $this->input->get('admin_mdd');
		
		/* if($admin_mdd!=-1){
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
		} */
		
		if($username!=null){$username="WHERE PWUSERNAME='".$username."'";}
		if($fname!=null){$fname="AND PWFNAME='".$fname."'";}
		if($lname!=null){$lname="AND PWLNAME='".$lname."'";}
		if($department==-1){$department=" ";}else{$department="AND department=".$department;}
		if($division==-1){$division=" ";}else{$division="AND division=".$division;}
		if($position==-1){$position=" ";}else{$position="AND PWPOSITION=".$position;}
		/* if($admin_min==1){$admin_min1="AND admin_min=".$admin_min;}
		if($admin_dep==1){$admin_dep1="AND admin_dep=".$admin_dep;}
		if($admin_div==1){$admin_div1="AND admin_div=".$admin_div;} */
		
		$sql="SELECT pwemployee.USERID AS USERID, PWFNAME, PWLNAME, PWEFNAME, PWELNAME, department.name AS dep_name, division.name AS div_name, PWPOSITION.PWNAME AS position_name, PWLEVEL, PWEMAIL   
			  FROM pwemployee  INNER JOIN division INNER JOIN department INNER JOIN pwposition
			  ON pwemployee.department = department.id
			  AND pwemployee.division = division.id
			  AND pwemployee.PWPOSITION = pwposition.PWPOSITION 
			  ".$username.' '.$fname.' '.$lname.' '.$department.' '.$division.' '.$position;
		$dta['sql']=$sql;
		$data2['data2']=$this->user_manage->get_search($sql);
		/* echo "<pre>";
		print_r($data2);
		print_r($dta);
		echo "</pre>"; */
		//echo json_encode($data);
		$this->load->view('manage/showUser_search',$data2);
	}
	
	
	//---------------------------------------------------------------------- Department -----------------------------------------
	
	function department_view()
	{
		$data['data']=$this->user_manage->get_department();
		$data['title'] = "MFA - Department Management";
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */ 
		$this->load->view('manageDepartment_view',$data);
	}
	
	function dep_show_user($id)
	{
		$data['data']=$this->user_manage->get_department_user($id);
		$data['user'] = $this->user_manage->get_user_1();
		$data['title'] = "MFA - Department Management";
		$data['result']=0;
		$data['result2']=0;
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		
		$this->load->view('manage/showDepartment_user',$data);
	}
	
	function addDepartment()
	{
		$data['title'] = "MFA - Department Management";
		$data['user'] = $this->user_manage->get_user_1();
		$data['result']=0;
		$this->load->view('manage/addDepartment',$data);
	}
	
	function addDepartmaent_save()
	{
		$department_name=$this->input->post('department');
		$result=$this->user_manage->addDepartmaent_save($department_name);
		
		$data['title'] = "MFA - Department Management";
		$data['user'] = $this->user_manage->get_user_1();
		$data['result']=$result;
		
		$this->load->view('manage/addDepartment',$data);
	}
	
	function addDepartmaent_user()
	{
		$id=$this->input->get('id');
		$user_name=$this->input->get('user');
		$status=$this->input->get('status');
		$result=$this->user_manage->addDepartmaent_user($id,$user_name,$status);
		
		$data['data']=$this->user_manage->get_department_user($id);
		$data['user'] = $this->user_manage->get_user_1();
		$data['title'] = "MFA - Department Management";
		$data['result']=$result;
		$data['result2']=0;
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		
		$this->load->view('manage/showDepartment_user',$data);
	}
	
	function dep_edit_name($id)
	{
		$data['data']=$this->user_manage->dep_edit_name($id);
		$data['user'] = $this->user_manage->get_user_1();
		$data['title'] = "MFA - Department Management";
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/editDepartment',$data);
	}
	
	function updateDepartmaent_save()
	{
		$id=$this->input->post('id');
		$department=$this->input->post('department');
		$result=$this->user_manage->updateDepartmaent_save($id,$department);
		
		$data['data']=$this->user_manage->dep_edit_name($id);
		$data['user'] = $this->user_manage->get_user_1();
		$data['title'] = "MFA - Department Management";
		$data['result']=$result;
		
		$this->load->view('manage/editDepartment',$data);
	}
	
	function dep_del_info($id)
	{
		$result=$this->user_manage->deleteDepartment($id);
		
		$data['data']=$this->user_manage->get_department();
		$data['title'] = "MFA - Department Management";
		$data['result']=$result;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manageDepartment_view',$data);
	}
	
	function dep_del_user($id,$id2)
	{
		$result=$this->user_manage->dep_del_user($id);
		
		$data['data']=$this->user_manage->get_department_user($id2);
		$data['user'] = $this->user_manage->get_user_1();
		$data['title'] = "MFA - Department Management";
		$data['result2']=$result;
		$data['result']=0;
		
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		
		$this->load->view('manage/showDepartment_user',$data);
	}
	
	//---------------------------------------------------------------------- Division -------------------------------------------
	function division_view()
	{
		$data['data']=$this->user_manage->get_division_show();
		$data['title'] = "MFA - Division Management";
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manageDivision_view',$data);
	}
	
	function addDivision()
	{
		$data['title'] = "MFA - Department Management";
		$data['user'] = $this->user_manage->get_user_1();
		$data['data']=$this->user_manage->get_department();
		$data['result'] = 0;
		$this->load->view('manage/addDivision',$data);
	}
	
	function addDivision_save()
	{	
		$department_id=$this->input->post('department');
		$division_name=$this->input->post('division');
		$userid=$this->input->post('userid');
		$result=$this->user_manage->addDivision_save($department_id,$division_name,$userid);
		
		$data['title'] = "MFA - Department Management";
		$data['user'] = $this->user_manage->get_user_1();
		$data['data']=$this->user_manage->get_department();
		$data['result'] = $result;
		
		$this->load->view('manage/addDivision',$data);
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
		$data['user'] = $this->user_manage->get_user_1();
		$dep_id=$data['div'][0]['dep_id'];
		$data['dep']=$this->user_manage->dep_edit_info($dep_id);
		$data['data']=$this->user_manage->get_department();
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/editDivision',$data);
	}
	
	function updateDivision_save()
	{
		$id=$this->input->post('id');
		$dep_id=$this->input->post('department');
		$division=$this->input->post('division');
		$userid=$this->input->post('userid');
		if($userid==-1){
		$userid=null;
		}
		$result=$this->user_manage->updateDivision_save($id,$dep_id,$division,$userid);
		
		$data['title'] = "MFA - Department Management";
		$data['div']=$this->user_manage->div_edit_info($id);
		$data['user'] = $this->user_manage->get_user_1();
		$dep_id=$data['div'][0]['dep_id'];
		$data['dep']=$this->user_manage->dep_edit_info($dep_id);
		$data['data']=$this->user_manage->get_department();
		$data['result']=$result;
		
		$this->load->view('manage/editDivision',$data);
	}
	
	function div_del_info($id)
	{
		$result=$this->user_manage->deleteDivision($id);
		
		$data['data']=$this->user_manage->get_division_show();
		$data['title'] = "MFA - Division Management";
		$data['result']=$result;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manageDivision_view',$data);
	}
	
//===================== Position ===================
	function position_view()
	{
		$data['title'] = "MFA - Position Management";
		$data['result'] = 0;
		$data['data']=$this->user_manage->position_view();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('managePosition_view',$data);
	}
	
	function get_data()
	{
		$id=$this->input->get('id');
		if($id==1){
			$data['data']=$this->user_manage->get_position_type();
			$this->load->view('manage/showPosition_type',$data);
		}else if($id==2){
			$data['data']=$this->user_manage->get_postition();
			$this->load->view('manage/showPosition',$data);
		}else if($id==3){
			$data['data']=$this->user_manage->get_position_level();
			$this->load->view('manage/showPosition_level',$data);
		}
	}
	
	function addPosition_type()
	{
		$data['title'] = "MFA - Position Management";
		$data['result'] = 0;
		$this->load->view('manage/addPosition_type',$data);
	}
	
	function addPosition()
	{
		$data['data']=$this->user_manage->get_position_type();
		$data['title'] = "MFA - Position Management";
		$data['result'] = 0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/addPosition',$data);
	}
	
	function addPosition_level()
	{
		$data['data']=$this->user_manage->get_position_type();
		$data['title'] = "MFA - Position Management";
		$data['result'] = 0;
		$this->load->view('manage/addPosition_level',$data);
	}
	
	function addPosition_type_save()
	{	
		$tposition=$this->input->post('tposition');
		$result=$this->user_manage->addPosition_type_save($tposition);
		
		$data['title'] = "MFA - Position Management";
		$data['result'] = $result;
		
		$this->load->view('manage/addPosition_type',$data);
	}
	
	function addPosition_save()
	{	
		$tposition=$this->input->post('tposition');
		$nposition=$this->input->post('nposition');
		$result=$this->user_manage->addPosition_save($tposition,$nposition);
		
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_position_type();
		$data['result'] = $result;
		
		$this->load->view('manage/addPosition',$data);
	}
	
	function addPosition_level_save()
	{	
		$tposition=$this->input->post('tposition');
		$eposition_level=$this->input->post('eposition_level');
		$result=$this->user_manage->addPosition_level_save($tposition,$eposition_level);
		
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_position_type();
		$data['result'] = $result;
		
		$this->load->view('manage/addPosition_level',$data);
	}
	
	function pos_type_edit($id)
	{
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_edit_position_type($id);
		$data['result']=0;
		$this->load->view('manage/editPosition_type',$data);
	}
	
	function updatePosition_type_save()
	{
		$id=$this->input->post('id');
		$name=$this->input->post('name');
		
		$data['title'] = "MFA - Position Management";
		$result=$this->user_manage->updatePosition_type_save($id,$name);
		$data['result']=$result;
		
		$data['data']=$this->user_manage->get_edit_position_type($id);
		$this->load->view('manage/editPosition_type',$data);
	}
	
	function pos_type_del($id)
	{
		$result=$this->user_manage->deletePosition_type($id);
		
		$data['title'] = "MFA - Position Management";
		$data['result'] = $result;
		$data['data']=$this->user_manage->position_view();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('managePosition_view',$data);
	}
	
	function pos_edit_info($id)
	{
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_edit_position($id);
		$data['type']=$this->user_manage->get_position_type();
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/editPosition',$data);
	}
	
	function updatePosition_save()
	{
		$id=$this->input->post('id');
		$tposition=$this->input->post('tposition');
		$nposition=$this->input->post('nposition');
		$result=$this->user_manage->updatePosition_save($id,$tposition,$nposition);
		
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_edit_position($id);
		$data['type']=$this->user_manage->get_position_type();
		$data['result']=$result;
		$this->load->view('manage/editPosition',$data);
	}
	
	function get_position_1($id)
	{
		$data=$this->user_manage->get_position_1($id);
		echo json_encode($data);
	}
	
	function get_position_2($id)
	{
		$data=$this->user_manage->get_position_2($id);
		echo json_encode($data);
	}
	
	function pos_del_info($id)
	{
		$result=$this->user_manage->deletePosition($id);
		
		$data['title'] = "MFA - Position Management";
		$data['result'] = $result;
		$data['data']=$this->user_manage->position_view();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('managePosition_view',$data);
	}
	
	function pos_lv_edit($id)
	{
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_edit_position_lv($id);
		$data['type']=$this->user_manage->get_position_type();
		$data['result']=0;
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('manage/editPosition_level',$data);
	}
	
	function updatePosition_lv_save()
	{
		$id=$this->input->post('id');
		$tposition=$this->input->post('tposition');
		$name=$this->input->post('name');
		$result=$this->user_manage->updatePosition_lv_save($id,$tposition,$name);
		
		$data['title'] = "MFA - Position Management";
		$data['data']=$this->user_manage->get_edit_position_lv($id);
		$data['type']=$this->user_manage->get_position_type();
		$data['result']=$result;
		$this->load->view('manage/editPosition_level',$data);
	}
	
	function pos_lv_del($id)
	{
		$result=$this->user_manage->deletePosition_level($id);
		
		$data['title'] = "MFA - Position Management";
		$data['result'] = $result;
		$data['data']=$this->user_manage->position_view();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		$this->load->view('managePosition_view',$data);
	}
}