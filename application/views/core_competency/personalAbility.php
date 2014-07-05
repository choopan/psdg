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
            <div class="col-lg-12">
                <h3 class="page-header">แบบประเมินสมรรถะ</h3>
            </div>
        </div>

        <form class="form-horizontal" action="<?php echo site_url('core_competency/saveAbility'); ?>" method="POST">

		<div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="skillTable">
                                <thead>
                                    <tr>
                                        <th style="width: 400px">ชื่อสมรรณะ</th>
                                        <th>คะแนนคาดหวัง</th>
										<th>คะแนนประเมิน</th>
                                    </tr>
                                </thead>
								<tbody>
										<?php
											$numIndex = 0;
											foreach($array_i as $ind) {
												$numIndex++;
										?>
										<tr>
											<td><?php echo $ind['name']; ?></td>
											<td><?php echo $ind['expectVal']; ?></td>
											<td><input type="text" class="form-control" name="score[]" id="score<?php echo $numIndex; ?>" ></td>
										</tr>
										<?php
											}
										?>
                                </tbody>
							</table>
							
							<div class="form-group row">
									<div class="col-lg-4 col-lg-offset-5">
										<input type="submit" class="btn btn-primary" value="บันทึก">
										<a href="<?php echo site_url('core_competency/'); ?>" class="btn btn-danger">ยกเลิก</a>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
								

	   </form>		
	</div>


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/js/bootbox.min.js"></script>

<script type="text/javascript" charset="utf-8">
	
</script>

</body>
</html>