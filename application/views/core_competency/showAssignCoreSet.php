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
            <div class="col-md-12">
                <div class="panel panel-default">
					<div class="panel-heading">
						กำหนดแบบประเมินสมรรณะตามตำแหน่งรับผิดชอบ
					</div>                                      
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="userTable">
                                <thead>
                                    <tr>
										<th>ประเภทตำแหน่ง</th>
										<th>ระดับตำแหน่ง</th>
										<th>ชื่อแบบประเมินสมรรณะ</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
									foreach($position_type_levels as $ptl){
										
								?>
									<tr>
										<td><?php echo $ptl['position_type_name']; ?></td>
										<td><?php echo $ptl['position_level_name']; ?></td>
                                        <td><div id="coreset<?php echo $ptl['position_level_id']; ?>">
                                        	<?php 	if($ptl['coreset_name'] == null || $ptl['coreset_name'] == '') {
                                        				echo "-";
                                        			} else {
                                        				echo $ptl['coreset_name']; 
                                        			}
											?>
                                        	</div>
                                        </td>
										<td>
											<div id="button<?php echo $ptl['position_level_id']; ?>">
												<button onclick="editAssignCoreSet('<?php echo $ptl['position_level_id']; ?>', '<?php echo $ptl['coresetID']?>', '<?php echo $ptl['coreset_name']?>')" id="coresetUser<?php echo $ptl['position_level_id']; ?>"  class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไขแบบประเมินสมรรณะ"><span class="glyphicon glyphicon-pencil"></span></button>
											</div>																		
										</td>
                                    </tr>
									<?php } ?>
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
	function cancelAssignCoreSet(userID, oldCoreSetID, oldCoreSetName) {
		//alert("cancel : userID" + userID + ", oldCoreSetName = " + oldCoreSetName);
		var editButton = '<button onclick="editAssignCoreSet(\'' + userID  + '\', \''
			+ oldCoreSetID + '\', \'' + oldCoreSetName +  '\')" id="coresetUser' + userID
			+ '" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไขแบบประเมินสมรรณะ"><span class="glyphicon glyphicon-pencil"></span></button>';

		//alert(editButton);
		$('#coreset' + userID).html(oldCoreSetName);
		$('#button'  + userID).html(editButton);
	}
	
	function editAssignCoreSet(userID, oldCoreSetID, oldCoreSetName) {
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
			+ ' id="saveButton' + userID + '"  class="btn btn-success btn-xs"'
			+ ' data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top"'
			+ ' rel="tooltip" title="บันทึกข้อมูล"><span class="glyphicon glyphicon-floppy-save"></span></button>';
			
		var cancelButton = 	'<button onclick="cancelAssignCoreSet(\'' + userID + '\', \'' + oldCoreSetID + '\', \'' + oldCoreSetName + '\')"'
			+ ' id="cancelButton' + userID + '"  class="btn btn-danger btn-xs"'
			+ ' data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top"'
			+ ' rel="tooltip" title="ยกเลิก"><span class="glyphicon glyphicon-floppy-remove"></span></button>';		
		
		$('#coreset' + userID).html(coresetBox);
		$('#button'  + userID).html(saveButton + ' ' + cancelButton);
		$('#select'  + userID).val(oldCoreSetID);
	}
	
	function saveAssignCoreSet(userID) {
		var coresetID = $('#select' + userID).val();

		//Call ajax to save 
		$.ajax({
			'type' : 	'POST', 
			'url'  : 	'<?php echo site_url("core_competency/saveAssignCoreSet"); ?>',
			'data' :	{ 'posLvlID': userID, 'coreSetID': coresetID },
			'dataType': 'json',
			'error' : 	function(data){ 
						alert('Something wrong with your server.' + data);
            			},
			'success' : function(data){
						var newCoreSetName = data[0]['name'];
						var editButton = '<button onclick="editAssignCoreSet(\'' + userID  + '\', \'' 
						+ coresetID + '\', \'' + newCoreSetName +  '\')" id="coresetUser' + userID
						+ '" class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไขแบบประเมินสมรรณะ"><span class="glyphicon glyphicon-pencil"></span></button>';


							$('#button'  + userID).html(editButton);
							$('#coreset' + userID).html(newCoreSetName);									
            			},
			'async' :	false            			
		});
		
	}
	
	$(document).ready(function() {
		//$('#userTable').dataTable({"order": [[ 1, "asc" ]]});
	});
</script>
</body>
</html>