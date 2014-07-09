        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><img style="max-width:90px; margin-top: -7px;" src="<?php echo base_url(); ?>images/logo.png"> ระบบข้อมูลสารสนเทศเพื่อการบริหารงานยุทธศาสตร์ของกระทรวงการต่างประเทศ</a>
            </div>
            <!-- /.navbar-header -->


            <ul class="nav navbar-top-links navbar-right">
				ผู้ใช้งาน :  <strong><?php echo $this->session->userdata('sessfirstname')." ".$this->session->userdata('sesslastname'); ?></strong>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url("main/changepass"); ?>"><i class="fa fa-gear fa-fw"></i> เปลี่ยนรหัสผ่าน</a>
                        </li>
						<!--
						<li><a href="<?php echo site_url("main/changeyear"); ?>"><i class="fa fa-gear fa-fw"></i> เปลี่ยนปีงบประมาณ</a>
                        </li>
						-->
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url("main/logout"); ?>"><i class="fa fa-sign-out fa-fw"></i> ออกจากระบบ</a>
                        </li>
                    </ul>

                </li>

            </ul>


            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">

                        </li>
                        <li>
                            <a href="<?php echo site_url("main"); ?>"><i class="fa fa-dashboard fa-fw"></i> หน้าแรก (MENU PERSON)</a>
                        </li>
						<li>
							<?php
								$evalRound = $this->personindicator->getActiveEvalRound();
								if(count($evalRound) == 0) {
									$year = "?";
									$round = "?";
								} else {
									$year = $evalRound[0]['year'];
									$round = $evalRound[0]['round'];
								}
							?>
							<a href="#">
                            <i class="fa fa-calendar fa-fw"></i> ปีงบประมาณ <strong><?php echo $year; ?></strong>
                            		รอบที่  <strong><?php echo $round; ?></strong>
                            </a>
                        </li>
                        
                            	<?php if($this->session->userdata('sessexecdep') != 1) { ?>
                                <li><a href="<?php echo site_url("person_evaluation/managePersonIndicator"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> กำหนดตัวชี้วัด</a></li>
                                <li><a href="<?php echo site_url("person_evaluation/managePersonEvaluation"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> รายงานผลการปฏิบัติการ </a></li>
                                <li><a href="<?php echo site_url("person_evaluation/managePersonEvaluation"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> ผลการปฏิบัติการย้อนหลัง </a></li>
                                <?php } ?>
                                
								<?php   if ($this->session->userdata('sessadmin_min') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonIndicator"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/minManagePersonEvaluation"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงรายงานผลปฏิบัติการ</a></li>									
								<?php   } elseif($this->session->userdata('sessexecdiv') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/divManagePersonIndicator"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/divManagePersonEvaluation"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงรายงานผลปฏิบัติการ</a></li>
                                <?php   } elseif($this->session->userdata('sessexecdep') == 1) { ?>
                                	<li><a href="<?php echo site_url("person_evaluation/depManagePersonIndicator"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงตัวชี้วัดรายบุคคล</a></li>
                                	<li><a href="<?php echo site_url("person_evaluation/depManagePersonEvaluation"); ?>"><i class='fa fa-bar-chart-o fa-fw'></i> แสดงรายงานผลปฏิบัติการ</a></li>
                                <?php   } ?>                            
                    </ul>
                </div>
            </div>  
        </nav>