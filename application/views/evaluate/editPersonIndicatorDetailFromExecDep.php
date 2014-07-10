<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Remote file for Bootstrap Modal</title>  
</head>
<body>
	<form class="form-inline" action="<?echo site_url('person_evaluation/savePersonIndicatorDetailFromExecDep')."/".$indicator['ID']."/".$user_id; ?>" method="POST">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">
                 	
                 	ตัวชี้วัดลำดับที่  <input type="text" class="form-control" name="order" value="<?php echo $indicator['order']; ?>" style="width: 10%" required>: 
                 	  <input type="text" class="form-control" name="indicatorName" value="<?php echo $indicator['name']; ?>" style="width: 60%" required>
                 <BR><BR>
                 	ค่าน้ำหนัก : <input type="text" class="form-control" name="weight" value="<?php echo $indicator['weight']; ?>">	                 	
                 </h4>
            </div>            <!-- /modal-header -->
            <div class="modal-body">
  				<table class="table table-striped table-bordered table-hover">
                	<thead>
                    	<tr>
                        	<th style="width: 30%" >เกณฑ์การให้คะแนน</th>
							<th>รายละเอียด</th>
                        </tr>
                    </thead>
					<tbody>
						<tr><td><input style="width: 90%"  type="text" name="indicator1" class="form-control" value="<?php echo $indicator['indicator1']; ?>"></td><td><input style="width: 90%" type="text" name="detail_indicator1" class="form-control" value="<?php echo $indicator['detail_indicator1']; ?>"></td></tr>
						<tr><td><input style="width: 90%"  type="text" name="indicator2" class="form-control" value="<?php echo $indicator['indicator2']; ?>"></td><td><input style="width: 90%" type="text" name="detail_indicator2" class="form-control" value="<?php echo $indicator['detail_indicator2']; ?>"></td></tr>
						<tr><td><input style="width: 90%" type="text" name="indicator3" class="form-control" value="<?php echo $indicator['indicator3']; ?>"></td><td><input style="width: 90%" type="text" name="detail_indicator3" class="form-control" value="<?php echo $indicator['detail_indicator3']; ?>"></td></tr>
						<tr><td><input style="width: 90%" type="text" name="indicator4" class="form-control" value="<?php echo $indicator['indicator4']; ?>"></td><td><input style="width: 90%" type="text" name="detail_indicator4" class="form-control" value="<?php echo $indicator['detail_indicator4']; ?>"></td></tr>
						<tr><td><input style="width: 90%" type="text" name="indicator5" class="form-control" value="<?php echo $indicator['indicator5']; ?>"></td><td><input style="width: 90%" type="text" name="detail_indicator5" class="form-control" value="<?php echo $indicator['detail_indicator5']; ?>"></td></tr>
					</tbody>
				</table>

            </div>            <!-- /modal-body -->
            <div class="modal-footer">
            	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> บันทึกข้อมูล</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
            </div>            <!-- /modal-footer -->
   </form>
</body>
</html>