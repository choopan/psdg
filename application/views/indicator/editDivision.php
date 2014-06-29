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
						<strong>แก้ไขรายละเอียดกอง</strong>
					</div>
					<div class="panel-body">
							
								<form action="<?php echo site_url("manageuser/updateDivision_save"); ?>" method="post" name="addDivision">
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
											<input type="hidden" class="form-control" name="id" value="<?php echo $div[0]['id'];?>">
                                            <label>เลือกกรม *</label>
											<select name="department" class="form-control">
												
												<?php if(is_array($data) && count($data) ) {?>
													<option value="<?php echo $dep[0]['id']; ?>"><?php echo "ข้อมูลเดิมคือ ".$dep[0]['name']; ?></option>
												<?php foreach($data as $loop){
												?>
													<option value="<?php echo $loop['id']; ?>"><?php echo $loop['name']; ?></option>
												<?php } } ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อกอง *</label>
                                            <input type="text" class="form-control" name="division" value="<?php echo $div[0]['name'];?>">
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ผู้อำนวยการกอง *</label>
											<select name="userid" class="form-control">
												
												<?php if(is_array($data) && count($data) ) {?>
													<option value="<?php echo $dep[0]['id']; ?>"><?php echo "ข้อมูลเดิมคือ ".$dep[0]['PWFNAME'].' '.$dep[0]['PWLNAME']; ?></option>
												<?php foreach($user as $loop2){
												?>
													<option value="<?php echo $loop2['USERID']; ?>"><?php echo $loop2['PWFNAME'].' '.$loop2['PWLNAME']; ?></option>
												<?php } } ?>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-1">
											<input id="addNew" type="submit" class="btn btn-success" value="แก้ไข">
											</div>
											<div class="col-lg-1">
											<a href="javascript:history.go(-1)" class="btn btn-primary">กลับ</a>
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