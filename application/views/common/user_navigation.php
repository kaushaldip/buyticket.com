<div class="clear"></div>
<ul class="dropdown">
  <li><a href="<?php echo site_url('event'); ?>"><?php echo $this->lang->line('event_system'); ?></a>
    <ul>
      <li><a href="<?php echo site_url('event/add'); ?>"><?php echo $this->lang->line('post_event'); ?></a></li>
    </ul>
  </li>
  <? if (($this->session->userdata(SESSION.'organizer'))=='1') { ?>
  <li>organizer</li>
  <? } ?>
  <? if ($this->session->userdata(SESSION.'user_id')) { ?>
  <li><?php echo $this->lang->line('dummy'); ?></li>
  <li><?php echo $this->lang->line('dummy'); ?></li>
  <li><a href="<?php echo site_url('users/account') ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
  <?php } ?>
</ul>
<br clear="all" />
<style>
*{margin:0; padding:0;}
.profile_button{width:205px; float:left; background:url(profile_button_bg.jpg) repeat-x; border-left:1px solid #000; border-right:1px solid #000; float:left; margin-left:10px; position:relative;}
.profile_link{height:31px; line-height:31px; font-size:13px; font-weight:bold; color:#eeeeff; text-decoration:none; float:left; width:100%; cursor:pointer;}
.profile_link img{float:left; border:1px solid #000; margin-right:10px;}

.profile_button ul{position:absolute; top:100%; display:none; color:#fff; background:#46454a; list-style:none; min-width:205px;-webkit-border-bottom-right-radius: 3px;-webkit-border-bottom-left-radius: 3px;-moz-border-radius-bottomright: 3px;-moz-border-radius-bottomleft: 3px;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px; overflow:hidden;}
.profile_button:hover ul{display:block;}
.profile_button ul li{display:inline; float:left; width:100%; border-bottom:1px solid #323135; border-top:1px solid #67666c;}
.profile_button ul li a{padding:5px 10px; float:left; font-size:11px; text-decoration:none; color:#aaa; font-weight:bold; width:185px;}
.profile_button ul li a:hover{color:#fff;}

.dropdown{list-style:none; float:left;}
.dropdown li{display:inline; float:left; padding:10px; background:#0CF; position:relative;}
.dropdown li ul{display:none; position:absolute; top:100%;}
.dropdown li:hover ul{display:block;}
.dropdown li li {width:100%; background:#06F;}

</style>
