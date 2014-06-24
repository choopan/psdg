<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	
<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
					กำหนดตัวชี้วัด
                </div>
                        <!-- /.panel-heading -->
                <div class="panel-body">
                            <!-- Nav tabs -->
							
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">การบริหารยุทธศาสตร์การต่างประเทศ</a>
                                </li>
                                <li><a href="#profile" data-toggle="tab">การประเมินผลการปฏิบัติราชการ</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
									<br/><p><center><button type="button" class="btn btn-primary btn-block custom-btn-block" onClick="window.location.href='<?php echo site_url("manageindicator/addIndicatorMinister"); ?>'">กำหนดตัวชี้วัดและประเด็นความสำเร็จ</button></center></p><br/>
									<p><center><button type="button" class="btn btn-primary btn-block custom-btn-block">แผนการบริการยุทธศาสตร์ปีงบประมาณก่อนหน้า</button></center></p><br/><br/>
                                </div>
                                <div class="tab-pane fade" id="profile">
                                    <br/><p><center><button type="button" class="btn btn-success btn-block custom-btn-block">กำหนดตัวชี้วัดสำหรับการปฏิบัติราชการ</button></center></p><br/>
									<p><center><button type="button" class="btn btn-success btn-block custom-btn-block">ส่งรายงานผลการปฏิบัติราชการ</button></center></p><br/>
									<p><center><button type="button" class="btn btn-success btn-block custom-btn-block">พิมพ์/เรียกดูผลการปฏิบัติงานย้อนหลัง</button></center></p><br/><br/>
								</div>
                                
                            </div>
                </div>
                        <!-- /.panel-body -->
            </div>
                    <!-- /.panel -->
        </div>
	</div>
</div>
</div>

<?php $this->load->view('js_footer'); ?>
</body>
</html>