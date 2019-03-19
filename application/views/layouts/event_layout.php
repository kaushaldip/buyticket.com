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
                            <li><a href="<?php echo site_url("event/create") ?>" target="_blank"><?php echo $this->lang->line('create_event') ?></a></li>
                            <li><a href="<?php echo site_url("event/index") ?>" target="_blank"><?php echo $this->lang->line('find_event') ?></a></li>
                        </ul>
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox pull-right">
                            <div class="custom_images">
                                <a class="addthis_button_facebook"><img src="<?=MAIN_IMAGES_DIR_FULL_PATH?>fb.png" /></a>
                                <a class="addthis_button_twitter"><img src="<?=MAIN_IMAGES_DIR_FULL_PATH?>tw.png" /></a>
                                <a class="addthis_button_google_plusone_share"><img src="<?=MAIN_IMAGES_DIR_FULL_PATH?>gp.png" /></a>
                            </div>
                        </div>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51e850956b0d3a6e"></script>
                        <!-- AddThis Button END -->
                      
                    </div><!-- /.navbar-collapse -->
                    
                </div><!-- /.container-fluid -->
                
            </nav>
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