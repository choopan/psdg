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
						<strong>เพิ่มผู้ใช้</strong>
					</div>
					<div class="panel-body">
							
								<form action="<?php echo site_url("manageuser/addUser_save"); ?>" method="post" name="addUser">
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Username *</label>
											<input type="text" name="username" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Password *</label>
                                            <input type="password" name="password" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Confirm-password *</label>
                                            <input type="password" name="retry_password" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อ(ภาษาไทย) *</label>
											<input type="text" name="fname" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>นามสกุล(ภาษาไทย) *</label>
                                            <input type="text" name="lname" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Name(ภาษาอังกฤษ) *</label>
											<input type="text" name="efname" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Last name(ภาษาอังกฤษ)  *</label>
                                            <input type="text" name="elname" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เพศ *</label>
                                            <select name="gender" class="form-control" required>
												<option value="1">ชาย</option>
												<option value="2">หญิง</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>E-mail *</label>
											<input type="email" name="email" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์ภายใน *</label>
                                            <input type="text" name="tel" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์มือถือ *</label>
                                            <input type="text" name="mobile" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกกรม *</label>
											<select name="department" class="form-control" onChange="get_division(this.value)" required>
													<option value="0">กรุณาเลือกกรม</option>
												<?php if(is_array($data) && count($data) ) {
													foreach($data as $loop){
												?>
													<option value="<?php echo $loop['id']; ?>"><?php echo $loop['name']; ?></option>
												<?php } } ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกกอง *</label>
                                            <select name="division" class="form-control" id="division_db" required>
												<option>------</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกตำแหน่ง *</label>
											<select name="position1" class="form-control" required>
													<option value="0">กรุณาเลือกตำแหน่ง</option>
												<?php foreach($position as $loop2){ ?>
													<option value="<?php echo $loop2['PWPOSITION']; ?>"><?php echo $loop2['PWNAME']; ?></option>
												<?php } ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกระดับ *</label>
                                            <select name="level" class="form-control" id="division_db" required>
												<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
												<option>7</option><option>8</option><option>9</option><option>10</option><option>11</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8">
											<div class="form-group">
											<label>ผู้ดูแลระบบ * |</label>
												<label class="checkbox-inline">
													<input type="checkbox" name="admin_min">ระดับกระทรวง
												</label>
												
												<label class="checkbox-inline">
													<input type="checkbox" name="admin_dep">ระดับกรม
												</label>
												
												<label class="checkbox-inline">
													<input type="checkbox" name="admin_div">ระดับกอง
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-2">
										<div class="form-group">
											<label>สิทธิบริหาร *</label>
											<select name="execode" class="form-control" required>
												<option value="0">ไม่มี</option>
												<option value="1">ผู้อำนวยการกอง</option>
												<option value="2">อธิบดีกรม</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-1">
											<input id="addNew" type="submit" class="btn btn-success" value="เพิ่ม">
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
						var tr='<option>เลือกกอง</option>';
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