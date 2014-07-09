<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Remote file for Bootstrap Modal</title>  
</head>
<body>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">ตัวชี้วัดลำดับที่  <?php echo $indicator['order']; ?>: <?php echo $indicator['name']; ?>
                 <BR>ค่าน้ำหนัก : <?php echo $indicator['weight']; ?>	                 	
                 </h4>
                 
            </div>            <!-- /modal-header -->
            <div class="modal-body">
  				<table class="table table-striped table-bordered table-hover">
                	<thead>
                    	<tr>
                        	<th style="width: 30%">เกณฑ์การให้คะแนน</th>
							<th>รายละเอียด</th>
                        </tr>
                    </thead>
					<tbody>
						<tr><td><?php echo $indicator['indicator1']; ?></td><td><?php echo $indicator['detail_indicator1']; ?></td></tr>
						<tr><td><?php echo $indicator['indicator2']; ?></td><td><?php echo $indicator['detail_indicator2']; ?></td></tr>
						<tr><td><?php echo $indicator['indicator3']; ?></td><td><?php echo $indicator['detail_indicator3']; ?></td></tr>
						<tr><td><?php echo $indicator['indicator4']; ?></td><td><?php echo $indicator['detail_indicator4']; ?></td></tr>
						<tr><td><?php echo $indicator['indicator5']; ?></td><td><?php echo $indicator['detail_indicator5']; ?></td></tr>
					</tbody>
				</table>

            </div>            <!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> ปิด</button>
            </div>            <!-- /modal-footer -->
</body>
</html>