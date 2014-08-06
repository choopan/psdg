<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<style type="text/css" class="init">

</style>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	<?php $url = site_url("manageindicator/delete");
          $urleditnum = site_url("manageindicator/editNumber");
    ?>
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">แสดงตัวชี้วัดระดับกระทรวง ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead><tr>
									<th rowspan="2" style="width: 60px;">ตัวชี้วัด</th>
									<th rowspan="2" style="text-align: center;">ชื่อ</th>
									<th colspan="5" style="text-align: center; width: 300px">เกณฑ์การให้คะแนน</th>
									<th rowspan="2" style="width: 60px;">น้ำหนัก</th>
									<th rowspan="2" style="width: 150px;">หน่วยงาน</th>
									<th rowspan="2" style="width: 125px;">จัดการ</th>
								</tr>
								<tr>
									<th style="text-align: center;">1</th>
									<th style="text-align: center;">2</th>
									<th style="text-align: center;">3</th>
									<th style="text-align: center;">4</th>
									<th style="text-align: center;">5</th>
								</tr>
								</thead>
                                <tbody>
                                <?php if(is_array($view_array)) {
                                        foreach($view_array as $loop){ ?>
                                    <tr>
                                    <td><?php echo $loop->number; ?></td>
                                    <td><?php echo $loop->name; ?></td>
                                    <td><?php echo $loop->criteria1; ?></td>
									<td><?php echo $loop->criteria2; ?></td>
									<td><?php echo $loop->criteria3; ?></td>
									<td><?php echo $loop->criteria4; ?></td>
									<td><?php echo $loop->criteria5; ?></td>
                                    <td><?php echo $loop->weight; ?></td>
                                    <td><?php echo $loop->TDepName; ?></td>
                                    <td>
    <div class="tooltip-demo">
    <a href="<?php echo site_url("manageindicator/viewindicator_min/".$loop->mid); ?>" class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
    <a href="<?php echo site_url("manageindicator/viewindicator_min/".$loop->mid); ?>" class="btn btn-primary btn-xs" data-title="Edit" data-toggle="tooltip" data-target="#edit" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
    <button class="btnEditNum btn btn-warning btn-xs" onclick="editNumber(<?php echo $loop->mid; ?>)" data-title="EditNum" data-toggle="modal" data-target="#editnum" data-placement="top" rel="tooltip" title="เปลี่ยนเลชตัวชี้วัด"><span class="glyphicon glyphicon-random"></span></button>
    <button class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $loop->mid; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button>
    </div>
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
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>
<script type="text/javascript" class="init">



</script>
	
<script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[rel=tooltip]",
        container: "body"
    })
function del_confirm(val1) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});
}

function editNumber(val1) {
    bootbox.prompt("กรุณาป้อนเลขตัวชี้วัดที่ต้องการ", function(result) {                
          if (result != null && result >0) {                          
                    
             var myurl = <?php echo json_encode($urleditnum); ?>; 
             window.location.replace(myurl+"/"+val1+"/"+result);             
          } else {
            //Example.show("Hi <b>"+result+"</b>");                          
          }
    });
}


</script>
</body>
</html>