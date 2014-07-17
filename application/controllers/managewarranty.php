<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managewarranty extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
	   $this->load->model('managewarranty_model');
	   $this->load->model('user','',TRUE);
	   $this->load->library("PHPWord/PHPWord");
	   $this->load->helper('download');

		$chk_time = date('Y-m-d H:i:s' , strtotime("-1 Hour"));  // เซตเวลา -1Hour = 60minute เอาไว้เช็คในเงื่อนไข
		$folder = $_SERVER['DOCUMENT_ROOT'].'/psdg/docs';
		$objScan = scandir($folder); // Scan folder ว่ามีไฟล์อะไรบ้าง

		foreach ($objScan as $value) {
			if ($value != "." && $value != "..") // เช็คว่าผลลัพท์ต้องไม่ใช่ . และ ..
			{
				$filedate = date("Y-m-d H:i:s.",filemtime($folder."/".$value.""));
				if ($chk_time > $filedate)
				{
					unlink($folder.'/'.$value);
				}
			}
		}

	   
	}
    
	function index()
	{
		
	}
	
    function autocompleteResponse()
	{
		//$this->load->model('user');
		$term = $this->input->get('term', TRUE);
		$pwemployee = $this->managewarranty_model->searchName($term);
		/* echo '<pre>';
		print_r($pwemployee);
		echo '</pre>';
		exit(); */
		//echo $this->input->get("callback", true) . '(' . json_encode($pwemployee) . ')';
			echo  json_encode($pwemployee);
	}

	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													department
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function department($alert=null)
    {
        // Form เพิ่ม ผู้ทำคำรับรอง และ ผู้รับคำรับรอง ระดับกรม อาจจะมีมากกว่า 1 คน
		$year=$this->session->userdata('sessyear');
		$data['warranty']=$this->managewarranty_model->get_warranty(array('year'=>$year,'flag'=>1));
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit(); */
		$data['alert']=$alert;
		$this->load->view('managewarranty/managewarranty_depart_view',$data);
    }

	function add_ratification_depart()
	{
		$data['department'] = $this->managewarranty_model->get_data('*','department');
		$this->load->view('managewarranty/add_managewarranty_depart_view',$data);
	}
	
	function save_ratification_depart()
	{
		$department_id=$this->input->post('department_id');
		
		$recip_employee_id=$this->input->post('recip_employee_id');
		$recip_possition_name=$this->input->post('recip_possition_name');
		
		$maker_employee_id=$this->input->post('maker_employee_id');
		$maker_possition_name=$this->input->post('maker_possition_name');	
		
		$warranty=array('year'=>$this->session->userdata('sessyear'),
						'department_id'=>$department_id,
						'flag'=>1
						);
		$warranty_id=$this->managewarranty_model->save_warranty($warranty);
		/* echo '<pre>';
		print_r($warranty_id);
		echo '</pre>';
		exit(); */
		$num=count($recip_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id[0]['warranty_id'],
						  'user_id'=>$recip_employee_id[$i],
						  'position_name'=>$recip_possition_name[$i],
						  'status'=>1
						  );

		}
		
		$num=count($maker_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id[0]['warranty_id'],
						  'user_id'=>$maker_employee_id[$i],
						  'position_name'=>$maker_possition_name[$i],
						  'status'=>2
						  );

		}
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit(); */
		
		if($this->managewarranty_model->save_warranty_data($data)){
			redirect('managewarranty/department/save_war_dep_success');
		}else{
			echo 'no';
		}
		
		
	}
	
	function edit_ratification_depart($warranty_id)
	{
		$data['department'] = $this->managewarranty_model->get_data('*','department');
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>1);
		$data['recip_employee']=$this->managewarranty_model->get_data_edit_warranty_dep($where);
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>2);
		$data['maker_employee']=$this->managewarranty_model->get_data_edit_warranty_dep($where);
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit(); */
		$this->load->view('managewarranty/edit_managewarranty_depart_view',$data);
	}
	
	function update_ratification_depart()
	{
		$warranty_id=$this->input->post('warranty_id');
		$department_id=$this->input->post('department_id');
		
		$warranty[]=array('warranty_id'=>$warranty_id,
						  'department_id'=>$department_id
						  );
						
		/* print_r($warranty);
		exit(); */
		$this->managewarranty_model->update_warranty($warranty);
		
		$recip_employee_id=$this->input->post('recip_employee_id');
		$recip_possition_name=$this->input->post('recip_possition_name');
		
		$maker_employee_id=$this->input->post('maker_employee_id');
		$maker_possition_name=$this->input->post('maker_possition_name');
		
		$num=count($recip_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id,
						  'user_id'=>$recip_employee_id[$i],
						  'position_name'=>$recip_possition_name[$i],
						  'status'=>1
						  );

		}
		
		$num=count($maker_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id,
						  'user_id'=>$maker_employee_id[$i],
						  'position_name'=>$maker_possition_name[$i],
						  'status'=>2
						  );

		}
		if($this->managewarranty_model->delete_data_where('warranty_data',array('warranty_id'=>$warranty_id))){
			if($this->managewarranty_model->save_warranty_data($data)){
				redirect('managewarranty/department/update_war_dep_success');
			}else{
				echo 'no';
			}
		}else{
			echo 'no';
		}
	}
	
	function data_ratification_depart_fancybox($warranty_id)
	{
		
		$data['data_warranty']=$this->managewarranty_model->get_data_warranty_dep($warranty_id);
		//$data['data_warranty']=$warranty_id;
		$this->load->view('managewarranty/data_managewarranty_depart_view',$data);
	}
	
	function delete_ratification_depart($warranty_id)
	{
		
		$this->db->trans_begin();
		
		$this->managewarranty_model->delete_data_where('warranty_data',array('warranty_id'=>$warranty_id));
		$this->managewarranty_model->delete_data_where('warranty',array('warranty_id'=>$warranty_id));
		
		$this->db->trans_complete();
		if($this->db->trans_status()){
			redirect('managewarranty/department/delete_war_dep_success');
		}else{
			echo 'no';
			exit();
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													division
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


    function division($alert=null)
    {
        // Form เพิ่ม ผู้ทำคำรับรอง และ ผู้รับคำรับรอง ระดับกอง อาจจะมีมากกว่า 1 คน   
		$year=$this->session->userdata('sessyear');
		$data['division']=$this->managewarranty_model->get_division(array('year'=>$year,'flag'=>2));
		//$data['warranty']=$this->managewarranty_model->get_warranty(array('year'=>$year,'flag'=>1));
		$data['alert']=$alert;
		$this->load->view('managewarranty/managewarranty_divis_view',$data);
    }
	function add_ratification_divis()
	{
		$data['division'] = $this->managewarranty_model->get_data('*','division');
		$this->load->view('managewarranty/add_managewarranty_divis_view',$data);
	}

	function save_ratification_divis()
	{
		$division_id=$this->input->post('division_id');
		
		$recip_employee_id=$this->input->post('recip_employee_id');
		$recip_possition_name=$this->input->post('recip_possition_name');
		
		$maker_employee_id=$this->input->post('maker_employee_id');
		$maker_possition_name=$this->input->post('maker_possition_name');	
		
		$warranty=array('year'=>$this->session->userdata('sessyear'),
						'division_id'=>$division_id,
						'flag'=>2
						);
		$warranty_id=$this->managewarranty_model->save_warranty($warranty);
		/* echo '<pre>';
		print_r($warranty_id);
		echo '</pre>';
		exit(); */
		$num=count($recip_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id[0]['warranty_id'],
						  'user_id'=>$recip_employee_id[$i],
						  'position_name'=>$recip_possition_name[$i],
						  'status'=>1
						  );

		}
		
		$num=count($maker_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id[0]['warranty_id'],
						  'user_id'=>$maker_employee_id[$i],
						  'position_name'=>$maker_possition_name[$i],
						  'status'=>2
						  );

		}
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit(); */
		
		if($this->managewarranty_model->save_warranty_data($data)){
			redirect('managewarranty/division/save_war_div_success');
		}else{
			echo 'no';
		}
		
		
	}
	
	function data_ratification_divis_fancybox($warranty_id)
	{
		
		$data['data_warranty']=$this->managewarranty_model->get_data_warranty_div($warranty_id);
		/* echo '<pre>';
		print_r($warranty_id);
		print_r($data);
		echo '</pre>';
		exit(); */
		$this->load->view('managewarranty/data_managewarranty_divis_view',$data);
	}
	
	function edit_ratification_divis($warranty_id)
	{
		$data['division'] = $this->managewarranty_model->get_data('*','division');
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>1);
		$data['recip_employee']=$this->managewarranty_model->get_data_edit_warranty_div($where);
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>2);
		$data['maker_employee']=$this->managewarranty_model->get_data_edit_warranty_div($where);
		/* echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit(); */
		$this->load->view('managewarranty/edit_managewarranty_divis_view',$data);
	}
	
	function update_ratification_divis()
	{
		$warranty_id=$this->input->post('warranty_id');
		$division_id=$this->input->post('division_id');
		
		$warranty[]=array('warranty_id'=>$warranty_id,
						  'division_id'=>$division_id
						  );
						
		/* print_r($warranty);
		exit(); */
		$this->managewarranty_model->update_warranty($warranty);
		
		$recip_employee_id=$this->input->post('recip_employee_id');
		$recip_possition_name=$this->input->post('recip_possition_name');
		
		$maker_employee_id=$this->input->post('maker_employee_id');
		$maker_possition_name=$this->input->post('maker_possition_name');
		
		$num=count($recip_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id,
						  'user_id'=>$recip_employee_id[$i],
						  'position_name'=>$recip_possition_name[$i],
						  'status'=>1
						  );

		}
		
		$num=count($maker_employee_id);
		for($i=0;$i<$num;$i++){
			$data[]=array('warranty_id'=>$warranty_id,
						  'user_id'=>$maker_employee_id[$i],
						  'position_name'=>$maker_possition_name[$i],
						  'status'=>2
						  );

		}
		if($this->managewarranty_model->delete_data_where('warranty_data',array('warranty_id'=>$warranty_id))){
			if($this->managewarranty_model->save_warranty_data($data)){
				redirect('managewarranty/division/update_war_div_success');
			}else{
				echo 'no';
			}
		}else{
			echo 'no';
		}
	}
	
	function delete_ratification_divis($warranty_id)
	{
		
		$this->db->trans_begin();
		
		$this->managewarranty_model->delete_data_where('warranty_data',array('warranty_id'=>$warranty_id));
		$this->managewarranty_model->delete_data_where('warranty',array('warranty_id'=>$warranty_id));
		
		$this->db->trans_complete();
		if($this->db->trans_status()){
			redirect('managewarranty/division/delete_war_div_success');
		}else{
			echo 'no';
			exit();
		}
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//													gen docs
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	function gen_warranty_depart_docx($warranty_id)
	{
		$warranty=$this->managewarranty_model->get_data_where('*','warranty',array('warranty_id'=>$warranty_id));
		//$data_warranty=$this->managewarranty_model->get_data_warranty($warranty_id);
		
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>1);
		$recip_employee=$this->managewarranty_model->get_data_edit_warranty_dep($where);
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>2);
		$maker_employee=$this->managewarranty_model->get_data_edit_warranty_dep($where);
		
		
		/* echo '<pre>';
		print_r($warranty);
		print_r($recip_employee);
		print_r($maker_employee);
		echo '</pre>';
		exit(); */
		$PHPWord = new PHPWord();
		$PHPWord->setDefaultFontName('Cordia New');
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addFontStyle('HeadStyle', array('bold'=>true,'size'=>18));
		
		$HeadTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		$ContentTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		$style=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		
		$PHPWord->addParagraphStyle('TextLongStyle', array('align'=>'both','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addParagraphStyle('TextShortStyle', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addTableStyle('myOwnTableStyle',array('borderSize'=>6,'borderColor'=>'000000','valign'=>'center','cellMarginTop'=>80,'cellMarginLeft'=>80,'cellMarginRight'=>80,'cellMarginBottom'=>0));
		
		$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
		// New portrait section
		$section = $PHPWord->createSection();
		$department=$recip_employee[0]['name'];
		$section->addImage('images/garuda_logo.png',array('width'=>100, 'height'=>100, 'align'=>'center'));
		$section->addText('คำรับรองการปฏิบัติราชการ', 'HeadStyle',array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText($department, 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('ประจำปีงบประมาณ พ.ศ. '.$warranty[0]['year'], 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1);
		
		//$section->addText('1. คำรับรองระหว่าง ');
		
		$section->addListItem('คำรับรองระหว่าง ', 0,null,$listStyle);
		
		//$section->addText('');
		
		$table = $section->addTable();
		$name_pos_recip='';
		$name_recip='';
		$num=count($recip_employee);
		for($i=0;$i<$num;$i++){
			$table->addRow();
			$table->addCell(4000)->addText('         '.$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME']);
			$table->addCell(4000)->addText($recip_employee[$i]['position_name']);
			$table->addCell(3000)->addText('ผู้รับคำรับรอง');
			$name_pos_recip.=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'].' ในฐานะ'.$recip_employee[$i]['position_name'];
			if($i!=($num-1)) $name_pos_recip.=' และ';
			$name_recip.=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'];
			if($i!=($num-1)) $name_recip.=' และ';
			$user_name[]=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'];
			$user_position[]=$recip_employee[$i]['position_name'];
		}
		
		$table->addRow();
		$table->addCell(180000, array('gridSpan' => 3))->addText('และ',null,array('align'=>'center'));
		
		$name_pos_maker='';
		$name_maker='';
		$num=count($maker_employee);
		for($i=0;$i<$num;$i++){
			$table->addRow();
			$table->addCell(4000)->addText('         '.$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME']);
			$table->addCell(4000)->addText($maker_employee[$i]['position_name']);
			$table->addCell(3000)->addText('ผู้ทำคำรับรอง');
			$name_pos_maker.=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'].' '.$maker_employee[$i]['position_name'];
			if($i!=($num-1)) $name_pos_maker.=' และ';
			$name_maker.=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'];
			if($i!=($num-1)) $name_maker.=' และ';
			$user_name[]=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'];
			$user_position[]=$maker_employee[$i]['position_name'];
		}
		
		//$section->addText('');
		
		/* $section->addText('2. คำรับรองนี้เป็นคำรับรองฝ่ายเดียว มิใช่สัญญาและใช้สำหรับระยะเวลา 1 ปี เริ่มตั้งแต่วันที่',null,'TextShortStyle');
		$section->addText('    1 ตุลาคม '.($warranty[0]['year']-1).' ถึงวันที่ 30 กันยายน '.$warranty[0]['year'],null,'TextShortStyle'); */
		$text2='คำรับรองนี้เป็นคำรับรองฝ่ายเดียว มิใช่สัญญาและใช้สำหรับระยะเวลา 1 ปี เริ่มตั้งแต่วันที่ 1 ตุลาคม'.($warranty[0]['year']-1).' ถึงวันที่ 30 กันยายน '.$warranty[0]['year'];
		$section->addListItem($text2, 0,null,$listStyle);
		
		//$section->addText('');

		/* $section->addText('3. รายละเอียดของคำรับรอง ได้แก่ กรอบการประเมินผล ประเด็นการประเมินผลการปฏิบัติราชการ',null,'TextShortStyle');
		$section->addText('    น้ำหนัก ตัวชี้วัดผลการปฏิบัติราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ',null,'TextShortStyle');
		$section->addText('    ตามที่ปรากฏอยู่ในเอกสารประกอบท้ายคำรับรองนี้',null,'TextShortStyle'); */
		
		$text3='รายละเอียดของคำรับรอง ได้แก่ กรอบการประเมินผล ประเด็นการประเมินผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่ปรากฏอยู่ในเอกสารประกอบท้ายคำรับรองนี้';
		$section->addListItem($text3, 0,null,$listStyle);
		
		//$section->addText('');
		
		/* $section->addText('4. '.$name_pos_recip.'และผู้บังคับบัญชาของ',null,'TextShortStyle');
		$section->addText('    '.$name_pos_maker,null,'TextShortStyle');
		$section->addText('    ได้พิจารณาและเห็นชอบกับแผนปฏิบัติราชการและแนวทางการพัฒนาการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการของกรมยุโรป ประเด็นการประเมิลผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่กำหนดในเอกสารประกอบ',null,'TextShortStyle');
		$section->addText('    ท้ายคำรับรองนี้ และข้าพเจ้ายินดีจะให้คำแนะนำกำกับ และตรวจสอบผลการปฏิบัติราชการของ',null,'TextShortStyle');
		$section->addText('    '.$name_pos_maker.' ให้เป็นไปตามคำรับรองที่จัดทำขึ้นนี้',null,'TextShortStyle'); */
		
		$text4='ข้าพเจ้า '.$name_pos_recip.'และผู้บังคับบัญชาของ'.$name_pos_maker.'ได้พิจารณาและเห็นชอบกับแผนปฏิบัติราชการและแนวทางการพัฒนาการปฏิบัติราชการของ'.$department.' ประเด็นการประเมินผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติ';
		$text4.='ราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่กำหนดในเอกสารประกอบท้ายคำรับรองนี้ และข้าพเจ้ายินดีจะให้คำแนะนำกำกับ และตรวจสอบผลการปฏิบัติราชการของ '.$name_maker.' ให้เป็นไปตามคำรับรองที่จัดทำขึ้นนี้';
		$section->addListItem($text4, 0,null,$listStyle);
		
		//$section->addText('');
		
		/* $section->addText('5. ข้าพเจ้า นายวิชาวัฒน์ อิศรภัคดี รองปลัดกระทรวงการต่างประเทศที่กำกับดูแลกรมยุโรป และ',null,'TextShortStyle');
		$section->addText('    นายศรัณย์ เจริญสุวรรณ อธิบดีกรมยุโรป ได้ทำความเข้าใจคำรับรองตาม 3 แล้ว ขอให้คำรับรองกับ',null,'TextShortStyle');
		$section->addText('    ปลัดกระทรวงการต่างประเทศ ว่าจะมุ่งมั่นปฏิบัติราชการให้เกิดผลงานที่ดีตามเป้าหมายของตัวชี้วัด',null,'TextShortStyle');
		$section->addText('    แต่ละตัวในระดับสูงสุด เพื่อให้เกิดประโยชน์สุขแก่ประชาชน ตามที่ให้คำรับรองไว้',null,'TextShortStyle'); */
		
		$text5='ข้าพเจ้า '.$name_pos_maker.'ได้ทำความเข้าใจคำรับรองตาม 3 แล้ว ขอให้คำรับรองกับปลัดกระทรวงการต่างประเทศ ว่าจะมุ่งมั่นปฏิบัติราชการให้เกิดผลงานที่ดีตามเป้าหมายของตัวชี้วัด';
		$text5.='แต่ละตัวในระดับสูงสุด เพื่อให้เกิดประโยชน์สุขแก่ประชาชน ตามที่ให้คำรับรองไว้';
		$section->addListItem($text5, 0,null,$listStyle);
		
		//$section->addText('');
		
		/* $section->addText('6. ผู้รับคำรับรองและผู้ทำคำรับรองได้เข้าใจคำรับรองการปฏิบัติราชการและเห็นพ้องกันแล้ว',null,'TextShortStyle');
		$section->addText('    จึงได้ลงลายมือชื่อไว้เป็นสำคัญ',null,'TextShortStyle'); */
		$text6='ผู้รับคำรับรองและผู้ทำคำรับรองได้เข้าใจคำรับรองการปฏิบัติราชการและเห็นพ้องกันแล้ว จึงได้ลงลายมือชื่อไว้เป็นสำคัญ';
		$section->addListItem($text6, 0,null,$listStyle);
		
		$section->addTextBreak(2);
		$st=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		
		$num_table=count($user_name);
		for($i=0;$i<$num_table;$i++){
			$table = $section->addTable();
			$table->addRow();
			$table->addCell(4600)->addText('…………………………………………………',null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText('…………………………………………………',null,$st);

			$table->addRow();
			$table->addCell(4600)->addText('( '.$user_name[$i].' )',null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText('( '.$user_name[($i+1)].' )',null,$st);
			
			$table->addRow();
			$table->addCell(4600)->addText($user_position[$i],null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText($user_position[($i+1)],null,$st);
			
			
			$table->addRow();
			$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
			if(isset($user_name[++$i]))
			$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
			$section->addTextBreak(1);
		}
		/* $table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายสีหศักดิ์ พวงเกตุแก้ว )',null,$st);
		$table->addCell(4600)->addText('( นายวิชาวัฒน์ อิศรภัคดี )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('ปลัดกระทรวงการต่างประเทศ',null,$st);
		$table->addCell(4600)->addText('รองปลัดกระทรวงการต่างประเทศ',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st); */
		
		/* $section->addTextBreak(1);
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายศรัณย์ เจริญสุวรรณ )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('อธิบดีกรมยุโรป',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st); */
		
		
		// ------------------------------new page -------------------------------------------------------
		
		
		$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER);
		$section = $PHPWord->createSection(array('orientation'=>'landscape'));
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addParagraphStyle('Textcenter', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));
		
		$section->addText('เอกสารแนบ',array('underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),array('align'=>'right','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('ตัวชี้วัดที่ 1 "ระดับความสำเร็จของการพัฒนาระบบราชการของกระทรวงฯ"',null,'TextShortStyle');
		$section->addText('');
		$section->addText('ประเด็นความสำเร็จ',array('bold'=>true,'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),'TextShortStyle');
		$section->addListItem('ความคืบหน้าของการจัดตั้งกรมความร่วมมือระหว่างประเทศ', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จในการจัดตั้งกองยุทธศาสตร์และความร่วมมืออาเซียน', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จในการจัดทำร่างแผนยุทธศาสตร์กระทรวงฯ(พ.ศ. 2556 - 2559)', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จของการให้คำปรึกษาและคำแนะนำในการพัฒนาประสิทธิภาพการปฏิบัติงานและคุณภาพการบริหารจัดการแก่หน่วยงานต่างๆ ของกระทรวงฯ', 0,null,$listStyle);
		$section->addListItem('ระดับความสำเร็จของการจัดทำคู่มือการตรวจราชการและการบริหารราชการในต่างประเมศแบบบูรณาการ', 0,null,$listStyle);
		
		$table = $section->addTable('myOwnTableStyle');
		
		$table->addRow();
		$table->addCell(7000)->addText('เกณฑ์การให้คะแนน',array('bold'=>true),'Textcenter');
		$table->addCell(3000)->addText('คะแนน',array('bold'=>true),'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 1 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('1',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 2 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('2',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 3 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('3',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 4 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('4',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 5 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('5',null,'Textcenter');
		
		
		
		
		
		// ------------------------------new page -------------------------------------------------------
		

		/* $section = $PHPWord->createSection(array('orientation'=>'landscape','marginTop'=>550,'marginBottom'=>550));
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addParagraphStyle('Textcenter', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));
		$section->addText('แบบประเมินผลการปฏิบัติราชการตามคำรับรองประจำปีงบประมาณ 2556',array('bold'=>true,'size'=>16),array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));
		$section->addText('กรมยุโรป', array('bold'=>true,'size'=>16),array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));

		$table = $section->addTable();
		$table->addRow();
		$table->addCell(8000)->addText('      ชื่อผู้รับการประเมิน  นายศรัณย์ เจริญสุวรรณ',null,array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$table->addCell(8000)->addText('ลงนาม ………………………………………………………………………',null,array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'right'));
		$table->addRow();
		$table->addCell(8000)->addText('      ชื่อผู้บังคับบัญชา/ผู้ประเมิน  นายวิชาวัฒน์ อิศรภัคดี',null,array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$table->addCell(8000)->addText('ลงนาม ………………………………………………………………………',null,array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'right'));
		
		$section->addTextBreak(0);
		
		$table = $section->addTable('myOwnTableStyle');
		$table->addRow();
		$table->addCell(500,array('vMerge' => 'restart','valign'=>'center'))->addText('ที่',array('bold'=>true),$HeadTables);
		$table->addCell(7000,array('vMerge' => 'restart','valign'=>'center'))->addText('ตัวชี้วัดผลงาน',array('bold'=>true),$HeadTables);
		$table->addCell(4000, array('gridSpan' => 5))->addText('คะแนนตามระดับค่าเป้าหมาย',array('bold'=>true),$HeadTables);
		$table->addCell(1500,array('vMerge' => 'restart','valign'=>'center'))->addText('คะแนน (ก)',array('bold'=>true),$HeadTables);
		$table->addCell(1500,array('vMerge' => 'restart','valign'=>'center'))->addText('น้ำหนัก (ข)',array('bold'=>true),$HeadTables);
		$table->addCell(1500)->addText('คะแนนรวม',array('bold'=>true),$HeadTables);
		$table->addRow();
		$table->addCell(null,array('vMerge' => 'fusion'));
		$table->addCell(null,array('vMerge' => 'fusion'));
		$table->addCell(800)->addText('1',array('bold'=>true),$HeadTables);
		$table->addCell(800)->addText('2',array('bold'=>true),$HeadTables);
		$table->addCell(800)->addText('3',array('bold'=>true),$HeadTables);
		$table->addCell(800)->addText('4',array('bold'=>true),$HeadTables);
		$table->addCell(800)->addText('5',array('bold'=>true),$HeadTables);
		$table->addCell(null,array('vMerge' => 'fusion'));
		$table->addCell(null,array('vMerge' => 'fusion'));
		$table->addCell(null)->addText('(ก x ข)',array('bold'=>true),$HeadTables);
		$table->addRow();
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('มิติภายนอก',array('bold'=>true),array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('0.50',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addRow();
		$table->addCell(null)->addText('1.1',null,'Textcenter');
		$table->addCell(null)->addText('ระดับความสำเร็จในการส่งเสริมความสัมพันธ์อันดีกับประเทศสมาชิกสหภาพยุโรป (*)',null,'TextShortStyle');
		$table->addCell(null)->addText('1',null,'Textcenter');
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.25',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('1.2',null,'Textcenter');
		$table->addCell(null)->addText('ระดับความสำเร็จในการส่งเสริมความสัมพันธ์อันดีกับประเทศสหพันธรัฐรัสเซีย (*)',null,'TextShortStyle');
		$table->addCell(null)->addText('1',null,'Textcenter');
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.25',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('มิติภายใน',array('bold'=>true),$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null)->addText('0.50',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addRow();
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('ร้อยละความพึงพอใจของผู้รับบริการและผู้มีส่วนได้ส่วนเสีย',null,'TextShortStyle');
		$table->addCell(null)->addText('40',null,'Textcenter');
		$table->addCell(null)->addText('50',null,'Textcenter');
		$table->addCell(null)->addText('60',null,'Textcenter');
		$table->addCell(null)->addText('60',null,'Textcenter');
		$table->addCell(null)->addText('70',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.10',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('ระดับความสำเร็จของการมีส่วนร่วมในการพัฒนาระบบราชการของกระทรวงฯ',null,'TextShortStyle');
		$table->addCell(null)->addText('1',null,'Textcenter');
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.10',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('ระดับความสำเร็จของการจัดทำ IPA ของหน่วยงาน',null,'TextShortStyle');
		$table->addCell(null)->addText('1',null,'Textcenter');
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.10',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('ระดับความสำเร็จของการจัดทำแผนการใช้จ่ายงบประมาณและรายงานการติดตามผลรายไตรมาส',null,'TextShortStyle');
		$table->addCell(null)->addText('1',null,'Textcenter');
		$table->addCell(null)->addText('2',null,'Textcenter');
		$table->addCell(null)->addText('3',null,'Textcenter');
		$table->addCell(null)->addText('4',null,'Textcenter');
		$table->addCell(null)->addText('5',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.10',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('6',null,'Textcenter');
		$table->addCell(null)->addText('ร้อยละของการเบิกจ่ายเงินงบประมาณให้เป็นไปตามเป้าหมายที่รัฐบาลกำหนด',null,'TextShortStyle');
		$table->addCell(null)->addText('92',null,'Textcenter');
		$table->addCell(null)->addText('93',null,'Textcenter');
		$table->addCell(null)->addText('94',null,'Textcenter');
		$table->addCell(null)->addText('95',null,'Textcenter');
		$table->addCell(null)->addText('96',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addCell(null)->addText('0.10',null,'Textcenter');
		$table->addCell(null)->addText('',null,'Textcenter');
		$table->addRow();
		$table->addCell(null)->addText('',null,$HeadTables);
		$table->addCell(null,array('gridSpan' => 7))->addText('รวม',array('bold'=>true,'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),$HeadTables);
		$table->addCell(null)->addText('1.00',null,$HeadTables);
		$table->addCell(null)->addText('',null,$HeadTables);
		$textrun = $section->createTextRun($style);
		$textrun->addText('      ');
		$textrun->addText('หมายเหตุ',array('underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),'TextShortStyle');
		$section->addText('      (*) รายละเอียดเกณฑ์การให้คะแนน ตามที่ปรากฏในคำรับรองฯ ระดับกระทรวงฯ',null,'TextShortStyle'); */

		$file_name=uniqid('managewarranty',true).'.docx';
		$path='docs/word'.$file_name;
		
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save($path);

		//$file['full_path']=$_SERVER['DOCUMENT_ROOT'].'/'.$path;
		$file['full_path']=$_SERVER['DOCUMENT_ROOT'].'/psdg/'.$path;
		$file['file_name']=$file_name;
		
		$this->download_file($file);
		
		
	}
	
	function gen_warranty_divis_docx($warranty_id)
	{
		$warranty=$this->managewarranty_model->get_data_where('*','warranty',array('warranty_id'=>$warranty_id));
		
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>1);
		$recip_employee=$this->managewarranty_model->get_data_edit_warranty_div($where);
		$where=array('warranty.warranty_id'=>$warranty_id,'status'=>2);
		$maker_employee=$this->managewarranty_model->get_data_edit_warranty_div($where);
		
		$PHPWord = new PHPWord();
		$PHPWord->setDefaultFontName('Cordia New');
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addFontStyle('HeadStyle', array('bold'=>true,'size'=>18));
		
		$HeadTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		$ContentTables=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		$style=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0);
		$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
		$PHPWord->addParagraphStyle('TextLongStyle', array('align'=>'both','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addParagraphStyle('TextShortStyle', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$PHPWord->addTableStyle('myOwnTableStyle',array('borderSize'=>6,'borderColor'=>'000000','valign'=>'center','cellMarginTop'=>80,'cellMarginLeft'=>80,'cellMarginRight'=>80,'cellMarginBottom'=>0));
		
		// New portrait section
		$section = $PHPWord->createSection();
		
		$section->addImage('images/garuda_logo.png',array('width'=>100, 'height'=>100, 'align'=>'center'));
		$section->addText('คำรับรองการปฏิบัติราชการ', 'HeadStyle',array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('กลุ่มพัฒนาระบบบริหาร', 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('กระทรวงการต่างประเทศ', 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('ประจำปีงบประมาณ พ.ศ. '.$warranty[0]['year'], 'HeadStyle', array('align'=>'center','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addTextBreak(1);
		
		$section->addListItem('คำรับรองระหว่าง ', 0,null,$listStyle);
		
		$table = $section->addTable();
		unset($user_name);
		unset($user_position);
		$name_pos_recip='';
		$name_recip='';
		$num=count($recip_employee);
		for($i=0;$i<$num;$i++){
			$table->addRow();
			$table->addCell(4000)->addText('         '.$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME']);
			$table->addCell(4000)->addText($recip_employee[$i]['position_name']);
			$table->addCell(3000)->addText('ผู้รับคำรับรอง');
			$name_pos_recip.=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'].' ในฐานะ'.$recip_employee[$i]['position_name'];
			if($i!=($num-1)) $name_pos_recip.=' และ';
			$name_recip.=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'];
			if($i!=($num-1)) $name_recip.=' และ';
			$user_name[]=$recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME'];
			$user_position[]=$recip_employee[$i]['position_name'];
		}
		
		$table->addRow();
		$table->addCell(180000, array('gridSpan' => 3))->addText('และ',null,array('align'=>'center'));
		
		$name_pos_maker='';
		$name_maker='';
		$num=count($maker_employee);
		for($i=0;$i<$num;$i++){
			$table->addRow();
			$table->addCell(4000)->addText('         '.$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME']);
			$table->addCell(4000)->addText($maker_employee[$i]['position_name']);
			$table->addCell(3000)->addText('ผู้ทำคำรับรอง');
			$name_pos_maker.=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'].' '.$maker_employee[$i]['position_name'];
			if($i!=($num-1)) $name_pos_maker.=' และ';
			$name_maker.=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'];
			if($i!=($num-1)) $name_maker.=' และ';
			$user_name[]=$maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME'];
			$user_position[]=$maker_employee[$i]['position_name'];
		}
		
		
		
		/* $section->addText('2. คำรับรองนี้เป็นคำรับรองฝ่ายเดียว มิใช่สัญญาและใช้สำหรับระยะเวลา 1 ปี เริ่มตั้งแต่วันที่',null,'TextShortStyle');
		$section->addText('    1 ตุลาคม '.($warranty[0]['year']-1).' ถึงวันที่ 30 กันยายน '.$warranty[0]['year'],null,'TextShortStyle'); */
		$text2='คำรับรองนี้เป็นคำรับรองฝ่ายเดียว มิใช่สัญญาและใช้สำหรับระยะเวลา 1 ปี เริ่มตั้งแต่วันที่ 1 ตุลาคม'.($warranty[0]['year']-1).' ถึงวันที่ 30 กันยายน '.$warranty[0]['year'];
		$section->addListItem($text2, 0,null,$listStyle);
		
		/* $section->addText('3. รายละเอียดของคำรับรอง ได้แก่ กรอบการประเมินผล ประเด็นการประเมินผลการปฏิบัติราชการ',null,'TextShortStyle');
		$section->addText('    น้ำหนัก ตัวชี้วัดผลการปฏิบัติราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ',null,'TextShortStyle');
		$section->addText('    ตามที่ปรากฏอยู่ในเอกสารประกอบท้ายคำรับรองนี้',null,'TextShortStyle'); */
		$text3='รายละเอียดของคำรับรอง ได้แก่ กรอบการประเมินผล ประเด็นการประเมินผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่ปรากฏอยู่ในเอกสารประกอบท้ายคำรับรองนี้';
		$section->addListItem($text3, 0,null,$listStyle);
		
		
		/* $section->addText('4. ข้าพเจ้า นายสีหศักดิ์ พวงเกตุแก้ว ในฐานะปลัดกระทรวงการต่างประเทศและผู้บังคับบัญชาของ',null,'TextShortStyle');
		$section->addText('    นายวิชาวัฒน์ อิศรภัคดี รองปลัดกระทรวงที่กำกับดูแลกรมยุโรป และนายศรัณย์ เจริญสุวรรณ',null,'TextShortStyle');
		$section->addText('    อธิบดีกรมยุโรป ได้พิจารณาและเห็นชอบกับแผนปฏิบัติราชการและแนวทางการพัฒนาการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการของกรมยุโรป ประเด็นการประเมิลผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติ',null,'TextShortStyle');
		$section->addText('    ราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่กำหนดในเอกสารประกอบ',null,'TextShortStyle');
		$section->addText('    ท้ายคำรับรองนี้ และข้าพเจ้ายินดีจะให้คำแนะนำกำกับ และตรวจสอบผลการปฏิบัติราชการของ',null,'TextShortStyle');
		$section->addText('    นายวิชาวัฒน์ อิศรภัคดี และนายศรัณย์ เจริญสุวรรณ ให้เป็นไปตามคำรับรองที่จัดทำขึ้นนี้',null,'TextShortStyle'); */
		$text4='ข้าพเจ้า '.$name_pos_recip.'และผู้บังคับบัญชาของ'.$name_pos_maker.'ได้พิจารณาและเห็นชอบกับแผนปฏิบัติราชการและแนวทางการพัฒนาการปฏิบัติราชการของ'.$department.' ประเด็นการประเมินผลการปฏิบัติราชการ น้ำหนัก ตัวชี้วัดผลการปฏิบัติ';
		$text4.='ราชการ เป้าหมาย เกณฑ์การให้คะแนน และรายละเอียดอื่น ๆ ตามที่กำหนดในเอกสารประกอบท้ายคำรับรองนี้ และข้าพเจ้ายินดีจะให้คำแนะนำกำกับ และตรวจสอบผลการปฏิบัติราชการของ '.$name_maker.' ให้เป็นไปตามคำรับรองที่จัดทำขึ้นนี้';
		$section->addListItem($text4, 0,null,$listStyle);
		
		
		/* $section->addText('5. ข้าพเจ้า นายวิชาวัฒน์ อิศรภัคดี รองปลัดกระทรวงการต่างประเทศที่กำกับดูแลกรมยุโรป และ',null,'TextShortStyle');
		$section->addText('    นายศรัณย์ เจริญสุวรรณ อธิบดีกรมยุโรป ได้ทำความเข้าใจคำรับรองตาม 3 แล้ว ขอให้คำรับรองกับ',null,'TextShortStyle');
		$section->addText('    ปลัดกระทรวงการต่างประเทศ ว่าจะมุ่งมั่นปฏิบัติราชการให้เกิดผลงานที่ดีตามเป้าหมายของตัวชี้วัด',null,'TextShortStyle');
		$section->addText('    แต่ละตัวในระดับสูงสุด เพื่อให้เกิดประโยชน์สุขแก่ประชาชน ตามที่ให้คำรับรองไว้',null,'TextShortStyle'); */
		$text5='ข้าพเจ้า '.$name_pos_maker.'ได้ทำความเข้าใจคำรับรองตาม 3 แล้ว ขอให้คำรับรองกับปลัดกระทรวงการต่างประเทศ ว่าจะมุ่งมั่นปฏิบัติราชการให้เกิดผลงานที่ดีตามเป้าหมายของตัวชี้วัด';
		$text5.='แต่ละตัวในระดับสูงสุด เพื่อให้เกิดประโยชน์สุขแก่ประชาชน ตามที่ให้คำรับรองไว้';
		$section->addListItem($text5, 0,null,$listStyle);
		
		/* $section->addText('6. ผู้รับคำรับรองและผู้ทำคำรับรองได้เข้าใจคำรับรองการปฏิบัติราชการและเห็นพ้องกันแล้ว',null,'TextShortStyle');
		$section->addText('    จึงได้ลงลายมือชื่อไว้เป็นสำคัญ',null,'TextShortStyle'); */
		$text6='ผู้รับคำรับรองและผู้ทำคำรับรองได้เข้าใจคำรับรองการปฏิบัติราชการและเห็นพ้องกันแล้ว จึงได้ลงลายมือชื่อไว้เป็นสำคัญ';
		$section->addListItem($text6, 0,null,$listStyle);
		
		$section->addTextBreak(2);
		$st=array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center');
		
		$num_table=count($user_name);
		for($i=0;$i<$num_table;$i++){
			$table = $section->addTable();
			$table->addRow();
			$table->addCell(4600)->addText('…………………………………………………',null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText('…………………………………………………',null,$st);

			$table->addRow();
			$table->addCell(4600)->addText('( '.$user_name[$i].' )',null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText('( '.$user_name[($i+1)].' )',null,$st);
			
			$table->addRow();
			$table->addCell(4600)->addText($user_position[$i],null,$st);
			if(isset($user_name[($i+1)]))
			$table->addCell(4600)->addText($user_position[($i+1)],null,$st);
			
			
			$table->addRow();
			$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
			if(isset($user_name[++$i]))
			$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
			$section->addTextBreak(1);
		}
		
		// ------------------------------new page -------------------------------------------------------
		
		
		$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER);
		$section = $PHPWord->createSection(array('orientation'=>'landscape'));
		$PHPWord->setDefaultFontSize(16);
		$PHPWord->addParagraphStyle('Textcenter', array('spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0,'align'=>'center'));
		
		$section->addText('เอกสารแนบ',array('underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),array('align'=>'right','spacing'=>0,'spaceBefore'=>0,'spaceAfter'=>0));
		$section->addText('ตัวชี้วัดที่ 1 "ระดับความสำเร็จของการพัฒนาระบบราชการของกระทรวงฯ"',null,'TextShortStyle');
		$section->addText('');
		$section->addText('ประเด็นความสำเร็จ',array('bold'=>true,'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE),'TextShortStyle');
		$section->addListItem('ความคืบหน้าของการจัดตั้งกรมความร่วมมือระหว่างประเทศ', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จในการจัดตั้งกองยุทธศาสตร์และความร่วมมืออาเซียน', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จในการจัดทำร่างแผนยุทธศาสตร์กระทรวงฯ(พ.ศ. 2556 - 2559)', 0,null,$listStyle);
		$section->addListItem('ความสำเร็จของการให้คำปรึกษาและคำแนะนำในการพัฒนาประสิทธิภาพการปฏิบัติงานและคุณภาพการบริหารจัดการแก่หน่วยงานต่างๆ ของกระทรวงฯ', 0,null,$listStyle);
		$section->addListItem('ระดับความสำเร็จของการจัดทำคู่มือการตรวจราชการและการบริหารราชการในต่างประเมศแบบบูรณาการ', 0,null,$listStyle);
		
		$table = $section->addTable('myOwnTableStyle');
		
		$table->addRow();
		$table->addCell(7000)->addText('เกณฑ์การให้คะแนน',array('bold'=>true),'Textcenter');
		$table->addCell(3000)->addText('คะแนน',array('bold'=>true),'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 1 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('1',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 2 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('2',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 3 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('3',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 4 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('4',null,'Textcenter');
		
		$table->addRow();
		$table->addCell(7000)->addText('สำเร็จ 5 ประเด็นจากประเด็นทั้งหมดที่กำหนดไว้',null,'Textcenter');
		$table->addCell(3000)->addText('5',null,'Textcenter');
		
		
		
		
		
		/* $table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายสีหศักดิ์ พวงเกตุแก้ว )',null,$st);
		$table->addCell(4600)->addText('( นายวิชาวัฒน์ อิศรภัคดี )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('ปลัดกระทรวงการต่างประเทศ',null,$st);
		$table->addCell(4600)->addText('รองปลัดกระทรวงการต่างประเทศ',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st);
		
		$section->addTextBreak(1);
		$table = $section->addTable();
		$table->addRow();
		$table->addCell(4600)->addText('…………………………………………………',null,$st);

		$table->addRow();
		$table->addCell(4600)->addText('( นายศรัณย์ เจริญสุวรรณ )',null,$st);
		
		$table->addRow();
		$table->addCell(4600)->addText('อธิบดีกรมยุโรป',null,$st);
		
		
		$table->addRow();
		$table->addCell(4600)->addText('วันที่ .........................................',null,$st); */
		
		$file_name=uniqid('managewarranty',true).'.docx';
		$path='docs/word'.$file_name;
		
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save($path);

		$file['full_path']=$_SERVER['DOCUMENT_ROOT'].'/psdg/'.$path;
		$file['file_name']=$file_name;
		
		$this->download_file($file);
	}
	
	function download_file($file)
	{
		$data = file_get_contents($file['full_path']);
		$name = $file['file_name'];
		force_download($name,$data);
	}
	
	
	
	
	
}