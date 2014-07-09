<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('logo_view'); ?>
	</div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">กรุณาเลือกระบบที่ต้องการใช้งาน</h3>
                    </div>
                  <form 
					<div class="panel-body">
               			<a href="<?php echo site_url('login/login_minister') ?>" type="button" class="btn btn-primary btn-block">ระบบประเมินผลปฏิบัติราชการระดับส่วนงาน</a>
               			<a href="<?php echo site_url('login/login_person') ?>" type="button" class="btn btn-success btn-block">ระบบประเมินผลปฏิบัติราชการระดับบุคคล</a>
               			<a href="<?php echo site_url('login/login_admin') ?>" type="button" class="btn btn-warning btn-block">ระบบบริหารจัดการข้อมูลพื้นฐาน</a>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('js_footer'); ?>
</body>
</html>