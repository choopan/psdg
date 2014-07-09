<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css" >
<style type="text/css" class="init">


td.highlight {
    background-color: red !important;
}


	</style>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-11">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>แก้ไขรายละเอียดกรม</strong>
					</div>
					<div class="panel-body">
						<?php if($result==1){?>
							<div class="alert alert-success" role="alert">
							  <p>แก้ไขข้อมูลเรียบร้อยแล้ว</p>
							</div>
						<?php }?>	
								<form action="<?php echo site_url("manageuser/updateDepartmaent_save"); ?>" method="post" name="addDepartment">
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $data[0]['id'];?>">
                                            <label>ชื่อกรม *</label>
                                            <input type="text" class="form-control" name="department" value="<?php echo $data[0]['name'];?>">
										</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-3">
											<input id="addNew" type="submit" class="btn btn-success" value="แก้ไข"> <a href="<?php echo site_url("manageuser/department_view");?>" class="btn btn-primary">กลับ</a>
										</div>
										</div>
									</div>
								</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>
</body>
</html>