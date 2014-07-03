<?php 
	$data['title']='คำรับรองการปฏิบัติราชการ  ระดับกรม';
	$this->load->view('header_view',$data);
?>
	<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>

		<div id="page-wrapper">
		
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">จัดการคำรับรองการปฏิบัติราชการ  ระดับกรม</h3>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div id="alert" hidden>
						<?php if($alert=='save_war_dep_success'){ ?>
								<div class="alert alert-success alert-dismissable" >
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong><span class="glyphicon glyphicon-ok"></span> สำเร็จ !</strong> เพิ่มคำรับรองเรียบร้อยแล้ว
								</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="<?php echo site_url('managewarranty/add_ratification_depart'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> เพิ่มคำรับรองการปฏิบัติราชการ</a>
						</div>
											
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="skillTable">
									<thead>
										<tr>
											<th>ชื่อกรม</th>
											<th width="20%">จัดการ</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>ทดสอบ</td>
											<td>											
												<a data-toggle="modal" data-target="#myModal" href='#' class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
												<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
														</div> 
													</div>
												</div> 

												<a href='#' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
												<a href='#' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>											
											</td>
										</tr>
									</tbody>
								</table>
							</div>
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
			$("#alert").fadeIn(1500);
		});
	</script>
	</body>
	</html>