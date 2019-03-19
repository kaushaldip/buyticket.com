<!DOCTYPE html>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $_SERVER['HTTP_HOST'] == "buyticket.com") @ob_start("ob_gzhandler"); else ob_start(); ?>
<html>
<head>
<title>::<?=$this->lang->line('buyticket');?>:: <?php echo $template['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta name="author" content="" />
<meta name="keywords" content="<?php echo $meta_keys;?>" />
<meta name="description" content="<?php echo $meta_desc;?>" />
<?php if(@$non_responsive !='yes'){?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php } ?>

<link rel="shortcut icon" href="<?php echo MAIN_IMG_DIR_FULL_PATH;?>favicon.ico" />

<!--[if IE 8]>     <html class="ie8"> <![endif]-->
<!--[if IE 9]>     <html class="ie9"> <![endif]-->
<!--[if IE 10]>     <html class="ie10"> <![endif]-->

<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main_responsive.css" rel="stylesheet" type="text/css"/>

<!-- Bootstrap -->
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap.css" rel="stylesheet" media="screen"/>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap-responsive.css" rel="stylesheet"/>

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
			$('#profile_img').attr('src', '<?php echo site_url('assets/images/spinner_large.gif');?>');
			$('#profile_img2').attr('src', '<?php echo site_url('assets/images/spinner_large.gif');?>');			
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
<!-- PROFILE IMG CHANGE -->
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
            <?php if($profile_data->organizer =='1' || $profile_data->is_referral_user =='yes'){ ?>
            <li <?php if($this->uri->segment(0) == 'affiliate'){echo ' class="active"';} ?>><a href="<?=site_url('affiliate/index') ?>"><?php echo $this->lang->line('affiliate_dashboard'); ?></a></li>
            <?php } ?>
            <li <?php if($this->uri->segment(0) == 'organizer'){echo ' class="active"';} ?>><a href="<?=site_url('organizer/index') ?>"><?php echo $this->lang->line('organizer_dashboard'); ?></a></li>
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
                    <dd><strong><?php echo $this->lang->line('joined_on'); ?>:</strong> <?php echo $this->general->date_formate($profile_data->reg_date);?></dd>
                    <dd><strong><?php echo $this->lang->line('last_update_on'); ?>:</strong> <?php echo $this->general->date_time_formate($profile_data->last_modify_date);?></dd>
                </dl>
            </div>
            <div class="span4 right">
                <figure class='profile_pic'>
                    <div class="profile_pic_frame">
                    <img src="<?php if($profile_data->image){echo site_url($profile_data->image);}else{ echo site_url('upload_files/no_profile.jpg');}?>" id="profile_img" />
                    </div>
                    <!-- // Button Container -->
                    <div class='change_button' id='change_button'>
                    	<!-- // Button -->
                    	<div class='change_button_text'><?php echo $this->lang->line('change_photo'); ?></div>
                    </div>
                </figure>  
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
<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>
</body>
</html>