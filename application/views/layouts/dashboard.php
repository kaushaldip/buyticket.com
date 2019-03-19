<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')&& $_SERVER['HTTP_HOST'] == "buyticket.com") @ob_start("ob_gzhandler"); else ob_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/text.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/fluid.css" media="screen" />

<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/mws.style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/icons.css" media="screen" />

<!-- Demo and Plugin Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/demo.css" media="screen" />

<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/colorpicker/colorpicker.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/imgareaselect/css/imgareaselect-default.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/fullcalendar/fullcalendar.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/fullcalendar/fullcalendar.print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/chosen/chosen.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/prettyphoto/css/prettyPhoto.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/tipsy/tipsy.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/sourcerer/Sourcerer-1.2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/jgrowl/jquery.jgrowl.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/spinner/spinner.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/jui/jquery.ui.css" media="screen" />

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/mws.theme.css" media="screen" />

<!-- JavaScript Plugins -->

<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/imgareaselect/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/duallistbox/jquery.dualListBox-1.3.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/jgrowl/jquery.jgrowl-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/filestyle/jquery.filestyle-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/datatables/jquery.dataTables-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/prettyphoto/js/jquery.prettyPhoto-min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
<![endif]-->
<!--<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/flot/jquery.flot.pie.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/flot/jquery.flot.stack.min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/flot/jquery.flot.resize.min.js"></script>-->
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/colorpicker/colorpicker-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/tipsy/jquery.tipsy-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/sourcerer/Sourcerer-1.2-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/placeholder/jquery.placeholder-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/validate/jquery.validate-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/spinner/jquery.mousewheel-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>plugins/spinner/ui.spinner-min.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/jquery-ui.js"></script>

<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/mws.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/demo.js"></script>
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/themer.js"></script>

<!--<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/demo.dashboard.js"></script>-->
<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>

<title><?php echo $template['title']; ?></title>
<?php 
$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
$this->output->set_header('Pragma: no-cache');
?>
</head>

<body>
	<!-- Header Wrapper -->
	<div id="mws-header" class="clearfix">
    
    	<!-- Logo Wrapper -->
    	<div id="mws-logo-container">
        	<div id="mws-logo-wrap">
            	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>">
                <img src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>images/mws-logo.png" alt="mws admin" />
                </a>
			</div>
        </div>
        
        <!-- User Area Wrapper -->
        <div id="mws-user-tools" class="clearfix">
        
        	<!-- User Notifications -->
            
        	<div id="mws-user-notif" class="mws-dropdown-menu">
            	<a href="#" class="mws-i-24 i-alert-2 mws-dropdown-trigger">Notifications</a>
                <span class="mws-dropdown-notif"><?=$this->general->notification_count();?></span>
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-notifications">
                        	
                            <!-- Notification Content -->
                            <?php
                            $notification = $this->general->get_notification(10);
                            
                            foreach($notification as $n){
                            ?>
                        	<li class="<?=($n->read=='yes')? 'read': 'unread'; ?>">
                            	<a href="#" onclick="change_to_read('<?=$n->id?>','<?=site_url(ADMIN_DASHBOARD_PATH."/site-settings/notification");?>')">
                                    <span class="message">
                                        <?=$n->notification;?>
                                    </span>
                                    <span class="time">
                                        <?=date('g:i a, j F, Y ', strtotime($n->date))?>
                                    </span>
                                </a>
                            </li>
                        	<?php 
                            }
                            ?>
                            <!-- End Notification Content -->
                            
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#" onclick="change_to_read('all','<?=site_url(ADMIN_DASHBOARD_PATH."/site-settings/notification");?>')">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Messages -->
            <!--
            <div id="mws-user-message" class="mws-dropdown-menu">
            	<a href="#" class="mws-i-24 i-message mws-dropdown-trigger">Messages</a>
                <span class="mws-dropdown-notif">35</span>
                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-messages">
                        -->
                        	<!-- Message Content -->
                            <!--
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="sender">John Doe</span>
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>-->
                            <!-- End Messages -->
                        <!--    
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Messages</a>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <!-- User Functions -->
            <div id="mws-user-info" class="mws-inset">
            	<div id="mws-user-photo">
                	<img src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>images/profile.png" alt="User Photo" />
                </div>
                <div id="mws-user-functions">
                    <div id="mws-username">
                        Hello, <?php echo $this->session->userdata(SESSION.ADMIN_LOGIN_USERNAME); ?>
                    </div>
                    <ul>
                    	<li><a href="<?php echo site_url('')?>" target="_blank"><?php echo $this->lang->line('visit_site'); ?></a></li>
                        <!--<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>">Home</a></li>-->
                        <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/change-password/index')?>"><?php echo $this->lang->line('change_password'); ?></a></li>               
                        <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/logout');?>"><?php echo $this->lang->line('logout'); ?></a></li>
                    </ul>
                </div>
            </div>
            <!-- End User Functions -->
            
        </div>
    </div>
    
    <!-- Main Wrapper -->
    <div id="mws-wrapper">
    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        	
            <!-- Search Box 
        	<div id="mws-searchbox" class="mws-inset">
            	<form action="dashboard.html">
                	<input type="text" class="mws-search-input" />
                    <input type="submit" class="mws-search-submit" />
                </form>
            </div>
            -->
            <!-- Main Navigation -->
            <?php $admin_type = $this->session->userdata(SESSION.'admin_type'); ?>
            <div id="mws-navigation">
            	<ul>
                    
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>" class="mws-i-24 i-home"><?php echo $this->lang->line('dashboard'); ?></a></li>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/users/administrator')?>" class="mws-i-24 i-admin-user-2">Administrators</a></li>
                    <?php endif; ?>
                    
                    
                    <li>
                    	<a href="#" class="mws-i-24 i-list"><?php echo $this->lang->line('account'); ?></a>
                        <ul>
                        	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/change-password/index')?>"><?php echo $this->lang->line('change_password'); ?></a></li>
                        	<li><a href="<?php echo site_url('')?>" target="_blank"><?php echo $this->lang->line('visit_site'); ?></a></li>
                        </ul>
                    </li>
                    
                    
                    <?php if($admin_type == 'ADMIN' || $admin_type == 'MODERATOR') : ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/users/index')?>" class="mws-i-24 i-admin-user"><?php echo $this->lang->line('users_management'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN' || $admin_type == 'MODERATOR') : ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/event/index')?>" class="mws-i-24 i-day-calendar"><?php echo $this->lang->line('event_management'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN' || $admin_type == 'MODERATOR') : ?>
                    <li>
                    	<a href="#" class="mws-i-24 i-table-1"><?php echo $this->lang->line('event').$this->lang->line('category_management'); ?></a>
                        <ul>
                        	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/category/index')?>"><?php echo $this->lang->line('event_category'); ?></a></li>
                        	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/category/add_category')?>"><?php echo $this->lang->line('add_event_category'); ?></a></li>
                        </ul>
                    </li>
                	
                    <?php endif; ?>
                    
                	<?php if($admin_type == 'ADMIN') : ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-settings/index')?>" class="mws-i-24 i-chart"><?php echo $this->lang->line('site_settings'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/cms/index/1')?>" class="mws-i-24 i-books-2">CMS Management</a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/email-settings/index/register_notification')?>" class="mws-i-24 i-file-cabinet"><?php echo $this->lang->line('email_settings'); ?></a></li>
                    <?php endif; ?>
                                                        	
                	<?php if($admin_type == 'ADMIN') : ?>
                    <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/help/index')?>" class="mws-i-24 i-cog"><?php echo $this->lang->line('help').$this->lang->line('management'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/time-zone-settings/index')?>" class="mws-i-24 i-text-styling"><?php echo $this->lang->line('time_setting'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/block-ip/index')?>" class="mws-i-24 i-blocks-images"><?php echo $this->lang->line('blocked_ip').$this->lang->line('management'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/bank/index')?>" class="mws-i-24 i-blocks-images">Bank Detail Management</a></li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN' || $admin_type == 'ACCOUNTANT') : ?>
                    <li><a href="#" class="mws-i-24 i-blocks-images">Payment Management</a>
                        <ul>                        	
                            <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment/approve_transaction')?>">Approve Transaction</a></li>
                            <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment/refund_transaction')?>">Refund Transaction</a></li>
                        	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment/organizer_payment')?>" >Organizer Payments</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                    <?php if($admin_type == 'ADMIN' || $admin_type == 'ACCOUNTANT') : ?>
                    <li><a href="#" class="mws-i-24 i-blocks-images">Payment Affiliate</a>
                        <ul>
                            <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment_affiliate/event_affiliate')?>">Event Affiliate Program</a></li>
                            <li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment_affiliate/referral_affiliate')?>">Referral Program</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if($admin_type == 'ADMIN') : ?>
                	<li><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/performer/view')?>" class="mws-i-24 i-blocks-images"><?php echo $this->lang->line('performer_type'); ?></a></li>
                    <?php endif; ?>
                    <!--
                	<li><a href="gallery.html" class="mws-i-24 i-polaroids">Gallery</a></li>
                	<li><a href="error.html" class="mws-i-24 i-alert-2">Error Page</a></li>
                	<li>
                    	<a href="icons.html" class="mws-i-24 i-pacman">
                        	Icons <span class="mws-nav-tooltip">2000+</span>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
            <!-- End Navigation -->
            
        </div>
        
        
        <!-- Container Wrapper -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Main Container -->
            <div class="container">
                <!-- Start Navigation Menu-->
                <?php if($admin_type == 'ADMIN') : ?>
                <div class="mws-report-container clearfix">
                	<a class="mws-report" href="<?php echo site_url(ADMIN_DASHBOARD_PATH)."/event/index"; ?>">
                    	<span class="mws-report-icon mws-ic ic-events"></span>
                        <span class="mws-report-content">
                        	<span class="mws-report-title"><?php echo $this->lang->line('total_events'); ?></span><br />
                            <span class="mws-report-value"><?=$this->general->total_events_admin(); ?></span>
                        </span>
                    </a>
                
                	<a class="mws-report" href="#">
                    	<span class="mws-report-icon mws-ic ic-cash-register"></span>
                        <span class="mws-report-content">
                        	<span class="mws-report-title">Public / Private</span><br />
                            <span class="mws-report-value"><?=$this->general->total_events_admin(1); ?> / <?=$this->general->total_events_admin(2); ?></span>
                        </span>
                    </a>
                    
                    <a class="mws-report" href="<?php echo site_url(ADMIN_DASHBOARD_PATH)."/users/index"; ?>">
                    	<span class="mws-report-icon mws-ic ic-user"></span>
                        <span class="mws-report-content">
                        	<span class="mws-report-title">Total Users</span><br />
                            <span class="mws-report-value"><?=$this->general->total_users(); ?></span>
                        </span>
                    </a>
                
                	<a class="mws-report" href="<?php echo site_url(ADMIN_DASHBOARD_PATH)."/users/organizers"; ?>">
                    	<span class="mws-report-icon mws-ic ic-user-suit"></span>
                        <span class="mws-report-content">
                        	<span class="mws-report-title"><?php echo $this->lang->line('total_organizer'); ?></span><br />
                            <span class="mws-report-value"><?=$this->general->total_users('organizer'); ?></span>
                        </span>
                    </a>
                    
                	<a class="mws-report" href="#">
                    	<span class="mws-report-icon mws-ic ic-money-bag"></span>
                        <span class="mws-report-content">
                        	<span class="mws-report-title">Total Revenue</span><br />
                            <span class="mws-report-value up" style="font-size: 13px;"><?="USD ".$this->general->dash_total_revenue();?></span>
                        </span>
                    </a>
                    
                </div>
                <?php endif;?>
                <!-- End Navigation Menu-->
                <?php echo $template['body']; ?>             	
            </div>
            <!-- End Main Container -->
            
            <!-- Footer -->
            <div id="mws-footer">
            	<p><br />Page rendered in {elapsed_time} seconds</p>
            </div>
            <!-- End Footer -->
            
        </div>
        <!-- End Container Wrapper -->
        
    </div>
    <!-- End Main Wrapper -->

</body>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ems.min.js"></script>
</html>

<script>
function change_to_read(id,link)
{
    $.ajax({
        url:'<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-settings/change_to_read'); ?>',
        type:'POST',
        data:'id='+id,
        success:function(r){            
            window.location.href = link;
        }
    });
}
</script>

<script>
function delete_notification(id)
{    
    if(confirm('Are you sure to delete this noticifation?')){
        $('#notification_'+id).prepend('<font color="red" style="font-style:italic;">Loading....</font>');
        $.ajax({
            url:'<?php echo site_url(ADMIN_DASHBOARD_PATH.'/site-settings/delete_notification'); ?>',
            type:'POST',
            data:'id='+id,
            success:function(r){
                $('#notification_'+id).hide(500).html('');
            }
        });    
        //$('#notification_'+id).find('font').hide();
    }else{
        return false;   
    }
    
}
</script>