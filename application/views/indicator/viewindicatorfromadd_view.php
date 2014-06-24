<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('header_view'); ?>
</head>

<body>


                    <h4>แสดงตัวชี้วัดระดับกระทรวง ปีงบประมาณ <?php echo $this->session->userdata('sessyear'); ?></h4>

                            <table class="table table-striped row-border table-hover" id="dataTables-example">
                                <thead><tr><th>ตัวชี้วัด</th><th>ชื่อ</th><th>เป้าหมาย</th><th>น้ำหนัก</th><th>หน่วยงาน</th></tr></thead>
                                <tbody>
                                <?php if(is_array($view_array)) {
                                        foreach($view_array as $loop){ ?>
                                    <tr>
                                    <td><?php echo $loop->number; ?></td>
                                    <td><?php echo $loop->name; ?></td>
                                    <td><?php echo $loop->goal; ?></td>
                                    <td><?php echo $loop->weight; ?></td>
                                    <td><?php echo $loop->TDepName; ?></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
							</table>



<br><br><br><br>

<?php $this->load->view('js_footer'); ?>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/js/plugins/dataTables/dataTables.bootstrap.js"></script>

</body>
</html>