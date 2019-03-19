<?php echo $this->load->view('common/head');?>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron list-jumb dashboard-menu">
    	<div class="container">
        	<nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo site_url(); ?>"> <img src="<?php echo MAIN_IMAGES_DIR_FULL_PATH;?>logo.png" alt="<?php echo SITE_NAME ?>" class="img-responsive"/></a>
                </div>
        
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
                    <ul class="nav navbar-nav">
                        <li <?php if(@$nav == 'users'){echo ' class="active"';} ?>><a href="<?=site_url('users/account') ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
                        <?php if( $this->general->is_referral_user($this->session->userdata(SESSION.'user_id')) || $this->general->has_event_referral_url($this->session->userdata(SESSION.'user_id'))){ ?>
                        <li <?php if(@$nav == 'affiliate'){echo ' class="active"';} ?>><a href="<?=site_url('affiliate/index') ?>"><?php echo $this->lang->line('affiliate_dashboard'); ?></a></li>
                        <?php } ?>
                        <?php if($this->general->has_event_by_organizer()){ ?>            
                        <li <?php if(@$nav == 'organizer'){echo ' class="active"';} ?>><a href="<?=site_url('organizer/event') ?>"><?php echo $this->lang->line('organizer_dashboard'); ?></a></li>
                        <?php } ?>            
                        <li <?php if(@$nav == 'event'){echo ' class="active"';} ?>><a href="<?=site_url('event/create') ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
                    </ul>
                  
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
               <a href="<?php echo site_url("users/logout"); ?>" class="head-btn btn-blue log-out"><i class="fa fa-sign-out"></i><?php echo $this->lang->line('logout') ?></a>
            </nav>
        </div>
    </div>
    
    <div class="jumbotron main-jumb"> 
   		 <div class="container">
            <div class="row">
                <div class="col-md-1 col-sm-12">
                   <div class="account-img">
                   		<img src="<?php echo MAIN_IMAGES_DIR_FULL_PATH;?>acc-pic.png" alt="" class="img-responsive img-circle">
                   </div>
                </div>                
                <div class="col-md-10 col-sm-12">
                  	<div class="account-info">
                   		<p><strong><?php echo (!empty($profile_data->first_name) && !empty($profile_data->last_name))? ucwords($profile_data->first_name.' '.$profile_data->last_name)."<br/>": "";?></strong>
                        <strong><?php echo strtolower($profile_data->email);?></strong><br />
                        <?php echo $this->lang->line('joined_on'); ?>: <?php echo $this->general->date_language($this->general->date_time_formate($profile_data->last_modify_date));?><br/>
                        <?php echo $this->lang->line('last_update_on'); ?>:<?php echo $this->general->date_language($this->general->date_time_formate($profile_data->last_modify_date));?> </p>
                        <div class="clearfix"></div>
                        <?php if(@$nav == 'organizer'){ ?>
                        <div id="organizer_status_info" style="clear: both; float:left;">
                            <strong><?php echo $this->lang->line('organizer')?> <?php echo $this->lang->line('status')?></strong>:
                            <?php
                            if($profile_data->organizer=='1'){                        
                            ?>
                                <font color='green'><?php echo $this->lang->line('verified')?> </font>
                            <?php
                            }                        
                            else if($profile_data->organizer=='2'){                        
                            ?>
                                <font color='orange'><?php echo $this->lang->line('pending_verification')?></font>
                            <?php
                            }                        
                            else if($profile_data->organizer=='0'){
                                
                            ?>
                                <font color='red'><?php echo $this->lang->line('not_verified')?></font>
                            - (<a data-toggle="modal" href="#verify_organizer_info"><?php echo $this->lang->line('learn_more')?></a>)
                            <div class="modal fade" id="verify_organizer_info" tabindex="-1" role="dialog" aria-labelledby="verify_organizer_infoLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"><?php echo $this->lang->line('Why should I verify my account?')?></h4>
                                  </div>
                                  <div class="modal-body">
                                    <?php echo $this->lang->line("1- Post your public events on buyticket's Catalog")?><br />
                                    <?php echo $this->lang->line("2- Post your public events on social media")?><br />
                                    <?php echo $this->lang->line("3- Allow marketer to market your public event")?><br />
                                    <?php echo $this->lang->line("4- Receive Payment")?><br />  
                                  </div>
                                  <div class="modal-footer">
                                    <a href="<?=site_url('organizer/index')?>" class="btn btn-success"><?php echo $this->lang->line("Verify your account")?></a>                                    
                                  </div>
                                </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <?php
         
                            }
                                
                            ?>                    
                        </div>
                        <?php } ?>  
                   </div>
                </div>  
            </div>
         </div>
    </div>
    <div class="container account-details">
        <!--Vertical Tab-->
        <div id="parentVerticalTab">            
            <!--body section start -->
            <?php echo $template['body']; ?>
            <!--body section end -->
        </div>
    </div><!--container account-details-->
   
    <!--footer sec start-->
    <?php echo $this->load->view('common/footer');?>
    <!--footer sec end-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
  
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script src="<?php echo MAIN_JS_DIR_FULL_PATH;?>bootstrap.min.js"></script>
   
  </body>
</html>