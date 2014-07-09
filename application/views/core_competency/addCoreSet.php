<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('menu_admin'); ?>
	
	
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">เพิ่มแบบประเมินสมรรณะ</h3>
            </div>
        </div>
        
        <form class="form-horizontal" action="<?php echo site_url('core_competency/saveCoreSet'); ?>" method="POST">
						
		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
					<div class="panel-heading">						
							<div class="form-group row">
									<div class="col-lg-3">
										<label for='coreset_name' class="control-label">ชื่อแบบประเมินสมรรณะ :</label>
									</div>
									<div class="col-lg-6">													
										<input id='coreset_name' type="text" class="form-control" name="coreset_name" required>
									</div>
							</div>
					</div>
                                        
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th style="width: 400px">ชื่อสมรรณะ</th>
                                        <th>คะแนนที่คาดหวัง</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
									<tr>
                                        <td>
                                        <select id="selectSkill" name="skill[]" class="form-control" style="width: 400px">
											<?php if(is_array($skill_array) && count($skill_array) ) {
													foreach($skill_array as $skill){
														echo "<option value=".$skill['ID'].">".$skill['name']."</option>";
													}
												  }
											?>
										</select>	                                        	
                                        </td>
                                        <td><input class="form-control" type="text" name="expectVal[]"></td>
										<td>
										<button type="button" class="btn btn-success" onclick="addSkill();"> เพิ่มหัวข้อสมรรณะ  </button>																					
										</td>
                                    </tr>
                                </tbody>
							</table>
							
							<div class="form-group row">									
									<div class="col-lg-4 col-lg-offset-5">
										<input type="submit" class="btn btn-primary" value="บันทึก">
										<a href="<?php echo site_url('core_competency/manageCoreSet'); ?>" class="btn btn-danger">ยกเลิก</a>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
								

	   </form>		
	</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>

<script type="text/javascript" charset="utf-8">
	var numrow = 0;
	function addSkill() {
		numrow++;
		$('#skillTable').append('<tr id="skillRow' + numrow +'"><td>'
							+ '<select id="selectSkill" name="skill[]" class="form-control" style="width: 400px">'
							<?php if(is_array($skill_array) && count($skill_array) ) {
									foreach($skill_array as $skill){
										echo "+ '<option value=\"".$skill['ID']."\">".$skill['name']."</option>'\n";
									}
								  }
							?>
							+ '</select>'							
							+ '</td>'
							+ '<td><input class="form-control" type="text" name="expectVal[]" required></td>'
							+ '<td><button type="button" class="btn btn-danger" onclick="deleteSkill('
							+ numrow + ')"> ลบหัวข้อสมรรณะ  </button></td>'
                            + '</tr>'
		);       						
	}
	
	function deleteSkill(rnum) {
		$('#skillRow'+rnum).remove();
	}
	
</script>
</body>
</html>