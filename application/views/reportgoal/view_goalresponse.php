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
                <h3 class="page-header">แสดงประเด็นความสำเร็จที่รับผิดชอบ ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
            </div>
        </div>
		
		<div class="row">
            
<?php if ($this->session->flashdata('result')=="success") { echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; }
						  else if ($this->session->flashdata('result')=="fail") echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTables-example">
                                <thead><tr>
									<th rowspan="2" style="width: 30%">ประเด็นความสำเร็จ</th>
									<th rowspan="2" style="width: 10%">สถานะ</th>
                                    <th colspan="3" style="text-align: center">รายงานผลการดำเนินการ</th>
                                    
								</tr>
                                <tr>
                                    <th style="text-align: center">รอบ 6 เดือน</th>    
                                    <th style="text-align: center">รอบ 9 เดือน</th>  
                                    <th style="text-align: center">รอบ 12 เดือน</th>  
                                </tr>
								</thead>
                                <tbody>
                                <?php if(is_array($div_array)) {
                                        foreach($div_array as $loop){ ?>
                                    <tr>
                                    <td><?php echo $loop->gnumber." ".$loop->gname; ?></td>
                                    <td><span class="label label-danger">รอรายงานรอบ 6 เดือน</span></td>
                                    <td style="text-align: center"><a href="<?php echo site_url('reportgoal/addreport/6/'.$loop->goalid); ?>"><button id="buttonselect" type="button" class="btn btn-primary">รายงาน</button></a>
                                    </td>
                                    <td style="text-align: center"><button id="buttonselect" type="button" class="btn btn-primary disabled ">รายงาน</button>
                                    </td>
                                    <td style="text-align: center"><button id="buttonselect" type="button" class="btn btn-primary disabled ">รายงาน</button>
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
<script>
$(".alert-message").alert();
//window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>