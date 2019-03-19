<div class="navbar navbar-fixed-top header_inside">
  <div class="navbar-inner">
    <div class="main">
    <?php if(isset($header_small)=='yes'):?>
        
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_preferred_1"></a>
        <a class="addthis_button_preferred_2"></a>
        <a class="addthis_button_preferred_3"></a>
        </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51e850956b0d3a6e"></script>
        <!-- AddThis Button END --> 
    <?php endif; ?>    	
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="logo" href="<?php echo site_url(); ?>">
        <img src="<?php echo MAIN_IMG_DIR_FULL_PATH;?>logo_small.png" />
      </a>
      <div class="nav-collapse collapse menu">
        <ul class="nav">
        	<li><a href="<?php echo site_url('event/add'); ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
            <li class="last_right"><a href="<?php echo site_url('event'); ?>"><?php echo $this->lang->line('find_event'); ?></a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>