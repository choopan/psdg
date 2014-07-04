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
						<strong>แก้ไขข้อมูลผู้ใช้</strong>
					</div>
					<div class="panel-body">
							
								<form action="<?php echo site_url("manageuser/editUser_save"); ?>" method="post" name="editUser">
									<input type="hidden" name="id" value="<?php echo $data[0]['USERID'];?>" class="form-control" required>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อ(ภาษาไทย) *</label>
											<input type="text" name="fname" value="<?php echo $data[0]['PWFNAME'];?>" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>นามสกุล(ภาษาไทย) *</label>
                                            <input type="text" name="lname" value="<?php echo $data[0]['PWLNAME'];?>" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Name(ภาษาอังกฤษ) *</label>
											<input type="text" name="efname" value="<?php echo $data[0]['PWEFNAME'];?>" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Last name(ภาษาอังกฤษ)  *</label>
                                            <input type="text" name="elname" value="<?php echo $data[0]['PWELNAME'];?>" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>E-mail *</label>
											<input type="email" name="email" value="<?php echo $data[0]['PWEMAIL'];?>" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์ภายใน *</label>
                                            <input type="text" name="tel" value="<?php echo $data[0]['PWTELOFFICE'];?>" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เบอร์มือถือ *</label>
                                            <input type="text" name="mobile" value="<?php echo $data[0]['mobile'];?>" class="form-control" >
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
										<div class="form-group">
                                            <label>เลือกกรม *</label>
											<select name="department" id="department" class="form-control" onChange="get_division(this.value)" required>
													<option value="<?php echo $data[0]['dep_id'];?>"><?php echo "default ".$data[0]['dep_name'];?></option>
												<?php if(is_array($department) && count($department) ) {
													foreach($department as $loop){
												?>
													<option value="<?php echo $loop['id']; ?>"><?php echo $loop['name']; ?></option>
												<?php } } ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกกอง *</label>
												<input type="hidden" value="<?php echo $data[0]['div_id'];?>" id="div_id">
												<input type="hidden" value="<?php echo $data[0]['div_name'];?>" id="div_name">
                                            <select name="division" class="form-control" id="division_db" required>
												<option value="<?php echo $data[0]['div_id'];?>"><?php echo "default ".$data[0]['div_name'];?></option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
										<div class="form-group">
                                            <label>เลือกตำแหน่ง *</label>
											<select name="position1" class="form-control"  required>
													<option value="<?php echo $data[0]['position'];?>"><?php echo "default ".$data[0]['position_name'];?></option>
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
												<option value="<?php echo $data[0]['PWLEVEL'];?>"><?php echo "default ".$data[0]['PWLEVEL'];?></option>
												<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
												<option>7</option><option>8</option><option>9</option><option>10</option><option>11</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
											<label>ผู้ดูแลระบบ * |</label>
												<label class="checkbox-inline">
													<?php if($data[0]['admin_min']==1): ?>
													<input type="radio" value="admin_min" name="admin" checked >ระดับกระทรวง
													<?php else:?>
													<input type="radio" value="admin_min" name="admin" >ระดับกระทรวง
													<?php endif?>
												</label>
												
												<label class="checkbox-inline">
													<?php if($data[0]['admin_dep']==1): ?>
													<input type="radio" value="admin_dep" name="admin" checked >ระดับกรม
													<?php else:?>
													<input type="radio" value="admin_dep" name="admin" >ระดับกรม
													<?php endif?>
												</label>
												
												<label class="checkbox-inline">
													<?php if($data[0]['admin_div']==1): ?>
													<input type="radio" value="admin_div" name="admin" checked >ระดับกอง
													<?php else:?>
													<input type="radio" value="admin_div" name="admin" >ระดับกอง
													<?php endif?>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
										<div class="form-group">
											<label>สิทธิบริหาร *</label>
											<select name="execode" class="form-control" >
												<?php if($data[0]['execode']==0){?>
													<option value="0" selected>ไม่มี</option>
													<option value="1">ผู้อำนวยการกอง</option>
													<option value="2">อธิบดีกรม</option>
												<?php }else if($data[0]['execode']==1){?>
													<option value="0">ไม่มี</option>
													<option value="1"selected>ผู้อำนวยการกอง</option>
													<option value="2">อธิบดีกรม</option>
												<?php }else if($data[0]['execode']==2){?>
													<option value="0">ไม่มี</option>
													<option value="1">ผู้อำนวยการกอง</option>
													<option value="2"selected>อธิบดีกรม</option>
												<?php }?>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-3">
											<input id="addNew" type="submit" class="btn btn-success" value="แก้ไข"> <a href="javascript:history.go(-1)" class="btn btn-primary">กลับ</a>
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
	var div_id = $('#div_id').val();
	var div_name = $('#div_name').val();
	$.ajax({
					'url' : '<?php echo site_url('manageuser/get_division'); ?>/'+val,
					'dataType': 'json',
					'error' : function(data){ 
						alert('error');
                    },
					'success' : function(data){
						$("#division_db").empty();
						var division_num=data.length;
						if(division_num>0){
							var tr='<option value="'+div_id+'">defualt '+div_name+'</option>';
							for(i=0;i<division_num;i++)
							{
								
								tr+='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
								
							}
							
						}else{
							var tr='<option>ไม่มีข้อมูล</option>';	
						}
						$(tr).appendTo('#division_db');
                    }
				});
}

$(document).ready(function () {
	if($("#department").val()!= -1){
		get_division($("#department").val());
	}

});
</script>

</body>
</html>
</html>