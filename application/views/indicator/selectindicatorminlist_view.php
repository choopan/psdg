<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>


                    <h4>กรุณาเลือกตัวชี้วัดระดับกระทรวง ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h4>

                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead><tr><th width="50">ตัวชี้วัดที่</th><th width="500">ชื่อ</th></tr></thead>
                                <tbody>
                                <?php 
									$id = 0;
									if(is_array($goal_array)) {
                                        foreach($goal_array as $loop){ 
								?>
                                    <tr>
									<td><?php if ($loop['goalid'] > 0) { ?>
									<!-- goals of minister indicators -->
									<input type="checkbox" name="goal_min_id<?php echo $id; ?>" id="goal_min_id<?php echo $id; ?>" value="<?php echo $loop['goalid']; ?>">
									<?php }else{ $id++; ?> 
									<!-- minister indicators -->
									<input type="checkbox" onclick="checkAll(<?php echo $id; ?>);" name="indicator_min_id<?php echo $id; ?>" id="indicator_min_id<?php echo $id; ?>" value="<?php echo $loop['number']; ?>">
									<?php  } ?>
									</td>
                                    <td><?php if ($loop['goalid'] > 0) { 
										if ($loop['number']!="") echo "<u>ประเด็นความสำเร็จที่ ".$loop['number']."</u> ";
										echo $loop['name']; 
									}else{ echo "<strong><u>ตัวชี้วัดที่ ".$loop['number']."</u> ".$loop['name']."</strong>"; }?>
									</td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
							</table>


						<div class="row">
							<div class="col-lg-6">
								<button type="button" class="btn btn-primary" onClick="sendval()">  เพิ่มตัวชี้วัดที่เลือก  </button>
							</div>
						</div>
<br><br><br><br>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">
function checkAll(id) {
	var indicator = document.getElementById('indicator_min_id'+id);
	var markgoal = document.getElementsByName("goal_min_id"+id);
	if (indicator.checked ==true) {
		for (var i = 0; i < markgoal.length; i++) {
			markgoal[i].checked = true;
		}
	}else{
		for (var i = 0; i < markgoal.length; i++) {
			markgoal[i].checked = false;
		}
	}
}

function sendval() {
	var sel= "";
	item = new Array();
	$(":checkbox:checked").each(function(index,data ) {
            item[index] = $(this).val(); 
    });

	$.ajax({
		  type: "POST",
		  url: "<?php echo site_url('manageindicator/saveindicatorsession'); ?>",
		  data: { value: item }
	   })
	alert(item);
	//window.parent.document.getElementById("selectIndicator").value = sel;
	//parent.$.fancybox.close();
}
</script>
</body>
</html>