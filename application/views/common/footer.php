<div class="jumbotron footer">
  <div class="container footer-top">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h3><?php echo $this->lang->line('event_catalog'); ?></h3>
        <ul class="footer-list">
            <?php $event_catolog=$this->general->get_event_catalog();
            foreach($event_catolog as $ec):
            ?>
            <li><a href="<?=site_url('event')?>?cat=<?=$ec->name ?>"><?=ucwords($ec->name) ?></a></li>
            <?php endforeach; ?>                   
        </ul>        
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h3><?php echo $this->lang->line('affiliate_program'); ?></h3>
        <ul class="footer-list">
        	<li><a href="<?=site_url("home/referral") ?>"><?php echo $this->lang->line('referral_program'); ?></a></li>
            <li><a href="<?=site_url("home/event_affiliate") ?>"><?php echo $this->lang->line('event_affiliate_program'); ?></a></li>
        </ul>        
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h3><?php echo $this->lang->line('about_buyticket'); ?></h3>
        <ul class="footer-list">
            <?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
                <li><a href="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?> "><?php echo $all_cms[$i]->heading;?></a></li>
            <?php }}?>
            <li><a href="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></a></li>
        </ul>        
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <h3><?php echo $this->lang->line('Connect With Us'); ?></h3>        
        <a href="<?php echo FACEBOOK_PAGE_URL;?>" target="_blank" class="social-button facebook">
          <i class="fa fa-facebook"></i>
          <?php echo $this->lang->line('facebook'); ?>
        </a>
        <a href="<?php echo TWITTER_PAGE_URL;?>" target="_blank" class="social-button twitter">
          <i class="fa fa-twitter"></i>
          <?php echo $this->lang->line('twitter'); ?>
        </a>
        <a href="<?php echo GOOGLEPLUS_PAGE_URL;?>" target="_blank" class="social-button google">
          <i class="fa fa-google-plus"></i>
          <?php echo $this->lang->line('google_plus'); ?>
        </a>
        <a href="<?php echo YOUTUBE_PAGE_URL;?>" target="_blank" class="social-button contact-btn">
          <i class="fa fa-youtube"></i>
          <?php echo $this->lang->line('you_tube'); ?>
        </a>
        <?php /*
        <a href="#"class="social-button contact-btn">
          <i class="fa fa-envelop"></i>
          contact us
        </a>
        */?>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <a href="http://www.esignature.com.np" target="_blank" class="copyright">Copyright &copy; <?php echo (date('Y')=='2015')? "2015" : 2015 - date('Y'); ?> by eSignature Pvt. Ltd.</a>
      <div class="footer-nav">
        <ul>
        	<li><a href="<?=site_url() ?>"><?php echo $this->lang->line('home'); ?></a></li>
            <li><a href="<?=site_url('event') ?>"><?php echo $this->lang->line('find_event'); ?></a></li>
            <li><a href="<?=site_url('event/create') ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
            <?php /*<!--<li><a href="<?=site_url('rss') ?>"><?php echo $this->lang->line('rss'); ?></a></li>-->*/?>
            <li><a href="<?=site_url('sitemap.xml') ?>"><?php echo $this->lang->line('sitemap'); ?></a></li>
            <li ><a href="<?=site_url('help/index') ?>"><?php echo $this->lang->line('help'); ?></a></li>
        </ul>        
      </div>
    </div>
  </div>
</div>

<div id="main-loader"><img src="<?php echo MAIN_IMAGES_DIR_FULL_PATH."loader.gif" ?>" /></div>
<!-- Modal -->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mainModalLabel">Message box</h4>
      </div>
      <div class="modal-body" id="mainModalBody">
        
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<script>
function loaderOn()
{
    $("#main-loader").show();
}
function loaderOff()
{
    $("#main-loader").hide();
}
</script>