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
            <div class="col-md-5 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">เข้าสู่ระบบ<?php echo $system_name; ?></h3>
                    </div>
					<?php echo validation_errors(); ?>
					<div class="panel-body">
                        <?php echo form_open('verifylogin'); ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus>
                                    <input type="hidden" name="system" value="<?php echo $system; ?>">
                                    <input type="hidden" name="system_name" value="<?php echo $system_name; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('js_footer'); ?>
</body>
</html>