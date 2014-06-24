<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	<?php $url = site_url("manageindicator/deletePerson"); ?>
	
	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">แสดงตัวชี้วัดระดับบุคคล ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h3>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ผู้รับผิดชอบ</th>
										<th>ตำแหน่ง</th>
										<th>จัดการ</th>
                                    </tr>
                                </thead>

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
            'sAjaxSource'    : '<?php echo site_url("manageindicator/getdataPersonAndButtonbyajax"); ?>',
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
function del_confirm(val1) {
	alert('a');
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = <?php echo json_encode($url); ?>;
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});
}


</script>
</body>
</html>