<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	<?php $url = site_url("manageindicator/deleteDivision"); ?>
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">แสดงตัวชี้วัดระดับกอง ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
            </div>
        </div>
		<?php 	if(is_array($admin_array)) {
					foreach($admin_array as $loop){ 
						$admin = $loop->adminName;
					}
				}
		?>
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
						<div class="row">
							<form method="post">
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>เลือก กอง</label>
										<select class="form-control" name="depid" id="depid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDiv')?>/'+this.value;this.form.submit()"> -->
											<option value=""></option>
										<?php 	if(is_array($dep_array)) {
												foreach($dep_array as $loop){
													echo "<option value='".$loop->depid."'";
													if ($divid==$loop->depid) echo " selected";
													echo ">".$loop->thdepname."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							</form>
						</div>
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ตัวชี้วัด</th>
										<th width="40%">ชื่อ</th>
										<th>ค่าเป้าหมาย</th>
										<th>น้ำหนัก</th>
										<th>ผู้ดูแล</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>
								<tbody>
									<?php  if(is_array($indicatordivision_array)) {
												foreach($indicatordivision_array as $loop){
									?>
									<tr>
									<td><?php echo $loop->number; ?></td>
									<td><?php echo $loop->name; ?></td>
									<td><?php echo $loop->goal; ?></td>
									<td><?php echo $loop->weight; ?></td>
									<td><?php echo $admin; ?></td>
									<td>
									<div class="tooltip-demo">
	<a href="<?php echo site_url("manageindicator/viewindicator_div/".$loop->id."/".$loop->isMinister); ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="<?php echo site_url("manageindicator/viewindicator_div/".$loop->id); ?>" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
	<button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $loop->id; ?>,<?php echo $loop->divisionID; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
	</div>
									</td></tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
        var oTable = $('#dataTables-example').dataTable
        ({
            "bJQueryUI": false,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            'bServerSide'    : false,
			"bPaginate" : false,
            "bDeferRender": true,
            "fnServerData": function ( sSource, aoData, fnCallback ) {
                $.ajax( {
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success":fnCallback
                
                });
            }
        });
    });
</script>
	
<script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[rel=tooltip]",
        container: "body"
    })
function del_confirm(val1,val2) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1+"/"+val2);
				}

		});
}


</script>
</body>
</html>