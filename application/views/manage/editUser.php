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
	<?php $this->load->view('menu_admin'); ?>
	
	
	
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-11">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>แก้ไขข้อมูลผู้ใช้</strong>
					</div>
					<div class="panel-body">
						<?php if($result==1){?>
							<div class="alert alert-success" role="alert">
							  <p>แก้ไขข้อมูลเรียบร้อยแล้ว</p>
							</div>
						<?php }?>	
								<form action="<?php echo site_url("manageuser/editUser_save"); ?>" method="post" name="editUser">
									<input type="hidden" name="id" value="<?php echo $data[0]['USERID'];?>" class="form-control" required>
									<input type="hidden" name="un" value="<?php echo $data[0]['PWUSERNAME'];?>" class="form-control" required>
									<input type="hidden" name="pw" value="<?php echo $data[0]['PWPASSWORD'];?>" class="form-control" required>
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
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกกรม/สำนักปลัด *</label>
											<select name="department" id="department" class="form-control" onChange="get_division(this.value)" required>
												<?php if(is_array($department) && count($department) ) {
													foreach($department as $loop){?>
														<?php if($loop['id']==$data[0]['department']){?>
															<option value="<?php echo $loop['id']; ?>" selected><?php echo $loop['name']; ?></option>
														<?php }else{?>
															<option value="<?php echo $loop['id']; ?>"><?php echo $loop['name']; ?></option>
												<?php } } } ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกกอง/หน่วยงาน *</label>
												<input type="hidden" value="<?php echo $data[0]['division'];?>" id="div_id">
												<input type="hidden" value="<?php echo $data[0]['div_name'];?>" id="div_name">
                                            <select name="division" class="form-control" id="division_db" required>
												<option value="<?php echo $data[0]['div_id'];?>"><?php echo $data[0]['div_name'];?></option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกประเภทตำแหน่ง *</label>
											<select name="position_ty" class="form-control" id="pos_ty" onChange="get_position(this.value)" required>
													<option value="0">กรุณาเลือกประเภทตำแหน่ง</option>
												<?php foreach($position as $loop2){ ?>
													<?php if($loop2['id']==$data[0]['position_type']){?>
														<option value="<?php echo $loop2['id']; ?>" selected><?php echo $loop2['name']; ?></option>
													<?php }else{?>
														<option value="<?php echo $loop2['id']; ?>"><?php echo $loop2['name']; ?></option>
												<?php }} ?>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกตำแหน่ง *</label>
											<input type="hidden" value="<?php echo $data[0]['position'];?>" id="pos_id">
                                            <select name="position" class="form-control" id="position"  required>
												<option value="0">--select--</option>
											</select>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>เลือกระดับ *</label>
											<input type="hidden" value="<?php echo $data[0]['position_level'];?>" id="pos_lv_id">
                                            <select name="position_lv" class="form-control" id="position_lv" required>
												<option value="0">--select--</option>
											</select>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-8">
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
													<?php if($data[0]['admin_min']==0): ?>
													<input type="radio" value="admin_no" name="admin" checked >ไม่มีสิทธิ์
													<?php else:?>
													<input type="radio" value="admin_no" name="admin" >ไม่มีสิทธิ์
													<?php endif?>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-3">
											<input id="addNew" type="submit" class="btn btn-success" value="แก้ไข"> <a href="<?php echo site_url("manageuser/user_view");?>" class="btn btn-primary">กลับ</a>
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
$(document).ready(function () {
	if($("#department").val()!= -1){
		get_division($("#department").val());
	}
		get_position($("#pos_ty").val());
});

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
							var tr='';
							for(i=0;i<division_num;i++)
							{
								if(div_id==data[i]['id']){
									tr+='<option value="'+data[i]['id']+'" selected>'+data[i]['name']+'</option>';
								}else{
									tr+='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
								}
								
							}
							
						}else{
							var tr='<option>ไม่มีข้อมูล</option>';	
						}
						$(tr).appendTo('#division_db');
                    }
				});
}

function get_position(val1){
	var pos_id = $('#pos_id').val();
	var pos_lv_id = $('#pos_lv_id').val();	
	$.ajax({
					'url' : '<?php echo site_url('manageuser/get_position_1'); ?>/'+val1,
					'dataType': 'json',
					'error' : function(data){ 
						alert('error');
                    },
					'success' : function(data){
						$("#position").empty();
						var d1_num=data.length;
						var tr='';
						for(i=0;i<d1_num;i++)
						{
							if(pos_id==data[i]['PWPOSITION']){
								tr+='<option value="'+data[i]['PWPOSITION']+'" selected>'+data[i]['PWNAME']+'</option>';
							}else{
								tr+='<option value="'+data[i]['PWPOSITION']+'">'+data[i]['PWNAME']+'</option>';
							}
						}
						$(tr).appendTo('#position');
                    }
				});
				
	$.ajax({
					'url' : '<?php echo site_url('manageuser/get_position_2'); ?>/'+val1,
					'dataType': 'json',
					'error' : function(data2){ 
						alert('error');
                    },
					'success' : function(data2){
						$("#position_lv").empty();
						var d2_num=data2.length;
						var tr='';
						for(i=0;i<d2_num;i++)
						{
							if(pos_lv_id==data2[i]['id']){
								tr+='<option value="'+data2[i]['id']+'" selected>'+data2[i]['name']+'</option>';
							}else{
								tr+='<option value="'+data2[i]['id']+'">'+data2[i]['name']+'</option>';
							}
						}
						$(tr).appendTo('#position_lv');
                    }
				});
}
</script>

</body>
</html>
</html>