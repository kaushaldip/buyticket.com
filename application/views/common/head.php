<!DOCTYPE html>
<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && $_SERVER['HTTP_HOST'] == "buyticket.com")
    @ob_start("ob_gzhandler");
else
    ob_start();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="<?php echo addslashes($meta_keys); ?>" />
    <meta name="description" content="<?php echo $meta_desc; ?>" />
    <meta name="author" content="ajayogal" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <link rel="icon" href="../../favicon.ico"/>

    <title>:: <?=strtoupper($this->lang->line('buyticket'));?> :: <?php echo $template['title']; ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>bootstrap.min.css" >

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>style.css" >
    <link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>headshrinker.css" media="screen" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>default.css" type="text/css">
     <!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>eventCalendar_theme_responsive.css">
    <link rel="stylesheet" href="<?php echo MAIN_CSS_DIR_FULL_PATH; ?>media.css" >
   <!-- google font here -->
    <link href="http://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Titillium+Web:600" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Titillium+Web:700" rel="stylesheet" type="text/css">
    
    
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>jquery.min.js"></script>
    
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>ems.min.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>general.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery-validate.js"></script>
    
    <!-- datetime picker start -->
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>datepicker.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery-ui-timepicker-addon.js"></script>
    <link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>datepicker.css" rel="stylesheet" type="text/css"/>
    <!-- datetime picker end -->
    
    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/<?php echo MAIN_JS_DIR_FULL_PATH; ?>ie8-responsive-file-warning.js"></script><![endif]-->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    site_url = "<?=site_url()?>";
    </script>
</head>

<body>