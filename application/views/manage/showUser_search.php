
<style type="text/css" class="init">
td.highlight {
    background-color: red !important;
}
</style>
		<table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>กรม/สำนักปลัด</th>
										<th>กอง/หน่วยงาน</th>
                                        <th>E-mail</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody id="user_db">
								<?php 
									foreach($data2 as $loop){
								?>
									<tr>
                                        <td><?php echo $loop['PWFNAME']." ".$loop['PWLNAME']; ?></td>
                                        <td><?php echo $loop['dep_name']; ?></td>
                                        <td><?php echo $loop['div_name']; ?></td>
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

<script type="text/javascript" charset="utf-8">
    $(document).ready(function()
    {
		var table = $('#dataTables-example').DataTable();
		
		$('#page_select').change(function() {
			var pagenum = $("#page_select").val();
			window.location.replace("user_view?pagenum="+ pagenum);											
		});
		
    });
</script>