
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ประเภทตำแหน่ง</th>
										<th>ระดับ</th>
										<th>เครื่องมือ</th>
                                    </tr>
                                </thead>
								<tbody>
								<?php if(is_array($data) && count($data) ) {
									foreach($data as $loop){
								?>
									<tr>
                                        <td><?php echo $loop['name']; ?></td>
										<td><?php echo $loop['pos_lv']; ?></td>
										<td>
											<a href='<?php echo "pos_lv_edit/".$loop['pos_id']; ?>' class="btn btn-primary btn-xs" data-title="View" data-toggle="tooltip" data-target="#view" data-placement="top" rel="tooltip" title="แก้ไข"><span class="glyphicon glyphicon-pencil"></span></a>
											<a href='<?php echo "pos_lv_del/".$loop['pos_id']; ?>' class="btnDelete btn btn-danger btn-xs" onClick='return confirm(" คุณต้องการลบหรือไม่ ")' title="ลบข้อมูล"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
                                    </tr>
									<?php } } ?>
                                </tbody>
							</table>
