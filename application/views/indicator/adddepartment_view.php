<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<style type="text/css" class="init">


td.highlight {
    background-color: red !important;
}


	</style>
</head>

<body>
	<div id="wrapper">
	<?php $this->load->view('menu'); ?>
	
	
	
<div id="page-wrapper">
	<div class="row">
        <div class="col-md-11">
            <div class="panel panel-default">
				<div class="panel-heading">
					<strong>กำหนดตัวชี้วัดและประเด็นความสำเร็จ <u>ระดับกรม</u></strong>
                </div>
                <div class="panel-body">
                            <!-- Nav tabs -->


                            <!-- Tab panes -->

					<?php if ($this->session->flashdata('success')) echo '<div class="alert-message alert alert-success"> ระบบทำการเพิ่มข้อมูลเรียบร้อยแล้ว</div>'; 
						  else if ($this->session->flashdata('fail')) echo '<div class="alert-message alert alert-danger"> ระบบไม่สามารถเพิ่มข้อมูลได้</div>';
					
					?>
						<?php echo form_open('manageindicator/saveDepartment'); ?>

						
						<div class="row">
							<div class="col-md-4">
									<div class="form-group">
                                        <label>กรม *</label>
										<select class="form-control" name="departmentid" id="departmentid" onchange="savedepid(this);">
											<option value="">---เลือกกรม---</option>
										<?php 	if(is_array($dep_array)) {
												foreach($dep_array as $loop){
													echo "<option value='".$loop->id."'";
                                                    if ($depid == $loop->id) echo " selected";
                                                    echo ">".$loop->name."</option>";
										 } } ?>
                                        </select>
                                    </div>
							</div>
						</div>
						
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
					<div class="panel-heading"><strong>รายการตัวชี้วัดและประเด็นความสำเร็จของกระทรวงที่เลือก</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive" id="dtbody">
						<!--<button id="buttonselect" type="button" class="btn btn-primary">แสดงเฉพาะตัวชี้วัดที่เลือก</button> -->
						<!-- show all indicator minister -->
						<a id="fancyboxall" href="<?php echo site_url("manageindicator/selectIndicatorMinisterList");  ?>"><button id="buttonselect" type="button" class="btn btn-primary">แสดงตัวชี้วัดกระทรวง</button></a>
                        
						<table class="table" id="dataTables-example">
                                <thead>
                                    <tr>
										<th style="text-align: center; width: 10%">ตัวชี้วัดที่</th>
										<th>ชื่อตัวชี้วัด</th>
										<th style="text-align: center; width: 12%">ค่าเป้าหมาย</th>
										<th style="text-align: center; width: 12%">น้ำหนัก</th>
                                        <th style="width: 3%"></th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for ($i=0; $i<count($indicator_min_id); $i++) {
										if ($indicator_min_id[$i] >0) {
                                        ?>
                                    <tr style="background-color: #E0FFFF;">
									<td style="text-align: center">
										<?php //echo $indicator_min_id[$i]; ?>
									</td>
                                    <td>
                                    <a id="buttonadddep" href="<?php echo site_url("manageindicator/addNewIndicatorDepFromInMin/".$indicator_min_id[$i]);  ?>">
										<?php echo $indicator_min_name[$i]['name'];
											
										?></a>&nbsp;&nbsp;
                                    <span class="label label-danger">รอการแก้ไขข้อมูล</span>
									</td>
									<td style="text-align: center">
									</td>
									<td style="text-align: center">
									</td>
                                    </tr>
                                <?php  } } ?>
								
								<?php for ($i=0; $i<count($goal_min_id); $i++) {
										if ($goal_min_id[$i] >0) {
                                        ?>
                                    <tr>
									<td style="text-align: center">
										<?php //echo $goal_min_id[$i]; ?>
									</td>
                                    <td>
                                        <a id="buttonadddep" href="<?php echo site_url("manageindicator/addNewIndicatorDepFromGoalMin/".$goal_min_id[$i]);  ?>">
										<?php echo $goal_min_name[$i]['name']; ?>
                                        </a>&nbsp;&nbsp;
                                        <span class="label label-danger">รอการแก้ไขข้อมูล</span>
									</td>
									<td style="text-align: center">
									</td>
									<td style="text-align: center">
									</td>
                                    </tr>
                                <?php  } } ?>
                                    
                                <?php foreach($newmin_array as $newmin) { ?>
                                    <tr>
                            <input type="hidden" name="newminid[]" id="newminid" value="<?php echo $newmin->id; ?>">
                                    <td style="text-align: center"><?php echo $newmin->number; ?></td>
                                    <td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkDep/".$newmin->id);  ?>"><?php echo $newmin->name; ?></a></td>
                                    <td style="text-align: center"><?php echo $newmin->goal; ?></td>
                                    <td style="text-align: center"><?php echo $newmin->weight; ?></td>
                                    <td><button type="button" class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $newmin->id; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button></td>
                                    </tr>
								<?php } ?>
                                    
                                <?php foreach($newgoal_array as $newmin) { ?>
                                    <tr>
                            <input type="hidden" name="newgoalid[]" id="newgoalid" value="<?php echo $newmin->id; ?>">
                                    <td style="text-align: center"><?php echo $newmin->number; ?></td>
                                    <td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkDep/".$newmin->id);  ?>"><?php echo $newmin->name; ?></a></td>
                                    <td style="text-align: center"><?php echo $newmin->goal; ?></td>
                                    <td style="text-align: center"><?php echo $newmin->weight; ?></td>
                                    <td><button type="button" class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $newmin->id; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button></td>
                                    </tr>
								<?php } ?>
                                </tbody>
								
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
		
		<div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
					<div class="panel-heading"><strong>รายการตัวชี้วัดของกรม</strong> </div>
                    <div class="panel-body">
                        <div class="table-responsive">
						<a id="buttonadddep" href="<?php echo site_url("manageindicator/addNewIndicatorDep");  ?>"><button type="button" class="btn btn-success">เพิ่มตัวชี้วัดของกรม</button></a>
                            <table class="table" id="dataTables-example2" cellspacing="0px" width="100%">
                                <thead>
                                    <tr>
										<th style="text-align: center;width: 10%">ตัวชี้วัดที่</th>
										<th>ชื่อตัวชี้วัด</th>
										<th style="text-align: center;width: 12%">ค่าเป้าหมาย</th>
										<th style="text-align: center;width: 12%">น้ำหนัก</th>
                                        <th style="width: 3%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($indicatordep_array)) {
                                        foreach($indicatordep_array as $loop){ ?>
                                    <tr>
                                    <td style="text-align: center"><input type="hidden" name="newdepid[]" id="newdepid" value="<?php echo $loop->id; ?>"><?php echo $loop->number; ?></td>
                                    <td><a id="fancyboxview" href="<?php echo site_url("manageindicator/viewIndicatorLinkDep/".$loop->id);  ?>"><?php echo $loop->name; ?></a></td>
                                    <td style="text-align: center"><?php echo $loop->goal; ?></td>
                                    <td style="text-align: center"><?php echo $loop->weight; ?></td>
                                    <td><button type="button" class="btnDelete btn btn-danger btn-xs" onclick="del_confirm(<?php echo $loop->id; ?>)" data-title="Delete" data-toggle="modal" data-target="#delete" data-placement="top" rel="tooltip" title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></button></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>

						<div class="row">
							<div class="col-md-6">
									<button type="submit" class="btn btn-primary">  บันทึก  </button>
									<button type="button" class="btn btn-warning" onClick="window.location.href='<?php echo site_url("main"); ?>'"> ยกเลิก </button>
							</div>
						</div>
								
									
						</form>

					</div>
				</div>
			</div>	
		</div>

                        <!-- /.panel-body -->
</div>
                    <!-- /.panel -->


<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>



<script type="text/javascript">
var rowNum = 0;
var rowNumRes = 0;
function addNewForm(frm) {
	rowNum ++;
	var row = '<div class="row" id="rowNum'+rowNum+'"><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="goalNO[]" id="goalNO" value="<?php echo set_value('goalNO'); ?>"><p class="help-block"><?php echo form_error('goalNO'); ?></p></div></div><div class="col-md-7"><div class="form-group"><input type="text" class="form-control" name="goalName[]" id="goalName" value="<?php echo set_value('goalName'); ?>"><p class="help-block"><?php echo form_error('goalName'); ?></p></div></div><div class="col-md-1"><div class="form-group"><button id="addNew" type="button" onClick="removeNewForm('+rowNum+');" class="btn btn-danger">ลบ</button></div></div></div>';
	$( ".addinput" ).append(row);
	frm.add_qty.value = '';
	frm.add_name.value = '';


}
function removeNewForm(rnum) {
jQuery('#rowNum'+rnum).remove();
}
function addNewFormResponse(idd) {

	while (idd<6) {
		var post1 = document.getElementById('addinputResponse'+idd);
		if (post1.style.display == 'block')  idd++;
		else { 
			post1.style.display = 'block';
			break;
		}
		
	}
		



}
function removeNewFormResponse(idd) {
	var post1 = document.getElementById('addinputResponse'+idd);
	if (post1.style.display == 'block') {
		post1.style.display = 'none';
		$("#resid"+idd).val("");
		$("#position"+idd).val("");
		$("#telephone"+idd).val("");
		$("#uid"+idd).val("");
	}
}

 function savedepid(obj) {
     var depid = $(obj).val();
     $.ajax({
        url: "<?php echo site_url('manageindicator/savedepid'); ?>",
        method: "POST",
        data: {depid: depid},
        success: function(data) {
            //alert(depid);
        }
    });
 }
    

function del_confirm(val1) {
	bootbox.confirm("ต้องการลบข้อมูลที่เลือกไว้ใช่หรือไม่ ?", function(result) {
				var currentForm = this;
				var myurl = "<?php echo site_url('manageindicator/deleteDepTemp'); ?>";
            	if (result) {
				
					window.location.replace(myurl+"/"+val1);
				}

		});
}

</script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
		/*
        var table = $('#dataTables-example').DataTable		
        ({
            "bJQueryUI": false,
            "bProcessing": true,
            "sPaginationType": "simple_numbers",
			'bFilter'  : false,
			"bInfo": false,
			"bLengthChange" : false,
			"bPaginate" : false,
			"iDisplayLength": 10000,
            "bDeferRender": false,
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
	 
		$('#dataTables-example tbody').on( 'click', 'tr', function () {
        	$(this).toggleClass('selected');
    	} );
		
		$('#buttondel').click( function () {
			table.row('.selected').remove().draw( false );
		} );
		
		$('#buttonselect').click( function () {
			var selectrow = table.rows( '.selected' ).data() ;
			table.clear();
				table.rows.add(selectrow).draw();
		} );
		*/

	 


    });


</script>
<script type='text/javascript'> 
$(document).ready(function() {
$('#fancyboxall').fancybox({ 
'width': '80%',
'height': '80%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'afterClose': function() {  parent.location.reload(true); },
'type':'iframe',
}); 
});
 </script>
 <script type='text/javascript'> 
$(document).ready(function() {
$('#fancyboxview').fancybox({ 
'width': '80%',
'height': '100%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'type':'iframe'}); 
});
 </script>
<script type='text/javascript'> 
$(document).ready(function() {
$('#buttonadddep').fancybox({ 
'width': '90%',
'height': '100%', 
'autoScale':false,
'transitionIn':'none', 
'transitionOut':'none', 
'afterClose': function() {  parent.location.reload(true); },
'type':'iframe'}); 
});
 </script>
<script type="text/javascript">
$(document).ready(function()
{



	$(function(){


		$('#residdep').autocomplete({
			source: function(request, response){
				 $.ajax({
                    url: "<?php echo site_url('manageindicator/autocompleteResponse'); ?>",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(pwemployee) {
                                return {
									id: pwemployee.userid,
									//position: pwemployee.poname,
									positionid: pwemployee.positionid,
                                    pwname: pwemployee.pwname,
									value: pwemployee.pwname,
									pwtelephone: pwemployee.pwtelephone

                                    };
                            }));
                        }
                    });
    

			},
			minLength: 2,
			autofocus: true,
			select: function (event, ui) {
            event.preventDefault();
            //$("#position").val(ui.item.position);
			$("#residdep").val(ui.item.pwname);
			$("#positiondep").val(ui.item.positionid);
			$("#telephonedep").val(ui.item.pwtelephone);
			$("#uiddep").val(ui.item.id);
        }
		});

		
		
	});

	
	
});
</script>

<script>
$(".alert-message").alert();
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
</script>
</body>
</html>