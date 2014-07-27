<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	<?php 
        
        $url = site_url("manageindicator/deleteDivision"); 
        $urleditnum = site_url("manageindicator/editNumberDiv");
    ?>
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">แสดงตัวชี้วัดระดับกอง ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
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
										<select class="form-control" name="depid" id="depid" onChange="selectDiv(this);">
											<option value="">---เลือกกรม---</option>
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
							<form method="post">
							<div class="col-lg-4">
									<div class="form-group">
                                        <label>เลือก กอง</label>
										<select class="form-control" name="divid" id="divid" onChange="this.form.action='<?php echo site_url('manageindicator/viewDiv')?>/'+this.value;this.form.submit()"> 
											<option value=""></option>
										
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
									<?php  if(is_array($indicatordivision_array)) {
												foreach($indicatordivision_array as $loop){
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
									<td>
									<div class="tooltip-demo">
	<a href="<?php echo site_url("manageindicator/viewindicator_div/".$loop->id."/".$loop->isDep); ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
	<a href="<?php echo site_url("manageindicator/viewindicator_div/".$loop->id); ?>" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
    <button class="btnEditNum btn btn-warning btn-xs" onclick="editNumber(<?php echo $loop->id.",".$divid; ?>)" data-title="EditNum" data-toggle="modal" data-target="#editnum" data-placement="top" rel="tooltip" title="เปลี่ยนเลชตัวชี้วัด"><span class="glyphicon glyphicon-random"></span></button>
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
        
        selectDiv(document.getElementById("depid"));
        
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

function selectDiv(obj) {
    var depid = $(obj).val();
    $.ajax({
        url: "<?php echo site_url('manageindicator/getKongFromGom'); ?>",
        type: "POST",
        dataType: 'json',
        data: {depid: depid},
        success: function(data) {
            var selectdiv = document.getElementById('divid');
            //$('#divid').empty();
            selectdiv.length = 0;
            selectdiv.options[0] = new Option('---เลือกกอง---','0');
            var divid = JSON.parse(<?php echo json_encode($divid); ?>);
            var index = 0;
            for (var i = 0; i < data.length; i++) { 
                if (divid==data[i].id) index = i+1;
                selectdiv.options[selectdiv.length] = new Option(data[i].name,data[i].id);
            }
            selectdiv.selectedIndex = index;
        }
    });
}

</script>
</body>
</html>