<?php 
	$data['title']='แก้ไขคำรับรองการปฏิบัติราชการ  ระดับกรม';
	$this->load->view('header_view',$data);
?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
	<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>

		<div id="page-wrapper">
		
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">แก้ไขคำรับรองการปฏิบัติราชการ  ระดับกรม</h3>
					<!--<div id="debug"></div>-->
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong>กรุณาใส่ข้อมูลให้ครบทุกช่อง</strong>
						</div>				
						<div class="panel-body">
						
						<form method="post" action="<?php echo site_url('managewarranty/update_ratification_depart'); ?>" onSubmit="return chk_add_managewarranty()">
							<input type="hidden" name="warranty_id" value="<?php echo $recip_employee[0]['warranty_id']; ?>">
							<div class="row">
								<div class="col-lg-3">
									<label>เลือกกรม <font color="red">*</font></label>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<select class="form-control" name="department_id" id="department_id">
											<option value="0"> </option>
											<?php foreach($department as $key=>$val){ ?>
											<option value="<?php echo $val['id']; ?>" <?php if($recip_employee[0]['department_id']==$val['id']) echo 'selected'; ?>> <?php echo $val['name']; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							
							<div id="recip">
								<input type="hidden" id="num_recip" value="<?php echo count($recip_employee); ?>">
								<div class="row">
									<div class="col-lg-5">
										<label>ผู้รับคำรับรอง <font color="red">*</font></label>
									</div>
									<div class="col-lg-5">
										<label>ตำแหน่ง <font color="red">*</font></label>
									</div>
								</div>
								<?php $num=count($recip_employee); ?>
								<?php for($i=0;$i<$num;$i++){ ?>
								<div class="row">
									<div class="col-lg-5">
										<div class="form-group" >
											<div class="<?php echo $i; ?>">
												<input type="hidden" name="recip_employee_id[]" id="recip_employee_id<?php echo $i; ?>" value="<?php echo $recip_employee[$i]['user_id']; ?>">
												<input type="text" class="form-control" name="recip_employee[]" id="recip_employee<?php echo $i; ?>" value="<?php echo $recip_employee[$i]['PWFNAME'].' '.$recip_employee[$i]['PWLNAME']; ?>" onChange="check_null(this)">
											</div>
										</div>
									</div>
									<div class="col-lg-5">
										<div class="form-group">
											<input type="text" class="form-control" name="recip_possition_name[]" id="recip_possition_name<?php echo $i; ?>" value="<?php echo $recip_employee[$i]['position_name']; ?>">
										</div>
									</div>
									<div class="col-lg-1">
										<div class="form-group">
										<?php if($i==0){ ?>
											<button type="button" class="btn btn-success" id="add_recip" ><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
										<?php }else{ ?>
											<div>
											<button type="button" class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>
											</div>
										<?php }?>
										</div>
									</div>
								</div>
								<?php } ?>
								
							</div>
							
							<hr/>
							
							<div id="maker">
								<input type="hidden" id="num_maker" value="<?php echo count($maker_employee); ?>">
								<div class="row">
									<div class="col-lg-5">
										<label>ผู้ทำคำรับรอง <font color="red">*</font></label>
									</div>
									<div class="col-lg-5">
										<label>ตำแหน่ง <font color="red">*</font></label>
									</div>
								</div>
								<?php $num=count($maker_employee); ?>
								<?php for($i=0;$i<$num;$i++){ ?>
								<div class="row">
									<div class="col-lg-5">
										<div class="form-group">
											<div class="<?php echo $i; ?>">
												<input type="hidden" name="maker_employee_id[]" id="maker_employee_id<?php echo $i; ?>" value="<?php echo $maker_employee[$i]['user_id']; ?>">
												<input type="text" class="form-control" name="maker_employee[]" id="maker_employee<?php echo $i; ?>" value="<?php echo $maker_employee[$i]['PWFNAME'].' '.$maker_employee[$i]['PWLNAME']; ?>" onChange="check_null(this)">
											</div>
										</div>
									</div>
									<div class="col-lg-5">
										<div class="form-group">
											<input type="text" class="form-control" name="maker_possition_name[]" id="maker_possition_name<?php echo $i; ?>" value="<?php echo $maker_employee[$i]['position_name']; ?>" >
										</div>
									</div>
									<div class="col-lg-1">
										<div class="form-group">
										<?php if($i==0){ ?>
											<button type="button" class="btn btn-success" id="add_maker" ><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
										<?php }else{ ?>
											<div>
											<button type="button" class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>
											</div>
										<?php }?>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
							
							<div class="row">
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> บันทึก </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("managewarranty/department"); ?>'"> กลับ </button>
								</div>
							</div>
						
						</form>
						
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>

	<?php $this->load->view('js_footer'); ?>
	<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			auto_tag("#recip_employee",0,'recip');
			auto_tag("#maker_employee",0,'maker');
			$('#add_recip').click(function(){
				var num_recip=$('#num_recip').val();
				var recip='<div>'+
						'<div class="row">'+
							'<div class="col-lg-5">'+
								'<div class="form-group">'+
									'<div class="'+num_recip+'">'+
										'<input type="hidden" name="recip_employee_id[]" id="recip_employee_id'+num_recip+'" value="">'+
										'<input type="text" class="form-control" name="recip_employee[]" id="recip_employee'+num_recip+'" value="" onChange="check_null(this)">'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-5">'+
								'<div class="form-group">'+
									'<input type="text" class="form-control" name="recip_possition_name[]" id="recip_possition_name'+num_recip+'" value="" >'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-1">'+
								'<div class="form-group">'+
									'<button type="button" class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>'+
								'</div>'+
							'</div>'+
						'</div></div>';
				$(recip).appendTo('#recip');
				auto_tag("#recip_employee",num_recip,'recip');
				$('#num_recip').val(++num_recip);
			});
			
			$('#add_maker').click(function(){
				var num_maker=$('#num_maker').val();
				var maker='<div>'+
						'<div class="row">'+
							'<div class="col-lg-5">'+
								'<div class="form-group">'+
									'<div class="'+num_maker+'">'+
										'<input type="hidden" name="maker_employee_id[]" id="maker_employee_id'+num_maker+'" value="">'+
										'<input type="text" class="form-control" name="maker_employee[]" id="maker_employee'+num_maker+'" value="" onChange="check_null(this)">'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-5">'+
								'<div class="form-group">'+
									'<input type="text" class="form-control" name="maker_possition_name[]" id="maker_possition_name'+num_maker+'" value="">'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-1">'+
								'<div class="form-group">'+
									'<button type="button" class="btn btn-danger" onclick="remove_tag(this)"><span class="glyphicon glyphicon-minus"></span> ลบ</button>'+
								'</div>'+
							'</div>'+
						'</div></div>';
				$(maker).appendTo('#maker');
				auto_tag("#maker_employee",num_maker,'maker');
				$('#num_maker').val(++num_maker);
			});

		});
		
		function check_null(obj)
		{
			var value_before=$(obj).val();
			$(obj).val(value_before.trim());
		}
		
		function remove_tag(obj)
		{
			$(obj).parent().parent().parent().parent().remove();
		}
		
		function auto_tag(tag,num,select)
		{
			$(tag+num).autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('managewarranty/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
					error: function(data){
							alert('error');
						},
                    success: function(data) {
							//$('#debug').html(JSON.stringify(data));
							
							 response($.map(data,function(pwemployee){
                                return {
									value: pwemployee.pwname,
									userid: pwemployee.userid,
                                    };
                            }));
							
							//alert(data);
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			mustMatch: true,
			select: function(event,ui){
				if(select=='recip'){
					$("#recip_employee_id"+num).val(ui.item.userid);
				}else{
					$("#maker_employee_id"+num).val(ui.item.userid);
				}
			}
			});
			
		}
		
		function chk_add_managewarranty()
		{
			var department_id=$('#department_id').val();
			if(department_id==0){
				alert('กรุณาป้อนข้อมูลให้ครบ');
				$('#department_id').focus();
				return false;
			}
			var ok = true;
			$.each($("input[name='recip_employee_id[]']"),function(index,value){
				if($(this).val()==''){
					alert('ป้อนข้อมูลไม่ครบหรือรายชื่อไม่ถูกต้อง');
					var num_tag=$(this).parent().attr('class');
					$('#recip_employee'+num_tag).val('');
					$('#recip_employee'+num_tag).focus();
					$(this).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
			$.each($("input[name='recip_possition_name[]']"),function(index,value){
				if($(this).val()==''){
					alert('กรุณาป้อนข้อมูลให้ครบ');
					$(this).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
			$.each($("input[name='maker_employee_id[]']"),function(index,value){
				if($(this).val()==''){
					alert('ป้อนข้อมูลไม่ครบหรือรายชื่อไม่ถูกต้อง');
					var num_tag=$(this).parent().attr('class');
					$('#maker_employee'+num_tag).val('');
					$('#maker_employee'+num_tag).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
			$.each($("input[name='maker_possition_name[]']"),function(index,value){
				if($(this).val()==''){
					alert('กรุณาป้อนข้อมูลให้ครบ');
					$(this).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
		}
		
	</script>
	</body>
	</html>