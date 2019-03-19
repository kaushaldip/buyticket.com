<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $_SERVER['HTTP_HOST'] == "buyticket.com") @ob_start("ob_gzhandler"); else ob_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $meta_keys;?>" />
<meta name="description" content="<?php echo $meta_desc;?>" />
<meta name="author" content="" />
<?php if(@$non_responsive !='yes'){?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php } ?>
<?php if($this->uri->segment(1)=='view'){
    if(!$current_event){
        ?>
    <meta name="robots" content="noindex, nofollow"/>
<?php }
    }
?>

<title>:: <?=$this->lang->line('buyticket');?> :: <?php echo $template['title']; ?></title>

<!--[if IE 8]>     <html class="ie8"> <![endif]-->
<!--[if IE 9]>     <html class="ie9"> <![endif]-->
<!--[if IE 10]>     <html class="ie10"> <![endif]-->

<link rel="shortcut icon" href="<?php echo MAIN_IMG_DIR_FULL_PATH;?>favicon.ico" />

<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main_responsive.css" rel="stylesheet" type="text/css"/>


<!-- Bootstrap -->
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap.css" rel="stylesheet" media="screen"/>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>bootstrap-responsive.css" rel="stylesheet"/>

<!--[if lt IE 9]>
<script src="<?php echo MAIN_JS_DIR_FULL_PATH;?>html5.min.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ems.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.form.js"></script>


<!-- Anything Slider start -->
<link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>anythingslider.css"/>
<script src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.anythingslider.js"></script>
<!-- Anything Slider end -->

<!-- datetime picker start -->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>datepicker.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery-ui-timepicker-addon.js"></script>
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>datepicker.css" rel="stylesheet" type="text/css"/>
<!-- datetime picker end -->
<!-- jquery validation start -->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.validate.js"></script>
<!-- jquery validation end -->
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ajaxupload.js"></script>

<?php if($this->uri->segment(0)=='' || $this->uri->segment(0)=='home'):?>
<!-- Anything Slider Start -->
<style>
#slider {
	width: 960px;
	height: 343px;
}
</style>
<script>
    
	// DOM Ready
	$(function(){
		$('#slider').anythingSlider({
			autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
			delay: 3000,                    // How long between slide transitions in AutoPlay mode
			animationTime: 600,             // How long the slide transition takes
			pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
			hashTags:false
		});
	});
</script>
<!-- Anything Slider Ends -->
<?php endif;?>

<script>
site_url = "<?=site_url()?>";
</script>
<style>
.navbar.header_inside{top: 0 !important; position: fixed;}
.header_inside .logo{display: block;}

</style>
</head>

<body>
<!--item sec start-->
<div class="row-fluid content inside">
	<div class="main">
    <?php echo $template['body']; ?>
    </div>
</div> 
<!--item sec end-->

<!--script src="<?=MAIN_JS_DIR_FULL_PATH ?>jquery.js"></script--> 
<script src="<?=MAIN_JS_DIR_FULL_PATH ?>bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>general.js"></script>
</body>
</html>