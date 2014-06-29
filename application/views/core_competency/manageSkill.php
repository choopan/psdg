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
            <div class="col-lg-12">
                <h3 class="page-header">จัดการหัวข้อสมรรณะ</h3>
            </div>
        </div>
		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
					<div class="panel-heading">
						<form class="form-horizontal" action="<?php echo site_url('core_competency/addSkill'); ?>" method="POST">
							<div class="form-group row">
									<div class="col-lg-2">
										<label for='skill' class="control-label">ชื่อสมรรณะ :</label>
									</div>
									<div class="col-lg-6">													
										<input id='skill' type="text" class="form-control" name="skill">
									</div>
									<div class="col-lg-3">												
										<input type="submit" class="btn btn-success" value=" เพิ่มสมรรณะ ">																					
									</div>
							</div>
						</form>
					</div>
                                        
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th>ชื่อสมรรณะ</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
									if(is_array($skill_array) && count($skill_array) ) {
									foreach($skill_array as $skill){
										
								?>
									<tr>
                                        <td><?php echo $skill['name']; ?></td>
										<td>
											<a href='<?php echo site_url("core_competency/editSkill/".$skill['ID']); ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo site_url("core_competency/deleteSkill/".$skill['ID']); ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>											
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
	$(document).ready(function() {
		$('#skillTable').dataTable({"order": [[ 1, "asc" ]]});
	});
</script>
</body>
</html>