<div class="row-fluid footer">
	<div class="main">
    	<div class="row-fluid">
        <div class="span3 footer_each">
        	<h3><?php echo $this->lang->line('event_catalog'); ?></h3>
            <ul>            	
                <?php $event_catolog=$this->general->get_event_catalog();
                foreach($event_catolog as $ec):
                ?>
                    <li><a href="<?=site_url('event')?>?cat=<?=$ec->name ?>"><?=ucwords($ec->name) ?></a></li>
                <?php endforeach; ?>                   
            </ul>
        </div>
        <div class="span3 footer_each">
        	<h3><?php echo $this->lang->line('affiliate_program'); ?></h3>
            <ul>
            	<li><a href="<?=site_url("home/referral") ?>"><?php echo $this->lang->line('referral_program'); ?></a></li>
                <li><a href="<?=site_url("home/event_affiliate") ?>"><?php echo $this->lang->line('event_affiliate_program'); ?></a></li>
            </ul>
        </div>
        <div class="span3 footer_each">
        	<h3><?php echo $this->lang->line('social_media'); ?></h3>
            <ul>
                <li class="fb"><a href="<?php echo FACEBOOK_PAGE_URL;?>" target="_blank"><?php echo $this->lang->line('facebook'); ?></a></li>
                <li class="twt"><a href="<?php echo TWITTER_PAGE_URL;?>" target="_blank"><?php echo $this->lang->line('twitter'); ?></a></li>
                <li class="utube"><a href="<?php echo YOUTUBE_PAGE_URL;?>" target="_blank"><?php echo $this->lang->line('you_tube'); ?></a></li>            
                 <li class="utube"><a href="<?php echo GOOGLEPLUS_PAGE_URL;?>" target="_blank"><?php echo $this->lang->line('google_plus'); ?></a></li>            
            </ul>
        </div>
        <div class="span3 footer_each">
        	<h3><?php echo $this->lang->line('about_buyticket'); ?> </h3>
            <ul>
                <?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
                    <li><a href="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?> "><?php echo $all_cms[$i]->heading;?></a></li>
                <?php }}?>
                <li><a href="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></a></li>
            </ul>
        </div>
        <center>
        <select class="footer_menu">
        	<optgroup label="<?php echo $this->lang->line('event_catalog'); ?>">
            	<?php $event_catolog=$this->general->get_event_catalog();
                foreach($event_catolog as $ec):
                ?>
                    <option value="<?=site_url('event')?>?cat=<?=$ec->name ?>"><?=ucwords($ec->name) ?></option>
                <?php endforeach; ?> 
            </optgroup>
            <optgroup label="<?php echo $this->lang->line('affiliate_program'); ?>">
                <option value="<?=site_url("home/referral") ?>"><?php echo $this->lang->line('referral_program'); ?></option>
                <option value="<?=site_url("home/event_affiliate") ?>"><?php echo $this->lang->line('event_affiliate_program'); ?></option>
            </optgroup>
            <optgroup label="<?php echo $this->lang->line('social_media'); ?>">
            	<option value="<?php echo FACEBOOK_PAGE_URL;?>"><?php echo $this->lang->line('facebook'); ?></option>
                <option value="<?php echo TWITTER_PAGE_URL;?>"><?php echo $this->lang->line('twitter'); ?></option>
                <option value="<?php echo YOUTUBE_PAGE_URL;?>"><?php echo $this->lang->line('you_tube'); ?></option>
            </optgroup>
            <optgroup label="<?php echo $this->lang->line('about_buyticket'); ?>">
            	<?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
                    <option value="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?>"><?php echo $all_cms[$i]->heading;?></option>
                    
                <?php }}?>
                <option value="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></option>
            </optgroup>
        </select>
        </center>
        </div>
        
        <div class="row-fluid copyright">
        	<div class="span6">
            <p><?php echo $this->lang->line('copy_right'); ?>&copy; </p>
            </div>
            
            <div class="span6">
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
<script>
$("select.footer_menu").change(function() {
  window.location = $(this).find("option:selected").val();
});
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-44736726-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>