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
						<strong>รายละเอียดกรม/สำนักปลัด</strong>
					</div>
					<div class="panel-body">
					
					<div class="modal fade" id="myModal">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header model-info">
							<h4 class="modal-title">เพิ่มผู้ดูแล</h4>
						 </div>
						  <div class="modal-body">
							<div class="row">
								<form action="<?php echo site_url("manageuser/addDepartmaent_user"); ?>" method="get">
								<div class="col-lg-4">
								<div class="form-group">
									<label>ชื่อผู้ดุแล *</label>
									<input type="hidden" name="id" value="<?php echo $data[0]['id'];?>">
									<select name="user" class="form-control" required>
									<?php 
										foreach($user as $value){
										echo "<option value=".$value['USERID'].">".$value['PWFNAME']." ".$value['PWLNAME']."</option>";
										}
									?>
									</select>
								</div>
								</div>
								<div class="col-lg-4">
								<div class="form-group">
									<label>ตำแหน่งดุแล *</label>
									<select name="status" class="form-control" required>
										<option value="1">อธิบดีกรม</option>
										<option value="2">รองอธิบดีกรม</option>
										<option value="3">พิเศษ</option>
									</select>
								</div>
								</div>
							</div>
						  </div>
						  <div class="modal-footer model-info">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="submit" value="บันทึก" class="btn btn-success">
							</form>
						  </div>
						</div>
					  </div>
					</div>
						<?php if($result==1){?>
							<div class="alert alert-success" role="alert">
							  เพิ่มข้อมูลเรียบร้อยแล้ว
							  <a href="<?php echo base_url()."index.php/manageuser/dep_show_user/".$data[0]['id']; ?>" class="close" data-dismiss="alert"><span aria-hidden="true"></span>ตกลง</a>
							</div>
						<?php }?>	
						<?php if($result2==1){?>
							<div class="alert alert-danger" role="alert">
							  ลบข้อมูลเรียบร้อยแล้ว
							 <a href="<?php echo base_url()."index.php/manageuser/dep_show_user/".$data[0]['id']; ?>" class="close" data-dismiss="alert"><span aria-hidden="true"></span>ตกลง</a>
							</div>
						<?php }?>
						<h3><?php echo $data[0]['name'];?></h3><hr>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> เพิ่มผู้ดูแล</button><br><br>
						<div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="indicator_table">
                                <thead>
                                    <tr>
                                        <th>ชื่อ</th>
										<th>ตำแหน่ง</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($data) && count($data) ) {
									foreach($data as $loop){
								?>
									<tr>
										<td><?php echo $loop['PWFNAME'].' '.$loop['PWLNAME']; ?></td>
                                        <td><?php
											if($loop['status']==1){
												echo "อธิบดีกรม";
											}else if($loop['status']==2){
												echo "รองอธิบดีกรม";
											}else if($loop['status']==3){
												echo "พิเศษ";
											}else{
												echo "";
											}
										?></td>
										<td>
											<?php if($loop['dep_id']!=null){?>
												<a href='<?php echo base_url()."index.php/manageuser/dep_del_user/".$loop['dep_id']."/".$loop['id']; ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
											<?php }?>
										</td>
                                    </tr>
									<?php } } ?>
                                </tbody>
							</table>
						</div>
						<a href="<?php echo site_url("manageuser/department_view");?>" class="btn btn-primary">กลับ</a>
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
	$('#myModal').modal({show:fualt});
</script>
</body>
</html>