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
						<strong>เพิ่มกรม</strong>
					</div>
					<div class="panel-body">
							
								<form action="<?php echo site_url("manageuser/addDepartmaent_save"); ?>" method="post" name="addDepartment">
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อกรม *</label>
                                            <input type="text" class="form-control" name="department" id="residperson" required>
										</div>
										</div>

										<div class="col-lg-4">
										<div class="form-group">
											<label>อธิบดีกรม *</label>
                                            <select name="userid" class="form-control">
											<?php 
												foreach($user as $value){
													echo "<option value='".$value['USERID']."'>".$value['PWFNAME']." ".$value['PWLNAME']."</option>";
												}
											?>
											</select>
										</div>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group">
										<div class="col-lg-3">
											<input id="addNew" type="submit" class="btn btn-success" value="เพิ่ม"> <a href="javascript:history.go(-1)" class="btn btn-primary">กลับ</a>
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