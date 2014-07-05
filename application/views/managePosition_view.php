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
                <h3 class="page-header">จัดการตำแหน่ง</h3>
            </div>
        </div>
		
		<div class="row">
            <div >
                <div class="panel panel-default">
					<div class="panel-heading">
						<button type="button" class="btn btn-outline btn-success" onClick="window.location.href='<?php echo site_url("manageuser/addPosition"); ?>'">เพิ่มตำแหน่ง</button>
					</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ชื่อตำแหน่ง(ภาษาไทย)</th>
										<th>ชื่อตำแหน่ง(ภาษาอังกฤษ)</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($data) && count($data) ) {
									foreach($data as $loop){
								?>
									<tr>
                                        <td><?php echo $loop['PWNAME']; ?></td>
										<td><?php echo $loop['PWENAME']; ?></td>
										<td>
											<a href='<?php echo "pos_edit_info/".$loop['PWPOSITION']; ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo "pos_del_info/".$loop['PWPOSITION']; ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
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
    });
</script>
</body>
</html>