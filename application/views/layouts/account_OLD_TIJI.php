<!DOCTYPE html>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $_SERVER['HTTP_HOST'] == "buyticket.com") @ob_start("ob_gzhandler"); else ob_start(); ?>
<html>
<head>
<title>::<?=$this->lang->line('buyticket');?>:: <?php echo $template['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="" />
<meta name="keywords" content="<?php echo $meta_keys;?>" />
<meta name="description" content="<?php echo $meta_desc;?>" />
<?php if(@$non_responsive !='yes'){?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php } ?>


<!--[if IE 8]>     <html class="ie8"> <![endif]-->
<!--[if IE 9]>     <html class="ie9"> <![endif]-->
<!--[if IE 10]>     <html class="ie10"> <![endif]-->

<link rel="shortcut icon" href="<?php echo MAIN_IMG_DIR_FULL_PATH;?>favicon.ico" />

<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main.css" rel="stylesheet" type="text/css"/>
<?php if(@$non_responsive !='yes'){?>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main_responsive.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap-responsive.css" rel="stylesheet"/>
<?php } ?>
<!-- Bootstrap -->
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap.css" rel="stylesheet" media="screen"/>

<!-- SCRIPTS-->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ems.min.js"></script>

<!-- datetime picker start -->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>datepicker.js"></script>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>datepicker.css" rel="stylesheet" type="text/css"/>
<!-- datetime picker end -->
<!-- jquery validation start -->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.validate.js"></script>
<!-- jquery validation end -->

<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ajaxupload.js"></script>

<!-- PROFILE IMG CHANGE -->

<!--
<script type="text/javascript">
$(window).load(function(){
	
	var button = $('#change_button');
	//var spinner = $('.profile_pic');
	
	//set the opacity to 0...
	button.css('opacity', 0);
	//spinner.css('top', ($('.profile_pic').height() - spinner.height()) / 2)
	//spinner.css('left', ($('.profile_pic').width() - spinner.width()) / 2)
	
	//On mouse over those thumbnail
	$('.profile_pic').hover(function() {
		button.css('opacity', .5);
		button.stop(false,true).fadeIn(200);
	},
	function() {
		button.stop(false,true).fadeOut(200);
	});
        
	
    new AjaxUpload(button,{
    	action: '<?php echo site_url('users/account/profileimage');?>', 
		name: 'myfile',
		onSubmit : function(file, ext){
			//spinner.css('display', 'block');			
			// you can disable upload button
			$('#profile_img').attr('src', '<?php echo site_url('assets/images/large-loader.gif',TRUE);?>');
			$('#profile_img2').attr('src', '<?php echo site_url('assets/images/large-loader.gif', TRUE);?>');			
			this.disable();
			},
		onComplete: function(file, response){
			button.stop(false,true).fadeOut(200);
			//spinner.css('display', 'none');
			//alert(response);
			if(response =='')
			{
				window.location.href = '<?php echo site_url('users/account/editprofile');?>';
			}
			else
			{
				$('#profile_img').attr('src', response);
				$('#profile_img2').attr('src', response);
			}
			// enable upload button
			this.enable();
		}
	});
	
});
  
</script>
-->
<!-- PROFILE IMG CHANGE -->
<script>  
$(function (){ 
    $(".tooltip-test").tooltip();  
});  
</script>

<style>
.navbar.header_inside{top: 0 !important; position: fixed;}
.header_inside .logo{display: block;}

</style>
</head>
<body>
<div class="navbar navbar-fixed-top header_inside">
  <div class="navbar-inner">
    <div class="main">    	
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
            <li <?php if($this->uri->segment(0) == 'users'){echo ' class="active"';} ?>><a href="<?=site_url('users/account') ?>"><?php echo $this->lang->line('my_account'); ?></a></li>
            <?php if( $this->general->is_referral_user($this->session->userdata(SESSION.'user_id')) || $this->general->has_event_referral_url($this->session->userdata(SESSION.'user_id'))){ ?>
            <li <?php if($this->uri->segment(0) == 'affiliate'){echo ' class="active"';} ?>><a href="<?=site_url('affiliate/index') ?>"><?php echo $this->lang->line('affiliate_dashboard'); ?></a></li>
            <?php } ?>
            <?php if($this->general->has_event_by_organizer()){ ?>            
            <li <?php if($this->uri->segment(0) == 'organizer'){echo ' class="active"';} ?>><a href="<?=site_url('organizer/event') ?>"><?php echo $this->lang->line('organizer_dashboard'); ?></a></li>
            <?php } ?>            
            <li <?php if($this->uri->segment(0) == 'event'){echo ' class="active"';} ?>><a href="<?=site_url('event/create') ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<div class="row-fluid content inside">
	<div class="main">
        <div class="row-fluid event_head">
            <div class="span8 left">
                <dl>
                    <dt><?php echo ucwords($profile_data->first_name.' '.$profile_data->last_name);?></dt>
                    <dd><em><?php echo $profile_data->email;?></em></dd>
                    <dd><strong><?php echo $this->lang->line('joined_on'); ?>:</strong> <?php echo $this->general->date_language($this->general->date_formate($profile_data->reg_date));?></dd>
                    <dd><strong><?php echo $this->lang->line('last_update_on'); ?>:</strong> <?php echo $this->general->date_language($this->general->date_time_formate($profile_data->last_modify_date));?></dd>
                </dl>
            </div>
            <div class="span4 right">
                <?php /*
                <!--
                <figure class='profile_pic'>
                    <div class="profile_pic_frame">
                    <?php
                    $profile_image = $profile_data->image;
                    $profile = (file_exists($profile_image)) ? $profile_image : UPLOAD_FILE_PATH . 'no_profile.jpg';
                    ?>
                    <img src="<?php echo site_url($profile,TRUE);?>" id="profile_img" />
                    </div>
                    
                    <div class='change_button' id='change_button'>                    	
                    	<div class='change_button_text'><?php echo $this->lang->line('change_photo'); ?></div>
                    </div>
                </figure>
                -->
                */ ?>
                <?php if($this->uri->segment(0) == 'organizer'){ ?>
                <div id="organizer_status_info" style="clear: both; float:left;">
                    <strong><?php echo $this->lang->line('status')?></strong>:
                    <?php
                    if($profile_data->organizer=='1'){                        
                    ?>
                        <font color='green'><?php echo $this->lang->line('verified')?></font>
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
                    <div id="verify_organizer_info" class="modal hide fade in" style="display: none; ">  
                        <div class="modal-header">  
                            <a class="close" data-dismiss="modal">&times;</a>  
                            <h3><?php echo $this->lang->line('Why should I verify my account?')?></h3>  
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
                    </div>
                    <?php
 
                    }
                        
                    ?>                    
                </div>
                <?php } ?>  
            </div>
            
        </div> 
        
        <div class="row-fluid">
        	<div class="span12">
                
                <!--body section start -->
                <?php echo $template['body']; ?>
                <!--body section end -->
            </div>
            
        </div>
    </div>
</div>
<?php echo $this->load->view('common/footer-boot');?>

<script src="<?=MAIN_JS_DIR_FULL_PATH; ?>jquery.js"></script> 
<script src="<?=MAIN_JS_DIR_FULL_PATH; ?>bootstrap.min.js"></script>
<!--color box-->
<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>
<!--color box-->
<script>
$(document).ready(function(){
    $(".ajax").colorbox({width:"60%",height:"75%"});
});
</script>
</body>
</html>