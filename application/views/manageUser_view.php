<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/plugins/dataTables/jquery.dataTables.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datepicker.css" >

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
            <div class="col-lg-12">
                <h3 class="page-header">จัดการผู้ใช้งาน</h3>
            </div>
        </div>
		
		<div class="row">
            <div class="panel panel-default">
					<div class="panel-heading">
						
							<button type="button" class="btn btn-outline btn-success" onClick="window.location.href='<?php echo site_url("manageuser/adduser"); ?>'">เพิ่มผู้ใช้งาน</button>
							<button class="btn btn-outline btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">กดเพื่อค้นหา</button>
							<b id="cancle"></b>
							
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg">
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myLargeModalLabel">ค้นหา</h4>
								</div>
								<div class="modal-body">

										<div class="row">
											<div class="col-lg-4">
											<div class="form-group">
												<label>Username *</label>
												<input type="text" id="username" class="form-control" value="username" required>
											</div>
											</div>
											<div class="col-lg-4">
											<div class="form-group">
												<label>ชื่อ *</label>
												<input type="text" id="fname" class="form-control">
											</div>
											</div>
											<div class="col-lg-4">
											<div class="form-group">
												<label>นามสกุล *</label>
												<input type="text" id="lname" class="form-control">
											</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
											<div class="form-group">
												<label>กรม *</label>
												<select id="department" class="form-control" onChange="get_division(this.value)">
													<option value="-1">---</option>
													<?php foreach($department as $value0){?>
													<option value="<?php echo $value0['id'];?>"><?php echo $value0['name'];?></option>
													<?php } ?>
												</select>
											</div>
											</div>
											<div class="col-lg-4">
											<div class="form-group">
												<label>กอง *</label>
												<select class="form-control" id="division_db">
													<option value="-1">---</option>
												</select>
											</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
											<div class="form-group">
												<label>ตำแหน่ง *</label>
												<select id="position" class="form-control" >
													<option value="-1">---</option>
													<?php foreach($position as $value1){?>
													<option value="<?php echo $value1['PWPOSITION'];?>"><?php echo $value1['PWNAME'];?></option>
													<?php } ?>
												</select>
											</div>
											</div>
											<div class="col-lg-4">
											<div class="form-group">
												<label>สิทธิผู้ดูแล *</label>
												<select id="admin_mdd" class="form-control" >
													<option value="-1">---</option>
													<option value="admin_min">ระดับกระทรวง</option>
													<option value="admin_dep">ระดับกรม</option>
													<option value="admin_div">ระดับกอง</option>
												</select>
											</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-1">
											<div class="form-group">	
												<button type="button" onClick="get_search()" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">ค้นหา</button>
											</div>
											</div>
										</div>
								  
								</div>
								</div>
							  </div>
							</div>
					</div>
                    <div class="panel-body">
						<?php if($result==1){?>
							<div class="modal fade" id="myModal2">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header model-info">
									<a href="<?php echo site_url("manageuser/user_view");?>" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
									<h4 class="modal-title">แจ้งเตือน</h4>
								  </div>
								  <div class="modal-body">
									<p>ทำการลบข้อมูลแล้ว</p>
								  </div>
								</div>
							  </div>
							</div>
						<?php }?>
						
                        <div class="table-responsive">
						<div class="row" id="page_bott">
							<div class="col-lg-2">
							<div class="form-group">
							<select id="page_select" class="form-control">
								<?php 
								  
								  $loop = $numuser / $limit;
								  for($i = 0; $i < $loop; $i++) {
									$pagenum = $i + 1;
									if($pagenum == $currentPage) { 
										echo "<option value=\"$pagenum\" SELECTED>หน้า $pagenum</option> ";
									} else {
										echo "<option value=\"$pagenum\">หน้า $pagenum</option> ";
									}
								  }
								?>

								</select>
							</div>
							</div>
							<p>
								<?php if($currentPage > 1){?>
									<a href="user_view?pagenum=<?php echo $currentPage-1;?>" class="btn btn-warning btn-outline"> << </a> 
								<?php }else{?>
									<a  class="btn btn-danger"> << </a> 
								<?php }?>
									<input type="text" value=" หน้าที่ <?php echo $currentPage;?> ทั้งหมด <?php echo $i;?> หน้า " style="width:170px; height:35px; margin-left:auto; margin-right:auto; border-style: none;" readonly>
								<?php if($currentPage < $i){?>
									<a href="user_view?pagenum=<?php echo $currentPage+1;?>" class="btn btn-warning btn-outline"> >> </a>
								<?php }else{?>
									<a  class="btn btn-danger"> >> </a> 
								<?php }?>
							</p>
						
						</div>
						<div id="user_db">	
						<table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>กรม</th>
										<th>กอง</th>
										<th>ตำแหน่ง(ระดับ)</th>
                                        <th>E-mail</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php 
									foreach($data2 as $loop){
								?>
									<tr>
                                        <td><?php echo $loop['PWFNAME']." ".$loop['PWLNAME']; ?></td>
                                        <td><?php echo $loop['dep_name']; ?></td>
                                        <td><?php echo $loop['div_name']; ?></td>
                                        <td><?php echo $loop['position_name']." (ระดับ ".$loop['PWLEVEL'].")"; ?></td>
                                        <td><?php echo $loop['PWEMAIL']; ?></td>
										<td>
											<a href='<?php echo "user_view_info/".$loop['USERID']; ?>' class="btn btn-success btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="ดูรายละเอียด"><span class="glyphicon glyphicon-fullscreen"></span></a>
											<a href='<?php echo "user_edit_info/".$loop['USERID']; ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo "user_del_info/".$loop['USERID']; ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
                                    </tr>
							     <?php  } ?>
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
<script src="<?php echo base_url(); ?>js/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
		var table = $('#dataTables-example').DataTable();
		$('#myModal2').modal({
							show:true,
							backdrop:false
							});
		
		$('#page_select').change(function() {
			var pagenum = $("#page_select").val();
			window.location.replace("user_view?pagenum="+ pagenum);											
		});
		
    });
	
	function get_division(val){

	$.ajax({
					'url' : '<?php echo site_url('manageuser/get_division'); ?>/'+val,
					'dataType': 'json',
					'error' : function(data){ 
						alert('error');
                    },
					'success' : function(data){
						$("#division_db").empty();
						var division_num=data.length;
						var tr='<option value="-1">เลือกกอง</option>';
						for(i=0;i<division_num;i++)
						{
							tr+='<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
							
						}
						$(tr).appendTo('#division_db');
                    }
				});
	}
	
	function get_search(){
			var username = $('#username').val();
			var fname = $('#fname').val();
			var lname = $('#lname').val();
			var department = $('#department').val();
			var division = $('#division_db').val();
			var position = $('#position').val();
			var admin_mdd = $('#admin_mdd').val();
			var execode = $('#execode').val();
			$.ajax({
					'url' : '<?php echo site_url('manageuser/get_search'); ?>/',
					'type':'get',
					'data':{username:username,fname:fname,lname:lname,department:department,division:division,position:position,admin_mdd:admin_mdd,execode:execode},
					'dayaType':'json',
					'error' : function(data){ 
						alert('error');
                    },
					'success' : function(data){
						$("#page_bott").empty();
						$("#user_db").empty();
						$("#cancle").empty();
						var bt = '<a href="user_view" class="btn btn-outline btn-danger" >ยกเลิกการค้นหา</a>';
						$('#cancle').append(bt);
						$('#user_db').html(data);
                    }
				});
			
	}
</script>
</body>
</html>