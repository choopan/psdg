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
            <div class="col-lg-12">
                <h3 class="page-header">จัดการกอง</h3>
            </div>
        </div>
		
		<div class="row">
            <div>
                <div class="panel panel-default">
					<div class="panel-heading">
						<button type="button" class="btn btn-success" onClick="window.location.href='<?php echo site_url("manageuser/addDivision"); ?>'">เพิ่มกอง</button>
					</div>
                    <div class="panel-body">
						<?php if($result==1){?>
							<div class="modal fade" id="myModal">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header model-info">
									<a href="<?php echo site_url("manageuser/division_view");?>" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
									<h4 class="modal-title">แจ้งเตือน</h4>
								  </div>
								  <div class="modal-body">
									<p>ทำการลบข้อมูลแล้ว</p>
								  </div>
								</div>
							  </div>
							</div>
						<?php }?>
					
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>กรม</th>
                                        <th>กอง</th>
										<th>ผู้อำนวยการกอง</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($data) && count($data) ) {
									foreach($data as $loop){
								?>
									<tr>
                                        <td><?php echo $loop['dep_name']; ?></td>
										<td><?php echo $loop['div_name']; ?></td>
										<td><?php echo $loop['PWFNAME'].' '.$loop['PWLNAME']; ?></td>
										<td>
											<a href='<?php echo "div_edit_info/".$loop['div_id']; ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo "div_del_info/".$loop['div_id']; ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
                                    </tr>
									<?php } } ?>
                                </tbody>
							</table>
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
    $(document).ready(function()
    {
		var table = $('#dataTables-example').DataTable();
		$('#myModal').modal({
							show:true,
							backdrop:false
							});
    });
</script>
</body>
</html>