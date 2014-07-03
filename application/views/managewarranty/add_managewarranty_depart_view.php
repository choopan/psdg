<?php 
	$data['title']='เพิ่มคำรับรองการปฏิบัติราชการ  ระดับกรม';
	$this->load->view('header_view',$data);
?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
	<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>

		<div id="page-wrapper">
		
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">เพิ่มคำรับรองการปฏิบัติราชการ  ระดับกรม</h3>
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
						
						<form method="post" action="<?php echo site_url('managewarranty/save_ratification_depart'); ?>" onSubmit="return chk_add_managewarranty()">
						
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
											<option value="<?php echo $val['id']; ?>"> <?php echo $val['name']; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							
							<div id="recip">
								<input type="hidden" id="num_recip" value="1">
								<div class="row">
									<div class="col-lg-3">
										<label>ผู้รับคำรับรอง <font color="red">*</font></label>
									</div>
									<div class="col-lg-3">
										<label>ตำแหน่ง <font color="red">*</font></label>
									</div>
									<div class="col-lg-3">
										<label>หน่วยงาน <font color="red">*</font></label>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group" >
											<input type="hidden" name="recip_employee_id[]" id="recip_employee_id0" value="">
											<input type="text" class="form-control" name="recip_employee[]" id="recip_employee0" value="" onChange="check_null(this)">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-success">
											<input type="hidden" name="recip_possition_id[]" id="recip_possition_id0" value="">
											<div class="0">
											<input type="text" class="form-control" name="recip_possition_name[]" id="recip_possition_name0" value="" readonly>
											</div>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-success">
											<input type="hidden" name="recip_depname_id[]" id="recip_depname_id0" value="">
											<input type="text" class="form-control" name="recip_depname_name[]" id="recip_depname_name0" value="" readonly>
										</div>
									</div>
									<div class="col-lg-1">
										<div class="form-group">
											<button type="button" class="btn btn-success" id="add_recip" ><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
										</div>
									</div>
								</div>
								
							</div>
							
							<hr/>
							
							<div id="maker">
								<input type="hidden" id="num_maker" value="1">
								<div class="row">
									<div class="col-lg-3">
										<label>ผู้ทำคำรับรอง <font color="red">*</font></label>
									</div>
									<div class="col-lg-3">
										<label>ตำแหน่ง <font color="red">*</font></label>
									</div>
									<div class="col-lg-3">
										<label>หน่วยงาน <font color="red">*</font></label>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input type="hidden" name="maker_employee_id[]" id="maker_employee_id0" value="">
											<input type="text" class="form-control" name="maker_employee[]" id="maker_employee0" value="" onChange="check_null(this)">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-success">
											<input type="hidden" name="maker_possition_id[]" id="maker_possition_id0" value="">
											<div class="0">
											<input type="text" class="form-control" name="maker_possition_name[]" id="maker_possition_name0" value="" readonly>
											</div>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group has-success">
											<input type="hidden" name="maker_depname_id[]" id="maker_depname_id0" value="">
											<input type="text" class="form-control" name="maker_depname_name[]" id="maker_depname_name0" value="" readonly>
										</div>
									</div>
									<div class="col-lg-1">
										<div class="form-group">
											<button type="button" class="btn btn-success" id="add_maker" ><span class="glyphicon glyphicon-plus"></span> เพิ่ม</button>	
										</div>
									</div>
								</div>
								
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
							'<div class="col-lg-3">'+
								'<div class="form-group">'+
									'<input type="hidden" name="recip_employee_id[]" id="recip_employee_id'+num_recip+'" value="">'+
									'<input type="text" class="form-control" name="recip_employee[]" id="recip_employee'+num_recip+'" value="" onChange="check_null(this)">'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-3">'+
								'<div class="form-group has-success">'+
									'<input type="hidden" name="recip_possition_id[]" id="recip_possition_id'+num_recip+'" value="">'+
									'<div class="'+num_recip+'">'+
									'<input type="text" class="form-control" name="recip_possition_name[]" id="recip_possition_name'+num_recip+'" value="" readonly>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-3">'+
								'<div class="form-group has-success">'+
									'<input type="hidden" name="recip_depname_id[]" id="recip_depname_id'+num_recip+'" value="">'+
									'<input type="text" class="form-control" name="recip_depname_name[]" id="recip_depname_name'+num_recip+'" value="" readonly>'+
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
							'<div class="col-lg-3">'+
								'<div class="form-group">'+
									'<input type="hidden" name="maker_employee_id[]" id="maker_employee_id'+num_maker+'" value="">'+
									'<input type="text" class="form-control" name="maker_employee[]" id="maker_employee'+num_maker+'" value="" onChange="check_null(this)">'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-3">'+
								'<div class="form-group has-success">'+
									'<input type="hidden" name="maker_possition_id[]" id="maker_possition_id'+num_maker+'" value="">'+
									'<div class="'+num_maker+'">'+
									'<input type="text" class="form-control" name="maker_possition_name[]" id="maker_possition_name'+num_maker+'" value="" readonly>'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div class="col-lg-3">'+
								'<div class="form-group has-success">'+
									'<input type="hidden" name="maker_depname_id[]" id="maker_depname_id'+num_maker+'" value="">'+
									'<input type="text" class="form-control" name="maker_depname_name[]" id="maker_depname_name'+num_maker+'" value="" readonly>'+
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
									positionid: pwemployee.positionid,
									position: pwemployee.poname,
									depid: pwemployee.depid,
									depname: pwemployee.depname
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
					$("#recip_possition_name"+num).val(ui.item.position);
					$("#recip_depname_name"+num).val(ui.item.depname);
				}else{
					$("#maker_employee_id"+num).val(ui.item.userid);
					$("#maker_possition_name"+num).val(ui.item.position);
					$("#maker_depname_name"+num).val(ui.item.depname);
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
			$.each($("input[name='recip_possition_name[]']"),function(index,value){
				if($(this).val()==''){
					alert('กรุณาป้อนข้อมูลให้ครบ');
					var num_tag=$(this).parent().attr('class');
					$('#recip_employee'+num_tag).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
			$.each($("input[name='maker_possition_name[]']"),function(index,value){
				if($(this).val()==''){
					alert('กรุณาป้อนข้อมูลให้ครบ');
					var num_tag=$(this).parent().attr('class');
					$('#maker_employee'+num_tag).focus();
					ok = false;
					return false;
				}
			}); 
			if(!ok) {return false;}
		}
		
	</script>
	</body>
	</html>