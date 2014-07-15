<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('menu_person'); ?>
<div id="page-wrapper">
	
	<div class="row">
		<div class="col-lg-12">
			<?php 	if($this->session->flashdata('success')) {
			?>
						<div class="alert alert-success alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('success'); ?>
						</div>
			<?php	} elseif($this->session->flashdata('failed')) { ?>
						<div class="alert alert-danger alert-dismissable">
  							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  			<?php			echo $this->session->flashdata('failed'); ?>
						</div>
			<?php	} 
					
			?>
				
            <div class="panel panel-primary">
				<div class="panel-heading"><h4><strong>รายงานผลการปฏิบัติราชการรายบุคคล</strong></h4></div>
				<div class="panel-body">
					<table class="table table-hover" id="history_table">
						<thead>
							<tr>
								<th>ปีงบประมาณ</th>							
								<th>รอบ</th>
								<th>กรม</th>
								<th>กอง</th>
								<th>ดูรายละเอียด</th>
							</tr>
						</thead>
						<tbody>	
								<?php
									
									foreach($historyEvals as $he) {										
								?>
									<tr>
										<td><?php echo $he['year']; ?></td>
										<td><?php echo $he['round']; ?></td>
										<td><?php echo $he['dep_name']; ?></td>
										<td><?php echo $he['div_name']; ?></td>
										<td>
											<?php 
											echo "<a href='". site_url('person_evaluation/viewHistoryEvaluation') ."/". $he['pid'] ."' class='btn btn-primary' type='button'> ดูรายละเอียด</a>";
											?>
										</td>
                            		</tr>
                            		
								<?php       		
									}								
								?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


</div>
</div>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" charset="utf-8">	
		$(document).ready(function() {
		$('#history_table').dataTable({
			"paging": false,
			"info":     false,
		});
	});
</script>
</body>
</html>