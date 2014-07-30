<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageindicator extends CI_Controller {

	function __construct()
	{
	   parent::__construct();
	   $this->load->model('user','',TRUE);
	   $this->load->model('department','',TRUE);
	   $this->load->model('ministerindicator','',TRUE);
	   $this->load->model('position','',TRUE);
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

	function showMinister()
	{
		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatorminister_view',$data);


	}
	
	function showDepartment()
	{
		//$this->load->helper(array('form'));
		
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$data['admin_array'] = array();		
		$data['depid']=0;
		$data['indicatordep_array'] = array();

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordepartment_view',$data);


	}

	function showDivision()
	{
		//$this->load->helper(array('form'));
        
        $query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
        $data['div_array'] = array();


		$data['admin_array'] = array();		
		$data['divid']=0;
        $data['depid']=0;
		$data['indicatordivision_array'] = array();

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordivision_view',$data);


	}
	
	function addIndicatorMinister()
	{
		$this->load->helper(array('form'));
        
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getDepName();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
		
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,"min_goal");
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addindicatorminister_view',$data);

	}

	function addDepartment()
	{
		$this->load->helper(array('form'));
        
        // set dep id for admin_dep
        $data['depid'] = $this->session->userdata('sessdep');
		
		$query = $this->position->getPosition();
		if($query){
			$data['position_array'] =  $query;
		}else{
			$data['position_array'] = array();
		}

		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
        
        

		
		// get minister indicator id and goal id from selected 
		$indicator_min_name_selected = null;
		$goal_min_name_selected = null;
		for ($i=0; $i<count($this->session->userdata('indicator_select')); $i++) {
			if ($this->session->userdata('indicator_select')[$i] > 0) {
				$indicator_min_name_selected[$i] = $this->ministerindicator->getNameFromMinister("min_indicator","id",$this->session->userdata('indicator_select')[$i])[0];
				
			}
		}
		
		for ($i=0; $i<count($this->session->userdata('goal_select')); $i++) {
			if ($this->session->userdata('goal_select')[$i] > 0) {
				$goal_min_name_selected[$i] = $this->ministerindicator->getNameFromMinister("min_goal","id",$this->session->userdata('goal_select')[$i])[0];
			}
		}
		
		$data['indicator_min_id'] = $this->session->userdata('indicator_select');
		$data['indicator_min_name'] = $indicator_min_name_selected;
		
		$data['goal_min_id'] = $this->session->userdata('goal_select');
		$data['goal_min_name'] = $goal_min_name_selected;
        
        // show saved minister indicator temp no depid
        $query = $this->ministerindicator->getIndicatorDep(0,"isMinister >",0,"isGoalmin",0,$this->session->userdata('sessid'));
        if($query){
			$data['newmin_array'] =  $query;
		}else{
			$data['newmin_array'] = array();
		}
        
        // show saved minister goal temp no depid
        $query = $this->ministerindicator->getIndicatorDep(0,"isMinister",0,"isGoalmin >",0,$this->session->userdata('sessid'));
        if($query){
			$data['newgoal_array'] =  $query;
		}else{
			$data['newgoal_array'] = array();
		}
		
		// show department indicator temp no depid
		$query = $this->ministerindicator->getIndicatorDep(0,"isMinister",0,"isGoalmin",0,$this->session->userdata('sessid'));
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/adddepartment_view',$data);

	}
    
    function savedepid()
    {
        $id = $this->input->post('depid'); 
        $this->session->set_userdata('depid',$id);
        return true;
    }
    
    function addNewIndicatorDepFromInMin() 
    {
        $id = $this->uri->segment(3);
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
        
        $data['min_array'] = $this->ministerindicator->getOneIndicator($id);
        $data['goal_array'] = $this->ministerindicator->getIndicatorMinGoal($id,$this->session->userdata('sessyear'))->result();
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'dep_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
        $data['showresult'] = null;
        $data['id'] = $id;
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordepfrominmin_view',$data);
    }
    
    function addNewIndicatorDepFromGoalMin() 
    {
        $id = $this->uri->segment(3);
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
        
        $data['min_array'] = $this->ministerindicator->getNameFromMinister("min_goal","id",$id);
        $data['min_goal_id'] = $id;
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'dep_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
        $data['id'] = $id;
        $data['showresult'] = null;
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordepfromgoalmin_view',$data);
    }

	function addDivision()
	{
		$this->load->helper(array('form'));

        $data['divid'] = $this->session->userdata('sessdiv');
        
        $data['depid'] = $this->session->userdata('sessdep');
        
        // dep of user
        $query = $this->department->getOneGom($this->session->userdata('sessdep'));
        $data['sessdep'] = $this->session->userdata('sessdep');
        foreach ($query as $result) {
            $data['depname'] = $result->name;
        }
        
        $query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}

		$query = $this->department->getKongFromOneGom($this->session->userdata('sessdep'));
		if($query){
			$data['div_array'] =  $query;
		}else{
			$data['div_array'] = array();
		}
        
        

		
		// get dep indicator id and goal id from selected 
		$indicator_dep_name_selected = null;
		$goal_dep_name_selected = null;
		for ($i=0; $i<count($this->session->userdata('indicator_dep_select')); $i++) {
			if ($this->session->userdata('indicator_dep_select')[$i] > 0) {
				$indicator_dep_name_selected[$i] = $this->ministerindicator->getNameFromMinister("dep_indicator","id",$this->session->userdata('indicator_dep_select')[$i])[0];
				
			}
		}
		
		for ($i=0; $i<count($this->session->userdata('goal_dep_select')); $i++) {
			if ($this->session->userdata('goal_dep_select')[$i] > 0) {
				$goal_dep_name_selected[$i] = $this->ministerindicator->getNameFromMinister("dep_goal","id",$this->session->userdata('goal_dep_select')[$i])[0];
			}
		}
		
		$data['indicator_dep_id'] = $this->session->userdata('indicator_dep_select');
		$data['indicator_dep_name'] = $indicator_dep_name_selected;
		
		$data['goal_dep_id'] = $this->session->userdata('goal_dep_select');
		$data['goal_dep_name'] = $goal_dep_name_selected;
        
        // show saved dep indicator temp no depid
        $query = $this->ministerindicator->getIndicatorDiv(0,"isDep >",0,"isGoalDep",0,$this->session->userdata('sessid'));
        if($query){
			$data['newdep_array'] =  $query;
		}else{
			$data['newdep_array'] = array();
		}
        
        // show saved minister goal temp no depid
        $query = $this->ministerindicator->getIndicatorDiv(0,"isDep",0,"isGoalDep >",0,$this->session->userdata('sessid'));
        if($query){
			$data['newgoal_array'] =  $query;
		}else{
			$data['newgoal_array'] = array();
		}
		
		// show department indicator temp no depid
		$query = $this->ministerindicator->getIndicatorDiv(0,"isDep",0,"isGoalDep",0,$this->session->userdata('sessid'));
		if($query){
			$data['indicatordiv_array'] =  $query;
		}else{
			$data['indicatordiv_array'] = array();
		}

		
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/adddivision_view',$data);

	}
    
    function savedivid()
    {
        list($id,$depid) = explode("x",$this->input->post('divid')); 
        $this->session->set_userdata('divid',$id);
        $this->session->set_userdata('divdepid',$depid);
        return true;
    }
    
    function addNewIndicatorDivFromInDep() 
    {
        $id = $this->uri->segment(3);
        
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
        
        $data['dep_array'] = $this->ministerindicator->getOneIndicatorDep($id);
        $data['goal_array'] = $this->ministerindicator->getOneIndicatorGoalDep($id,$this->session->userdata('sessyear'));
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'division_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
        $data['id'] = $id;
        $data['divid'] = $this->uri->segment(4);
        $data['showresult'] = null;
        
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivfromindep_view',$data);
    }
    
    function addNewIndicatorDivFromGoalDep() 
    {
        $id = $this->uri->segment(3);
        $data['divid'] = $this->uri->segment(4);
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
        
        $data['dep_array'] = $this->ministerindicator->getNameFromMinister("dep_goal","id",$id);
        $data['dep_goal_id'] = $id;
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'division_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
        
        $data['showresult'] = null;
        
        $data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivfromgoaldep_view',$data);
    }

	function addNewIndicatorDep()
	{
		$this->load->helper(array('form'));
        
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
		
        $data['showresult'] = null;
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'dep_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordep_view',$data);

	}
	
	function addNewIndicatorDivision()
	{
		$this->load->helper(array('form'));
        
        $data['indicatorNO'] = $this->session->userdata('number');
        $data['indicatorName'] = $this->session->userdata('name');
        $data['weightmin'] = $this->session->userdata('weightmin');
        $data['divid'] = $this->uri->segment(3);

		$data['showresult'] = null;
        
        $userid = $this->session->userdata('sessid');
        $query = $this->ministerindicator->getGoalTemp($userid,'division_goal');
        if($query){
			$data['goaltemp_array'] =  $query;
		}else{
			$data['goaltemp_array'] = array();
		}
	
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addnewindicatordivision_view',$data);

	}

	function addIndicatorDep()
	{
		$this->load->helper(array('form'));
		
	
		$query = $this->department->getName();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
			
		$data['title'] = "MFA - Add Indicator ";
		$this->load->view('indicator/addindicatordep_view',$data);

	}
	
	function viewDep()
	{
		$this->load->helper(array('form'));
		$id = $this->uri->segment(3);
		
			
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
			
		$query = $this->ministerindicator->getAllIndicatorDep($id);
		if($query){
			$data['indicatordep_array'] =  $query;
		}else{
			$data['indicatordep_array'] = array();
		}

		$query = $this->user->getAllAdminDep("admin_dep",$id);
		if($query){
			$data['admin_array'] =  $query;
		}else{
			$data['admin_array'] = array();
		}

		$data['depid']=$id;
		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordepartment_view',$data);

	}
	
	function viewDiv()
	{
		$this->load->helper(array('form'));
        $id = $this->uri->segment(3);
        
        
		$query = $this->department->getGom();
		if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
        
		$query = $this->department->getOneKong($id);
		foreach($query as $loop) {
            $depid = $loop->dep_id;   
        }
			
		$query = $this->ministerindicator->getIndicatorDivision($id);
		if($query){
			$data['indicatordivision_array'] =  $query;
		}else{
			$data['indicatordivision_array'] = array();
		}

		$query = $this->user->getAllAdminDiv("admin_div",$id);
		if($query){
			$data['admin_array'] =  $query;
		}else{
			$data['admin_array'] = array();
		}

		$data['divid']=$id;
        $data['depid']=$depid;
		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatordivision_view',$data);

	}
	
	function insertDep()
	{
		$this->load->helper(array('form'));
		
		if($this->session->userdata('logged_in'))
		{

			
			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}
			$data['min'] = 0;
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorminister_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 show_404();
	   }
	}
	
	function insertPerson()
	{
		$this->load->helper(array('form'));
		
		if($this->session->userdata('logged_in'))
		{

			
			$query = $this->department->getName();
			if($query){
				$data['depname_array'] =  $query;
			}else{
				$data['depname_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorDep(0);
			if($query){
				$data['indicatordep_array'] =  $query;
			}else{
				$data['indicatordep_array'] = array();
			}
			
			$query = $this->ministerindicator->getIndicatorPerson(0);
			if($query){
				$data['indicatorperson_array'] =  $query;
			}else{
				$data['indicatorperson_array'] = array();
			}
			$data['min'] = 2;
			$session_data = $this->session->userdata('logged_in');
			$data['firstname'] = $session_data['firstname'];
			$data['lastname'] = $session_data['lastname'];
			$data['year'] = $session_data['year'];
			$data['title'] = "MFA - Add Indicator ";
			$this->load->view('indicator/addindicatorminister_view',$data);
		}
	   else
	   {
		 //If no session, redirect to login page
		 show_404();
	   }
	}
	
	public function getdatabyajax()
	{
		$this->load->library('Datatables');
		$this->datatables
		->select("id, name", FALSE)
		->from('min_indicator')
		/*
		->edit_column("id",'$1',"id")
		->add_column("goalDetail",'unknown',"id")
		->add_column("goal",'unknown',"id");
		*/
		->edit_column("id",'<input type="hidden" name="indicatorid[]" id="indicatorid[]" value="$1"><input type="text" class="form-control" name="number[]" id="number[]" value="">',"id")
		->add_column("goal",'<div class="form-group"><label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="1">1</label>
                                            <label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="2">2</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="3">3</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="4">4</label>
											<label class="radio-inline"><input type="radio" name="goal-$1" id="goal-$1" value="5">5</label>
                                        </div>',"id")
		->add_column("weight",'<input type="text" class="form-control" name="weight[]" id="weight[]" value="">',"id");
		echo $this->datatables->generate(); 
		
		
	}
	
	public function getdataAndButtonbyajax()
	{
		$this->load->library('Datatables');
		$this->datatables
		->select("number, name, resName,id", FALSE)
		->from('min_indicator')
		/*
		->edit_column("id",'$1',"id")
		->add_column("goalDetail",'unknown',"id")
		->add_column("goal",'unknown',"id");
		*/
		->edit_column("id",'<div class="tooltip-demo">
	<a href="'.site_url("manageindicator/viewindicator_min/$1").'" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="'.site_url("manageindicator/viewindicator_min/$1").'" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
	<button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm($1)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
	</div>',"id");
		
		echo $this->datatables->generate(); 
	}
	
	function required_resid0()
    {
        if( ! $this->input->post('resid')[0])
        {
            $this->form_validation->set_message('required_resid0', '<code>กรุณาใส่ข้อมูล</code>');
            return FALSE;
        }
		
        return TRUE;
    }



	function saveMinister()
	{
		$this->form_validation->set_rules('indicatorNO', 'indicatorNO', 'trim|xss_clean|required|numeric');
		$this->form_validation->set_rules('indicatorName', 'indicatorName', 'trim|xss_clean|required');

		$this->form_validation->set_rules('goalmin', 'goalmin', 'trim|required|maxlength[1]|xss_clean');
		$this->form_validation->set_rules('weightmin', 'weightmin', 'trim|xss_clean|required');
		
		// validate only control name
		$this->form_validation->set_rules('controlname', 'controlname', 'trim|xss_clean|required');
		
		// validate only first response name
		$this->form_validation->set_rules('resid0', 'resid0', 'trim|xss_clean|callback_required_resid0');
		//$this->form_validation->set_rules('position0', 'position0', 'trim|xss_clean|required');
		//$this->form_validation->set_rules('telephone0', 'telephone0', 'trim|xss_clean|required');

		$test1= ($this->input->post('resid'));

		$this->form_validation->set_message('required', 'กรุณาใส่ข้อมูล');
		$this->form_validation->set_message('numeric', 'กรุณาใส่เฉพาะตัวเลขเท่านั้น');
		$this->form_validation->set_error_delimiters('<code>', '</code>');
		
		if($this->form_validation->run() == TRUE) {
			$year = $this->session->userdata('sessyear');

			$indicatorNO= ($this->input->post('indicatorNO'));
			$indicatorName= ($this->input->post('indicatorName'));

			$goalmin= ($this->input->post('goalmin'));
			$weightmin= ($this->input->post('weightmin'));
			
			$controluserid= ($this->input->post('controluserid'));
			
			// array
			$uid= ($this->input->post('uid'));
			/*
			$resid= ($this->input->post('resid'));
			$position= ($this->input->post('position'));
			$depid= ($this->input->post('depid'));
			$telephone= ($this->input->post('telephone'));
			*/

			//array
            $goalid = $this->input->post('goalid');
			//$goalNO = $this->input->post('goalNO');
			//$goalName = $this->input->post('goalName');

			$criterion1 = $this->input->post('criterion1');
			$criterion2 = $this->input->post('criterion2');
			$criterion3 = $this->input->post('criterion3');
			$criterion4 = $this->input->post('criterion4');
			$criterion5 = $this->input->post('criterion5');

			$technote = $this->input->post('technote');
			

			$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote
				
			);


			$resultMin = $this->ministerindicator->addIndicator($indicator);
			if ($resultMin) {

				$indicatorid = $this->db->insert_id();
				$control = array(
					'minIndicatorID' => $indicatorid,
					'userID' => $controluserid,
					'isControl' => 1
				);
				$resultRes = $this->ministerindicator->addIndicatorResponse($control);
				$response = array();
				for ($i=0; $i<count($uid); $i++) {
					if ($uid[$i]>0) {
						$response['minIndicatorID'] = $indicatorid;
						$response['userID'] = $uid[$i];
						$response['isControl'] = 0;
						/*
						$response['resName'] = $resid[$i];
						$response['resPosition'] = $position[$i];
						$response['resTelephone'] = $telephone[$i];
						$response['resDepartmentID'] = $depid[$i];
						*/
					

						$resultRes = $this->ministerindicator->addIndicatorResponse($response);
						/*
						if ($result) $this->session->set_flashdata('showresult', 'success');
						else { 
							$this->session->set_flashdata('showresult', 'fail');
							$this->ministerindicator->delIndicator($indicatorid);
							$this->ministerindicator->delGoalbyIndicator($indicatorid);
						}
						*/
					}
				}

				$goal = array();
				for ($i=0; $i<count($goalid); $i++) {
                    $goal['id'] = $goalid[$i];
                    $goal['indicatorID'] = $indicatorid;
				    $result = $this->ministerindicator->editNumberGoal($goal,"min_goal");

				}
				
                $this->session->unset_userdata('number');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('weightmin');
                
				$this->session->set_flashdata('success', 'yes');

				// if success , go to indicator table


			}
			else {
				$this->session->set_flashdata('fail', 'yes');
			}
				//redirect(current_url());
			
		}
		
			redirect('manageindicator/addIndicatorMinister', 'location');
	}

	function viewIndicatorFromAdd() {

		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromadd_view',$data);
	}
	
	function selectIndicatorMinisterList() {

		$query = $this->ministerindicator->getIndicatorMin($this->session->userdata('sessyear'));
		$result = array();
		foreach($query->result_array() as $row)
		{
			$row['goalid'] = 0;
			$result[] = $row;
			$query2 = $this->ministerindicator->getIndicatorMinGoal($row['id'],$this->session->userdata('sessyear'));
			foreach($query2->result_array() as $row2)
			{
				$result[] = $row2;
			}
		}
		
		$data['goal_array'] = $result;

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/selectindicatorminlist_view',$data);
	}
    
    function selectIndicatorDepList() {

		
        // dep of user
        $query = $this->department->getOneGom($this->session->userdata('sessdep'));
        if($query){
			$data['dep_array'] =  $query;
		}else{
			$data['dep_array'] = array();
		}
        
        $query = $this->ministerindicator->getIndicatorOneDep($this->session->userdata('sessdep'),$this->session->userdata('sessyear'));
        
		$result = array();
		foreach($query->result_array() as $row)
		{
			$row['goalid'] = 0;
			$result[] = $row;
			$query2 = $this->ministerindicator->getIndicatorOneDepGoal($row['id'],$this->session->userdata('sessyear'));
			foreach($query2->result_array() as $row2)
			{
				$result[] = $row2;
			}
		}
		
		$data['goal_array'] = $result;

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/selectindicatordeplist_view',$data);
	}
	
	function saveIndicatorSession() {
		$this->session->set_userdata('indicator_select',$this->input->post('indicator'));
		$this->session->set_userdata('goal_select',$this->input->post('goal'));
	}
        
    function saveIndicatorDepSession() {
		$this->session->set_userdata('indicator_dep_select',$this->input->post('indicator'));
		$this->session->set_userdata('goal_dep_select',$this->input->post('goal'));
	}
    
    function clearIndicatorSession() {
        
        $this->session->set_userdata('indicator_select');
		$this->session->set_userdata('goal_select');
        
        $this->addDepartment();
    }

	function viewIndicatorLink() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicator($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoal($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponse($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlink_view',$data);
	}

	function viewIndicatorLinkDep() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicatorDep($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
        $data['goal_min_array'] = array();
        foreach ($query as $loop) {
            if ($loop->isMinister > 0) {
                $resultmin = $this->ministerindicator->getOneIndicatorGoalDepFromMinIndicator($loop->isMinister);
                $data['goal_min_array'] = $resultmin;
            }
            if ($loop->isGoalmin > 0) $goalminid = $loop->isGoalmin;
            
        }
            
		$query = $this->ministerindicator->getOneIndicatorGoalDep($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlinkdep_view',$data);
	}
	
	function viewIndicatorLinkDivision() {

		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicatorDivision($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
        
        $data['goal_dep_array'] = array();
        foreach ($query as $loop) {
            if ($loop->isDep > 0) {
                $resultmin = $this->ministerindicator->getGoalDivFromDep($loop->isDep);
                $data['goal_dep_array'] = $resultmin;
            }
            if ($loop->isGoalDep > 0) $goalminid = $loop->isGoalDep;
            
        }
        
		$query = $this->ministerindicator->getOneIndicatorGoalDivision($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}

		$data['title'] = "MFA - View Indicator ";
		$this->load->view('indicator/viewindicatorfromlinkdivision_view',$data);
	}

	function saveDepartment()
	{
        $depid= ($this->session->userdata('sessdep'));
        
        // array new indicator temp
        $newminid = ($this->input->post('newminid'));
        $newgoalid = ($this->input->post('newgoalid'));
        $newdepid = ($this->input->post('newdepid'));
        
        if ($depid > 0) {
			
			$indicatordep = array(
				'depID' => $depid
			);
			
			// edit new indicator into dep
			for ($i=0; $i<count($newminid); $i++) {
				$indicatordep['id'] = $newminid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
            
            for ($i=0; $i<count($newgoalid); $i++) {
				$indicatordep['id'] = $newgoalid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
            
            for ($i=0; $i<count($newdepid); $i++) {
				$indicatordep['id'] = $newdepid[$i];
				$this->ministerindicator->editIndicatorDep($indicatordep);
			}
			
			$this->session->set_flashdata('success', 'yes');

        }else{
            $this->session->set_flashdata('fail', 'yes');
        }

        redirect('manageindicator/addDepartment', 'location');
	}
	
	function saveDep()
	{
        
		$year = $this->session->userdata('sessyear');
        $nextpage = 0;
        
        // link minister indicator id 
        if ($this->input->post('minid') > 0) {
            $indicator_min_id = $this->input->post('minid');
            $nextpage = 1;
            
            // remove minister indicator in session
            $filter = $this->session->userdata('indicator_select');
            $index = array_search($indicator_min_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('indicator_select', $filter);
        }else{
            $indicator_min_id = 0;
        }
        
        // link minister goal id 
        if ($this->input->post('mingoalid') > 0) {
            $goal_min_id = $this->input->post('mingoalid');
            $nextpage = 2;
            
            // remove minister goal in session
            $filter = $this->session->userdata('goal_select');
            $index = array_search($goal_min_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('goal_select', $filter);
        }else{
            $goal_min_id = 0;
        }

        $indicatorNO= ($this->input->post('indicatorNO'));
		$indicatorName= ($this->input->post('indicatorName'));

		$goalmin= ($this->input->post('goalmin'));
		$weightmin= ($this->input->post('weightmin'));
		
        // dep goal response name array
		//$userid= ($this->input->post('userid'));
            
		//array
        $goalid = $this->input->post('goalid');
		

		$criterion1 = $this->input->post('criterion1');
		$criterion2 = $this->input->post('criterion2');
		$criterion3 = $this->input->post('criterion3');
		$criterion4 = $this->input->post('criterion4');
		$criterion5 = $this->input->post('criterion5');
		$technote = $this->input->post('technote');
        
        $editid = $this->session->userdata('sessid');
			
        
		$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote,
                'isMinister' => $indicator_min_id,
                'isGoalmin' => $goal_min_id,
                'editorID' => $editid
				
        );


        $resultMin = $this->ministerindicator->addIndicatorDep($indicator);
		if ($resultMin) {

		  $indicatorid = $this->db->insert_id();
		  $goal_min = array();
		  
		  if ($indicator_min_id > 0) {
				$query = $this->ministerindicator->getIndicatorMinGoal($indicator_min_id,$year)->result();
				foreach($query as $loop) {
					$goal_min['indicatorID'] = $indicatorid;
					$goal_min['number'] = $loop->number;
					$goal_min['name'] = $loop->name;
					$goal_min['editorID'] = $editid;
					$goal_min['isGoalMin'] = $loop->goalid;
					$result = $this->ministerindicator->addIndicatorGoalDep($goal_min);
				}
		  }
		  
		  $goal = array();
          // edit goal temp
		  for ($i=0; $i<count($goalid); $i++) {
			    $goal['id'] = $goalid[$i];
                $goal['indicatorID'] = $indicatorid;
				$result = $this->ministerindicator->editNumberGoal($goal,"dep_goal");
          }
				
                $this->session->unset_userdata('number');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('weightmin');
            
                $data['showresult'] = "success";
				// if success , go to indicator table


        }
		else {
		  $data['showresult'] = "fail";
		}
        
        if ($nextpage == 1) {
            $this->load->view('indicator/addnewindicatordepfrominmin_view',$data);
        }elseif ($nextpage == 2) {
            $this->load->view('indicator/addnewindicatordepfromgoalmin_view',$data);
        }else{
            $this->load->view('indicator/addnewindicatordep_view',$data);
        }
	}	

	function saveDivision()
	{
		
        $divid= ($this->session->userdata('sessdiv'));
        
        
        // array new indicator temp
        $newminid = ($this->input->post('newminid'));
        $newgoalid = ($this->input->post('newgoalid'));
        $newdepid = ($this->input->post('newdepid'));
        
        if ($divid > 0) {
			
			$indicatordep = array(
				'divisionID' => $divid
			);
			
			// edit new indicator into dep
			for ($i=0; $i<count($newminid); $i++) {
				$indicatordep['id'] = $newminid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
            
            for ($i=0; $i<count($newgoalid); $i++) {
				$indicatordep['id'] = $newgoalid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
            
            for ($i=0; $i<count($newdepid); $i++) {
				$indicatordep['id'] = $newdepid[$i];
				$this->ministerindicator->editIndicatorDivision($indicatordep);
			}
			
			$this->session->set_flashdata('success', 'yes');

        }else{
            $this->session->set_flashdata('fail', 'yes');
        }

        redirect('manageindicator/addDivision', 'location');

	}	
	
	function saveDiv()
	{
		$year = $this->session->userdata('sessyear');
        $nextpage = 0;
        
        // link minister indicator id 
        if ($this->input->post('depid') > 0) {
            $indicator_dep_id = $this->input->post('depid');
            $nextpage = 1;
            
            // remove minister indicator in session
            $filter = $this->session->userdata('indicator_dep_select');
            $index = array_search($indicator_dep_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('indicator_dep_select', $filter);
        }else{
            $indicator_dep_id = 0;
        }
        
        // link minister goal id 
        if ($this->input->post('depgoalid') > 0) {
            $goal_dep_id = $this->input->post('depgoalid');
            $nextpage = 2;
            
            // remove minister goal in session
            $filter = $this->session->userdata('goal_dep_select');
            $index = array_search($goal_dep_id,$filter);
            unset($filter[$index]);
            $filter = array_values($filter);
            $this->session->set_userdata('goal_dep_select', $filter);
        }else{
            $goal_dep_id = 0;
        }

        $indicatorNO= ($this->input->post('indicatorNO'));
		$indicatorName= ($this->input->post('indicatorName'));

		$goalmin= ($this->input->post('goalmin'));
		$weightmin= ($this->input->post('weightmin'));
		
        // dep goal response name array
		$userid= ($this->input->post('userid'));
            
		//array
        
        $goalid = $this->input->post('goalid');
        
        if ($nextpage==1) {
            $goaldepid = $this->input->post('goaldepid');
            $goalnumber = $this->input->post('goaldepnumber');
            $goalname = $this->input->post('goaldepname');
            $responseid = $this->input->post('responsetextid');
        }

		$criterion1 = $this->input->post('criterion1');
		$criterion2 = $this->input->post('criterion2');
		$criterion3 = $this->input->post('criterion3');
		$criterion4 = $this->input->post('criterion4');
		$criterion5 = $this->input->post('criterion5');
		$technote = $this->input->post('technote');
        
        $editid = $this->session->userdata('sessid');
			
        
		$indicator = array(
				'year' => $year,
				'number' => $indicatorNO,
				'name' => $indicatorName,
				'goal' => $goalmin,
				'weight' => $weightmin,
				'criteria1' => $criterion1,
				'criteria2' => $criterion2,
				'criteria3' => $criterion3,
				'criteria4' => $criterion4,
				'criteria5' => $criterion5,
				'technicalNote' => $technote,
                'isDep' => $indicator_dep_id,
                'isGoalDep' => $goal_dep_id,
                'editorID' => $editid
				
        );


        $resultMin = $this->ministerindicator->addIndicatorDivision($indicator);
		if ($resultMin) {

		  $indicatorid = $this->db->insert_id();
		  $goaldep = array();
          $goal = array();
		  
          // insert goal from dep
          if ($nextpage==1) {  
              for ($i=0; $i<count($goalnumber); $i++) {
                  $goaldep['number'] = $goalnumber[$i];
                  $goaldep['name'] = $goalname[$i];
                  $goaldep['indicatorID'] = $indicatorid;
                  $goaldep['responseID'] = $responseid[$i];
                  $goaldep['editorID'] = $editid;
                  $goaldep['isGoalDep'] = $goaldepid[$i];
                  $result = $this->ministerindicator->addIndicatorGoalDivision($goaldep);  
              }
          }
          
            
          // edit goal temp
		  for ($i=0; $i<count($goalid); $i++) {
			    $goal['id'] = $goalid[$i];
                $goal['indicatorID'] = $indicatorid;
				$result = $this->ministerindicator->editNumberGoal($goal,"division_goal");
          }
				
                $this->session->unset_userdata('number');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('weightmin');
            
                $data['showresult'] = "success";
				// if success , go to indicator table


        }
		else {
		  $data['showresult'] = "fail";
		}
        
        if ($nextpage == 1) {
            $this->load->view('indicator/addnewindicatordivfromindep_view',$data);
        }elseif ($nextpage == 2) {
            $this->load->view('indicator/addnewindicatordivfromgoaldep_view',$data);
        }else{
            $this->load->view('indicator/addnewindicatordivision_view',$data);
        }
	}	
	
	function required_depid() {
		if( $this->input->post('depid')[0] < 0)
        {
            $this->form_validation->set_message('required_depid', '<code>กรุณาเลือกสังกัด</code>');
            return FALSE;
        }
		
        return TRUE;
	}
	
	function editNumber() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumber($indicator);
		$query = $this->ministerindicator->getIndicatorGroupDepartment($this->session->userdata('sessyear'));
		if($query){
			$data['view_array'] =  $query;
		}else{
			$data['view_array'] = array();
		}

		$data['title'] = "MFA - Show All Indicator ";
		$this->load->view('indicator/allindicatorminister_view',$data);
				
	}
    
    function editNumberDep() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);
        $depid = $this->uri->segment(5);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumberDep($indicator);

		redirect('manageindicator/viewDep/'.$depid, 'location');
				
	}
    
    function editNumberDiv() {
		$indicatorid = $this->uri->segment(3);
		$newnum = $this->uri->segment(4);
        $divid = $this->uri->segment(5);

		$indicator = array(
			"id" => $indicatorid,
			"number" => $newnum
			);

		$result = $this->ministerindicator->editNumberDiv($indicator);

		redirect('manageindicator/viewDiv/'.$divid, 'location');
				
	}
	
	function delete()
	{
		
		$indicatorid = $this->uri->segment(3);
		$this->ministerindicator->delIndicator($indicatorid);
		$this->ministerindicator->delGoalbyIndicator($indicatorid);
		$this->ministerindicator->delResponsebyIndicator($indicatorid);
		
		redirect('manageindicator/showMinister', 'refresh');
	}
    
    function deleteGoalTemp($table=null,$goalid,$indicatorid, $divid)
	{
        switch($table) {
            case 1: $this->ministerindicator->delGoalTemp($goalid,"min");
                    redirect('manageindicator/addIndicatorMinister', 'location');
                    break;
            // new dep indicator
            case 2: $this->ministerindicator->delGoalTemp($goalid,"dep");
                    redirect('manageindicator/addNewIndicatorDep', 'location');
                    break;
            case 3: $this->ministerindicator->delGoalTemp($goalid,"dep");
                    redirect('manageindicator/addNewIndicatorDepFromInMin/'.$indicatorid, 'location');
                    break;
            case 4: $this->ministerindicator->delGoalTemp($goalid,"dep");
                    redirect('manageindicator/addNewIndicatorDepFromGoalMin/'.$indicatorid, 'location');
                    break;
            case 5: $this->ministerindicator->delGoalTemp($goalid,"division");
                    redirect('manageindicator/addNewIndicatorDivision', 'location');
                    break;
            case 6: $this->ministerindicator->delGoalTemp($goalid,"division");
                    redirect('manageindicator/addNewIndicatorDivFromInDep/'.$indicatorid."/".$divid, 'location');
                    break;
            case 7: $this->ministerindicator->delGoalTemp($goalid,"division");
                    redirect('manageindicator/addNewIndicatorDivFromGoalDep/'.$indicatorid."/".$divid, 'location');
                    break;
            default: break;
        }
		
		
	}
	
	function deleteDep()
	{
		
		$id = $this->uri->segment(3);
		$depid = $this->uri->segment(4);
		$this->ministerindicator->delIndicatorDep($id);
		//$this->ministerindicator->delGoalbyIndicatorDep($id);
		
		$query = $this->department->getName();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
		//$data['depid']=0;
		$data['indicatordep_array'] = array();
		
		redirect('manageindicator/viewDep/'.$depid, 'refresh');
	}
    
    function deleteDepTemp()
    {
        $id = $this->uri->segment(3);
        $this->ministerindicator->delDepIndicatorTemp($id);
        
        $this->addDepartment();
    }
    
    function deleteDivTemp()
    {
        $id = $this->uri->segment(3);
        $this->ministerindicator->delDivIndicatorTemp($id);
        
        $this->addDivision();
    }
	
	function deleteDivision()
	{
		
		$id = $this->uri->segment(3);
		$divid = $this->uri->segment(4);
		$this->ministerindicator->delIndicatorDivision($id);
		//$this->ministerindicator->delGoalbyIndicatorDivision($id);
		
		$query = $this->department->getKong();
		if($query){
			$data['depname_array'] =  $query;
		}else{
			$data['depname_array'] = array();
		}
		//$data['depid']=0;
		$data['indicatordivision_array'] = array();
		
		redirect('manageindicator/viewDiv/'.$divid, 'refresh');
	}
	
	function viewindicator_min()
	{
		$id = $this->uri->segment(3);
		$query = $this->ministerindicator->getOneIndicator($id);
		if($query){
			$data['minis_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalDepFromMinIndicator($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponse($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}
		

		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatorminister_view',$data);
	}
	
	function viewindicator_dep()
	{
		$id = $this->uri->segment(3);
		$isMin = $this->uri->segment(4);
		$query = $this->ministerindicator->getOneIndicatorDep($id);
		if($query){
			$data['dep_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalDep($id);
		if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		
		$query = $this->ministerindicator->getOneIndicatorGoalDepIsGoalMin($id);
		if($query){
			$data['goal_min_array'] =  $query;
		}else{
			$data['goal_min_array'] =  array();
		}
		
        /*
		$query = $this->ministerindicator->getOneIndicatorResponseDep($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}*/
		$data['depID'] = $id;
		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatordepartment_view',$data);
	}
	
    function viewindicator_div()
	{
		$id = $this->uri->segment(3);
		$isMin = $this->uri->segment(4);
		$query = $this->ministerindicator->getOneIndicatorDivision($id);
		if($query){
			$data['dep_indicator_array'] =  $query;
		}
		$query = $this->ministerindicator->getOneIndicatorGoalDivision($id);
        if($query){
			$data['goal_indicator_array'] =  $query;
		}else{
			$data['goal_indicator_array'] =  array();
		}
		$query = $this->ministerindicator->getOneIndicatorResponseDivision($id);
		if($query){
			$data['res_indicator_array'] =  $query;
		}else{
			$data['res_indicator_array'] =  array();
		}
		$data['divID'] = $id;
		$data['title'] = "MFA - View Indicator";
		$this->load->view('indicator/viewindicatordivision_view',$data);
	}
	
	function autocompleteResponse()
	{
		//$this->load->model('user');
		$term = $this->input->get('term', TRUE);
		$pwemployee = $this->user->searchResponseName($term,$this->uri->segment(3));
		echo json_encode($pwemployee);
	}
    
    function getKongFromGom()
    {
        $depid = $this->input->post('depid');
        $result = $this->department->getKongFromOneGom($depid);
        echo json_encode($result);
    }
    
    function addMinGoalTemp() 
    {
        $number = $this->input->post('goalnumber');
        $name = $this->input->post('goalname');
        
        $this->session->set_userdata('number', $this->input->post('number'));
        $this->session->set_userdata('name', $this->input->post('name'));
        $this->session->set_userdata('weightmin', $this->input->post('weight'));
        
        $userid = $this->session->userdata('sessid');
        
        $goal = array('number' => $number, 'name' => $name, 'indicatorID' => 0, 'editorID' => $userid);
        
        $this->ministerindicator->addIndicatorGoal($goal);
        redirect('manageindicator/addIndicatorMinister', 'location');
    }
    
    function addDepGoalTemp() 
    {
        $number = $this->input->post('goalnumber');
        $name = $this->input->post('goalname');
        
        $this->session->set_userdata('number', $this->input->post('number'));
        $this->session->set_userdata('name', $this->input->post('name'));
        $this->session->set_userdata('weightmin', $this->input->post('weight'));
        
        $userid = $this->session->userdata('sessid');
        
        $goal = array('number' => $number, 'name' => $name, 'indicatorID' => 0, 'editorID' => $userid);
        
        $this->ministerindicator->addIndicatorGoalDep($goal);
        redirect('manageindicator/addNewIndicatorDep', 'location');
    }
    
    function addDivGoalTemp() 
    {
        $number = $this->input->post('goalnumber');
        $name = $this->input->post('goalname');
        $responseid = $this->input->post('responseid');
        
        $this->session->set_userdata('number', $this->input->post('number'));
        $this->session->set_userdata('name', $this->input->post('name'));
        $this->session->set_userdata('weightmin', $this->input->post('weight'));
        
        $userid = $this->session->userdata('sessid');
        
        $goal = array('number' => $number, 'name' => $name, 'indicatorID' => 0, 'responseID' =>$responseid, 'editorID' => $userid);
        
        $this->ministerindicator->addIndicatorGoalDivision($goal);
        redirect('manageindicator/addNewIndicatorDivision', 'location');
    }
    
    function view_minplan()
    {
        $goalid = $this->uri->segment(3);
        $data['show'] = $this->uri->segment(4);
        
        // segment4:  0=add new min plan 1=show min plan
        //            2=add new dep plan 3=show dep plan
        //            4=add new div plan 5=show div plan
        $query1=0;
        switch ($this->uri->segment(4)) {
            case 1: $query1 = $this->ministerindicator->getPlanTarget($goalid,'min');
            case 0: $query2 = $this->ministerindicator->getOneGoal($goalid,'min'); break;
            case 3: $query1 = $this->ministerindicator->getPlanTarget($goalid,'dep');
            case 2: $query2 = $this->ministerindicator->getOneGoal($goalid,'dep'); break;
            case 5: $query1 = $this->ministerindicator->getPlanTarget($goalid,'division');
            case 4: $query2 = $this->ministerindicator->getOneGoal($goalid,'division'); break;
        }
        
        if ($query1) $data['plan_array']=$query1;
        else $data['plan_array']=array();
        
        
        foreach($query2 as $loop) {
            $data['goalnumber']=$loop->number;
            $data['goalname']=$loop->name;
        }
        
        $data['goalid'] = $goalid;
        $data['title'] = "MFA - View Plan";
		$this->load->view('indicator/view_minplan',$data);
        
    }
    
    function add_plan()
    {
        $tableid = $this->uri->segment(3);
        switch ($tableid) {
            case 0: $table = 'min'; break;
            case 2: $table = 'dep'; break;
            case 4: $table = 'division'; break;
            default: $table = "";
        }
        $number = $this->input->post('number');
        $name = $this->input->post('name');
        $goalid = $this->input->post('goalid');
        
        // array target
        $target_number = $this->input->post('target_number');
        $target_name = $this->input->post('target_name');
        
        $plan = array('number' => $number, 'name' => $name, $table.'_goal_id' => $goalid);
        
        $query = $this->ministerindicator->addPlan($plan,$table);
        if ($query) {
            $planid = $this->db->insert_id();
            $target = array();
            for ($i=0; $i<count($target_number); $i++) {
                $target['number'] = $target_number[$i];
                $target['name'] = $target_name[$i];
                $target[$table.'_plan_id'] = $planid;
                
                $query = $this->ministerindicator->addTarget($target,$table);
            }
            if ($query) $this->session->set_flashdata('success', 'yes');
        }
        else $this->session->set_flashdata('fail', 'yes');

        redirect('manageindicator/view_minplan/'.$goalid."/".$tableid, 'refresh');
    }

}