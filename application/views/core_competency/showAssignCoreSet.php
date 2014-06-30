<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
					<div class="panel-heading">
						กำหนดแบบประเมินสมรรณะ
					</div>                                      
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="userTable">
                                <thead>
                                    <tr>
										<th>ชื่อ-นามสกุล</th>
										<th>กรม</th>
										<th>กอง</th>
										<th>ตำแหน่ง</th>
										<th>ชื่อแบบประเมินสมรรณะ</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
									if(is_array($users) && count($users) ) {
									foreach($users as $user){
										
								?>
									<tr>
                                        <td><?php echo $user['PWFNAME']." ".$user['PWLNAME']; ?></td>
                                        <td><?php echo $user['dep_name']; ?></td>
                                        <td><?php echo $user['div_name']; ?></td>
                                        <td><?php echo $user['position_name']." (ระดับ  ".$user['PWLEVEL'].")"; ?></td>
                                        <td><div id="coreset<?php echo $user['userID']; ?>">
                                        	<?php 	if($user['coreset_name'] == null || $user['coreset_name'] == '') {
                                        				echo "-";
                                        			} else {
                                        				echo $user['coreset_name']; 
                                        			}
											?>
                                        	</div>
                                        </td>
										<td>
											<div id="button<?php echo $user['userID']; ?>">
												<button onclick="editAssignCoreSet('<?php echo $user['userID']; ?>', '<?php echo $user['coresetID']?>')" id="coresetUser<?php echo $user['userID']; ?>"  class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไขแบบประเมินสมรรณะ"><span class="glyphicon glyphicon-pencil"></span></button>
											</div>																		
										</td>
                                    </tr>
									<?php } } ?>
                                </tbody>
							</table>							
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>





<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>

<script type="text/javascript" charset="utf-8">
	function editAssignCoreSet(userID, oldValue) {
		var coresetBox = "<select id='select" + userID + "' class='form-control'>"
		<?php
			foreach($coresets as $coreset) {
		?>
				+ "<option value='<?php echo $coreset['ID']; ?>'><?php echo $coreset['name'] ?></option>"
		<?php			
			}			
		?>
					+ "</select>";
			
		
		var saveButton = '<button onclick="saveAssignCoreSet(\'' + userID + '\')"'
			+ ' id="saveButton' + userID + '"  class="btn btn-success btn-sm"'
			+ ' data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top"'
			+ ' rel="tooltip" title="บันทึก">บันทึกข้อมูล</button>';
		
		$('#coreset' + userID).html(coresetBox);
		$('#button'  + userID).html(saveButton);
		$('#select'  + userID).val(oldValue);
	}
	
	function saveAssignCoreSet(userID) {
		var coresetID = $('#select' + userID).val();
		var editButton = '<button onclick="editAssignCoreSet(\'' + userID  + '\', \'' 
			+ coresetID + '\')" id="coresetUser' + userID 
			+ '" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไขแบบประเมินสมรรณะ"><span class="glyphicon glyphicon-pencil"></span></button>';

		//Call ajax to save 
		$.ajax({
			'type' : 	'POST', 
			'url'  : 	'<?php echo site_url("core_competency/saveAssignCoreSet"); ?>',
			'data' :	{ 'userID': userID, 'coreSetID': coresetID },
			'dataType': 'json',
			'error' : 	function(data){ 
						alert('Something wrong with your server.' + data);
            			},
			'success' : function(data){
							$('#button'  + userID).html(editButton);
							$('#coreset' + userID).html(data[0]['name']);									
            			},
			'async' :	false            			
		});
		
	}
	
	$(document).ready(function() {
		$('#userTable').dataTable({"order": [[ 1, "asc" ]]});
	});
</script>
</body>
</html>