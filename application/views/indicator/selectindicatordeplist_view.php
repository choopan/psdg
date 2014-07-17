<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>
<?php foreach($dep_array as $dep) { $depname = $dep->name; $depid = $dep->id; }?>

                    <h4>กรุณาเลือกตัวชี้วัดจากกรม <strong><u><?php echo $depname; ?></u></strong> ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h4>

                            <table class="table" id="dataTables-example">
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
									<input type="checkbox" onclick="checkAll(<?php echo $id; ?>);" name="indicator_min_id<?php echo $id; ?>" id="indicator_min_id<?php echo $id; ?>" value="<?php echo $loop['id']; ?>">
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
								<button type="button" class="btn btn-primary" onClick="sendval(<?php echo $id; ?>)">  เพิ่มตัวชี้วัดที่เลือก  </button>
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
	if (indicator.checked) {
		for (var i = 0; i < markgoal.length; i++) {
			markgoal[i].checked = true;
		}
	}else{
		for (var i = 0; i < markgoal.length; i++) {
			markgoal[i].checked = false;
		}
	}
}

function sendval(id) {
	var indicator = [];
	var goal =  [];
	var in_temp;
	var goal_temp;
	for (var i=1; i<id+1; i++) {
		in_temp = document.getElementById('indicator_min_id'+i);
		if (in_temp.checked) {
			indicator.push(in_temp.value);
		}else{
			goal_temp = document.getElementsByName("goal_min_id"+i);
			for (var j = 0; j < goal_temp.length; j++) {
				if (goal_temp[j].checked) {
					goal.push(goal_temp[j].value);
				}
			}
		}
		
	}
	//alert(indicator+" / "+goal);


	$.ajax({
		  url: "<?php echo site_url('manageindicator/saveIndicatorDepSession'); ?>",
		  type: "POST",
		  data: { indicator:indicator, goal:goal },
		  'error' : function(data){ 
				alert('error');
          },
		  'success': function(data){
				parent.$.fancybox.close();
		  }
	   })

	
	//window.parent.document.getElementById("selectIndicator").value = sel;
	//parent.$.fancybox.close();
}
</script>
</body>
</html>