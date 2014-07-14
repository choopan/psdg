<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css" >

<script type="text/javascript" charset="uft-8">
function get_data(val)
	{
		if(val==0){
			exit();
		}
		$.ajax({
						'url' : '<?php echo site_url('manageuser/get_data'); ?>',
						'type':'get',
						'data':{id:val},
						'error' : function(data){ 
							alert('error');
						},
						'success' : function(data){
							$('#a').empty();
							$('#a').html(data);
							}		   
					});
	}
</script>
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
            <div class="col-lg-12">
                <h3 class="page-header">จัดการตำแหน่ง</h3>
            </div>
        </div>
		
		<div class="row">
            <div >
                <div class="panel panel-default">
					<div class="panel-heading">
						<button type="button" class="btn btn-success" onClick="window.location.href='<?php echo site_url("manageuser/addPosition_type"); ?>'">เพิ่มชนิดตำแหน่ง</button>
						<button type="button" class="btn btn-info" onClick="window.location.href='<?php echo site_url("manageuser/addPosition"); ?>'">เพิ่มตำแหน่ง</button>
						<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("manageuser/addPosition_level"); ?>'">เพิ่มขั้นตำแหน่ง</button>
					</div>
                    <div class="panel-body">
						<?php if($result==1){?>
							<div class="modal fade" id="myModal">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header model-info">
									<a href="<?php echo site_url("manageuser/position_view");?>" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
									<h4 class="modal-title">แจ้งเตือน</h4>
								  </div>
								  <div class="modal-body">
									<p>ทำการลบข้อมูลแล้ว</p>
								  </div>
								</div>
							  </div>
							</div>
						<?php }?>
						
						<div class="row">
							<div class="col-lg-4">
							<div class="form-group">
								<label>เลือกจัดการข้อมูล</label>
								<select name="position" class="form-control" id="position" onChange="get_data(this.value)">
									<option value="0" selected>- select -</option>
									<option value="1">ชนิดตำแหน่ง</option>
									<option value="2">ตำแหน่ง</option>
									<option value="3">ขั้นตำแหน่ง</option>
								</select>
							</div>
							</div>
						</div>
                        <div class="table-responsive">
							<div id="a"></div>
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