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
                <h3 class="page-header">จัดการแบบประเมินสมรรณะ</h3>
            </div>
        </div>
		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
					<div class="panel-heading">
						<a href="<?php echo site_url('core_competency/addCoreSet'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> เพิ่มแบบประเมินสมรรณะ</a>
					</div>
                                        
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th>ชื่อแบบประเมินสมรรณะ</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
									if(is_array($coreset_array) && count($coreset_array) ) {
									foreach($coreset_array as $coreset){
										
								?>
									<tr>
                                        <td><?php echo $coreset['name']; ?></td>
										<td>											
											<a data-toggle="modal" data-target="#myModal<?php echo $coreset['ID']; ?>" href='<?php echo site_url("core_competency/viewCoreSet/".$coreset['ID']); ?>' class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
											<div class="modal fade" id="myModal<?php echo $coreset['ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											    <div class="modal-dialog">
        											<div class="modal-content">
        											</div> 
    											</div>
											</div> 

											<a href='<?php echo site_url("core_competency/editCoreSet/".$coreset['ID']); ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo site_url("core_competency/deleteCoreSet/".$coreset['ID']); ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>											
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