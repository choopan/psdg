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
						<strong>รายละเอียด</strong>
					</div>
					<div class="panel-body">
							
								<form action="<?php echo site_url("manageuser/addUser_save"); ?>" method="post" name="addUser">
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Username *</label>
											<input type="text" class="form-control" value="<?php echo $data[0]['PWUSERNAME']?>" readonly>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อ(ภาษาไทย) *</label>
											<input type="text" class="form-control" value="<?php echo $data[0]['PWFNAME']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>นามสกุล(ภาษาไทย)  *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['PWLNAME']?>" readonly>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Name(ภาษาอังกฤษ) *</label>
											<input type="text" class="form-control" value="<?php echo $data[0]['PWEFNAME']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Last name(ภาษาอังกฤษ)  *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['PWELNAME']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เพศ *</label>
											<?php if($data[0]['PWSEX']==1){?>
                                            <input type="text" class="form-control" value="ชาย" readonly>
											<?php }else{?>
											<input type="text" class="form-control" value="หญิง" readonly>
											<?php }?>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>E-mail *</label>
											<input type="email" class="form-control" value="<?php echo $data[0]['PWEMAIL']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์ภายใน *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['PWTELOFFICE']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์มือถือ *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['mobile']?>" readonly>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>กรม *</label>
											<input type="text" class="form-control" value="<?php echo $data[0]['dep_name']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>กอง *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['div_name']?>" readonly>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ตำแหน่ง *</label>
											<input type="text" class="form-control" value="<?php echo $data[0]['position_name']?>" readonly>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกระดับ *</label>
                                            <input type="text" class="form-control" value="<?php echo $data[0]['PWLEVEL']?>" readonly>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8">
											<div class="form-group">
											<label>ผู้ดูแลระบบ * |</label>
												<label class="checkbox-inline">
													<?php if($data[0]['admin_min']==1): ?>
													<input type="checkbox" checked disabled>ระดับกระทรวง
													<?php else:?>
													<input type="checkbox" disabled>ระดับกระทรวง
													<?php endif?>
												</label>
												
												<label class="checkbox-inline">
													<?php if($data[0]['admin_dep']==1): ?>
													<input type="checkbox" checked disabled>ระดับกรม
													<?php else:?>
													<input type="checkbox" disabled>ระดับกรม
													<?php endif?>
												</label>
												
												<label class="checkbox-inline">
													<?php if($data[0]['admin_div']==1): ?>
													<input type="checkbox" checked disabled>ระดับกอง
													<?php else:?>
													<input type="checkbox" disabled>ระดับกอง
													<?php endif?>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
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

<script type="text/javascript" charset="utf-8">
function get_division(val){
	$.ajax({
					'url' : '<?php echo site_url('manageuser/get_division'); ?>/'+val,
					'dataType': 'json',
					'error' : function(data){ 
						alert('error');
                    },
					'success' : function(data){
						$("#division_db").empty();
						var division_num=data.length;
						var tr='<option>เลือก section</option>';
						for(i=0;i<division_num;i++)
						{
							tr+='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
							
						}
						$(tr).appendTo('#division_db');
                    }
				});
}
</script>

</body>
</html>
</html>