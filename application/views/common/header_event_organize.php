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
                        <li><a href="<?php echo site_url('event'); ?>"><?php echo $this->lang->line('find_event'); ?></a></li>
                        <li><a href="<?=site_url('myticket'); ?>"><?php echo $this->lang->line('my_tickets'); ?></a></li>
                        <li><a href="<?php echo site_url('event/create'); ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
                        <li><a href="<?php echo site_url('organizer/event'); ?>"><?php echo $this->lang->line('my_events'); ?></a></li>            
                        <li><a href="<?=site_url('help/index'); ?>"><?php echo $this->lang->line('help'); ?></a></li>                        
                    </ul>
                    <!-- Right nav BEGIN -->
                    <div class="pull-right addthis_toolbox">
                        <div class="custom_images">
                        <? if (!$this->session->userdata(SESSION.'user_id')) { ?>
                            <a class="btn btn-success" href="<?php echo site_url('users/login');?>"><?php echo $this->lang->line('login'); ?></a>            
                            <a class="btn btn-success" href="<?php echo site_url('users/register');?>"><?php echo $this->lang->line('register'); ?></a>
                        <?php } else{ ?>
                            <a class="btn btn-success" href="<?php echo site_url('users/account');?>"><?php echo $this->session->userdata(SESSION.'email'); ?></a>
                            
                            <a class="btn btn-danger" href="<?php echo site_url('users/logout');?>"><?php echo $this->lang->line('logout'); ?></a>
                        <?php } ?>                            
                        </div>
                    </div>                    
                    <!-- Right nav END -->
                  
                </div><!-- /.navbar-collapse -->
                
            </div><!-- /.container-fluid -->
            
        </nav>
        
        
    </div>
</div>
<div class="jumbotron sub-nav-container">
    <div class="container">
        <div class="sub-nav-holder">
            <ul class="nav navbar-nav">
                <?php            
                $event_with_no_order = $this->general->is_event_with_no_order($this->uri->segment(count($this->uri->segment_array())));
                ?>
                <?php if($active_event || $event_with_no_order){?>
                <li><a href="<?php echo site_url('event/edit/'.$this->uri->segment(count($this->uri->segment_array()))); ?>"><?php echo $this->lang->line('edit'); ?></a></li>
                <?php }?>            
                <li class="last_right active"><a href="<?php echo site_url('event/organize/'.$this->uri->segment(count($this->uri->segment_array()))); ?>"><?php echo $this->lang->line('manage'); ?></a></li>
                <li class="last-one"><a href="<?php echo site_url('event/view/'.$this->uri->segment(count($this->uri->segment_array()))); ?>" target="_blank"><?php echo $this->lang->line('view'); ?></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
