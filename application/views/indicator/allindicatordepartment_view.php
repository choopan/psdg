<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	<?php $url = site_url("manageindicator/deleteDep"); 
          $urleditnum = site_url("manageindicator/editNumberDep");
    ?>
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">แสดงตัวชี้วัดระดับกรม ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
            </div>
        </div>
		<?php 	if(is_array($admin_array)) {
					foreach($admin_array as $loop){ 
						$admin = $loop->PWFNAME." ".$loop->PWLNAME;
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
                                        <label>เลือก กรม</label>
										<select class="form-control" name="depid" id="depid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDep')?>/'+this.value;this.form.submit()"> -->
											<option value=""></option>
										<?php 	if(is_array($dep_array)) {
												foreach($dep_array as $loop){
													echo "<option value='".$loop->id."'";
													if ($depid==$loop->id) echo " selected";
													echo ">".$loop->name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
							</form>
						</div>
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead><tr>
									<th rowspan="2">ตัวชี้วัด</th>
									<th rowspan="2">ชื่อ</th>
									<th colspan="5">เกณฑ์การให้คะแนน</th>
									<th rowspan="2">น้ำหนัก</th>
									<th rowspan="2">ผู้ดูแล</th>
									<th rowspan="2" width="125">จัดการ</th>
								</tr>
								<tr>
									<th>1</th>
									<th>2</th>
									<th>3</th>
									<th>4</th>
									<th>5</th>
								</tr>
								</thead>
								<tbody>
									<?php  if(is_array($indicatordep_array)) {
												foreach($indicatordep_array as $loop){
									?>
									<tr>
									<td><?php echo $loop->number; ?></td>
									<td><?php echo $loop->name; ?></td>
                                    <td><?php echo $loop->criteria1; ?></td>
									<td><?php echo $loop->criteria2; ?></td>
									<td><?php echo $loop->criteria3; ?></td>
									<td><?php echo $loop->criteria4; ?></td>
									<td><?php echo $loop->criteria5; ?></td>
									<td><?php echo $loop->weight; ?></td>
									<td><?php echo $admin; ?></td>
									<td>
									<div class="tooltip-demo">
	<a href="<?php echo site_url("manageindicator/viewindicator_dep/".$loop->id."/".$loop->isMinister); ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="<?php echo site_url("manageindicator/viewindicator_dep/".$loop->id); ?>" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
    <button class="btnEditNum btn btn-warning btn-xs" onclick="editNumber(<?php echo $loop->id.",".$depid; ?>)" data-title="EditNum" data-toggle="modal" data-target="#editnum" data-placement="top" rel="tooltip" title="เปลี่ยนเลชตัวชี้วัด"><span class="glyphicon glyphicon-random"></span></button>
	<button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $loop->id; ?>,<?php echo $loop->depID; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
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
    
function editNumber(val1,val2) {
    bootbox.prompt("กรุณาป้อนเลขตัวชี้วัดที่ต้องการ", function(result) {                
          if (result != null && result >0) {                          
                    
             var myurl = <?php echo json_encode($urleditnum); ?>; 
             window.location.replace(myurl+"/"+val1+"/"+result+"/"+val2);             
          } else {
            //Example.show("Hi <b>"+result+"</b>");                          
          }
    });
}


</script>
</body>
</html>