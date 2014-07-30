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
						<?php if($result==1){?>
							<div class="alert alert-success" role="alert">
							  <p>เพิ่มข้อมูลเรียบร้อยแล้ว</p>
							</div>
						<?php }?>	
								<div id="show"></div>
								<form onSubmit="return check_pass()" action="<?php echo site_url("indicator_admin/indicatorUser_save3"); ?>" method="post" name="addUser">

									<div class="row">
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>ชื่อ-นามสกุล *</label>
											<input type="hidden" name="userid" id="userid">
											<input type="hidden" name="dep_id" id="dep_id">
											<input type="hidden" name="div_id" id="div_id">
											<input type="text" id="myinput" name="name" class="form-control" value="" required>
										</div>
										</div>
									</div>

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
                                            <input type="password" name="password" id="pw1" class="form-control" required>
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group">
                                            <label>Confirm-password *</label>
                                            <input type="password" name="repassword" id="pw2" class="form-control" required>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group">
											<label>ผู้ดูแลระบบ * |</label>
												<label class="checkbox-inline">
													<input type="radio" value="approve_dep" name="admin">อธิบดีกรม
												</label>	
												<label class="checkbox-inline">
													<input type="radio" value="approve_div" name="admin">ผู้อำนวยการกอง
												</label>	
												<label class="checkbox-inline">
													<input type="radio" value="set_div"  name="admin" checked>ผู้กำหนดตัวชี้วัดกอง
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
										<div class="col-lg-3">
											<input id="addNew" type="submit" class="btn btn-success" value="เพิ่ม"> <a href="<?php echo site_url("indicator_admin/user_indicator_view3");?>" class="btn btn-primary">กลับ</a>
										</div>
										</div>
									</div>
								</form>
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
		$(document).ready(function() {	
			$('#myinput').autocomplete({
			
				source: function(request, response){
					 $.ajax({
						url: "<?php echo site_url('indicator_admin/autocompleteResponse'); ?>",
						dataType: "json",
						data: {term:request.term},
						error: function(data){
								alert('error');
							},
						success: function(data) {
								//$('#debug').html(JSON.stringify(data));
								 response($.map(data,function(pwemployee){
									return {
										value: pwemployee.pwname,
										userid: pwemployee.userid,
										department: pwemployee.department,
										division: pwemployee.division
										};
								}));
							}
						});
		

				},
				minLength: 2,
				autofocus: true,
				mustMatch: true,
				select: function(event,ui){
						$("#userid").val(ui.item.userid);
						$("#dep_id").val(ui.item.department);
						$("#div_id").val(ui.item.division);
				}
				
				
			});
			
		});
		
		function check_null(obj)
		{
			var value_before=$(obj).val();
			$(obj).val(value_before.trim());
		}
		
		function check_pass()
		{
			var pw1=$('#pw1').val();
			var pw2=$('#pw2').val();
			
			if(pw1 == pw2){
				return true;
			}else{
				var tr='<div class="alert alert-danger" role="alert">รหัสผ่านไม่ตรงกัน</div>';
				$("#show").append(tr);
				return false;
			}
		}
			
	</script>
</body>
</html>